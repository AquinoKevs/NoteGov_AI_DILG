<x-app-layout>
    <x-slot name="header">
        <div>
            <div class="chip mb-2">User Management</div>
            <div class="text-2xl font-bold text-gray-900 sm:text-3xl">Add new user</div>
        </div>
    </x-slot>

    <div class="panel max-w-2xl">
        <form method="POST" action="{{ route('users.store') }}">
            @csrf

            <div class="space-y-6">
                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" class="mt-1 block w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="mt-1 block w-full" type="email" name="email" :value="old('email')" required autocomplete="email" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="mt-1 block w-full" type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                    <x-text-input id="password_confirmation" class="mt-1 block w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="role" :value="__('Role')" />
                    <select id="role" name="role" class="mt-1 block w-full rounded-md border-gray-300 bg-white py-2 pl-3 pr-10 text-base focus:border-sky-500 focus:outline-none focus:ring-sky-500 sm:text-sm">
                        <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>User</option>
                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                    <x-input-error :messages="$errors->get('role')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="job_title" :value="__('Job Title')" />
                    <x-text-input id="job_title" class="mt-1 block w-full" type="text" name="job_title" :value="old('job_title')" autocomplete="organization-title" />
                    <x-input-error :messages="$errors->get('job_title')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="office" :value="__('Office')" />
                    <x-text-input id="office" class="mt-1 block w-full" type="text" name="office" :value="old('office')" autocomplete="organization" />
                    <x-input-error :messages="$errors->get('office')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end gap-4">
                    <a href="{{ route('users.index') }}" class="btn-secondary">Cancel</a>
                    <x-primary-button>Add User</x-primary-button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
