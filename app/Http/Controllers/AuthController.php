<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

/**
 * Authentication controller. Shows login page and handles login.
 */
class AuthController extends Controller
{
    public function showLoginPage()
    {
        return view('login');
    }

    /**
     * Attempt a login. Redirect to products page if succesful. Throw a ValidationException otherwise.
     * 
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $this->validateLoginSyntax($request);

        $userExists = auth()->attempt($request->only(['email', 'password']));
        if ($userExists) {
            return redirect('/products');
        }

        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    /**
     * Validate the syntactic rules of a login attempt.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    private function validateLoginSyntax(Request $request): void
    {
        validator($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required']
        ])->validate();
    }
}