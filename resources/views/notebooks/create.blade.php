<x-app-layout>
    <x-slot name="header">
        <div>
            <div class="chip mb-2">Create notebook</div>
            <div class="text-2xl font-bold text-white sm:text-3xl">Launch a new AI workspace for policy, project, or governance knowledge.</div>
        </div>
    </x-slot>

    <form method="POST" action="{{ route('notebooks.store') }}">
        @csrf
        @include('notebooks.partials.form')
    </form>
</x-app-layout>
