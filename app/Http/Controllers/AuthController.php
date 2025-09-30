<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse Respuesta JSON con el resultado de la autenticación.
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $email = $request->email;

        try {
            $token = $this->service->login($email, $request->password);

            Log::info('Login exitoso', [ 
                'email'     => $email,
                'user_id'   => Auth::id() ?? null,
                'ip'        => $request->ip(),
            ]);

            return response()->json([
                'token' => $token,
            ]);
        } catch (ValidationException $exception) {
            Log::warning('Intento de login fallido', [
                'email' => $email,
                'ip'    => $request->ip(),
                'error' => $exception->getMessage(),
            ]);

            return response()->json(['error' => $exception->getMessage()], Response::HTTP_UNAUTHORIZED);
        } catch (\Exception $exception) {
            Log::error('Error inesperado en login', [
                'email' => $email,
                'ip'    => $request->ip(),
                'error' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString(),
            ]);

            return response()->json(['error' => 'Ocurrió un error al intentar iniciar sesión'], Response::HTTP_INTERNAL_SERVER_ERROR);
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
}
