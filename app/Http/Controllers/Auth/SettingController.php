<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UpdatePassword;
use App\Models\KLModel;
use App\Models\KLUsers;
use App\Models\Login;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Svg\Tag\Rect;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kantorlayanan = KLModel::where('lokasi', '!=', 'pusat')->get();
        $kl_users = KLUsers::all();
        $foto_profile = Auth::user()->foto;
        return view('auth.setting', ['kantorlayanan' => $kantorlayanan, 'foto_profile' => $foto_profile, 'kl_users' => $kl_users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function add_user(Request $request)
    {
        // Validasi inputan
        $request->validate([
            'username' => 'required|string|unique:kl_users,username|max:100',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:user,admin',
        ]);

        // Menyimpan data ke dalam tabel KLUsers
        KLUsers::create([
            'username' => $request->username,
            'password' => $request->password, 
            'role' => $request->role,
            'pop' => $request->kantor_id,
        ]);

        return redirect()->back()
        ->with('success', 'Penggantian  username berhasil dilakukan!')
        ->with('activeTab', 'daftarpop');
    }
    
    public function destroy_user(Request $request, $id, $username, $password)
    {
        KLUsers::where('username', $username)
        ->where('password', $password)
        ->where('id', $id)
        ->delete(); 
        
        Login::where('username', $username)
        ->where('password', $password)
        ->delete(); 

        return redirect()->back()
        ->with('success', 'Penggantian  username berhasil dilakukan!')
        ->with('activeTab', 'daftarpop');
    }







    public function update_username(Request $request)
    {
        Login::where('id', Auth::user()->id)
            ->where('username', Auth::user()->username)
            ->where('password', Auth::user()->password)
            ->update([
                'username' => $request->username,
            ]);

        return redirect()->back()
            ->with('success', 'Penggantian  username berhasil dilakukan!')
            ->with('activeTab', 'pengaturanakun');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function update_password(UpdatePassword $request)
    {
        $hashedPassword = Hash::make($request->new_password);
        Login::where('id', Auth::user()->id)
            ->where('username', Auth::user()->username)
            ->where('role', 'superadmin')
            ->where('password', Auth::user()->password)
            ->update([
                'password' => $hashedPassword,
            ]);

        KLModel::where('lokasi', 'pusat')
            ->where('password_superadmin', $request->current_password)
            ->update([
                'password_superadmin' => $request->new_password,
            ]);

        return redirect()->back()
            ->with('success', 'Penggantian password berhasil dilakukan!')
            ->with('activeTab', 'pengaturanakun');
    }

    /**
     * Display the specified resource.
     */
    public function update_profile_picture(Request $request)
    {
        $request->validate([
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Jika ada foto yang diupload
        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');

            // Buat nama file unik
            $finalFileName = uniqid() . '.' . $file->getClientOriginalExtension();

            // Hapus foto lama jika ada
            $user = Auth::user();
            if (!empty($user->foto) && Storage::exists('public/' . $user->foto)) {
                Storage::delete('public/' . $user->foto);
            }

            // Simpan foto baru ke storage
            $file->storeAs('public/img/profile', $finalFileName);

            // Update path foto profil di tabel user
            User::where('id', $user->id)->update(['foto' => 'img/profile/' . $finalFileName]);
        }


        return redirect()->back()
            ->with('success', 'Penggantian foto profile berhasil dilakukan!')
            ->with('activeTab', 'pengaturanfoto');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
