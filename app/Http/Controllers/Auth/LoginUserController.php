<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\KLModel;
use App\Models\Login;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class LoginUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $kantorlayanan = KLModel::all();
        return view('auth.login', compact('kantorlayanan'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(LoginRequest $request)
    {
        $username = strtolower(preg_replace('/\s+/', '', $request->input('username')));
        $password = $request->input('password');

        // Cari user di KLUsers berdasarkan username
        $KLUser = Login::whereRaw("REPLACE(LOWER(username), ' ', '') = ?", [$username])->first();

        if (!$KLUser) {
            return redirect()->back()->withErrors([
                'username_error' => 'Username tidak valid.',
            ])->withInput();
        }

        if ($KLUser->password != $password) {
            return redirect()->back()->withErrors([
                'password_error' => 'Password tidak valid.',
            ])->withInput();
        }

        $user = Login::where('id', $KLUser->id)->first();
        if (!$user) {
            // Jika belum ada di users, buat entri baru
            $user = Login::create([
                'id' => $KLUser->id,
                'request_access' => false,
                'foto' => null,
                'last_login' => now(),
            ]);
        } else {
            // Update last_login
            $user->update(['last_login' => now()]);
        }

        // Login pengguna
        Auth::login($user);

        return $KLUser->role === 'superadmin'
            ? redirect()->route('tabel_barang_masuk.superadmin')
            : redirect()->route('dashboard');
    }


    public function requestAccess()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'User tidak ditemukan.', 'alert_type' => 'error']);
        }
        if (!$user) {
            return response()->json(['message' => 'Akun ini tidak memiliki akses ke kantor layanan.', 'alert_type' => 'error']);
        }
        if ($user->request_access) {
            return response()->json(['message' => 'Permintaan akses sudah pernah dikirim.', 'alert_type' => 'warning']);
        }
        User::where('id', $user->id)->update(['request_access' => true]);
        return response()->json(['message' => 'Permintaan akses telah dikirim.', 'alert_type' => 'success']);
    }


    public function approveAccess($userId)
    {
        $user = Login::where('id', $userId)->first();
        if ($user && $user->request_access) {
            if ($user) {
                $user->update(['role' => 'admin']);
                return redirect()->back()->with('message', 'Permintaan akses telah disetujui.');
            } else {
                return redirect()->back()->with('error', 'User tidak memiliki akun di kantor layanan.');
            }
        }
    }


    public function deleteAccess($userId)
    {
        $user = Login::where('id', $userId)->first();
        if ($user && $user->request_access) {
            if ($user) {
                $user->update(['role' => 'user']);
                $user->update(['request_access' => false]);
                return redirect()->back()->with('message', 'Permintaan akses telah dihapus.');
            } else {
                return redirect()->back()->with('error', 'User tidak memiliki akun di kantor layanan.');
            }
        }
    }
}
