<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ isset($studio) ? __('Edit Studio') : __('Create New Studio') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl overflow-hidden">
                <div class="p-8 text-gray-900 dark:text-gray-100">
                    <form
                        action="{{ isset($studio) ? route('admin.studios.update', $studio) : route('admin.studios.store') }}"
                        method="POST" class="space-y-6">
                        @csrf
                        @if (isset($studio))
                            @method('PUT')
                        @endif

                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">Name</label>
                            <input type="text" name="name" value="{{ old('name', $studio->name ?? '') }}"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                required>
                        </div>

                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">Location</label>
                            <input type="text" name="location" value="{{ old('location', $studio->location ?? '') }}"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                required>
                        </div>

                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">Capacity</label>
                            <input type="number" name="capacity" value="{{ old('capacity', $studio->capacity ?? '') }}"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                min="1" required>
                        </div>

                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">Description</label>
                            <textarea name="description" rows="4"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">{{ old('description', $studio->description ?? '') }}</textarea>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg shadow-md transition duration-300">
                                {{ isset($studio) ? 'Update' : 'Create' }} Studio
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
