<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'NoteGov AI DILG') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=manrope:400,500,600,700,800|space-grotesk:400,500,700&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="relative overflow-hidden">
            <div class="absolute inset-0 opacity-80">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(56,189,248,0.2),transparent_32%),radial-gradient(circle_at_bottom_right,rgba(245,158,11,0.22),transparent_30%)]"></div>
                <div class="floating-grid absolute inset-0 opacity-30"></div>
            </div>

            <div class="relative mx-auto flex min-h-screen max-w-7xl flex-col px-4 py-6 sm:px-6 lg:px-8">
                <header class="flex items-center justify-between gap-4">
                    <a href="{{ route('home') }}" class="flex items-center gap-4">
                        <x-application-logo class="h-12 w-12" />
                        <div>
                            <p class="text-xs uppercase tracking-[0.28em] text-sky-200/80">Government AI Platform</p>
                            <p class="text-xl font-bold text-white">NoteGov AI DILG</p>
                        </div>
                    </a>
                    <div class="flex items-center gap-3">
                        @auth
                            <a href="{{ route('dashboard') }}" class="btn-primary">Open Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="btn-secondary">Sign InAHAHAHAHAHHAHAHH</a>
                            <a href="{{ route('register') }}" class="btn-primary">Create Account</a>
                        @endauth
                    </div>
                </header>

                <main class="grid flex-1 items-center gap-10 py-12 lg:grid-cols-[1.05fr_.95fr]">
                    <section>
                        <div class="chip">NotebookLM-inspired knowledge workspace</div>
                        <h1 class="mt-6 max-w-3xl text-5xl font-bold leading-tight text-white sm:text-6xl">A smart governance notebook for DILG teams, policy units, and local operations.</h1>
                        <p class="mt-6 max-w-2xl text-lg leading-8 text-slate-300">Create notebooks, upload sources, ask grounded AI questions, generate policy briefs, compare documents, and keep institutional knowledge organized in one responsive dark workspace.</p>

                        <div class="mt-8 flex flex-wrap gap-3">
                            @auth
                                <a href="{{ route('dashboard') }}" class="btn-primary">Go to Dashboard</a>
                            @else
                                <a href="{{ route('register') }}" class="btn-primary">Start Building Notebooks</a>
                                <a href="{{ route('login') }}" class="btn-secondary">Use Existing Access</a>
                            @endauth
                        </div>

                        <div class="mt-10 grid gap-4 sm:grid-cols-3">
                            <div class="panel p-5">
                                <p class="text-xs uppercase tracking-[0.24em] text-slate-400">Source-ready</p>
                                <p class="mt-3 text-xl font-bold text-white">PDF, DOCX, TXT, web, audio, video</p>
                            </div>
                            <div class="panel p-5">
                                <p class="text-xs uppercase tracking-[0.24em] text-slate-400">AI-native</p>
                                <p class="mt-3 text-xl font-bold text-white">RAG chat, summaries, reports, briefs</p>
                            </div>
                            <div class="panel p-5">
                                <p class="text-xs uppercase tracking-[0.24em] text-slate-400">Governance-safe</p>
                                <p class="mt-3 text-xl font-bold text-white">Roles, activity history, secure uploads</p>
                            </div>
                        </div>
                    </section>

                    <section class="space-y-6">
                        <div class="panel p-6">
                            <div class="rounded-[28px] border border-white/10 bg-slate-950/60 p-5">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-xs uppercase tracking-[0.24em] text-slate-400">Notebook Workspace</p>
                                        <h2 class="mt-2 text-2xl font-bold text-white">Flood Resilience Coordination</h2>
                                    </div>
                                    <span class="chip">Shared</span>
                                </div>

                                <div class="mt-6 grid gap-4 lg:grid-cols-[.9fr_1.1fr]">
                                    <div class="panel-muted space-y-3 p-4">
                                        <p class="text-xs uppercase tracking-[0.22em] text-slate-500">Sources</p>
                                        <div class="rounded-2xl border border-white/8 bg-white/5 px-4 py-3 text-sm text-slate-200">Provincial risk assessment.pdf</div>
                                        <div class="rounded-2xl border border-white/8 bg-white/5 px-4 py-3 text-sm text-slate-200">Municipal DRRM briefing.docx</div>
                                        <div class="rounded-2xl border border-white/8 bg-white/5 px-4 py-3 text-sm text-slate-200">Meeting recording.mp4</div>
                                    </div>

                                    <div class="panel-muted p-4">
                                        <p class="text-xs uppercase tracking-[0.22em] text-slate-500">AI response</p>
                                        <div class="mt-4 rounded-2xl border border-sky-300/15 bg-sky-400/10 p-4 text-sm leading-7 text-slate-100">
                                            The uploaded materials indicate three recurring issues: delayed barangay reporting, overlapping evacuation protocols, and uneven budget visibility. Suggested next step: generate a concise policy brief for field coordination and budget alignment.
                                        </div>
                                        <div class="mt-4 flex flex-wrap gap-2">
                                            <span class="chip">Action items</span>
                                            <span class="chip">Policy brief</span>
                                            <span class="chip">Cross-source compare</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="grid gap-4 sm:grid-cols-2">
                            <div class="panel p-5">
                                <p class="text-xs uppercase tracking-[0.24em] text-slate-400">Core Capabilities</p>
                                <ul class="mt-4 space-y-3 text-sm leading-7 text-slate-300">
                                    <li>Context-aware AI chat for every notebook</li>
                                    <li>Suggested questions and smart tagging</li>
                                    <li>Activity history and exportable chat reports</li>
                                </ul>
                            </div>
                            <div class="panel p-5">
                                <p class="text-xs uppercase tracking-[0.24em] text-slate-400">Built For</p>
                                <ul class="mt-4 space-y-3 text-sm leading-7 text-slate-300">
                                    <li>Policy development and legal reference work</li>
                                    <li>Project monitoring and governance research</li>
                                    <li>DILG operations and LGU coordination</li>
                                </ul>
                            </div>
                        </div>
                    </section>
                </main>
            </div>
        </div>
    </body>
</html>
