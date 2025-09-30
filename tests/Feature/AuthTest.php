<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\AuthService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Mockery;

class AuthTest extends TestCase
{
    use RefreshDatabase;
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create([
            'email'     => 'test@example.com',
            'password'  => bcrypt('password123'),
        ]);
    }

    public function test_login_exitoso_devuelve_token()
    {
        $expectedResponse = [
            'token' => 'TOKEN123',  
        ];
        $mock = Mockery::mock(AuthService::class);
        $mock->shouldReceive('login')
             ->once()
             ->with('test@example.com', 'password123')
             ->andReturn($expectedResponse['token']);
        $this->app->instance(AuthService::class, $mock);

        $response = $this->postJson('/api/login', [
            'email'     => 'test@example.com',
            'password'  => 'password123',
        ]);

        $response->assertStatus(200)->assertJson($expectedResponse);
    }

    public function test_login_falla_con_credenciales_invalidas()
    {
        $expectedResponse = 'Credenciales inválidas'; 
        $mock = Mockery::mock(AuthService::class);
        $mock->shouldReceive('login')
             ->once()
             ->with('test@example.com', 'wrongpassword')
             ->andThrow(\Illuminate\Validation\ValidationException::withMessages([$expectedResponse]));
        $this->app->instance(AuthService::class, $mock);

        $response = $this->postJson('/api/login', [
            'email'     => 'test@example.com',
            'password'  => 'wrongpassword',
        ]);

        $response->assertStatus(401)->assertJsonFragment([$expectedResponse]);
    }

    public function test_logout_elimina_tokens()
    {
        $mock = Mockery::mock(AuthService::class);
        $mock->shouldReceive('logout')
             ->once()
             ->with($this->user);
        $this->app->instance(AuthService::class, $mock);

        $response = $this->actingAs($this->user, 'sanctum')->postJson('/api/logout');

        $response->assertStatus(200);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
        $this->user = null;
    }
}
