<x-app-layout>
    <x-slot name="header">
        <div>
            <div class="chip mb-2">{{ $notebook->category?->name ?: 'Governance notebook' }}</div>
            <div class="text-2xl font-bold text-white sm:text-3xl">{{ $notebook->title }}</div>
        </div>
    </x-slot>

    <div
        x-data="workspaceChat({
            endpoint: @js(route('api.notebooks.chats.messages.store', [$notebook, $activeChat])),
            csrf: @js(csrf_token()),
            mode: @js($activeChat->mode ?? 'qa'),
            suggestions: @js($workspace['suggested_questions']),
            initialMessages: @js($activeChat->messages->map(fn ($message) => [
                'id' => $message->id,
                'role' => $message->role,
                'content' => $message->content,
                'citations' => $message->citations ?? [],
                'created_at' => $message->created_at?->format('M d, Y h:i A'),
            ])->values()),
        })"
        class="grid gap-6 2xl:grid-cols-[320px_minmax(0,1fr)_320px]"
    >
        <aside class="space-y-6">
            <div class="panel p-5">
                <div class="rounded-[24px] p-5 text-white" style="background: linear-gradient(135deg, {{ $notebook->cover_color ?? '#1f6feb' }} 0%, rgba(8,15,31,0.95) 85%);">
                    <div class="flex items-center justify-between">
                        <span class="chip border-white/15 bg-black/20 text-white/80">Open Workspace</span>
                        <span class="text-xs uppercase tracking-[0.22em] text-white/70">{{ str($notebook->status)->headline() }}</span>
                    </div>
                    <p class="mt-4 text-sm leading-7 text-white/80">{{ $notebook->summary ?: 'No summary yet. Use the AI tools on the right to generate one from your sources.' }}</p>
                </div>

                <div class="mt-5 grid gap-3 sm:grid-cols-3 2xl:grid-cols-1">
                    <div class="panel-muted px-4 py-3">
                        <p class="text-xs uppercase tracking-[0.2em] text-slate-500">Sources</p>
                        <p class="mt-2 text-lg font-semibold text-white">{{ $notebook->sources->count() }}</p>
                    </div>
                    <div class="panel-muted px-4 py-3">
                        <p class="text-xs uppercase tracking-[0.2em] text-slate-500">Chats</p>
                        <p class="mt-2 text-lg font-semibold text-white">{{ $notebook->chats->count() }}</p>
                    </div>
                    <div class="panel-muted px-4 py-3">
                        <p class="text-xs uppercase tracking-[0.2em] text-slate-500">Last activity</p>
                        <p class="mt-2 text-sm font-semibold text-white">{{ optional($notebook->last_activity_at ?? $notebook->updated_at)->diffForHumans() }}</p>
                    </div>
                </div>
            </div>

            <div x-data="{ sourceType: 'pdf', fileName: '' }" class="panel p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs uppercase tracking-[0.24em] text-slate-400">Source Management</p>
                        <h2 class="mt-2 text-xl font-bold text-white">Upload or import sources</h2>
                    </div>
                    <span class="chip">Queued AI indexing</span>
                </div>

                <form method="POST" action="{{ route('notebooks.sources.store', $notebook) }}" enctype="multipart/form-data" class="mt-5 space-y-4">
                    @csrf
                    <div>
                        <x-input-label for="source_type" value="Source type" />
                        <select id="source_type" name="source_type" class="input-shell mt-1" x-model="sourceType">
                            <option value="pdf">PDF</option>
                            <option value="docx">DOCX</option>
                            <option value="txt">TXT</option>
                            <option value="url">Website URL</option>
                            <option value="youtube">YouTube link</option>
                            <option value="audio">Audio file</option>
                            <option value="video">Video file</option>
                        </select>
                    </div>

                    <div>
                        <x-input-label for="title" value="Custom source title" />
                        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" placeholder="Optional display title" />
                    </div>

                    <div x-show="sourceType === 'url' || sourceType === 'youtube'">
                        <x-input-label for="source_url" value="Source URL" />
                        <x-text-input id="source_url" name="source_url" type="url" class="mt-1 block w-full" placeholder="https://..." />
                    </div>

                    <div x-show="sourceType !== 'url' && sourceType !== 'youtube'">
                        <x-input-label for="upload_file" value="Upload file" />
                        <label class="panel-muted mt-1 block cursor-pointer border-dashed px-4 py-5 text-center text-sm text-slate-300">
                            <input id="upload_file" name="upload_file" type="file" class="hidden" @change="fileName = $event.target.files[0]?.name || ''">
                            <span x-text="fileName || 'Drag and drop or choose a file'"></span>
                        </label>
                    </div>

                    <div>
                        <x-input-label for="notes" value="Notes for indexing" />
                        <textarea id="notes" name="notes" rows="3" class="input-shell mt-1" placeholder="Context, metadata, or instructions for the source"></textarea>
                    </div>

                    <button type="submit" class="btn-primary w-full">Add Source</button>
                </form>
            </div>

            <div class="panel p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs uppercase tracking-[0.24em] text-slate-400">Current sources</p>
                        <h2 class="mt-2 text-xl font-bold text-white">Notebook inventory</h2>
                    </div>
                </div>
                <div class="mt-5 space-y-3">
                    @forelse ($notebook->sources as $source)
                        <div class="panel-muted px-4 py-4">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <p class="text-sm font-semibold text-white">{{ $source->name }}</p>
                                    <p class="mt-1 text-xs uppercase tracking-[0.18em] text-slate-500">{{ strtoupper($source->type) }} - {{ str($source->status)->headline() }}</p>
                                </div>
                                <form method="POST" action="{{ route('notebooks.sources.destroy', [$notebook, $source]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-xs font-semibold text-rose-300 transition hover:text-rose-200" type="submit">Remove</button>
                                </form>
                            </div>
                            @if ($source->summary)
                                <p class="mt-3 text-sm leading-6 text-slate-300">{{ $source->summary }}</p>
                            @endif
                        </div>
                    @empty
                        <p class="text-sm text-slate-400">Upload source material to activate RAG search, AI summaries, and grounded chat answers.</p>
                    @endforelse
                </div>
            </div>
        </aside>

        <section class="panel flex min-h-[78vh] flex-col overflow-hidden">
            <div class="border-b border-white/8 px-5 py-4">
                <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <p class="text-xs uppercase tracking-[0.24em] text-slate-400">AI chat workspace</p>
                        <h2 class="mt-1 text-2xl font-bold text-white">{{ $activeChat->title }}</h2>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <template x-for="candidate in ['qa', 'summary', 'brief', 'report', 'compare']" :key="candidate">
                            <button type="button" class="btn-secondary capitalize" :class="{ 'bg-sky-400/15 border-sky-300/20 text-white': mode === candidate }" @click="mode = candidate" x-text="candidate"></button>
                        </template>
                        <a href="{{ route('notebooks.chats.export', [$notebook, $activeChat]) }}" class="btn-secondary">Export PDF</a>
                    </div>
                </div>
            </div>

            <div id="chat-scroll" class="flex-1 space-y-4 overflow-y-auto px-5 py-5">
                <template x-if="messages.length === 0">
                    <div class="panel-muted p-5 text-center">
                        <p class="text-lg font-semibold text-white">Ask your first notebook question</p>
                        <p class="mt-2 text-sm text-slate-300">Use this chat to summarize sources, draft policy briefs, compare documents, and extract actions grounded in notebook content.</p>
                    </div>
                </template>

                <template x-for="message in messages" :key="message.id ?? `${message.role}-${message.created_at}-${message.content.length}`">
                    <div class="flex" :class="message.role === 'user' ? 'justify-end' : 'justify-start'">
                        <div class="max-w-3xl rounded-[26px] px-5 py-4" :class="message.role === 'user' ? 'bg-sky-400/15 text-slate-100' : 'panel-muted text-slate-100'">
                            <div class="flex items-center justify-between gap-4">
                                <p class="text-xs uppercase tracking-[0.2em] text-slate-400" x-text="message.role === 'user' ? 'You' : 'NoteGov AI'"></p>
                                <p class="text-xs text-slate-500" x-text="message.created_at ?? 'Now'"></p>
                            </div>
                            <p class="mt-3 whitespace-pre-wrap text-sm leading-7" x-text="message.content"></p>
                            <template x-if="message.citations && message.citations.length">
                                <div class="mt-4 flex flex-wrap gap-2">
                                    <template x-for="citation in message.citations" :key="`${citation.source_id}-${citation.chunk_index ?? 0}`">
                                        <span class="chip" x-text="citation.source_name"></span>
                                    </template>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>
            </div>

            <div class="border-t border-white/8 px-5 py-5">
                <div class="mb-4 flex flex-wrap gap-2">
                    <template x-for="suggestion in suggestions" :key="suggestion">
                        <button type="button" class="btn-secondary text-left text-xs leading-5" @click="prompt = suggestion" x-text="suggestion"></button>
                    </template>
                </div>

                <form @submit.prevent="sendPrompt()" class="space-y-3">
                    <textarea x-model="prompt" rows="4" class="input-shell" placeholder="Ask about policies, summaries, action items, reports, or multi-document comparisons"></textarea>
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <p class="text-sm text-slate-400" x-show="isLoading">Generating a grounded response from notebook context...</p>
                        <div class="flex gap-3 sm:ml-auto">
                            <button type="button" class="btn-secondary" @click="prompt = ''">Clear</button>
                            <button type="submit" class="btn-primary" :disabled="isLoading">
                                <span x-text="isLoading ? 'Thinking...' : 'Send to AI'"></span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </section>

        <aside class="space-y-6">
            <div class="panel p-5">
                <p class="text-xs uppercase tracking-[0.24em] text-slate-400">Notebook Summary</p>
                <p class="mt-4 text-sm leading-7 text-slate-300">{{ $workspace['summary'] }}</p>

                <div class="mt-5 flex flex-wrap gap-2">
                    @foreach ($workspace['smart_tags'] as $tag)
                        <span class="chip">{{ $tag }}</span>
                    @endforeach
                </div>
            </div>

            <div class="panel p-5">
                <p class="text-xs uppercase tracking-[0.24em] text-slate-400">Workspace details</p>
                <div class="mt-4 space-y-3">
                    <div class="panel-muted px-4 py-4">
                        <p class="text-sm font-semibold text-white">Access mode</p>
                        <p class="mt-1 text-sm text-slate-300">This notebook opens directly in the shared workspace with no login or sign-up required.</p>
                    </div>
                    <div class="panel-muted px-4 py-4">
                        <p class="text-sm font-semibold text-white">Category</p>
                        <p class="mt-1 text-sm text-slate-300">{{ $notebook->category?->name ?: 'General notebook' }}</p>
                    </div>
                    <div class="panel-muted px-4 py-4">
                        <p class="text-sm font-semibold text-white">Status</p>
                        <p class="mt-1 text-sm text-slate-300">{{ str($notebook->status)->headline() }}</p>
                    </div>
                </div>
            </div>

            <div class="panel p-5">
                <p class="text-xs uppercase tracking-[0.24em] text-slate-400">Activity history</p>
                <div class="mt-4 space-y-3">
                    @forelse ($notebook->activityLogs->take(8) as $activity)
                        <div class="panel-muted px-4 py-4">
                            <p class="text-sm font-semibold text-white">{{ $activity->description }}</p>
                            <p class="mt-2 text-xs uppercase tracking-[0.18em] text-slate-500">{{ $activity->action }} - {{ $activity->created_at?->diffForHumans() }}</p>
                        </div>
                    @empty
                        <p class="text-sm text-slate-400">Notebook events will appear here after uploads, edits, and AI interactions.</p>
                    @endforelse
                </div>
            </div>
        </aside>
    </div>

    <script>
        function workspaceChat(config) {
            return {
                endpoint: config.endpoint,
                csrf: config.csrf,
                mode: config.mode || 'qa',
                messages: config.initialMessages || [],
                suggestions: config.suggestions || [],
                prompt: '',
                isLoading: false,
                async sendPrompt() {
                    const userPrompt = this.prompt.trim();
                    if (! userPrompt || this.isLoading) return;

                    this.messages.push({
                        role: 'user',
                        content: userPrompt,
                        created_at: 'Now',
                        citations: [],
                    });

                    const assistantMessage = {
                        role: 'assistant',
                        content: '',
                        created_at: 'Now',
                        citations: [],
                    };

                    this.messages.push(assistantMessage);
                    this.prompt = '';
                    this.isLoading = true;
                    this.scrollToBottom();

                    try {
                        const response = await fetch(this.endpoint, {
                            method: 'POST',
                            headers: {
                                'Accept': 'text/event-stream',
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': this.csrf,
                            },
                            body: JSON.stringify({
                                prompt: userPrompt,
                                mode: this.mode,
                                stream: true,
                            }),
                        });

                        const reader = response.body.getReader();
                        const decoder = new TextDecoder();
                        let buffer = '';

                        while (true) {
                            const { value, done } = await reader.read();
                            if (done) break;

                            buffer += decoder.decode(value, { stream: true });
                            const chunks = buffer.split('\n\n');
                            buffer = chunks.pop() || '';

                            chunks.forEach((eventChunk) => {
                                if (! eventChunk.startsWith('data: ')) {
                                    return;
                                }

                                const payload = JSON.parse(eventChunk.replace('data: ', ''));

                                if (payload.chunk) {
                                    assistantMessage.content += payload.chunk;
                                }

                                if (payload.message) {
                                    assistantMessage.id = payload.message.id;
                                    assistantMessage.content = payload.message.content;
                                    assistantMessage.citations = payload.message.citations || [];
                                }

                                this.scrollToBottom();
                            });
                        }
                    } catch (error) {
                        assistantMessage.content = 'The AI response could not be completed right now. Please try again after the current source processing finishes or after verifying the OpenAI configuration.';
                    } finally {
                        this.isLoading = false;
                        this.scrollToBottom();
                    }
                },
                scrollToBottom() {
                    this.$nextTick(() => {
                        const container = document.getElementById('chat-scroll');
                        if (container) {
                            container.scrollTop = container.scrollHeight;
                        }
                    });
                },
            };
        }
    </script>
</x-app-layout>
