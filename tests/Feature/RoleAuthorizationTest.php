<?php

namespace Tests\Feature;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    // ── Login & Redirect Tests ───────────────────────────

    public function test_parent_login_redirects_to_parent_dashboard(): void
    {
        $parent = User::factory()->create(['role' => 'parent']);

        $response = $this->post('/login', [
            'email' => $parent->email,
            'password' => 'password',
        ]);

        $response->assertRedirect('/dashboard');
    }

    public function test_doctor_login_redirects_to_doctor_dashboard(): void
    {
        $doctor = User::factory()->create(['role' => 'doctor']);

        $response = $this->post('/login', [
            'email' => $doctor->email,
            'password' => 'password',
        ]);

        $response->assertRedirect('/dokter/dashboard');
    }

    // ── Logout Tests ─────────────────────────────────────

    public function test_parent_can_logout(): void
    {
        $parent = User::factory()->create(['role' => 'parent']);

        $response = $this->actingAs($parent)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }

    public function test_doctor_can_logout(): void
    {
        $doctor = User::factory()->create(['role' => 'doctor']);

        $response = $this->actingAs($doctor)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }

    // ── Access Control Tests ─────────────────────────────

    public function test_parent_cannot_access_doctor_dashboard(): void
    {
        $parent = User::factory()->create(['role' => 'parent']);

        $response = $this->actingAs($parent)->get('/dokter/dashboard');

        $response->assertStatus(403);
    }

    public function test_doctor_can_access_doctor_dashboard(): void
    {
        $doctor = User::factory()->create(['role' => 'doctor']);

        $response = $this->actingAs($doctor)->get('/dokter/dashboard');

        $response->assertStatus(200);
    }

    public function test_doctor_cannot_access_parent_dashboard(): void
    {
        $doctor = User::factory()->create(['role' => 'doctor']);

        $response = $this->actingAs($doctor)->get('/dashboard');

        $response->assertStatus(403);
    }

    public function test_parent_can_access_parent_dashboard(): void
    {
        $parent = User::factory()->create(['role' => 'parent']);

        $response = $this->actingAs($parent)->get('/dashboard');

        $response->assertStatus(200);
    }

    // ── Unauthenticated Access Tests ─────────────────────

    public function test_guest_cannot_access_doctor_dashboard(): void
    {
        $response = $this->get('/dokter/dashboard');

        $response->assertRedirect('/login');
    }

    public function test_guest_cannot_access_parent_dashboard(): void
    {
        $response = $this->get('/dashboard');

        $response->assertRedirect('/login');
    }

    // ── Root Redirect Tests ──────────────────────────────

    public function test_root_redirects_parent_to_dashboard(): void
    {
        $parent = User::factory()->create(['role' => 'parent']);

        $response = $this->actingAs($parent)->get('/');

        $response->assertRedirect(route('dashboard'));
    }

    public function test_root_redirects_doctor_to_doctor_dashboard(): void
    {
        $doctor = User::factory()->create(['role' => 'doctor']);

        $response = $this->actingAs($doctor)->get('/');

        $response->assertRedirect(route('dokter.dashboard'));
    }

    public function test_root_redirects_guest_to_login(): void
    {
        $response = $this->get('/');

        $response->assertRedirect(route('login'));
    }

    // ── Role Model Tests ─────────────────────────────────

    public function test_user_default_role_is_parent(): void
    {
        $user = User::factory()->create();

        $this->assertEquals('parent', $user->role);
    }

    public function test_is_parent_helper(): void
    {
        $user = User::factory()->create(['role' => 'parent']);

        $this->assertTrue($user->isParent());
        $this->assertFalse($user->isDoctor());
    }

    public function test_is_doctor_helper(): void
    {
        $user = User::factory()->create(['role' => 'doctor']);

        $this->assertTrue($user->isDoctor());
        $this->assertFalse($user->isParent());
    }

    public function test_doctor_user_has_doctor_profile(): void
    {
        $user = User::factory()->create(['role' => 'doctor']);
        $doctor = Doctor::create([
            'user_id' => $user->id,
            'name' => 'Dr. Test',
            'specialization' => 'Sp.A',
        ]);

        $this->assertNotNull($user->doctor);
        $this->assertEquals($doctor->id, $user->doctor->id);
        $this->assertEquals($user->id, $doctor->user->id);
    }

    // ── Privilege Escalation Prevention ─────────────────

    public function test_registration_with_doctor_role_is_ignored_and_creates_parent(): void
    {
        $response = $this->post('/register', [
            'name' => 'Attacker User',
            'email' => 'attacker@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 'doctor',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard', absolute: false));

        $user = User::where('email', 'attacker@example.com')->first();
        $this->assertNotNull($user);
        $this->assertEquals('parent', $user->role);
        $this->assertTrue($user->isParent());
        $this->assertFalse($user->isDoctor());
    }

    // ── Cross-Role Access Prevention ────────────────────

    public function test_parent_cannot_access_any_doctor_routes(): void
    {
        $parent = User::factory()->create(['role' => 'parent']);

        $doctorRoutes = [
            '/dokter/dashboard',
            '/dokter/konsultasi',
            '/dokter/konsultasi/1',
            '/dokter/pasien',
            '/dokter/profil',
        ];

        foreach ($doctorRoutes as $route) {
            $response = $this->actingAs($parent)->get($route);
            $response->assertStatus(403);
        }
    }

    public function test_doctor_cannot_access_any_parent_routes(): void
    {
        $doctor = User::factory()->create(['role' => 'doctor']);

        $parentRoutes = [
            '/dashboard',
            '/nutrition',
            '/food-scan',
            '/tanya-ai',
            '/children',
            '/children/create',
        ];

        foreach ($parentRoutes as $route) {
            $response = $this->actingAs($doctor)->get($route);
            $response->assertStatus(403);
        }
    }

    // ── Comprehensive Guest Access Prevention ───────────

    public function test_guest_cannot_access_any_doctor_routes(): void
    {
        $doctorRoutes = [
            '/dokter/dashboard',
            '/dokter/konsultasi',
            '/dokter/konsultasi/1',
            '/dokter/pasien',
            '/dokter/profil',
        ];

        foreach ($doctorRoutes as $route) {
            $response = $this->get($route);
            $response->assertRedirect('/login');
        }
    }

    // ── Shared Profile Redirect Tests ───────────────────

    public function test_doctor_visiting_shared_profile_redirects_to_doctor_profile(): void
    {
        $doctor = User::factory()->create(['role' => 'doctor']);

        $response = $this->actingAs($doctor)->get('/profile');

        $response->assertRedirect(route('dokter.profil'));
    }

    public function test_parent_visiting_shared_profile_displays_profile_page(): void
    {
        $parent = User::factory()->create(['role' => 'parent']);

        $response = $this->actingAs($parent)->get('/profile');

        $response->assertOk();
    }

    // ── Doctor Logout Alias Tests ───────────────────────

    public function test_doctor_can_logout_via_dokter_logout_alias(): void
    {
        $doctor = User::factory()->create(['role' => 'doctor']);

        $response = $this->actingAs($doctor)->post('/dokter/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }

    // ── Legacy Doctor Login Tests ───────────────────────

    public function test_legacy_doctor_login_get_redirects_to_shared_login(): void
    {
        $response = $this->get('/dokter/login');

        $response->assertRedirect(route('login'));
    }

    public function test_legacy_doctor_login_post_authenticates_doctor_and_redirects_to_doctor_dashboard(): void
    {
        $doctor = User::factory()->create(['role' => 'doctor']);

        $response = $this->post('/dokter/login', [
            'email' => $doctor->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticatedAs($doctor);
        $response->assertRedirect(route('dokter.dashboard', absolute: false));
    }

    // ── Guest Middleware Redirect for Authenticated Users ─

    public function test_authenticated_doctor_visiting_login_redirects_to_doctor_dashboard(): void
    {
        $doctor = User::factory()->create(['role' => 'doctor']);

        $response = $this->actingAs($doctor)->get('/login');

        $response->assertRedirect(route('dokter.dashboard'));
    }

    public function test_authenticated_parent_visiting_login_redirects_to_parent_dashboard(): void
    {
        $parent = User::factory()->create(['role' => 'parent']);

        $response = $this->actingAs($parent)->get('/login');

        $response->assertRedirect(route('dashboard'));
    }

    // ── Doctor Views Render Without Missing Route Errors ──

    public function test_all_doctor_menu_pages_can_be_rendered(): void
    {
        $doctor = User::factory()->create(['role' => 'doctor']);

        $routes = [
            route('dokter.dashboard'),
            route('dokter.konsultasi'),
            route('dokter.konsultasi.detail', ['id' => 1]),
            route('dokter.pasien'),
            route('dokter.profil'),
        ];

        foreach ($routes as $route) {
            $response = $this->actingAs($doctor)->get($route);
            $response->assertOk();
        }
    }
}
