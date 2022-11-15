<?php

namespace App\Http\Controllers\Auth;

//use App\Models\User;
use Domain\Auth\Models\User;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Two\InvalidStateException;


class SocialAuthInController extends Controller
{
    public function redirect(string $driver)
    {
        try
        {
            return Socialite::driver($driver)->redirect();
        }
        catch(\Throwable $exception)
        {
            throw new \DomainException('Error или нет драйвера');
        }

    }

    public function callback(string $driver)//:RedirectResponse
    {
        if($driver != 'github')
        {
            throw new \DomainException('!! Error или нет драйвера');
        }
        //TODO не работает
        $githubUser = Socialite::driver($driver)->stateless()->user();

        try{
            $user = User::query()->updateOrCreate([
                'github_id' => $githubUser->id,
            ], [
                'name' => $githubUser->name ?? $githubUser->email,
                'email' => $githubUser->email,
                'password' => bcrypt(str()->random(20))
            ]);

            \Illuminate\Support\Facades\Auth::login($user);
        }
        catch (InvalidStateException $e) {
            //$user = Socialite::driver('github')->stateless()->user();
            print $e->getMessage();
            die();
        }
        catch(\Exception $e)
        {
            print $e->getMessage();
            die();
        }
        die();
        return redirect()->intended('home');
    }
}
