<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNotebookRequest;
use App\Http\Requests\UpdateNotebookRequest;
use App\Models\Category;
use App\Models\Chat;
use App\Models\Notebook;
use App\Services\ActivityLogger;
use App\Services\NotebookInsightsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class NotebookController extends Controller
{
    public function __construct(
        protected ActivityLogger $activityLogger,
        protected NotebookInsightsService $insights,
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
        $this->authorize('create', Notebook::class);

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

        $notebook = Notebook::create([
            ...$data,
            'owner_id' => $request->user()->id,
            'slug' => $this->uniqueSlug($data['title']),
            'shared_token' => ($data['visibility'] ?? 'private') === 'shared' ? Str::random(40) : null,
            'smart_tags' => $data['smart_tags'] ?? null,
            'last_activity_at' => now(),
        ]);

        $chat = $notebook->chats()->create([
            'user_id' => $request->user()->id,
            'title' => 'Primary workspace',
            'mode' => 'qa',
            'context_summary' => $notebook->summary,
            'last_message_at' => now(),
        ]);

        $this->activityLogger->log(
            $request->user(),
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
     * Display the specified notebook.
     */
    public function show(Request $request, Notebook $notebook): View
    {
        $this->authorize('view', $notebook);

        $notebook->load([
            'owner',
            'category',
            'members',
            'sources',
            'activityLogs.user',
            'chats.messages.user',
        ]);

        /** @var Chat $activeChat */
        $activeChat = $notebook->chats()
            ->with(['messages.user'])
            ->find($request->integer('chat'))
            ?? $notebook->chats()->with(['messages.user'])->latest('updated_at')->first()
            ?? $notebook->chats()->create([
                'user_id' => $request->user()->id,
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
        $this->authorize('update', $notebook);

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
            $request->user(),
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
        $this->authorize('delete', $notebook);

        $title = $notebook->title;

        $this->activityLogger->log(
            $request->user(),
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
