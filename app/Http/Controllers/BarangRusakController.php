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
        //format hashname database
        $finalFileName = time() . '-' . $foto->hashName();
        $foto->storeAs('public/img', $finalFileName);

        $barangMasuk = BarangMasukModel::find($id); // Cari barang berdasarkan ID;
        // Simpan data ke database untuk setiap barang
        BarangRusakModel::create([
            'id' => $id,
            'kode_barang' => $barangMasuk->kode_barang,
            'kategori' => $barangMasuk->kategori,
            'nama_barang' => $barangMasuk->nama_barang,
            'seri' => $barangMasuk->seri,
            'jumlah' => $request->input('jumlah'),
            'foto' => 'img/' . $finalFileName,
            'input_by' => $input_by,
            'kondisi' => $request->input('kondisi'),
            'penyebab' => $request->input('penyebab'),
            'pop' => Auth::user()->pop,
            'status' => 'rusak_sebelum_penggunaan',
            'qr_code' => NULL,
        ]);

        if ($barangMasuk->jumlah > 0) {
            // Kurangi jumlah barang di tabel BarangMasukModel
            $barangMasuk->jumlah -= $request->input('jumlah');
            $barangMasuk->save();

            $stokGudang = StokGudangModel::firstOrNew(['id' => $barangMasuk->id]);
            $stokGudang->jumlah = $barangMasuk->jumlah;
            $stokGudang->save();

            $rekap = RekapModel::firstOrNew(['id' => $barangMasuk->id]);
            $rekap->jumlah = $barangMasuk->jumlah;
            $rekap->out += $request->input('jumlah');
            $rekap->save();

            if ($barangMasuk->jumlah === 0) {
                $barangMasuk->delete();
            }
        } else {
            // Jika jumlah kurang dari atau sama dengan 1, hapus barang dari tabel BarangMasukModel
            $barangMasuk->delete();
        }
        return redirect()->route('tabel_barang_masuk')->with([
            'success_rusak' => 'Barang rusak berhasil diperbarui!',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $query = DB::table('barang_rusak')
            ->where('pop', Auth::user()->pop);

        if ($request->kategori) {
            $query->where('kategori', 'like', '%' . $request->kategori . '%');
        }
        if ($request->namabarang) {
            $query->where('nama_barang', 'like', '%' . $request->namabarang . '%');
        }
        if ($request->seri) {
            $query->where('seri', 'like', '%' . $request->seri . '%');
        }
        if ($request->id) {
            // Memisahkan id dan qr_code
            $parts = explode('-', $request->id);
        
            if (count($parts) == 2) {
                $id = $parts[0];
                $qr_code = $parts[1];
        
                // Cek apakah kombinasi id dan qr_code ada di database
                $exists = DB::table('barang_rusak')
                    ->where('pop', Auth::user()->pop)
                    ->where('id', $id)
                    ->where('qr_code', $qr_code)
                    ->exists();
        
                if ($exists) {
                    // Gunakan kombinasi id dan qr_code
                    $query->where('id', $id)
                        ->where('qr_code', $qr_code);
                } else {
                    // Jika qr_code tidak ditemukan, gunakan id saja dan pastikan qr_code bernilai null
                    $query->where('id', $id)
                        ->whereNull('qr_code');
                }
            } else {
                // Jika format tidak sesuai atau hanya memiliki ID, gunakan ID saja dan pastikan qr_code bernilai null
                $query->where('id', $parts[0])
                    ->whereNull('qr_code');
            }
        }
        $results = $query->get();

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
    public function destroy($id, $nama_barang, $penyebab, $kondisi)
    {
        // Cari item berdasarkan ID, nama_barang, nama_customer, dan output_by
        BarangRusakModel::where('id', $id)
            ->where('nama_barang', $nama_barang)
            ->where('penyebab', $penyebab)
            ->where('kondisi', $kondisi)
            ->delete();
        // Periksa apakah item ditemukan sebelum menghapu
        return redirect()->route('tabel_barang_rusak')->with(['success_hapus' => 'Data Berhasil Dihapus!']);
    }
}
