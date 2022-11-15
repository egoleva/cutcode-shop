<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\SignUpFormRequest;
use Domain\Auth\Contracts\RegisterNewUserContract;
//use Illuminate\Foundation\Auth\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\Factory;
use App\Http\Controllers\Controller;

class SignUpController extends Controller
{
    public function page()
    {
        return view('auth.sign-up');
    }

    public function handle(SignUpFormRequest $request, RegisterNewUserContract $action): RedirectResponse
    {
        //см RegisterNewUserAction
        $action($request->validated());

        return redirect()->intended(route('home'));

    }

}
