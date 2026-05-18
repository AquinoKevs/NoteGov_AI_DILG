<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Notebook;
use App\Services\NotebookInsightsService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, NotebookInsightsService $insights): View
    {
        $user = $request->user();
        
        $notebook = Notebook::query()
            ->with(['owner', 'category'])
            ->accessibleBy($user)
            ->latest('last_activity_at')
            ->latest('updated_at')
            ->first();

        if (!$notebook) {
            $notebook = Notebook::create([
                'user_id' => $user->id,
                'title' => 'My Workspace',
                'summary' => 'Your personal AI workspace',
                'description' => 'A place for your notes, documents, and AI-powered insights',
                'category_id' => null,
                'status' => 'active',
                'icon' => 'sparkles',
                'cover_color' => '#8b5cf6',
                'last_activity_at' => now(),
            ]);
        }

        $notebook->load([
            'category',
            'sources',
            'activityLogs.user',
            'chats.messages.user',
            'memberships.user',
        ]);

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

        $workspace = $insights->buildWorkspace($notebook);

        return view('notebooks.show', [
            'notebook' => $notebook,
            'activeChat' => $activeChat,
            'workspace' => $workspace,
        ]);
    }
}
