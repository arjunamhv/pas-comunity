<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();

        $formattedId = $user->id;

        $part1 = substr($formattedId, 0, 4);
        $part2 = substr($formattedId, 4, 6);
        $part3 = substr($formattedId, 10, 6);
        $part4 = substr($formattedId, 16, 3);

        $formattedId = $part1 . ' ' . $part2 . ' ' . $part3 . ' ' . $part4;

        return view('profile.edit', [
            'user' => $user,
            'formattedId' => $formattedId,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        if ($request->hasFile('foto')) {
            if ($user->foto) {
                Storage::disk('minio')->delete($user->foto);
            }

            $filePath = $request->file('foto')->getRealPath();
            $apiKey = 'FXZzcfLdbMjhoLMnCQ7xEHth';

            try {
                $client = new \GuzzleHttp\Client();
                $res = $client->post('https://api.remove.bg/v1.0/removebg', [
                    'multipart' => [
                        [
                            'name' => 'image_file',
                            'contents' => fopen($filePath, 'r')
                        ],
                        [
                            'name' => 'size',
                            'contents' => 'auto'
                        ]
                    ],
                    'headers' => [
                        'X-Api-Key' => $apiKey
                    ]
                ]);

                if ($res->getStatusCode() === 200) {
                    $filename = 'foto-id-card/' . Str::uuid() . '.png';
                    Storage::disk('minio')->put($filename, $res->getBody(), 'public');

                    $user->foto = $filename;
                } else {
                    return Redirect::route('profile.edit')->withErrors('Failed to remove background from the image.');
                }
            } catch (\Exception $e) {
                return Redirect::route('profile.edit')->withErrors('Error connecting to Remove.bg API: ' . $e->getMessage());
            }
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
