<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNotebookRequest;
use App\Http\Requests\UpdateNotebookRequest;
use App\Models\Category;
use App\Models\Chat;
use App\Models\Notebook;
use App\Services\ActivityLogger;
use App\Services\NotebookInsightsService;
use App\Support\WorkspaceUserResolver;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class NotebookController extends Controller
{
    public function __construct(
        protected ActivityLogger $activityLogger,
        protected NotebookInsightsService $insights,
        protected WorkspaceUserResolver $workspaceUserResolver,
    ) {}

    /**
     * Display a listing of the notebooks.
     */
    public function index(Request $request): View
    {
        $user = $request->user();

        $featuredNotebooks = Notebook::query()
            ->with(['owner', 'category'])
            ->withCount(['sources', 'chats', 'members'])
            ->where('is_featured', true)
            ->orWhere('is_pinned', true)
            ->orderBy('display_order')
            ->orderByDesc('featured_at')
            ->get();

        $userNotebooks = Notebook::query()
            ->with(['owner', 'category'])
            ->withCount(['sources', 'chats', 'members'])
            ->where('owner_id', $user->id)
            ->orderByDesc('last_activity_at')
            ->get();

        return view('notebooks.index', compact('featuredNotebooks', 'userNotebooks'));
    }

    /**
     * Create a quick notebook.
     */
    public function create(Request $request): RedirectResponse
    {
        return $this->createQuick($request);
    }

    /**
     * Store a newly created notebook.
     */
    public function store(StoreNotebookRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $user = $request->user();

        $notebook = Notebook::create([
            ...$data,
            'owner_id' => $user->id,
            'slug' => $this->uniqueSlug($data['title']),
            'shared_token' => ($data['visibility'] ?? 'private') === 'shared' ? Str::random(40) : null,
            'smart_tags' => $data['smart_tags'] ?? null,
            'last_activity_at' => now(),
        ]);

        $chat = $notebook->chats()->create([
            'user_id' => null,
            'title' => 'Primary workspace',
            'mode' => 'qa',
            'context_summary' => $notebook->summary,
            'last_message_at' => now(),
        ]);

        $this->activityLogger->log(
            null,
            'notebook.created',
            "Created notebook {$notebook->title}.",
            $notebook,
            null,
            ['chat_id' => $chat->id],
            $request->ip(),
            $request->userAgent()
        );

        return redirect()
            ->route('notebooks.show', $notebook)
            ->with('status', 'Notebook created successfully.');
    }

    /**
     * Create a quick notebook.
     */
    public function createQuick(Request $request): RedirectResponse
    {
        $user = $request->user();

        $notebook = Notebook::create([
            'owner_id' => $user->id,
            'title' => 'Untitled notebook',
            'summary' => 'Quick notebook workspace',
            'description' => '',
            'category_id' => null,
            'status' => 'active',
            'visibility' => 'private',
            'icon' => 'sparkles',
            'cover_color' => '#8b5cf6',
            'slug' => $this->uniqueSlug('Untitled notebook'),
            'last_activity_at' => now(),
        ]);

        $chat = $notebook->chats()->create([
            'user_id' => null,
            'title' => 'Primary workspace',
            'mode' => 'qa',
            'context_summary' => $notebook->summary,
            'last_message_at' => now(),
        ]);

        $this->activityLogger->log(
            null,
            'notebook.created',
            "Created notebook {$notebook->title}.",
            $notebook,
            null,
            ['chat_id' => $chat->id],
            $request->ip(),
            $request->userAgent()
        );

        return redirect()->route('notebooks.show', $notebook);
    }

    /**
     * Display the specified notebook.
     */
    public function show(Request $request, Notebook $notebook): View
    {
        $notebook->load([
            'category',
            'activityLogs.user',
            'chats.messages.user',
            'memberships.user',
        ]);

        $sources = $notebook->sources()
            ->latest()
            ->paginate(3, ['*'], 'sources_page')
            ->withQueryString();

        $sourcesTotal = $notebook->sources()->count();

        /** @var Chat $activeChat */
        $activeChat = $notebook->chats()
            ->with(['messages.user'])
            ->find($request->integer('chat'))
            ?? $notebook->chats()->with(['messages.user'])->latest('updated_at')->first()
            ?? $notebook->chats()->create([
                'user_id' => null,
                'title' => 'Primary workspace',
                'mode' => 'qa',
                'last_message_at' => now(),
            ]);

        $workspace = $this->insights->buildWorkspace($notebook);

        return view('notebooks.show', [
            'notebook' => $notebook,
            'sources' => $sources,
            'sourcesTotal' => $sourcesTotal,
            'activeChat' => $activeChat,
            'workspace' => $workspace,
            'activitySeries' => $this->insights->activitySeries($notebook),
        ]);
    }

    /**
     * Show the form for editing the notebook.
     */
    public function edit(Notebook $notebook): View
    {
        return view('notebooks.edit', [
            'notebook' => $notebook,
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    /**
     * Update the specified notebook.
     */
    public function update(Request $request, Notebook $notebook): RedirectResponse
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
        ]);

        $data = [
            'title' => $request->title,
        ];

        if ($data['title'] !== $notebook->title) {
            $data['slug'] = $this->uniqueSlug($data['title'], $notebook->id);
        }

        $notebook->update($data);

        $this->activityLogger->log(
            null,
            'notebook.updated',
            "Renamed notebook to {$notebook->title}.",
            $notebook,
            null,
            [],
            $request->ip(),
            $request->userAgent()
        );

        return redirect()
            ->route('notebooks.index')
            ->with('status', 'Notebook renamed successfully.');
    }

    /**
     * Remove the specified notebook.
     */
    public function destroy(Request $request, Notebook $notebook): RedirectResponse
    {
        $title = $notebook->title;

        $this->activityLogger->log(
            null,
            'notebook.deleted',
            "Deleted notebook {$title}.",
            $notebook,
            null,
            [],
            $request->ip(),
            $request->userAgent()
        );

        $notebook->delete();

        return redirect()
            ->route('notebooks.index')
            ->with('status', "Notebook {$title} deleted.");
    }

    protected function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($title);
        $slug = $baseSlug;
        $counter = 1;

        while (
            Notebook::query()
                ->when($ignoreId, fn ($query) => $query->whereKeyNot($ignoreId))
                ->where('slug', $slug)
                ->exists()
        ) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}
