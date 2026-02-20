<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class CustomerAuthController extends Controller
{
    // ── Email / Password ──────────────────────────────────────────────────────

    public function showLogin()
    {
        if (Auth::check())
            return redirect()->route('account.dashboard');
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            app(CartService::class)->mergeGuestCart($request, Auth::id());
            return redirect()->intended(route('account.dashboard'));
        }

        return back()->withErrors(['email' => 'The provided credentials are incorrect.'])->withInput();
    }

    public function showRegister()
    {
        if (Auth::check())
            return redirect()->route('account.dashboard');
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'password' => Hash::make($data['password']),
        ]);

        Auth::login($user);
        $request->session()->regenerate();
        app(CartService::class)->mergeGuestCart($request, $user->id);

        return redirect()->route('account.dashboard')->with('success', 'Welcome! Your account has been created.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    // ── Socialite (Google / GitHub) ───────────────────────────────────────────

    public function redirectToProvider(string $provider)
    {
        $this->ensureValidProvider($provider);
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback(Request $request, string $provider)
    {
        $this->ensureValidProvider($provider);

        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Unable to authenticate with ' . ucfirst($provider) . '. Please try again.');
        }

        // Find existing user by provider or by email
        $user = User::where('provider', $provider)
            ->where('provider_id', $socialUser->getId())
            ->first();

        if (!$user) {
            $user = User::where('email', $socialUser->getEmail())->first();

            if ($user) {
                // Link existing account to this provider
                $user->update([
                    'provider' => $provider,
                    'provider_id' => $socialUser->getId(),
                    'avatar' => $socialUser->getAvatar(),
                ]);
            } else {
                // Create new user
                $user = User::create([
                    'name' => $socialUser->getName() ?? $socialUser->getNickname(),
                    'email' => $socialUser->getEmail(),
                    'provider' => $provider,
                    'provider_id' => $socialUser->getId(),
                    'avatar' => $socialUser->getAvatar(),
                    'password' => null,
                ]);
            }
        }

        Auth::login($user, remember: true);
        $request->session()->regenerate();
        app(CartService::class)->mergeGuestCart($request, $user->id);

        return redirect()->intended(route('account.dashboard'));
    }

    private function ensureValidProvider(string $provider): void
    {
        if (!in_array($provider, ['google', 'github'])) {
            abort(404);
        }
    }
}
