<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\User;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin(){

        return view('auth.login');
    }
    
    public function showRegister(){

        return view('auth.register');
    }

    public function login(Request $request){

        $validated = $request->validate([
            "name" => "required|string",
            "password" => "required|string"
        ]);

        if(Auth::attempt($validated)){
            $request->session()->regenerate();

            return redirect()->route('pharmacy.index');
        };

        throw ValidationException::withMessages([
            "logError"=> "username or password incorrect"
        ]);
        
    }

    public function logout(Request $request){

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('show.login');
    }
    
    public function register(Request $request){

        $validated = $request->validate([
            "name"=> "required|string|max:255|unique:users",
            "email"=> "required|email|unique:users",
            "password"=> "required|string|min:8|confirmed",
        ]);
        
        $user = User::create($validated);

        Auth::login($user);
    
        return redirect()->route('pharmacy.index');
    }
}
