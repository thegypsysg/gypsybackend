<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function index()
    {
        if(Auth::user()){
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->getCredentials();
        
        $email = User::where(array_key_first($credentials), $request->username)->first();
        
        if(!$email):
            return redirect()->to('/login')->withErrors(['username'=>'User does not exists!']);
        endif;

        if(!Auth::validate($credentials)):
            return redirect()->to('/login')
                ->withErrors(['password' => 'Password does not match']);
        endif;

        $user = Auth::getProvider()->retrieveByCredentials($credentials);

        Auth::login($user);

        return redirect()->route('dashboard');

        return $this->authenticated($request, $user);
    }
    
    public function logout()
    {
        Session::flush();
        
        Auth::logout();

        return redirect('login');
    }
}
