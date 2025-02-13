<section class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
    <header>
        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <!-- Form untuk Update Profil -->
    <form id="profile-form" method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6"
        enctype="multipart/form-data">
        @csrf
        @method('patch')
        <!-- Foto Profil -->
        <div x-data="{ previewUrl: '{{ $user->profile_photo_url ?? '' }}' }">
            <x-input-label for="photo" :value="__('Profile Photo')" />

            <div class="mt-3 flex items-center gap-4">
                <img x-show="previewUrl" :src="previewUrl" alt="Profile Photo"
                    class="w-20 h-20 rounded-full object-cover border border-gray-300 dark:border-gray-700 shadow-md transition-transform hover:scale-105">

                <input id="photo" name="photo" type="file"
                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-md cursor-pointer dark:text-gray-400 dark:border-gray-600 dark:bg-gray-700 focus:ring focus:ring-indigo-300"
                    x-on:change="previewUrl = URL.createObjectURL($event.target.files[0])">
            </div>

            <x-input-error class="mt-2" :messages="$errors->get('photo')" />
        </div>


        <!-- Nama -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text"
                class="mt-1 block w-full border-gray-300 dark:border-gray-600 focus:ring focus:ring-indigo-300 rounded-md shadow-sm"
                :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email"
                class="mt-1 block w-full border-gray-300 dark:border-gray-600 focus:ring focus:ring-indigo-300 rounded-md shadow-sm"
                :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        <!-- Tombol Simpan dengan SweetAlert -->
        <div class="flex items-center gap-4">
            <button type="button" id="save-btn"
                class="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded-lg shadow-md transition-all">
                {{ __('Save') }}
            </button>
        </div>
    </form>
</section>

<!-- SweetAlert Script -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('save-btn').addEventListener('click', function() {
        Swal.fire({
            title: "Are you sure?",
            text: "Do you want to save the changes?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, save it!"
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('profile-form').submit();
            }
        });
    });

    // Menampilkan notifikasi sukses setelah update
    @if (session('status') === 'profile-updated')
        Swal.fire({
            title: "Success!",
            text: "Your profile has been updated successfully.",
            icon: "success",
            timer: 2000,
            showConfirmButton: false
        });
    @endif
</script>
