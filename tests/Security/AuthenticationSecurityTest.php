<?php

namespace Tests\Security;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthenticationSecurityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_enforces_strong_password_policy()
    {
        // Test avec un mot de passe faible
        $response = $this->postJson('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'weak',
            'password_confirmation' => 'weak'
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['password']);

        // Test avec un mot de passe fort
        $response = $this->postJson('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'StrongP@ssw0rd123',
            'password_confirmation' => 'StrongP@ssw0rd123'
        ]);

        $response->assertStatus(201);
    }

    /** @test */
    public function it_protects_against_brute_force_attacks()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('StrongP@ssw0rd123')
        ]);

        // Tentative de connexion avec mauvais mot de passe
        for ($i = 0; $i < 5; $i++) {
            $response = $this->postJson('/login', [
                'email' => 'test@example.com',
                'password' => 'wrongpassword'
            ]);
        }

        // La 6ème tentative devrait être bloquée
        $response = $this->postJson('/login', [
            'email' => 'test@example.com',
            'password' => 'wrongpassword'
        ]);

        $response->assertStatus(429)
            ->assertJson([
                'message' => 'Too many login attempts'
            ]);
    }

    /** @test */
    public function it_protects_against_session_fixation()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('StrongP@ssw0rd123')
        ]);

        // Première connexion
        $response = $this->postJson('/login', [
            'email' => 'test@example.com',
            'password' => 'StrongP@ssw0rd123'
        ]);

        $oldSessionId = session()->getId();

        // Déconnexion
        $this->postJson('/logout');

        // Deuxième connexion
        $response = $this->postJson('/login', [
            'email' => 'test@example.com',
            'password' => 'StrongP@ssw0rd123'
        ]);

        $newSessionId = session()->getId();

        // Vérification que l'ID de session a changé
        $this->assertNotEquals($oldSessionId, $newSessionId, 'La session n\'a pas été régénérée');
    }

    /** @test */
    public function it_protects_against_password_reset_attacks()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('StrongP@ssw0rd123')
        ]);

        // Tentative de réinitialisation avec un email inexistant
        $response = $this->postJson('/password/email', [
            'email' => 'nonexistent@example.com'
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'We have emailed your password reset link'
            ]);

        // Vérification qu'aucun token n'a été généré
        $this->assertDatabaseMissing('password_resets', [
            'email' => 'nonexistent@example.com'
        ]);
    }

    /** @test */
    public function it_protects_against_remember_me_attacks()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('StrongP@ssw0rd123')
        ]);

        // Connexion avec "Se souvenir de moi"
        $response = $this->postJson('/login', [
            'email' => 'test@example.com',
            'password' => 'StrongP@ssw0rd123',
            'remember' => true
        ]);

        $response->assertStatus(200);

        // Vérification que le token remember me est sécurisé
        $this->assertNotNull($user->remember_token);
        $this->assertNotEquals('', $user->remember_token);
        $this->assertGreaterThan(60, strlen($user->remember_token));
    }

    /** @test */
    public function it_protects_against_2fa_bypass()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('StrongP@ssw0rd123'),
            'two_factor_enabled' => true
        ]);

        // Tentative de connexion sans 2FA
        $response = $this->postJson('/login', [
            'email' => 'test@example.com',
            'password' => 'StrongP@ssw0rd123'
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'requires_2fa' => true
            ]);

        // Tentative d'accès à une route protégée sans 2FA
        $response = $this->getJson('/api/user');

        $response->assertStatus(401);
    }
} 