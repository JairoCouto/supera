<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */


    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

 
    /**
     * Função responsável por criar o view do Registrar Nova Conta
     */
    public function view()
    {
        return view('auth.register');
    }



    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(Request $request)
    {

        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|string|max:100|unique:usuario',
            'password' => 'required|string|max:100'

        ]);

        try {

            User::create([
                'nome'  => $request->name,
                'email' => $request->email,
                'senha' => $request->password,
            ]);

            return redirect()
                    ->route('index')
                    ->with('success', 'Cadastro realizado com sucesso.');

        } catch (\Exception $ex) {
            return redirect()
                    ->route('index')
                    ->with('error', 'Ocorreu um erro ao realizar o cadastro.');
        }
    }
}
