<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'primer_nombre' => ['required', 'string', 'max:255'],
            'apellidos' => ['required', 'string', 'max:255'],
            'documento_identidad' => ['required', 'string', 'max:255', 'unique:users,documento_identidad'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'telefono' => ['nullable', 'string'],
            'direccion' => ['nullable', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'rol' => ['required', 'in:egresado,jefe,admin'],
        ])->validate();
    

        return User::create([
            'primer_nombre' => $input['primer_nombre'],
            'apellidos' => $input['apellidos'],
            'documento_identidad' => $input['documento_identidad'],
            'email' => $input['email'],
            'telefono' => $input['telefono'],
            'direccion' => $input['direccion'],
            'password' => Hash::make($input['password']),
            'rol' => $input['rol'],
        ]);
    }
}
