<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create New Movie') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('admin.movies.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="title"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Title</label>
                            <input type="text" name="title" id="title"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100"
                                required>
                        </div>

                        <div class="mb-4">
                            <label for="synopsis"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Synopsis</label>
                            <textarea name="synopsis" id="synopsis" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100"
                                required></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="genre"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Genre</label>
                            <input type="text" name="genre" id="genre"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100"
                                required>
                        </div>

                        <div class="mb-4">
                            <label for="duration"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Duration
                                (minutes)</label>
                            <input type="number" name="duration" id="duration"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100"
                                required>
                        </div>

                        <div class="mb-4">
                            <label for="poster"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Poster</label>
                            <input type="file" name="poster" id="poster"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100"
                                required>
                        </div>

                        <div class="mb-4">
                            <label for="trailer_url"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Trailer URL</label>
                            <input type="url" name="trailer_url" id="trailer_url"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100">
                        </div>

                        <div class="mb-4">
                            <label for="release_date"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Release Date</label>
                            <input type="date" name="release_date" id="release_date"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100"
                                required>
                        </div>

                        <div class="mb-4">
                            <label for="status"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                            <select name="status" id="status"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100"
                                required>
                                <option value="now_showing">Now Showing</option>
                                <option value="coming_soon">Coming Soon</option>
                            </select>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Create Movie
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
