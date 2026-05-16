<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PengaturanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin')->except(['profileIndex', 'profileUpdate']);
    }

    // ── Manajemen User ─────────────────────────────
    public function user()
    {
        $users = User::orderBy('role')->orderBy('name')->paginate(10);
        return view('pengaturan.user', compact('users'));
    }

    public function userCreate()
    {
        return view('pengaturan.user-create');
    }

    public function userStore(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role'     => 'required|in:admin,peternak',
            'no_hp'    => 'nullable|string|max:15',
            'alamat'   => 'nullable|string',
        ], [
            'name.required'      => 'Nama wajib diisi.',
            'email.required'     => 'Email wajib diisi.',
            'email.unique'       => 'Email sudah digunakan.',
            'password.required'  => 'Password wajib diisi.',
            'password.min'       => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'role.required'      => 'Role wajib dipilih.',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
            'no_hp'    => $request->no_hp,
            'alamat'   => $request->alamat,
        ]);

        return redirect()->route('pengaturan.user')
            ->with('success', "User {$request->name} berhasil ditambahkan!");
    }

    public function userEdit(User $user)
    {
        return view('pengaturan.user-edit', compact('user'));
    }

    public function userUpdate(Request $request, User $user)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|min:6|confirmed',
            'role'     => 'required|in:admin,peternak',
            'no_hp'    => 'nullable|string|max:15',
            'alamat'   => 'nullable|string',
        ]);

        $data = [
            'name'   => $request->name,
            'email'  => $request->email,
            'role'   => $request->role,
            'no_hp'  => $request->no_hp,
            'alamat' => $request->alamat,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('pengaturan.user')
            ->with('success', "User {$user->name} berhasil diperbarui!");
    }

    public function userDestroy(User $user)
    {
        // Cegah hapus diri sendiri
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak bisa menghapus akun sendiri!');
        }

        $nama = $user->name;
        $user->delete();

        return redirect()->route('pengaturan.user')
            ->with('success', "User {$nama} berhasil dihapus.");
    }

    // ── Profile sendiri ────────────────────────────
    public function profileIndex()
    {
        return view('pengaturan.profile', ['user' => auth()->user()]);
    }

    public function profileUpdate(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        $request->validate([
            'name'         => 'required|string|max:100',
            'email'        => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'no_hp'        => 'nullable|string|max:15',
            'alamat'       => 'nullable|string',
            'password'     => 'nullable|min:6|confirmed',
            'old_password' => 'nullable|required_with:password',
        ]);

        // Cek password lama kalau mau ganti
        if ($request->filled('password')) {
            if (!Hash::check($request->old_password, $user->password)) {
                return back()->withErrors(['old_password' => 'Password lama tidak cocok.']);
            }
        }

        $data = [
            'name'   => $request->name,
            'email'  => $request->email,
            'no_hp'  => $request->no_hp,
            'alamat' => $request->alamat,
        ];

        // Upload foto
        if ($request->hasFile('foto')) {
            // Hapus foto lama kalau ada
            if ($user->foto && file_exists(public_path('uploads/foto/' . $user->foto))) {
                unlink(public_path('uploads/foto/' . $user->foto));
            }

            $file     = $request->file('foto');
            $namaFile = time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/foto'), $namaFile);
            $data['foto'] = $namaFile;
        }

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return back()->with('success', 'Profil berhasil diperbarui! ✅');
    }
}
