<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginPostRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
//    public function login(LoginPostRequest $request) {
//        $formFields = $request->validated();
    public function index()
    {
        if(Auth::check()) {
            return redirect(route('albums'));
        } else {
            return view('login');
        }
    }

    public function login(Request $request)
    {
        if($request->expectsJson()) {
            return self::loginIfJsonExpected($request);
        } else {
            $formFields = $request->only(['email', 'password']);
            if(Auth::check()) {
                return redirect()->intended(route('albums'));
            }
            if(Auth::attempt($formFields)) {
                $request->session()->regenerate();
                return redirect()->intended('albums');
            } else {
                return redirect(route('user.login'))->withErrors([
                    'formError' => "Не удалось авторизоваться"
                ]);
            }
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/albums');
    }



    private function loginIfJsonExpected(Request $request)
    {
        $formFields = $request->only(['email', 'password']);
        if(Auth::check()) {
            return response()->json();
        }
        if(Auth::attempt($formFields)) {
            $request->session()->regenerate();
            return response()->json();
        } else {
            return response()->json([
                'errors' => "Password doesn't match",
            ], 422);
        }
    }


}
