<?php

namespace App\Http\Controllers;

use App\Models\NotificationSetting;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class NotificationController extends Controller
{
    public function updateSettings(Request $request)
    {
        $request->validate([
            'roll' => 'required|integer|min:1',
            'pack' => 'required|integer|min:1',
            'unit' => 'required|integer|min:1',
        ]);

        $pop = Auth::user()->pop;
        $setting = NotificationSetting::where('pop', $pop)->first();

        if (!$setting) {
            // Jika pop tidak ada, insert data dengan nilai default
            NotificationSetting::create([
                'pop' => $pop,
                'roll' => 5,
                'pack' => 5,
                'unit' => 5,
                'pcs' => 5
            ]);
        }

        NotificationSetting::where('pop', $pop)->update([
            'roll' => $request->input('roll'),
            'pack' => $request->input('pack'),
            'unit' => $request->input('unit'),
            'pcs' => $request->input('unit'),
        ]);

        return redirect()->back()->with('success_notification', 'Pengaturan notifikasi berhasil disimpan.');
    }


    public function resetSettings(Request $request)
    {
        $pop = Auth::user()->pop;
        $setting = NotificationSetting::where('pop', $pop)->first();
        if (
            $setting->roll == 5 &&
            $setting->pack == 5 &&
            $setting->unit == 5 &&
            $setting->pcs == 5
        ) {
            return redirect()->back()->with('error', 'Data sudah bernilai default, tidak ada perubahan!');
        }

        NotificationSetting::where('pop', $pop)->update([
            'roll' => 5,
            'pack' => 5,
            'unit' => 5,
            'pcs' => 5
        ]);

        return redirect()->back()->with('success_notification', 'Pengaturan notifikasi berhasil dikembalikan ke nilai default.');
    }
}
