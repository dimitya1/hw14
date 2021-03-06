<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

final class AuthController
{
    public function login()
    {
        return redirect()
            ->route('home')
            ->withErrors(['not allowed' => 'You need to sign in!']);
    }

    public function check()
    {
        $validator = Validator::make(
            request()->all(),
            [
                'email' => 'email|required|min:10|max:40',
                'password' => 'required|min:6|max:70|regex:/[a-z]/',
            ]
        );

        if ($validator->fails()) {
            return back()
                ->withErrors($validator->errors());
        }

        $credentials = [
            'email' => request()->get('email'),
            'password' => request()->get('password'),
        ];

        $remember = request()->get('remember') === 'on';

        if (!Auth::attempt($credentials, $remember)) {
            return back()
                ->withErrors(['email or password' => 'Invalid email or password!']);
        }

        return back();
    }

    public function logout()
    {
        Auth::logout();
        return back();
    }
}

