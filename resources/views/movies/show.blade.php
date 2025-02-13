<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $movie->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <div class="space-y-4">
                            <img src="{{ asset('storage/' . $movie->poster) }}" alt="{{ $movie->title }}"
                                class="w-full rounded-lg shadow-lg">
                            <div class="space-y-2">
                                <p><strong>Duration:</strong> {{ $movie->duration }} min</p>
                                <p><strong>Release Date:</strong>
                                    {{ \Carbon\Carbon::parse($movie->release_date)->format('M d, Y') }}</p>
                                <p><strong>Status:</strong>
                                    <span
                                        class="px-2 py-1 text-sm rounded-full {{ $movie->status === 'now_showing' ? 'bg-green-500' : 'bg-yellow-500' }}">
                                        {{ ucfirst(str_replace('_', ' ', $movie->status)) }}
                                    </span>
                                </p>
                                <p><strong>Rating:</strong>
                                    <span class="text-yellow-500">★ {{ number_format($movie->rating, 1) }}</span>
                                </p>
                            </div>
                        </div>
                        <div class="space-y-6">
                            <h3 class="text-lg font-semibold">Synopsis</h3>
                            <p class="text-gray-700 dark:text-gray-300">{{ $movie->synopsis }}</p>
                            @if ($movie->trailer_url)
                                <h3 class="text-lg font-semibold">Trailer</h3>
                                <div class="aspect-w-16 aspect-h-9">
                                    <iframe src="{{ $movie->trailer_url }}" class="w-full rounded-lg shadow-md"
                                        allowfullscreen></iframe>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="mt-12">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-xl font-semibold">User Reviews</h3>
                            @auth
                                <button onclick="document.getElementById('review-form').classList.toggle('hidden')"
                                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                                    Write a Review
                                </button>
                            @endauth
                        </div>

                        <div class="space-y-4">
                            @forelse($movie->reviews as $review)
                                <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <p class="font-semibold">{{ $review->user->name }}</p>
                                            <p class="text-yellow-500">★ {{ $review->rating }}</p>
                                        </div>
                                        <span class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $review->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                    <p class="text-gray-700 dark:text-gray-300">{{ $review->comment }}</p>
                                    <div class="mt-2 flex space-x-2">
                                        @can('update', $review)
                                            <button class="text-blue-500 hover:text-blue-700 text-sm edit-btn"
                                                data-id="{{ $review->id }}" data-rating="{{ $review->rating }}"
                                                data-comment="{{ $review->comment }}">
                                                Edit Review
                                            </button>
                                        @endcan
                                        @can('delete', $review)
                                            <button class="text-red-500 hover:text-red-700 text-sm delete-btn"
                                                data-id="{{ $review->id }}">
                                                Delete Review
                                            </button>
                                        @endcan
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-600 dark:text-gray-400">No reviews yet</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function() {
                    let reviewId = this.getAttribute('data-id');
                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'You won\'t be able to revert this!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(`/reviews/${reviewId}`, {
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector(
                                            'meta[name="csrf-token"]').getAttribute(
                                            'content'),
                                        'Content-Type': 'application/json'
                                    }
                                })
                                .then(response => {
                                    if (!response.ok) throw new Error(
                                        'Failed to delete');
                                    return response.json();
                                })
                                .then(() => location.reload())
                                .catch(error => console.error('Error:', error));
                        }
                    });
                });
            });
        });
    </script>
</x-app-layout>
