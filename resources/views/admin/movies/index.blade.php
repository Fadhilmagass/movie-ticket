<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Movie Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <!-- Button Create -->
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-bold">Movies List</h3>
                        <a href="{{ route('admin.movies.create') }}"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition-all">
                            + Create Movie
                        </a>
                    </div>

                    <!-- Tabel -->
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse border border-gray-200 dark:border-gray-700">
                            <thead>
                                <tr class="bg-gray-100 dark:bg-gray-900 text-gray-700 dark:text-gray-200">
                                    <th class="px-4 py-3 text-left">Poster</th>
                                    <th class="px-4 py-3 text-left">Title</th>
                                    <th class="px-4 py-3 text-left">Genre</th>
                                    <th class="px-4 py-3 text-left">Status</th>
                                    <th class="px-4 py-3 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach ($movies as $movie)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-all">
                                        <td class="px-4 py-3">
                                            <img src="{{ asset('storage/' . $movie->poster) }}"
                                                alt="{{ $movie->title }}"
                                                class="w-20 h-32 object-cover rounded-md shadow">
                                        </td>
                                        <td class="px-4 py-3 font-semibold">{{ $movie->title }}</td>
                                        <td class="px-4 py-3">{{ $movie->genre }}</td>
                                        <td class="px-4 py-3">
                                            <span
                                                class="px-3 py-1 text-sm font-semibold rounded-full 
                                                {{ $movie->status === 'now playing' ? 'bg-green-500' : 'bg-yellow-500' }} text-white">
                                                {{ ucfirst($movie->status) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 flex justify-center space-x-4">
                                            <!-- Edit Button -->
                                            <a href="{{ route('admin.movies.edit', $movie) }}"
                                                class="text-blue-600 hover:text-blue-800 transition-all">
                                                ✏️ Edit
                                            </a>

                                            <!-- Delete Button -->
                                            <form action="{{ route('admin.movies.destroy', $movie) }}" method="POST"
                                                class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 hover:text-red-800 transition-all"
                                                    onclick="return confirm('Are you sure you want to delete this movie?')">
                                                    🗑️ Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6 flex justify-center">
                        {{ $movies->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
