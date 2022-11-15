<?php

namespace App\Http\Controllers\Auth;


use App\Http\Requests\SignInFormRequest;
use Illuminate\Auth\Events\Registered;
//use Illuminate\Foundation\Auth\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Domain\Auth\Models\User;
//use App\Models\User;
use App\Http\Controllers\Controller;

class SignInController extends Controller
{
    /*ublic function index()
    {
        //flash()->info('test');
        //return redirect()->route('home');

        return view('auth.login');
    }*/

    public function page()
    {
        return view('auth.login');
    }

    public function handle(SignInFormRequest $request): RedirectResponse
    {
        //TODO auth() не работает с domain user
        if(!auth()->attempt($request->validated()))
        {
            return back()->withErrors([
                'email' => 'Email does not exist'
            ])->onlyInput('email');
        }
        $request->session()->regenerate();

        return redirect()->intended(route('home'));

    }

    public function logout()
    {
        auth()->logout();

        request()->session()->invalidate();

        request()->session()->regenerateToken();

        return redirect()->intended('home');
    }

/*
    public function github()
    {
        return \Laravel\Socialite\Facades\Socialite::driver('github')->redirect();
    }

    public function githubCallback()
    {
        $githubUser = \Laravel\Socialite\Facades\Socialite::driver('github')->user();

        $user = User::query()->updateOrCreate([
            'github_id' => $githubUser->id,
        ], [
            'name' => $githubUser->name ?? $githubUser->email,
            'email' => $githubUser->email,
            'password' => bcrypt(str()->random(20))
        ]);

        \Illuminate\Support\Facades\Auth::login($user);

        return redirect()->intended('home');
    }*/
}
