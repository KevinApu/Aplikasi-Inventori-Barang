<?php

namespace App\Http\Controllers;

use App\Models\RekapModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RekapController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        // Misalkan Anda ingin menghitung total barang keluar dalam rentang waktu tertentu
        $startDate = Carbon::now()->startOfYear(); // Awal tahun ini (1 Januari)
        $endDate = Carbon::now()->endOfYear(); // Akhir bulan ini

        // Ambil semua data dari tabel rekap dengan filter tanggal
        $rekap = RekapModel::whereBetween('updated_at', [$startDate, $endDate])->get();

        // Inisialisasi array untuk menyimpan total per bulan
        $totalPerBulan = [];

        // Iterasi melalui data rekap
        foreach ($rekap as $entry) {
            $bulan = Carbon::parse($entry->updated_at)->format('n'); // Mengambil bulan dari updated_at
            $jumlah = $entry->out; // Misalkan kolom 'jumlah'

            // Jika bulan belum ada di totalPerBulan, inisialisasi dengan 0
            if (!isset($totalPerBulan[$bulan])) {
                $totalPerBulan[$bulan] = 0;
            }

            // Tambahkan jumlah ke total bulan yang sesuai
            $totalPerBulan[$bulan] += $jumlah;
        }

        // Mengubah totalPerBulan menjadi array dengan ukuran tetap
        $totalBarangKeluar = [];
        for ($i = 1; $i <= 12; $i++) {
            $totalBarangKeluar[$i] = isset($totalPerBulan[$i]) ? $totalPerBulan[$i] : 0;
        }

        // Kirim data ke view
        return view('dashboard', compact('totalBarangKeluar'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function updateRekapBulanan(Request $request)
    {
        // Update kolom `in` dengan nilai `hasil` dan kosongkan `out`
        $rekapItems = DB::table('rekap')->get(); // Ambil semua data dari tabel 'rekap'

        foreach ($rekapItems as $item) {
            if ($item->satuan === 'roll' || $item->satuan === 'pack') {
                // Jika satuan 'roll' atau 'pack', update kolom 'in' dengan 'hasil'
                DB::table('rekap')
                    ->where('id', $item->id)
                    ->update([
                        'stok_awal' => DB::raw('hasil'),
                        'in' => 0,
                        'out' => 0
                    ]);
            } elseif ($item->satuan === 'pcs' || $item->satuan === 'unit') {
                // Jika satuan 'pcs' atau 'unit', update kolom 'in' dengan 'jumlah'
                DB::table('rekap')
                    ->where('id', $item->id)
                    ->update([
                        'stok_awal' => DB::raw('jumlah'),
                        'in' => 0,
                        'out' => 0
                    ]);
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $query = RekapModel::whereHas('stokGudang', function ($query) {
            $query->where('jumlah', '>=', 1);
        })->with('stokGudang')
            ->where('pop', Auth::user()->KLModel->pop);



        if ($request->namabarang) {
            $query->whereHas('stokGudang', function ($q) use ($request) {
                $q->where('nama_barang', 'like', '%' . $request->namabarang . '%');
            });
        }

        $results = $query->get()->map(function ($rekap) {
            return [
                'id' => $rekap->id,
                'stok_awal' => $rekap->stok_awal,
                'in' => $rekap->in ?? 0,
                'out' => $rekap->out ?? 0,
                'satuan' => $rekap->stokGudang->satuan ?? null,
                'jumlah' => $rekap->stokGudang->jumlah ?? null, // Ambil dari stokGudang
                'hasil' => $rekap->stokGudang->hasil ?? null, // Ambil dari stokGudang
                'nama_barang' => $rekap->stokGudang->nama_barang ?? null,
                'seri' => $rekap->stokGudang->seri ?? null,
            ];
        });
        return $results->isEmpty() ? response()->json(null) : response()->json($results);
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
