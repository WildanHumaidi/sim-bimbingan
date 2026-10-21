<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_mahasiswa_can_register_successfully(): void
    {
        $response = $this->post('/register/mahasiswa', [
            'nim' => '1234567890',
            'nama' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'program_studi' => 'Teknik Informatika',
            'angkatan' => 2024,
        ]);

        $response->assertRedirect('/login');
        $this->assertDatabaseHas('users', [
            'username' => '1234567890',
            'email' => 'budi@example.com',
            'role' => 3,
        ]);
        $this->assertDatabaseHas('mahasiswas', [
            'id_nim' => '1234567890',
            'nama' => 'Budi Santoso',
            'program_studi' => 'Teknik Informatika',
        ]);
    }

    public function test_dosen_can_register_with_fakultas_successfully(): void
    {
        $response = $this->post('/register/dosen', [
            'nidn' => '0987654321',
            'nama' => 'Dr. Hendra Gunawan',
            'email' => 'hendra@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'jabatan' => 'Lektor',
            'fakultas' => 'Teknik & Informatika',
        ]);

        $response->assertRedirect('/login');
        $this->assertDatabaseHas('users', [
            'username' => '0987654321',
            'email' => 'hendra@example.com',
            'role' => 2,
        ]);
        $this->assertDatabaseHas('dosens', [
            'id_nidn' => '0987654321',
            'nama' => 'Dr. Hendra Gunawan',
            'fakultas' => 'Teknik & Informatika',
        ]);
    }

    public function test_user_can_login_and_redirect_based_on_role(): void
    {
        $user = User::create([
            'username' => 'admin_test',
            'email' => 'admin_test@example.com',
            'password' => bcrypt('password123'),
            'role' => 1,
        ]);

        $response = $this->post('/login', [
            'email' => 'admin_test@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('dashboard.index'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_role_middleware_blocks_unauthorized_role(): void
    {
        $mhsUser = User::create([
            'username' => 'mhs_test',
            'email' => 'mhs_test@example.com',
            'password' => bcrypt('password123'),
            'role' => 3,
        ]);

        $response = $this->actingAs($mhsUser)->get('/admin/dashboard');
        $response->assertRedirect('/mhs/dashboard');
    }
}
