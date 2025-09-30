<?php

namespace Tests\Unit\Services;

use App\Models\User;
use App\Services\AuthService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class AuthServiceTest extends TestCase
{
    use RefreshDatabase;

    private AuthService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new AuthService();
    }

    public function test_login_exitoso_devuelve_token()
    {
        User::factory()->create([
            'email'    => 'user@example.com',
            'password' => Hash::make('secret123'),
        ]);

        $token = $this->service->login('user@example.com', 'secret123');

        $this->assertIsString($token);
        $this->assertNotEmpty($token);
    }

    public function test_login_fallido_lanza_excepcion()
    {
        User::factory()->create([
            'email'    => 'user@example.com',
            'password' => Hash::make('secret123'),
        ]);

        $this->expectException(ValidationException::class);

        $this->service->login('user@example.com', 'wrongpassword');
    }

    public function test_logout_elimina_tokens_del_usuario()
    {
        $user = User::factory()->create();
        $user->createToken('api-token');

        $this->assertCount(1, $user->tokens);

        $this->service->logout($user);

        $this->assertCount(0, $user->fresh()->tokens);
    }
}
