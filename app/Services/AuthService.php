<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    /**
     * Intenta autenticar a un usuario y devuelve un token.
     *
     * @param string $email
     * @param string $password
     * @return string Token de acceso
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(string $email, string $password): string
    {
        $user = User::where('email', $email)->first();

        if (! $user || ! Hash::check($password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Credenciales inválidas.'],
            ]);
        }

        return $user->createToken('api-token')->plainTextToken;
    }

    /**
     * Cierra sesión de un usuario eliminando sus tokens.
     *
     * @param \App\Models\User $user
     * @return void
     */
    public function logout(User $user): void
    {
        $user->tokens()->delete();
    }
}
