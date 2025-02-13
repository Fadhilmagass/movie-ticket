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
                @php
                    $stats = [
                        ['title' => 'Total Movies', 'count' => $totalMovies, 'icon' => 'film'],
                        ['title' => 'Total Users', 'count' => $totalUsers, 'icon' => 'users'],
                        ['title' => 'Total Reviews', 'count' => $totalReviews, 'icon' => 'message-square'],
                    ];
                @endphp

                @foreach ($stats as $stat)
                    <div
                        class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-xl p-6 flex items-center space-x-4">
                        <div class="bg-blue-500 text-white p-3 rounded-full">
                            <x-lucide-{{ $stat['icon'] }} class="w-6 h-6" />
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold">{{ $stat['title'] }}</h3>
                            <p class="text-3xl font-bold">{{ $stat['count'] }}</p>
                        </div>
                    </div>
                @endforeach

                <!-- Film Terbaru -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-xl p-6 md:col-span-3">
                    <h3 class="text-lg font-semibold mb-4">Latest Movies</h3>
                    <ul>
                        @foreach ($latestMovies as $movie)
                            <li class="py-3 border-b last:border-none flex justify-between items-center">
                                <a href="{{ route('movies.show', $movie->slug) }}"
                                    class="text-blue-500 hover:text-blue-700 transition">
                                    {{ $movie->title }} ({{ optional($movie->release_date)->format('Y') }})
                                </a>
                                <span
                                    class="text-sm text-gray-500 dark:text-gray-400">{{ $movie->created_at->diffForHumans() }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Shortcut Menu -->
                @role('admin')
                    <div
                        class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-xl p-6 md:col-span-3 flex justify-end">
                        <a href="{{ route('admin.movies.create') }}"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition duration-300">
                            + Add New Movie
                        </a>
                    </div>
                @endrole

            </div>
        </div>
    </div>
</x-app-layout>
