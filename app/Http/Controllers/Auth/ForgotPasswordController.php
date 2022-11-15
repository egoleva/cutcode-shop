<?php

namespace App\Http\Controllers\Auth;


use Illuminate\Support\Facades\Password;
use App\Http\Requests\ForgotPasswordFormRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Domain\Auth\Models\User;
use App\Http\Controllers\Controller;

class ForgotPasswordController extends Controller
{
    public function page()
    {
        return view('auth.forgot-password');
    }

    public function handle(ForgotPasswordFormRequest $request): RedirectResponse
    {

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if($status === Password::RESET_LINK_SENT)
        {
            flash()->info(__($status));
            return back();
        }

        return back()->withErrors(['email' => __($status)]);
    }
}
