<?php

namespace Domain\Auth\Actions;


use Domain\Auth\Contracts\RegisterNewUserContract;
//use App\Models\User;
use Domain\Auth\Models\User;
use Illuminate\Auth\Events\Registered;

class RegisterNewUserAction implements RegisterNewUserContract
{

    public function __invoke(array $data)
    {
        $user = User::query()->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        event(new Registered($user));

        auth()->login($user);
    }

}