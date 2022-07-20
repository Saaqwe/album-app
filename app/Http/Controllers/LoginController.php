<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request) {
        $formFields = $request->only(['email', 'password']);

        if(Auth::check()) {
            return redirect()->intended(route('private'));
        }

        if(Auth::attempt($formFields)) {
            $request->session()->regenerate();

            return redirect()->intended('private');
        } else {
            return redirect(route('user.login'))->withErrors([
                'formError' => "Не удалось авторизоваться"
            ]);
        }
    }


}