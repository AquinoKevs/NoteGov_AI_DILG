<x-app-layout>
    <x-slot name="header">
        <div>
            <div class="chip mb-2">User Management</div>
            <div class="text-2xl font-bold text-gray-900 sm:text-3xl">Edit user: {{ $user->name }}</div>
        </div>
    </x-slot>

    <div class="panel max-w-2xl">
        <form method="POST" action="{{ route('users.update', $user) }}">
            @csrf
            @method('PATCH')

            <div class="space-y-6">
                <div>
                    <x-input-label for="name" value="Name" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="email" value="Email" />
                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="password" value="Password (leave blank to keep current)" />
                    <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="role" value="Role" />
                    <select id="role" name="role" class="mt-1 block w-full rounded-2xl border-gray-200 focus:border-sky-500 focus:ring-sky-500">
                        <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>User</option>
                        <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Administrator</option>
                    </select>
                    <x-input-error :messages="$errors->get('role')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="job_title" value="Job Title" />
                    <x-text-input id="job_title" name="job_title" type="text" class="mt-1 block w-full" :value="old('job_title', $user->job_title)" />
                    <x-input-error :messages="$errors->get('job_title')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="office" value="Office" />
                    <x-text-input id="office" name="office" type="text" class="mt-1 block w-full" :value="old('office', $user->office)" />
                    <x-input-error :messages="$errors->get('office')" class="mt-2" />
                </div>

                <div class="flex items-center gap-4 pt-4">
                    <x-primary-button>Update User</x-primary-button>
                    <a href="{{ route('users.index') }}" class="btn-secondary">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
