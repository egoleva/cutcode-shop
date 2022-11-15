<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\ResetPasswordFormRequest;
use Domain\Auth\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    public function page(string $token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function handle(ResetPasswordFormRequest $request)
    {
        $status = \Illuminate\Support\Facades\Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => bcrypt($password)
                ])->setRememberToken(str()->random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        if($status === \Illuminate\Support\Facades\Password::PASSWORD_RESET)
        {
            flash()->info(__($status));
            return redirect()->route('login');
        }

        return back()->withErrors(['email' => __($status)]);
    }

}
