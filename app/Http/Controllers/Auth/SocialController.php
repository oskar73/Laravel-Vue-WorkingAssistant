<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Socialite;

class SocialController extends Controller
{
    public $socials;

    public function __construct()
    {
        $this->socials = optional(option('social', null));
    }

    public function setConfig($provider)
    {
        switch ($provider) {
            case 'facebook':
                config([
                    'services.facebook.client_id' => $this->socials['facebook_client_id'],
                    'services.facebook.client_secret' => $this->socials['facebook_client_secret'],
                ]);
                break;
            case 'twitter':
                config([
                    'services.twitter.client_id' => $this->socials['twitter_client_id'],
                    'services.twitter.client_secret' => $this->socials['twitter_client_secret'],
                ]);
                break;
            case 'linkedin':
                config([
                    'services.linkedin.client_id' => $this->socials['linkedin_client_id'],
                    'services.linkedin.client_secret' => $this->socials['linkedin_client_secret'],
                ]);
                break;
            case 'instagram':
                config([
                    'services.instagram.client_id' => $this->socials['instagram_client_id'],
                    'services.instagram.client_secret' => $this->socials['instagram_client_secret'],
                ]);
                break;
            case 'github':
                config([
                    'services.github.client_id' => $this->socials['github_client_id'],
                    'services.github.client_secret' => $this->socials['github_client_secret'],
                ]);
                break;
            case 'google':
                config([
                    'services.google.client_id' => $this->socials['google_client_id'],
                    'services.google.client_secret' => $this->socials['google_client_secret'],
                ]);
                break;
        }
    }

    public function redirectToProvider($provider)
    {
        if ($this->socials[$provider] != 1 || option('register', 0) != 1) {
            return redirect()->route('login')->with('error', 'Provider is invalid.');
        }
        $this->setConfig($provider);

        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        if ($this->socials[$provider] != 1 || option('register', 0) != 1) {
            return redirect()->route('login')->with('error', 'Provider is invalid.');
        }

        $this->setConfig($provider);

        try {
            $socialuser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Something went wrong.');
        }

        $authUser = User::where('provider', $provider)
            ->where('provider_id', $socialuser->id)
            ->first();

        if ($authUser == null) {
            $check = User::where('email', $socialuser->email)->first();
            if ($check) {
                return redirect()->route('login')->with('info', 'Your social account email already exists in our website. To secure your account, please login with your email.');
            }
            $authUser = User::create([
                'web_id' => tenant('id'),
                'name' => $socialuser->name,
                'email_verified_at' => now()->toDateTimeString(),
                'email' => $socialuser->email,
                'provider' => $provider,
                'provider_id' => $socialuser->id,
            ]);
            $authUser->addMediaFromUrl($socialuser->avatar)
                ->usingFileName(uniqid().'.jpg')
                ->toMediaCollection('avatar');
        }

        Auth::login($authUser, true);

        return redirect()->route('dashboard');
    }
}
