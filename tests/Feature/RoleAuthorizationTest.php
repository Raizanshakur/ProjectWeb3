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
}
