<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\KLModel;
use App\Models\Login;
use App\Models\Users;
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
        // Validasi sudah dilakukan oleh StoreUserRequest
        $username = $request->input('username');
        $password = $request->input('password');

        // Cek apakah pengguna sudah ada di database
        $inputUsername = strtolower(preg_replace('/\s+/', '', $username)); // Hilangkan semua spasi dan ubah ke huruf kecil

        // Ambil semua username dari database yang sudah diubah ke lowercase dan tanpa spasi
        $user = Login::get()->first(function ($user) use ($inputUsername) {
            return strtolower(preg_replace('/\s+/', '', $user->username)) === $inputUsername;
        });

        if ($user) {
            // Cek apakah password sesuai dengan yang di-hash di database
            if (Hash::check($password, $user->password)) {
                $user->update(['last_login' => now()]);
                Auth::login($user);
                return $user->role === 'superadmin'
                ? redirect()->route('tabel_barang_masuk.superadmin')
                : redirect()->route('dashboard');
            } else {
                // Jika password tidak sesuai
                return redirect()->back()->withErrors(['password_error' => 'Password tidak valid.'])->withInput();
            }
        } else {
            $roleData = $request->assignRole($username, $password);

            if (!$roleData) {
                return redirect()->back()->withErrors([
                    'username_error' => 'Username tidak valid.',
                    'password_error' => 'Password tidak valid.',
                ])->withInput();                
            }

            // Ambil role dan pop
            $role = $roleData['role'];
            $pop = $roleData['pop'];

            $newUser = Login::create([
                'username' => $username,
                'password' => Hash::make($password),
                'role' => $role,
                'pop' => $pop,
                'last_login' => now(),
            ]);

            Auth::login($newUser);
            return $role === 'superadmin'
            ? redirect()->route('tabel_barang_masuk.superadmin')
            : redirect()->route('dashboard');
        }
    }

    public function requestAccess()
    {
        $userId = Auth::id();
        $user = User::find($userId);

            if ($user->request_access) {
                return response()->json(['message' => 'Permintaan akses sudah pernah dikirim.', 'alert_type' => 'warning']);
            } else {
                DB::table('users')->where('id', $userId)->update(['request_access' => true]);
                return response()->json(['message' => 'Permintaan akses telah dikirim.', 'alert_type' => 'success']);
            }
    }

    public function approveAccess($userId)
    {
        $user = User::find($userId);
        if ($user && $user->request_access) {
            $user->role = 'admin';
            $user->save();
        }

        return redirect()->back()->with('message', 'Permintaan akses telah disetujui.');
    }


    public function deleteAccess($userId)
    {
        $user = User::find($userId);
        if ($user && $user->request_access) {
            $user->role = 'user';
            $user->request_access = false;
            $user->save();
        }

        return redirect()->back()->with('message', 'Permintaan akses telah disetujui.');
    }
}
