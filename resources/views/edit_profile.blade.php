<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @if (session('status'))
                        <div class="mb-4 font-medium text-sm text-green-600">
                            {{ session('status') }}
                        </div>
                    @endif

                    <!-- Current Profile Picture -->
                    @if(auth()->user()->profile_picture)
                        <div class="mb-4">
                            <img src="{{ Storage::disk('s3')->url(auth()->user()->profile_picture) }}" 
                                 alt="Profile Picture"
                                 class="rounded-full h-20 w-20 object-cover" />
                        </div>
                    @endif

                    <!-- Profile Picture Form -->
                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('patch')

                        <div class="mb-4">
                            <x-input-label for="profile_picture" value="Profile Picture" />
                            <input type="file" 
                                   id="profile_picture" 
                                   name="profile_picture"
                                   class="mt-1 block w-full" 
                                   accept="image/*" />
                            <x-input-error :messages="$errors->get('profile_picture')" class="mt-2" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Save') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>