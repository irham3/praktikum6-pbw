<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'username'      => ['required', 'string', 'max:255', 'unique:users'],
            'fullname'      => ['required', 'string', 'max:255'],
            'email'         => ['email'],
            'password'      => ['required', 'confirmed', Rules\Password::defaults()],
            'alamat'       => ['required', 'string'],
            'birthdate'     => ['required', 'date', 'before:today'],
            'phoneNumber'   => ['required']
        ],
        [
            'username.required' => 'Username harus diisi',
            'username.unique' => 'Username telah digunakan',
            'birthdate.before' => 'Tanggal lahir harus sebelum hari ini'
        ]);

        $user = User::create([
            'username'  => $request->username,
            'fullname'  => $request->fullname,
            'email'  => $request->email,
            'password'  => Hash::make($request->password),
            'alamat'  => $request->alamat,
            'birthdate'  => $request->birthdate,
            'phoneNumber'  => $request->phoneNumber,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
