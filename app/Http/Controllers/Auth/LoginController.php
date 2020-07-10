<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User\User;
use Illuminate\Support\Facades\Auth;

//use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    /**
     * Função responsável por realizar o login
     */
    public function login(Request $request)
    {

        $request->validate([
            'email'    => 'required|string',
            'password' => 'required|string'
        ]);

        try {

            $user = User::where("email", '=', $request->email)
                        ->where('senha', '=', $request->password)
                        ->first();
    
            if(is_null($user)) {
               
                return redirect()
                    ->route('index')
                    ->with('error', 'Usuário e/ou Senha inválido, tente novamente.');
            }

            Auth::loginUsingId($user->id_usuario);

            return redirect()
                    ->route('admin.form');

        } catch (\Exception $ex) {
            return redirect()
                    ->route('index')
                    ->with('error', 'Ocorreu um erro ao realizar o login, tente novamente.');
        }
    }


    /**
     * Função responsável por realizar o logout
     */
    public function logout()
    {
        Auth::logout();
        return redirect()
                ->route('index');
    }

}
