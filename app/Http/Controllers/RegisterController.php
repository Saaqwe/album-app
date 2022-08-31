<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function save(Request $request) {
        if(Auth::check()) {
            return redirect('user.private');
        }
        $validateFields = $request->validate([
            'name' => 'required',
            'login' => 'required|unique:users',
            'email' => 'required|unique:users',
            'password' => 'required'
        ]);

        if(User::where('email', $validateFields['email'])->exists()) {
            redirect(route('user.registration'))->withErrors([
               "email" => 'Пользователь с таким email уже зарегестрирован'
            ]);
        }

        if(User::where('email', $validateFields['login'])->exists()) {
            redirect(route('user.registration'))->withErrors([
                "email" => 'Пользователь с таким email уже зарегестрирован'
            ]);
        }


        $user = User::create($validateFields);
        if($user) {
            $user->createToken("auth_token");
            Auth::login($user);
            return redirect()->to(route('user.private'));
        }

        return redirect(route('user.login'))->withErrors([
            'formError' => "Error during creating user"
        ]);
    }

    public function saveIfJsonExpected () {

    }
}
