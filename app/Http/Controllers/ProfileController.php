<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Http;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $apiKey = config('services.newsapi.key');

        $category = $request->input('category', 'general');

        $response = Http::get('https://newsapi.org/v2/top-headlines', [
            'category' => $category,
            'apiKey' => $apiKey,
            'pageSize' => 3,
            'domains' => 'https://www.prothomalo.com/,techcrunch.com,techradar.com,thenextweb.com,engadget.com,arstechnica.com',
        ]);

        $articles = $response->successful() ? $response->json()['articles'] : [];

        $categories = ['general', 'business', 'entertainment', 'health', 'science', 'sports', 'technology'];

        return view('dashboard', compact('articles', 'categories', 'category'));
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

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
