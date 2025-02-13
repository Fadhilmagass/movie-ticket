<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <!-- Statistik -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold">Total Movies</h3>
                    <p class="text-3xl font-bold">{{ $totalMovies }}</p>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold">Total Users</h3>
                    <p class="text-3xl font-bold">{{ $totalUsers }}</p>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold">Total Reviews</h3>
                    <p class="text-3xl font-bold">{{ $totalReviews }}</p>
                </div>

                <!-- Film Terbaru -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 md:col-span-3">
                    <h3 class="text-lg font-semibold mb-4">Latest Movies</h3>
                    <ul>
                        @foreach ($latestMovies as $movie)
                            <li class="py-2 border-b">
                                <a href="{{ route('movies.show', $movie->id) }}" class="text-blue-500 hover:underline">
                                    {{ $movie->title }} ({{ $movie->release_date->format('Y') }})
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Shortcut Menu -->
                <div
                    class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 md:col-span-3 flex justify-end">
                    <a href="{{ route('admin.movies.create') }}"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        + Add New Movie
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
