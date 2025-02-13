<div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg mb-4 transition hover:shadow-md">
    <div class="flex justify-between items-start">
        <div>
            <p class="font-semibold text-gray-800 dark:text-gray-200">{{ $review->user->name }}</p>
            <div class="flex items-center mt-1">
                <span class="text-yellow-500 flex items-center">
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= $review->rating)
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                                <path
                                    d="M12 17.27L18.18 21L16.54 13.97L22 9.24L14.81 8.63L12 2L9.19 8.63L2 9.24L7.46 13.97L5.82 21L12 17.27Z" />
                            </svg>
                        @else
                            <svg class="w-5 h-5 fill-current text-gray-300" viewBox="0 0 24 24">
                                <path
                                    d="M12 17.27L18.18 21L16.54 13.97L22 9.24L14.81 8.63L12 2L9.19 8.63L2 9.24L7.46 13.97L5.82 21L12 17.27Z" />
                            </svg>
                        @endif
                    @endfor
                </span>
                <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">
                    ({{ $review->rating }}/5)
                </span>
            </div>
        </div>
        <p class="text-sm text-gray-600 dark:text-gray-400">
            {{ $review->created_at->diffForHumans() }}
        </p>
    </div>

    @if ($review->comment)
        <p class="mt-3 text-gray-700 dark:text-gray-300">
            {{ $review->comment }}
        </p>
    @endif

    @auth
        @can('manage', $review)
            <div class="mt-3 flex space-x-4">
                <button type="button" class="text-blue-500 hover:text-blue-700 text-sm transition-colors duration-200"
                    onclick="editReview({{ $review->id }}, '{{ $review->comment }}', {{ $review->rating }})">
                    Edit
                </button>

                <button type="button" class="text-red-500 hover:text-red-700 text-sm transition-colors duration-200"
                    onclick="deleteReview({{ $review->id }})">
                    Delete
                </button>
            </div>
        @endcan
    @endauth
</div>

@push('scripts')
    <script>
        function editReview(id, comment, rating) {
            // Implementasi edit modal atau form inline
            Swal.fire({
                title: 'Edit Review',
                html: `
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Rating</label>
                <select id="edit-rating" class="mt-1 block w-full rounded-md border-gray-300">
                    ${[1,2,3,4,5].map(num => 
                        `<option value="${num}" ${rating === num ? 'selected' : ''}>${num} Stars</option>`
                    ).join('')}
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Comment</label>
                <textarea id="edit-comment" class="mt-1 block w-full rounded-md border-gray-300" rows="3">${comment}</textarea>
            </div>
        `,
                showCancelButton: true,
                confirmButtonText: 'Update',
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    const rating = document.getElementById('edit-rating').value;
                    const comment = document.getElementById('edit-comment').value;

                    return fetch(`/reviews/${id}`, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                rating,
                                comment
                            })
                        })
                        .then(response => {
                            if (!response.ok) throw new Error('Failed to update review');
                            return response.json();
                        })
                        .catch(error => {
                            Swal.showValidationMessage(`Request failed: ${error}`);
                        });
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire('Updated!', 'Your review has been updated.', 'success')
                        .then(() => {
                            window.location.reload();
                        });
                }
            });
        }

        function deleteReview(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/reviews/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        })
                        .then(response => {
                            if (!response.ok) throw new Error('Failed to delete review');
                            return response.json();
                        })
                        .then(() => {
                            Swal.fire('Deleted!', 'Your review has been deleted.', 'success')
                                .then(() => {
                                    window.location.reload();
                                });
                        })
                        .catch(error => {
                            Swal.fire('Error!', 'Failed to delete review.', 'error');
                        });
                }
            });
        }
    </script>
@endpush
