script<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $movie->title ?? 'Movie Details' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if ($movie)
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            <div class="space-y-4">
                                @if ($movie->poster)
                                    <img src="{{ asset('storage/' . $movie->poster) }}" alt="{{ $movie->title }}"
                                        class="w-full rounded-lg shadow-lg"
                                        onerror="this.src='{{ asset('images/default-poster.jpg') }}'">
                                @else
                                    <img src="{{ asset('images/default-poster.jpg') }}" alt="{{ $movie->title }}"
                                        class="w-full rounded-lg shadow-lg">
                                @endif

                                <div class="space-y-2">
                                    <p><strong>Duration:</strong> {{ $movie->duration ?? 'N/A' }} min</p>
                                    <p><strong>Release Date:</strong>
                                        {{ $movie->release_date ? \Carbon\Carbon::parse($movie->release_date)->format('M d, Y') : 'N/A' }}
                                    </p>
                                    <p><strong>Status:</strong>
                                        <span
                                            class="px-2 py-1 text-sm rounded-full {{ $movie->status === 'now_showing' ? 'bg-green-500' : ($movie->status === 'coming_soon' ? 'bg-yellow-500' : 'bg-gray-500') }}">
                                            {{ ucfirst(str_replace('_', ' ', $movie->status ?? 'unknown')) }}
                                        </span>
                                    </p>
                                    <p><strong>Rating:</strong>
                                        <span class="text-yellow-500">★
                                            {{ number_format($movie->rating ?? 0, 1) }}</span>
                                    </p>
                                </div>
                            </div>
                            <div class="space-y-6">
                                <h3 class="text-lg font-semibold">Synopsis</h3>
                                <p class="text-gray-700 dark:text-gray-300">
                                    {{ $movie->synopsis ?? 'No synopsis available.' }}</p>

                                @if ($movie->trailer_url)
                                    <h3 class="text-lg font-semibold">Trailer</h3>
                                    <div class="aspect-w-16 aspect-h-9">
                                        @php
                                            $videoId = '';
                                            if (str_contains($movie->trailer_url, 'v=')) {
                                                $videoId = explode('v=', $movie->trailer_url)[1];
                                                // Handle additional parameters
                                                if (str_contains($videoId, '&')) {
                                                    $videoId = explode('&', $videoId)[0];
                                                }
                                            } elseif (str_contains($movie->trailer_url, 'youtu.be/')) {
                                                $videoId = explode('youtu.be/', $movie->trailer_url)[1];
                                            }
                                        @endphp
                                        @if ($videoId)
                                            <iframe src="https://www.youtube.com/embed/{{ $videoId }}"
                                                class="w-full rounded-lg shadow-md" allowfullscreen loading="lazy">
                                            </iframe>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="mt-12">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="text-xl font-semibold">User Reviews</h3>
                                @auth
                                    <!-- Tombol Trigger -->
                                    <button onclick="toggleReviewModal()"
                                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition"
                                        id="write-review-btn">
                                        Write a Review
                                    </button>
                                    <!-- Modal -->
                                    <div id="review-modal"
                                        class="hidden fixed inset-0 z-50 overflow-auto bg-black bg-opacity-50">
                                        <div class="relative flex items-center justify-center min-h-screen px-4">
                                            <!-- Modal Content -->
                                            <div
                                                class="relative bg-white dark:bg-gray-800 rounded-lg shadow-xl w-full max-w-md p-6">
                                                <!-- Header -->
                                                <div class="flex justify-between items-center mb-4">
                                                    <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Write
                                                        a Review</h3>
                                                    <button onclick="toggleReviewModal()"
                                                        class="text-gray-500 hover:text-gray-700 dark:text-gray-400">
                                                        &times;
                                                    </button>
                                                </div>

                                                <!-- Form -->
                                                <form id="submit-review" action="{{ route('reviews.store') }}"
                                                    method="POST">
                                                    @csrf
                                                    <input type="hidden" name="movie_id" value="{{ $movie->id }}">

                                                    <div class="mb-4">
                                                        <label class="block text-gray-700 dark:text-gray-300 mb-2">Your
                                                            Rating</label>
                                                        <select name="rating"
                                                            class="w-full rounded-lg border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100"
                                                            required>
                                                            <option value="">Select Rating</option>
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                <option value="{{ $i }}">{{ $i }}
                                                                    Star{{ $i > 1 ? 's' : '' }}</option>
                                                            @endfor
                                                        </select>
                                                    </div>

                                                    <div class="mb-4">
                                                        <label class="block text-gray-700 dark:text-gray-300 mb-2">Your
                                                            Review</label>
                                                        <textarea name="comment" rows="3"
                                                            class="w-full rounded-lg border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100"
                                                            placeholder="Share your thoughts..." required></textarea>
                                                    </div>

                                                    <div class="flex justify-end gap-2">
                                                        <button type="button" onclick="toggleReviewModal()"
                                                            class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
                                                            Cancel
                                                        </button>
                                                        <button type="submit"
                                                            class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg">
                                                            Submit Review
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endauth
                            </div>

                            <div class="space-y-4">
                                @if ($movie->reviews && $movie->reviews->count() > 0)
                                    @foreach ($movie->reviews as $review)
                                        <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg"
                                            id="review-{{ $review->id }}">
                                            <div class="flex justify-between items-start mb-2">
                                                <div>
                                                    <p class="font-semibold">
                                                        {{ optional($review->user)->name ?? 'Anonymous' }}</p>
                                                    <p class="text-yellow-500">★
                                                        {{ number_format($review->rating, 1) }}</p>
                                                </div>
                                                <span class="text-sm text-gray-500 dark:text-gray-400">
                                                    {{ optional($review->created_at)->diffForHumans() ?? 'Recent' }}
                                                </span>
                                            </div>
                                            <p class="text-gray-700 dark:text-gray-300">{{ $review->comment }}</p>
                                            <div class="mt-2 flex space-x-2">
                                                @can('update', $review)
                                                    <button class="text-blue-500 hover:text-blue-700 text-sm edit-btn"
                                                        data-id="{{ $review->id }}" data-rating="{{ $review->rating }}"
                                                        data-comment="{{ htmlspecialchars($review->comment, ENT_QUOTES, 'UTF-8') }}"
                                                        onclick="editReview(event)">
                                                        Edit Review
                                                    </button>

                                                    <!-- Modal Edit Review -->
                                                    <div id="edit-modal"
                                                        class="hidden fixed inset-0 z-50 overflow-auto bg-black bg-opacity-50">
                                                        <div
                                                            class="relative flex items-center justify-center min-h-screen px-4">
                                                            <div
                                                                class="relative bg-white dark:bg-gray-800 rounded-lg shadow-xl w-full max-w-md p-6">
                                                                <!-- Header -->
                                                                <div class="flex justify-between items-center mb-4">
                                                                    <h3
                                                                        class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                                                                        Edit Review</h3>
                                                                    <button onclick="closeEditModal()"
                                                                        class="text-gray-500 hover:text-gray-700 dark:text-gray-400">
                                                                        &times;
                                                                    </button>
                                                                </div>

                                                                <!-- Form -->
                                                                <form id="edit-review-form" class="space-y-4">
                                                                    @csrf
                                                                    @method('PUT')

                                                                    <div>
                                                                        <label
                                                                            class="block text-gray-700 dark:text-gray-300 mb-2">Rating</label>
                                                                        <select id="edit-rating" name="rating"
                                                                            class="w-full rounded-lg border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100"
                                                                            required>
                                                                            @for ($i = 1; $i <= 5; $i++)
                                                                                <option value="{{ $i }}">
                                                                                    {{ $i }}
                                                                                    Star{{ $i > 1 ? 's' : '' }}</option>
                                                                            @endfor
                                                                        </select>
                                                                    </div>

                                                                    <div>
                                                                        <label
                                                                            class="block text-gray-700 dark:text-gray-300 mb-2">Review</label>
                                                                        <textarea id="edit-comment" name="comment"
                                                                            class="w-full rounded-lg border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100"
                                                                            rows="3" required></textarea>
                                                                    </div>

                                                                    <div class="flex justify-end gap-2">
                                                                        <button type="button" onclick="closeEditModal()"
                                                                            class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
                                                                            Cancel
                                                                        </button>
                                                                        <button type="submit"
                                                                            class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg">
                                                                            Update Review
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endcan

                                                <!-- Tambahkan ini untuk admin -->
                                                @role('admin')
                                                    <form action="{{ route('admin.reviews.destroy', $review) }}"
                                                        method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="text-red-500 hover:text-red-700 text-sm"
                                                            onclick="return confirm('Delete this review permanently?')">
                                                            Delete as Admin
                                                        </button>
                                                    </form>
                                                @endrole
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <p class="text-gray-600 dark:text-gray-400">No reviews yet</p>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-600 dark:text-gray-400">Movie not found</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        // Modal review
        // Toggle Modal
        function toggleReviewModal() {
            const modal = document.getElementById('review-modal');
            modal.classList.toggle('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('review-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                toggleReviewModal();
            }
        });

        // Handle form submission
        document.getElementById('submit-review').addEventListener('submit', function(e) {
            e.preventDefault();

            fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: new FormData(this)
                })
                .then(response => {
                    if (response.ok) {
                        toggleReviewModal();
                        location.reload();
                    } else {
                        alert('Failed to submit review');
                    }
                })
                .catch(error => console.error('Error:', error));
        });

        // Handle form submission
        document.getElementById('submit-review').addEventListener('submit', function(e) {
            e.preventDefault();

            fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: new FormData(this)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Failed to submit review');
                    }
                })
                .catch(error => console.error('Error:', error));
        });

        function submitReview(data) {
            fetch('{{ route('reviews.store') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(data)
                })
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(() => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Review Submitted!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    setTimeout(() => location.reload(), 1500);
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed to submit review',
                        text: 'Please try again later'
                    });
                });
        }
        // Modal review end

        // Modal edit review
        let currentReviewId = null;

        function editReview(event) {
            event.preventDefault();
            const button = event.currentTarget;

            // Ambil data dari atribut button
            currentReviewId = button.dataset.id;
            const rating = button.dataset.rating;
            const comment = button.dataset.comment;

            // Isi form
            document.getElementById('edit-rating').value = rating;
            document.getElementById('edit-comment').value = comment;

            // Tampilkan modal
            document.getElementById('edit-modal').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('edit-modal').classList.add('hidden');
            currentReviewId = null;
        }

        // Handle form submission
        document.getElementById('edit-review-form').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = {
                rating: this.rating.value,
                comment: this.comment.value
            };

            fetch(`/reviews/${currentReviewId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(formData)
                })
                .then(response => {
                    if (response.ok) {
                        closeEditModal();
                        location.reload();
                    } else {
                        alert('Failed to update review');
                    }
                })
                .catch(error => console.error('Error:', error));
        });

        // Close modal ketika klik di luar
        document.getElementById('edit-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeEditModal();
            }
        });
        // Modal edit review end

        function deleteReview(reviewId, isAdmin = false) {
            const url = isAdmin ? `/admin/reviews/${reviewId}` : `/reviews/${reviewId}`;

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
                    fetch(url, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(response => {
                            if (!response.ok) throw new Error('Failed to delete review');
                            return response.json();
                        })
                        .then(() => {
                            document.getElementById(`review-${reviewId}`).remove();
                            Swal.fire('Deleted!', 'Review has been deleted.', 'success');
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire('Error', 'Failed to delete review', 'error');
                        });
                }
            });
        }

        // Error handling for images
        document.addEventListener('DOMContentLoaded', function() {
            const moviePoster = document.querySelector('img[alt="{{ $movie->title }}"]');
            if (moviePoster) {
                moviePoster.addEventListener('error', function() {
                    this.src = '{{ asset('images/default-poster.jpg') }}';
                });
            }
        });
    </script>

</x-app-layout>
