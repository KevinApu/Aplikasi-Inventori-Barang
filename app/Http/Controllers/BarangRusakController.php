<?php

namespace App\Http\Controllers;

use App\Models\BarangKeluarModel;
use App\Models\BarangMasukModel;
use App\Models\BarangRusakModel;
use App\Models\RekapModel;
use App\Models\StokGudangModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BarangRusakController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return view('Tabelview.Tabelbarangrusak');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {
        $input_by = Auth::user()->username;
        $foto = $request->file('foto'); // 'jpg'
        $finalFileName = time() . '-' . $foto->hashName();
        $foto->storeAs('public/img', $finalFileName);
        $StokGudangModel = StokGudangModel::find($id);
        BarangRusakModel::create([
            'jumlah' => $request->input('jumlah'),
            'foto' => 'img/' . $finalFileName,
            'input_by' => $input_by,
            'kondisi' => $request->input('kondisi'),
            'penyebab' => $request->input('penyebab'),
            'pop' => Auth::user()->pop,
            'status' => 'rusak_sebelum_penggunaan',
            'qr_code' => NULL,
            'stok_gudang_id' => $id,
        ]);

        $StokGudangModel->jumlah -= $request->input('jumlah');
        $StokGudangModel->save();

        $rekap = RekapModel::firstOrNew(['stok_gudang_id' => $StokGudangModel->id]);
        $rekap->out += $request->input('jumlah');
        $rekap->save();

        return redirect()->route('tabel_barang_masuk')->with([
            'success_rusak' => 'Barang rusak berhasil diperbarui!',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $query = BarangRusakModel::with('stokGudang')->where('pop', Auth::user()->pop);

        // Filter berdasarkan nama_barang di tabel stok_gudang (pakai whereHas)
        if ($request->kategori) {
            $query->whereHas('stokGudang', function ($q) use ($request) {
                $q->where('kategori', 'like', '%' . $request->kategori . '%');
            });
        }

        if ($request->namabarang) {
            $query->whereHas('stokGudang', function ($q) use ($request) {
                $q->where('nama_barang', 'like', '%' . $request->namabarang . '%');
            });
        }

        // Filter berdasarkan seri di stok_gudang
        if ($request->seri) {
            $query->whereHas('stokGudang', function ($q) use ($request) {
                $q->where('seri', 'like', '%' . $request->seri . '%');
            });
        }

        // Filter berdasarkan ID dan QR Code jika tersedia
        if ($request->id) {
            $parts = explode('-', $request->id);

            if (count($parts) == 2) {
                $id = $parts[0];       // Dicari di stok_gudang
                $qr_code = $parts[1];  // Dicari di barang_rusak

                $query->where('qr_code', $qr_code) // Pencarian qr_code di barang_rusak
                    ->whereHas('stokGudang', function ($q) use ($id) {
                        $q->where('id', $id); // Pencarian id di stok_gudang
                    });
            } else {
                $query->whereHas('stokGudang', function ($q) use ($parts) {
                    $q->where('id', $parts[0]); // Jika hanya ada id, cari di stok_gudang
                });
            }
        }

        $results = $query->get()->map(function ($barangRusak) {
            return [
                'id' => $barangRusak->id,
                'kode_barang' => $barangRusak->stokGudang->kode_barang ?? null,
                'kategori' => $barangRusak->stokGudang->kategori ?? null,
                'nama_barang' => $barangRusak->stokGudang->nama_barang ?? null,
                'seri' => $barangRusak->stokGudang->seri ?? null,
                'jumlah' => $barangRusak->jumlah ?? null, // Ambil dari stokGudang
                'foto' => $barangRusak->stokGudang->foto ?? null,
                'kondisi' => $barangRusak->kondisi ?? null,
                'penyebab' => $barangRusak->penyebab ?? null,
                'input_by' => $barangRusak->input_by ?? null,
                'status' => $barangRusak->status ?? null,
                'created_at' => $barangRusak->created_at->format('Y-m-d H:i:s'),
            ];
        });

        return response()->json($results);
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
    public function destroy($id)
    {
        // Cari item berdasarkan ID, nama_barang, nama_customer, dan output_by
        BarangRusakModel::where('id', $id)->delete();
        // Periksa apakah item ditemukan sebelum menghapu
        return redirect()->route('tabel_barang_rusak')->with(['success_hapus' => 'Data Berhasil Dihapus!']);
    }
}
