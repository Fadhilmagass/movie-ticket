<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Movies') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Search and Filter -->
                    <form action="{{ route('movies.index') }}" method="GET" class="mb-8">
                        <div class="flex gap-4">
                            <input type="text" name="search" placeholder="Search movies..."
                                class="w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100"
                                value="{{ request('search') }}">
                            <select name="status"
                                class="rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100">
                                <option value="">All Status</option>
                                <option value="now_showing" {{ request('status') == 'now_showing' ? 'selected' : '' }}>
                                    Now Showing
                                </option>
                                <option value="coming_soon" {{ request('status') == 'coming_soon' ? 'selected' : '' }}>
                                    Coming Soon
                                </option>
                            </select>
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                                Search
                            </button>
                        </div>
                    </form>

                    <!-- Movie Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @forelse($movies as $movie)
                            <div
                                class="bg-gray-100 dark:bg-gray-700 rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow">
                                <img src="{{ asset('storage/' . $movie->poster) }}" alt="{{ $movie->title }}"
                                    class="w-full h-64 object-cover">
                                <div class="p-4">
                                    <h3 class="font-bold text-lg text-gray-800 dark:text-gray-200 mb-2">
                                        {{ $movie->title }}
                                    </h3>
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">
                                            {{ $movie->genre }}
                                        </span>
                                        <span class="text-yellow-500">
                                            ★ {{ number_format($movie->rating, 1) }}
                                        </span>
                                    </div>
                                    <div class="mt-4">
                                        <a href="{{ route('movies.show', $movie->slug) }}"
                                            class="block w-full text-center bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-8">
                                <p class="text-gray-600 dark:text-gray-400">No movies found</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8">
                        {{ $movies->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
