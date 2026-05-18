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
        $search = trim((string) $request->input('search'));
        $categoryId = $request->integer('category_id');

        $notebooks = Notebook::query()
            ->with(['owner', 'category'])
            ->withCount(['sources', 'chats', 'members'])
            ->accessibleBy($user)
            ->when($search !== '', fn ($query) => $query->where('title', 'like', "%{$search}%"))
            ->when($categoryId, fn ($query) => $query->where('category_id', $categoryId))
            ->orderByDesc('last_activity_at')
            ->paginate(12)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view('notebooks.index', compact('notebooks', 'categories', 'search', 'categoryId'));
    }

    /**
     * Show the form for creating a new notebook.
     */
    public function create(): View
    {
        return view('notebooks.create', [
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    /**
     * Store a newly created notebook.
     */
    public function store(StoreNotebookRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $workspaceUser = $this->workspaceUserResolver->resolve();

        $notebook = Notebook::create([
            ...$data,
            'owner_id' => $workspaceUser->id,
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
        $workspaceUser = $this->workspaceUserResolver->resolve();

        $notebook = Notebook::create([
            'owner_id' => $workspaceUser->id,
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
            'sources',
            'activityLogs.user',
            'chats.messages.user',
            'memberships.user',
        ]);

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
    public function update(UpdateNotebookRequest $request, Notebook $notebook): RedirectResponse
    {
        $data = $request->validated();

        if (($data['title'] ?? $notebook->title) !== $notebook->title) {
            $data['slug'] = $this->uniqueSlug($data['title'], $notebook->id);
        }

        if (($data['visibility'] ?? 'private') === 'shared' && blank($notebook->shared_token)) {
            $data['shared_token'] = Str::random(40);
        }

        $notebook->update($data);

        $this->activityLogger->log(
            null,
            'notebook.updated',
            "Updated notebook {$notebook->title}.",
            $notebook,
            null,
            [],
            $request->ip(),
            $request->userAgent()
        );

        return redirect()
            ->route('notebooks.show', $notebook)
            ->with('status', 'Notebook updated successfully.');
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
