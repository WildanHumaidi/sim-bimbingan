<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // Role constants
    const ROLE_ADMIN = 1;
    const ROLE_DOSEN = 2;
    const ROLE_MAHASISWA = 3;

    /**
     * Display a listing of users
     */
    public function index()
    {
        $users = User::with(['mahasiswa', 'dosen'])->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user
     */
    public function create()
    {
        $fakultas_list = Dosen::getListFakultas();
        return view('admin.users.create', compact('fakultas_list'));
    }

    /**
     * Show the form for creating a new admin user
     */
    public function createAdmin()
    {
        return view('admin.users.create-admin');
    }

    /**
     * Show the form for creating a new dosen user
     */
    public function createDosen()
    {
        $fakultas_list = Dosen::getListFakultas();
        return view('admin.users.create-dosen', compact('fakultas_list'));
    }

    /**
     * Show the form for creating a new mahasiswa user
     */
    public function createMahasiswa()
    {
        return view('admin.users.create-mahasiswa');
    }

    /**
     * Store a newly created admin user in storage
     */
    public function storeAdmin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            User::create([
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => self::ROLE_ADMIN,
            ]);

            return redirect()->route('admin.users.index')
                ->with('success', 'Admin berhasil dibuat');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Store a newly created dosen user in storage
     */
    public function storeDosen(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'id_nidn' => 'required|string|unique:dosens,id_nidn',
            'nama_dosen' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'fakultas' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Validate fakultas
        if (!Dosen::validateFakultas($request->fakultas)) {
            return redirect()->back()
                ->withErrors(['fakultas' => 'Fakultas tidak valid'])
                ->withInput();
        }

        try {
            DB::transaction(function () use ($request) {
                $user = User::create([
                    'username' => $request->username,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role' => self::ROLE_DOSEN,
                ]);

                Dosen::create([
                    'id_nidn' => $request->id_nidn,
                    'id_user' => $user->id_user,
                    'nama' => $request->nama_dosen,
                    'jabatan' => $request->jabatan,
                    'fakultas' => $request->fakultas,
                ]);
            });

            return redirect()->route('admin.users.index')
                ->with('success', 'Dosen berhasil dibuat');

        } catch (\Exception $e) {
            Log::error('Gagal membuat dosen: ' . $e->getMessage());
            return redirect()->back()
                ->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data dosen.'])
                ->withInput();
        }
    }

    /**
     * Store a newly created mahasiswa user in storage
     */
    public function storeMahasiswa(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'id_nim' => 'required|string|unique:mahasiswas,id_nim',
            'nama_mahasiswa' => 'required|string|max:255',
            'program_studi' => 'required|string|max:255',
            'angkatan' => 'required|integer|min:2000|max:' . (date('Y') + 1),
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::transaction(function () use ($request) {
                $user = User::create([
                    'username' => $request->username,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role' => self::ROLE_MAHASISWA,
                ]);

                Mahasiswa::create([
                    'id_nim' => $request->id_nim,
                    'id_user' => $user->id_user,
                    'nama' => $request->nama_mahasiswa,
                    'program_studi' => $request->program_studi,
                    'angkatan' => $request->angkatan,
                ]);
            });

            return redirect()->route('admin.users.index')
                ->with('success', 'Mahasiswa berhasil dibuat');

        } catch (\Exception $e) {
            Log::error('Gagal membuat mahasiswa: ' . $e->getMessage());
            return redirect()->back()
                ->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data mahasiswa.'])
                ->withInput();
        }
    }

    /**
     * Store a newly created user in storage
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:1,2,3', // 1: admin, 2: dosen, 3: mahasiswa

            // Mahasiswa fields
            'id_nim' => 'required_if:role,3|string|unique:mahasiswas,id_nim',
            'nama_mahasiswa' => 'required_if:role,3|string|max:255',
            'program_studi' => 'required_if:role,3|string|max:255',
            'angkatan' => 'required_if:role,3|integer|min:2000|max:' . (date('Y') + 1),

            // Dosen fields
            'id_nidn' => 'required_if:role,2|string|unique:dosens,id_nidn',
            'nama_dosen' => 'required_if:role,2|string|max:255',
            'jabatan' => 'required_if:role,2|string|max:255',
            'fakultas' => 'required_if:role,2|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Validate fakultas if role is dosen
        if ($request->role == self::ROLE_DOSEN) {
            if (!Dosen::validateFakultas($request->fakultas)) {
                return redirect()->back()
                    ->withErrors(['fakultas' => 'Fakultas tidak valid'])
                    ->withInput();
            }
        }

        try {
            DB::transaction(function () use ($request) {
                // Create user
                $user = User::create([
                    'username' => $request->username,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role' => $request->role,
                ]);

                // Create related model based on role
                if ($request->role == self::ROLE_MAHASISWA) {
                    Mahasiswa::create([
                        'id_nim' => $request->id_nim,
                        'id_user' => $user->id_user,
                        'nama' => $request->nama_mahasiswa,
                        'program_studi' => $request->program_studi,
                        'angkatan' => $request->angkatan,
                    ]);
                } elseif ($request->role == self::ROLE_DOSEN) {
                    Dosen::create([
                        'id_nidn' => $request->id_nidn,
                        'id_user' => $user->id_user,
                        'nama' => $request->nama_dosen,
                        'jabatan' => $request->jabatan,
                        'fakultas' => $request->fakultas,
                    ]);
                }
            });

            return redirect()->route('admin.users.index')
                ->with('success', 'User berhasil dibuat');

        } catch (\Exception $e) {
            Log::error('Gagal membuat user: ' . $e->getMessage());
            return redirect()->back()
                ->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data pengguna.'])
                ->withInput();
        }
    }

    /**
     * Display the specified user
     */
    public function show(User $user)
    {
        $user->load(['mahasiswa', 'dosen']);
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user
     * Automatically detects role and redirects to appropriate edit page
     */
    public function edit(User $user)
    {
        $user->load(['mahasiswa', 'dosen']);
        $fakultas_list = Dosen::getListFakultas();

        // Redirect to specific edit page based on role
        switch ($user->role) {
            case self::ROLE_ADMIN:
                return view('admin.users.edit-admin', compact('user'));
            case self::ROLE_DOSEN:
                return view('admin.users.edit-dosen', compact('user', 'fakultas_list'));
            case self::ROLE_MAHASISWA:
                return view('admin.users.edit-mahasiswa', compact('user'));
            default:
                return view('admin.users.edit', compact('user', 'fakultas_list'));
        }
    }

    /**
     * Show the form for editing admin user
     */
    public function editAdmin(User $user)
    {
        if ($user->role !== self::ROLE_ADMIN) {
            return redirect()->route('admin.edit', $user)->with('error', 'User bukan admin');
        }

        return view('admin.users.edit-admin', compact('user'));
    }

    /**
     * Show the form for editing dosen user
     */
    public function editDosen(User $user)
    {
        if ($user->role !== self::ROLE_DOSEN) {
            return redirect()->route('admin.edit', $user)->with('error', 'User bukan dosen');
        }

        $user->load('dosen');
        $fakultas_list = Dosen::getListFakultas();
        return view('admin.users.edit-dosen', compact('user', 'fakultas_list'));
    }

    /**
     * Show the form for editing mahasiswa user
     */
    public function editMahasiswa(User $user)
    {
        if ($user->role !== self::ROLE_MAHASISWA) {
            return redirect()->route('admin.edit', $user)->with('error', 'User bukan mahasiswa');
        }

        $user->load('mahasiswa');
        return view('admin.users.edit-mahasiswa', compact('user'));
    }

    /**
     * Update admin user
     */
    public function updateAdmin(Request $request, User $user)
    {
        if ($user->role !== self::ROLE_ADMIN) {
            return redirect()->route('admin.edit', $user)->with('error', 'User bukan admin');
        }

        $validator = Validator::make($request->all(), [
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id_user, 'id_user')],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id_user, 'id_user')],
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $userData = [
                'username' => $request->username,
                'email' => $request->email,
            ];

            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            $user->update($userData);

            return redirect()->route('admin.users.index')
                ->with('success', 'Admin berhasil diupdate');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Update dosen user
     */
    public function updateDosen(Request $request, User $user)
    {
        if ($user->role !== self::ROLE_DOSEN) {
            return redirect()->route('admin.edit', $user)->with('error', 'User bukan dosen');
        }

        $validator = Validator::make($request->all(), [
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id_user, 'id_user')],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id_user, 'id_user')],
            'password' => 'nullable|string|min:8|confirmed',
            'id_nidn' => 'required|string',
            'nama_dosen' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'fakultas' => 'required|string|max:255',
        ]);

        // Add unique validation for NIDN if it changed
        if ($user->dosen && $request->id_nidn !== $user->dosen->id_nidn) {
            $validator->addRules(['id_nidn' => 'unique:dosens,id_nidn']);
        }

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Validate fakultas
        if (!Dosen::validateFakultas($request->fakultas)) {
            return redirect()->back()
                ->withErrors(['fakultas' => 'Fakultas tidak valid'])
                ->withInput();
        }

        try {
            $userData = [
                'username' => $request->username,
                'email' => $request->email,
            ];

            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            $user->update($userData);

            // Update dosen data
            $user->dosen->update([
                'id_nidn' => $request->id_nidn,
                'nama' => $request->nama_dosen,
                'jabatan' => $request->jabatan,
                'fakultas' => $request->fakultas,
            ]);

            return redirect()->route('admin.users.index')
                ->with('success', 'Dosen berhasil diupdate');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Update mahasiswa user
     */
    public function updateMahasiswa(Request $request, User $user)
    {
        if ($user->role !== self::ROLE_MAHASISWA) {
            return redirect()->route('admin.edit', $user)->with('error', 'User bukan mahasiswa');
        }

        $validator = Validator::make($request->all(), [
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id_user, 'id_user')],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id_user, 'id_user')],
            'password' => 'nullable|string|min:8|confirmed',
            'id_nim' => 'required|string',
            'nama_mahasiswa' => 'required|string|max:255',
            'program_studi' => 'required|string|max:255',
            'angkatan' => 'required|integer|min:2000|max:' . (date('Y') + 1),
        ]);

        // Add unique validation for NIM if it changed
        if ($user->mahasiswa && $request->id_nim !== $user->mahasiswa->id_nim) {
            $validator->addRules(['id_nim' => 'unique:mahasiswas,id_nim']);
        }

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $userData = [
                'username' => $request->username,
                'email' => $request->email,
            ];

            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            $user->update($userData);

            // Update mahasiswa data
            $user->mahasiswa->update([
                'id_nim' => $request->id_nim,
                'nama' => $request->nama_mahasiswa,
                'program_studi' => $request->program_studi,
                'angkatan' => $request->angkatan,
            ]);

            return redirect()->route('admin.users.index')
                ->with('success', 'Mahasiswa berhasil diupdate');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Update the specified user in storage (original method)
     */
    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id_user, 'id_user')],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id_user, 'id_user')],
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:1,2,3', // 1: admin, 2: dosen, 3: mahasiswa

            // Mahasiswa fields
            'id_nim' => 'required_if:role,3|string',
            'nama_mahasiswa' => 'required_if:role,3|string|max:255',
            'program_studi' => 'required_if:role,3|string|max:255',
            'angkatan' => 'required_if:role,3|integer|min:2000|max:' . (date('Y') + 1),

            // Dosen fields
            'id_nidn' => 'required_if:role,2|string',
            'nama_dosen' => 'required_if:role,2|string|max:255',
            'jabatan' => 'required_if:role,2|string|max:255',
            'fakultas' => 'required_if:role,2|string|max:255',
        ]);

        // Add unique validation for NIM and NIDN if they changed
        if ($request->role == self::ROLE_MAHASISWA && $user->mahasiswa && $request->id_nim !== $user->mahasiswa->id_nim) {
            $validator->addRules(['id_nim' => 'unique:mahasiswas,id_nim']);
        }
        if ($request->role == self::ROLE_DOSEN && $user->dosen && $request->id_nidn !== $user->dosen->id_nidn) {
            $validator->addRules(['id_nidn' => 'unique:dosens,id_nidn']);
        }

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Validate fakultas if role is dosen
        if ($request->role == self::ROLE_DOSEN) {
            if (!Dosen::validateFakultas($request->fakultas)) {
                return redirect()->back()
                    ->withErrors(['fakultas' => 'Fakultas tidak valid'])
                    ->withInput();
            }
        }

        try {
            // Update user
            $userData = [
                'username' => $request->username,
                'email' => $request->email,
                'role' => $request->role,
            ];

            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            $user->update($userData);

            // Handle role changes
            if ($user->role != $request->role) {
                // Delete old related models
                if ($user->mahasiswa) {
                    $user->mahasiswa->delete();
                }
                if ($user->dosen) {
                    $user->dosen->delete();
                }
            }

            // Create or update related model based on role
            if ($request->role == self::ROLE_MAHASISWA) {
                Mahasiswa::updateOrCreate(
                    ['id_user' => $user->id_user],
                    [
                        'id_nim' => $request->id_nim,
                        'nama' => $request->nama_mahasiswa,
                        'program_studi' => $request->program_studi,
                        'angkatan' => $request->angkatan,
                    ]
                );
            } elseif ($request->role == self::ROLE_DOSEN) {
                Dosen::updateOrCreate(
                    ['id_user' => $user->id_user],
                    [
                        'id_nidn' => $request->id_nidn,
                        'nama' => $request->nama_dosen,
                        'jabatan' => $request->jabatan,
                        'fakultas' => $request->fakultas,
                    ]
                );
            }

            return redirect()->route('admin.users.index')
                ->with('success', 'User berhasil diupdate');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Remove the specified user from storage
     */
    public function destroy(User $user)
    {
        try {
            // Delete related models first
            if ($user->mahasiswa) {
                $user->mahasiswa->delete();
            }
            if ($user->dosen) {
                $user->dosen->delete();
            }

            // Delete user
            $user->delete();

            return redirect()->route('admin.users.index')
                ->with('success', 'User berhasil dihapus');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }
}
