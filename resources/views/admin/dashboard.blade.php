<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

                @php
                    $stats = [
                        [
                            'title' => 'Total Movies',
                            'count' => $totalMovies ?? 0,
                            'icon' => 'film',
                            'color' => 'bg-blue-500',
                        ],
                        [
                            'title' => 'Total Users',
                            'count' => $totalUsers ?? 0,
                            'icon' => 'users',
                            'color' => 'bg-green-500',
                        ],
                        [
                            'title' => 'Total Reviews',
                            'count' => $totalReviews ?? 0,
                            'icon' => 'message-square',
                            'color' => 'bg-yellow-500',
                        ],
                        [
                            'title' => 'Total Studios',
                            'count' => $totalStudios ?? 0,
                            'icon' => 'building',
                            'color' => 'bg-red-500',
                        ],
                    ];
                @endphp

                @foreach ($stats as $stat)
                    <div
                        class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-xl p-6 flex items-center space-x-4 transform hover:scale-105 transition duration-300">
                        <div class="{{ $stat['color'] }} text-white p-4 rounded-full shadow-md">
                            <x-lucide-{{ $stat['icon'] }} class="w-8 h-8" />
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">{{ $stat['title'] }}</h3>
                            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stat['count'] }}</p>
                        </div>
                    </div>
                @endforeach

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-xl p-6 md:col-span-4">
                    <h3 class="text-lg font-semibold mb-4 text-gray-700 dark:text-gray-300">Latest Movies</h3>
                    <ul class="divide-y divide-gray-300 dark:divide-gray-700">
                        @forelse ($latestMovies ?? [] as $movie)
                            <li class="py-4 flex justify-between items-center">
                                <a href="{{ route('movies.show', $movie->slug) }}"
                                    class="text-blue-500 hover:text-blue-700 transition font-medium">
                                    {{ $movie->title }} ({{ optional($movie->release_date)->format('Y') }})
                                </a>
                                <span class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ optional($movie->created_at)->diffForHumans() }}
                                </span>
                            </li>
                        @empty
                            <li class="py-4 text-gray-500 dark:text-gray-400">No movies available.</li>
                        @endforelse
                    </ul>
                </div>

                @role('admin')
                    <div
                        class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-xl p-6 md:col-span-4 flex justify-end">
                        <a href="{{ route('admin.movies.create') }}"
                            class="bg-gradient-to-r from-blue-500 to-blue-700 hover:from-blue-600 hover:to-blue-800 text-white font-bold py-3 px-6 rounded-lg shadow-md transform hover:scale-105 transition duration-300">
                            + Add New Movie
                        </a>
                    </div>
                @endrole
            </div>
        </div>
    </div>
</x-app-layout>
