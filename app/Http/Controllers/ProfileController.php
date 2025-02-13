<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rules\CurrentPassword;
use Illuminate\Validation\Rule;


class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();
        $oldEmail = $user->email; // Simpan email lama untuk pengecekan perubahan

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'photo' => ['nullable', 'image', 'max:2048'],
            'current_password' => [
                'required_with:password',
                function ($attribute, $value, $fail) use ($user) {
                    if (!Hash::check($value, $user->password)) {
                        $fail('The current password is incorrect.');
                    }
                },
            ],
            'password' => ['nullable', Password::defaults(), 'confirmed'],
        ]);

        // Handle profile photo update (tanpa metode terpisah)
        if ($request->hasFile('photo')) {
            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }

            $user->profile_photo_path = $request->file('photo')->store('profile-photos', 'public');
        }

        // Handle password update
        if ($request->filled('password')) {
            $user->password = Hash::make($validated['password']);
        }

        // Handle email update & verifikasi ulang jika berubah
        if ($validated['email'] !== $oldEmail) {
            $user->email_verified_at = null;
            // $user->sendEmailVerificationNotification();
        }

        $user->fill($validated)->save(); // Optimasi penyimpanan data

        return redirect()->route('profile.edit')
            ->with('status', 'Profile updated successfully!');
    }
}
