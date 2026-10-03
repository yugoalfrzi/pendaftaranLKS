<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use WithoutMiddleware;

    public function test_super_admin_dashboard_renders_without_undefined_variables(): void
    {
        $user = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'role' => 'superadmin',
        ]);

        $this->actingAs($user)
            ->get('/dashboard')
            ->assertOk();
    }
}
