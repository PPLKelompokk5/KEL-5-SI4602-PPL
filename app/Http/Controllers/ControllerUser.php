<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ControllerUser extends Controller
{
    /**
     * Tampilkan daftar seluruh pengguna.
     */
    public function index()
    {
        // Mis. paginasi 10 data per halaman
        $users = User::latest()->paginate(10);

        return view('users.index', compact('users'));
        // ‑ Atau untuk API: return response()->json($users);
    }

    /**
     * Tampilkan form pembuatan user.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Simpan user baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()
            ->route('users.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Tampilkan detail 1 user.
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * Tampilkan form edit user.
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Perbarui data user di database.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => [
                'required', 'email', 'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $user->name  = $validated['name'];
        $user->email = $validated['email'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()
            ->route('users.index')
            ->with('success', 'User berhasil diperbarui.');
    }

    /**
     * Hapus user dari database.
     */
    public function destroy(User $user)
    {
        // Cegah penghapusan diri sendiri (opsional)
        // // if (auth()->id() === $user->id) {
        // //     return back()->withErrors('Anda tidak dapat menghapus akun Anda sendiri.');
        // // }

        // $user->delete();

        // return redirect()
        //     ->route('users.index')
        //     ->with('success', 'User berhasil dihapus.');
    }
}
