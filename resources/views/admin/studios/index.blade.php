<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage Studio') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl overflow-hidden">
                <div class="p-8 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <a href="{{ route('admin.studios.create') }}"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg shadow-md transition duration-300">
                            + Add New Studio
                        </a>
                    </div>

                    <div class="overflow-x-auto rounded-lg shadow">
                        <table
                            class="min-w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg">
                            <thead class="bg-gray-200 dark:bg-gray-800">
                                <tr class="text-left text-gray-700 dark:text-gray-300">
                                    <th class="px-6 py-3 font-semibold">Name</th>
                                    <th class="px-6 py-3 font-semibold">Location</th>
                                    <th class="px-6 py-3 font-semibold">Capacity</th>
                                    <th class="px-6 py-3 font-semibold text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($studios as $studio)
                                    <tr
                                        class="border-t border-gray-300 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                                        <td class="px-6 py-4">{{ $studio->name }}</td>
                                        <td class="px-6 py-4">{{ $studio->location }}</td>
                                        <td class="px-6 py-4">{{ $studio->capacity }}</td>
                                        <td class="px-6 py-4 flex justify-center space-x-4">
                                            <a href="{{ route('admin.studios.edit', $studio) }}"
                                                class="text-blue-600 hover:text-blue-800 font-medium transition">
                                                Edit
                                            </a>
                                            <form action="{{ route('admin.studios.destroy', $studio) }}" method="post"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 hover:text-red-800 font-medium transition"
                                                    onclick="return confirm('Are you sure you want to delete this studio?')">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6 flex justify-center">
                        {{ $studios->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
