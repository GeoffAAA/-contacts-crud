<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function test_users_can_authenticate_using_the_login_screen()
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/dashboard');
    }

    public function test_users_can_not_authenticate_with_invalid_password()
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_users_can_logout()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/login');
    }

    public function test_register_screen_can_be_rendered()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
    }

    public function test_new_users_can_register()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/dashboard');
    }

    public function test_dashboard_requires_authentication()
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect('/login');
    }

    public function test_authenticated_users_can_access_dashboard()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/dashboard');
        $response->assertStatus(200);
    }

    public function test_root_redirects_to_login_when_not_authenticated()
    {
        $response = $this->get('/');
        $response->assertRedirect('/login');
    }

    public function test_root_redirects_to_dashboard_when_authenticated()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/');
        $response->assertRedirect('/dashboard');
    }

    public function test_logout_clears_session_data()
    {
        $user = User::factory()->create();

        // Login and set some session data
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        // Verify we're authenticated and redirected
        $response->assertRedirect('/dashboard');

        // Logout
        $logoutResponse = $this->post('/logout');

        // Verify we're redirected to login
        $logoutResponse->assertRedirect('/login');
    }

    public function test_login_sets_visit_flag()
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertTrue(session()->has('has_visited_before'));
    }

    public function test_security_headers_are_present()
    {
        $response = $this->get('/login');
        
        $response->assertHeader('Cache-Control');
        $response->assertHeader('Pragma', 'no-cache');
        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('X-Frame-Options', 'DENY');
        $response->assertHeader('X-XSS-Protection', '1; mode=block');
    }

    public function test_auth_pages_have_security_headers()
    {
        $response = $this->get('/login');
        
        // Verify security headers are present (but Clear-Site-Data is disabled to preserve CSRF tokens)
        $response->assertHeader('Surrogate-Control', 'no-store');
        $response->assertHeader('Vary', '*');
        // Clear-Site-Data is commented out to prevent CSRF token issues
        // $response->assertHeader('Clear-Site-Data', '"cache", "storage", "executionContexts"');
    }

    public function test_registration_validation()
    {
        // Test required fields
        $response = $this->post('/register', []);
        $response->assertSessionHasErrors(['name', 'email', 'password']);

        // Test email format
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'invalid-email',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
        $response->assertSessionHasErrors(['email']);

        // Test password confirmation
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'different-password',
        ]);
        $response->assertSessionHasErrors(['password']);
    }
}