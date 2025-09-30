<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function __construct(private readonly AuthService $service) {}

    /**
     * Maneja la petición de login de un usuario.
     *
     * Valida el request e intenta autenticar al usuario.
     * Devuelve un JSON con el token de acceso o un mensaje de error.
     *
     * @param \Illuminate\Http\Request $request Request HTTP con las credenciales de login.
     * @return \Illuminate\Http\JsonResponse Respuesta JSON con el resultado de la autenticación.
     */
    public function login(Request $request): JsonResponse
    {
        $this->validarLoginRequest($request);

        try {
            $token = $this->service->login($request->email, $request->password);
    
            return response()->json([
                'token' => $token,
            ]);
        } catch(ValidationException $exception) {
            return response()->json($exception->getMessage(), 401);
        }
    }

    /**
     * Cierra la sesión del usuario actualmente autenticado.
     *
     * Elimina todos los tokens de acceso del usuario.
     *
     * @param \Illuminate\Http\Request $request Request HTTP con el usuario autenticado.
     * @return \Illuminate\Http\JsonResponse Respuesta JSON confirmando el cierre de sesión.
     */
    public function logout(Request $request): void
    {
        $this->service->logout($request->user());
    }

    private function validarLoginRequest(Request $request): void
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);
    }
}
