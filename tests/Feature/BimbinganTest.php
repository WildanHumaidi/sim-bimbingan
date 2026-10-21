<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\Bimbingan;
use App\Models\Dokumen;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BimbinganTest extends TestCase
{
    use RefreshDatabase;

    protected User $mhsUser;
    protected User $dosenUser;
    protected Mahasiswa $mhs;
    protected Dosen $dosen;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mhsUser = User::create([
            'username' => '1234567890',
            'email' => 'mhs@example.com',
            'password' => bcrypt('password123'),
            'role' => 3,
        ]);

        $this->mhs = Mahasiswa::create([
            'id_nim' => '1234567890',
            'id_user' => $this->mhsUser->id_user,
            'nama' => 'Mahasiswa Test',
            'program_studi' => 'Teknik Informatika',
            'angkatan' => 2024,
        ]);

        $this->dosenUser = User::create([
            'username' => '0987654321',
            'email' => 'dosen@example.com',
            'password' => bcrypt('password123'),
            'role' => 2,
        ]);

        $this->dosen = Dosen::create([
            'id_nidn' => '0987654321',
            'id_user' => $this->dosenUser->id_user,
            'nama' => 'Dosen Test',
            'jabatan' => 'Lektor',
            'fakultas' => 'Teknik & Informatika',
        ]);
    }

    public function test_mahasiswa_can_create_bimbingan_with_pending_status(): void
    {
        $response = $this->actingAs($this->mhsUser)->post('/mhs/bimbingan', [
            'nidn' => $this->dosen->id_nidn,
            'topik' => 'Bab 1 Pendahuluan Sistem',
            'deskripsi' => 'Pengajuan bab 1',
            'tanggal' => now()->format('Y-m-d'),
        ]);

        $response->assertRedirect('/mhs/bimbingan');
        $this->assertDatabaseHas('bimbingan', [
            'nim' => $this->mhs->id_nim,
            'nidn' => $this->dosen->id_nidn,
            'status_validasi' => 'pending',
        ]);
    }

    public function test_bimbingan_status_scopes_work_correctly(): void
    {
        $bimbingan = Bimbingan::create([
            'nim' => $this->mhs->id_nim,
            'nidn' => $this->dosen->id_nidn,
            'tanggal' => now()->format('Y-m-d'),
            'topik' => 'Bab 2 Tinjauan Pustaka',
            'catatan' => 'Catatan tes',
            'status_validasi' => 'pending',
        ]);

        $this->assertEquals(1, Bimbingan::pending()->count());
        $this->assertEquals(0, Bimbingan::valid()->count());

        $bimbingan->update(['status_validasi' => 'valid']);

        $this->assertEquals(0, Bimbingan::pending()->count());
        $this->assertEquals(1, Bimbingan::valid()->count());
    }

    public function test_dokumen_public_url_accessor(): void
    {
        $bimbingan = Bimbingan::create([
            'nim' => $this->mhs->id_nim,
            'nidn' => $this->dosen->id_nidn,
            'tanggal' => now()->format('Y-m-d'),
            'topik' => 'Bab 3 Metodologi',
            'status_validasi' => 'pending',
        ]);

        $doc1 = Dokumen::create([
            'id_bimbingan' => $bimbingan->id_bimbingan,
            'nama_file' => 'draft.pdf',
            'file_path' => 'doc/12345_draft.pdf',
        ]);

        $doc2 = Dokumen::create([
            'id_bimbingan' => $bimbingan->id_bimbingan,
            'nama_file' => 'revisi.pdf',
            'file_path' => 'dokumen_bimbingan/abc123_revisi.pdf',
        ]);

        $this->assertStringContainsString('doc/12345_draft.pdf', $doc1->public_url);
        $this->assertStringContainsString('storage/dokumen_bimbingan/abc123_revisi.pdf', $doc2->public_url);
    }
}
