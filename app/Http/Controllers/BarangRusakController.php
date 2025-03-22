<?php

namespace App\Http\Controllers;

use App\Http\Requests\BarangRusakRequest;
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
        return view('Inputview.inputbarangrusak');
    }

    public function check_barcode(Request $request)
    {
        $barcode = $request->input('barcode');
        if (!$barcode) {
            return back()->with('error_rusak', 'Barcode tidak boleh kosong');
        }

        $barcodeParts = explode('-', $barcode);

        if (count($barcodeParts) < 2) {
            return back()->with('error_rusak', 'Format barcode salah, mungkin barcode ini tidak berasal dari aplikasi ini.');
        }

        // Ambil bagian pertama dari barcode
        $part1 = $barcodeParts[0];

        // Cari di database
        $check_barcode = StokGudangModel::where('id', $part1)
            ->where('pop', Auth::user()->KLModel->pop)
            ->first();

        if (!$check_barcode) {
            return back()->with('error_rusak', 'Barcode tidak ditemukan di stok gudang');
        }
        return redirect()->route('input_barang_rusak')->with([
            'check_barcode' => $check_barcode,
            'barcode' => $barcode
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BarangRusakRequest $request, $id)
    {
        $input_by = Auth::user()->username;
        $foto = $request->file('foto');
        $finalFileName = time() . '-' . $foto->hashName();
        $foto->storeAs('public/img', $finalFileName);
        $StokGudangModel = StokGudangModel::find($id);
        BarangRusakModel::create([
            'jumlah' => $request->jumlah_rusak,
            'foto' => 'img/' . $finalFileName,
            'input_by' => $input_by,
            'kondisi' => $request->kondisi,
            'penyebab' => $request->penyebab,
            'pop' => Auth::user()->KLModel->pop,
            'qr_code' => $request->barcode,
            'stok_gudang_id' => $id,
        ]);

        if ($StokGudangModel->satuan == 'pack' || $StokGudangModel->satuan == 'roll') {

            $StokGudangModel->hasil = $StokGudangModel->hasil - $request->jumlah_rusak;
            $roll = $StokGudangModel->hasil / $StokGudangModel->rasio;
            $nilaiGenap = ceil($roll);
            $StokGudangModel->jumlah = $nilaiGenap;
            $StokGudangModel->detail_jumlah = $StokGudangModel->hasil % $StokGudangModel->rasio;
            $StokGudangModel->save();


            $rekap = RekapModel::where('stok_gudang_id', $StokGudangModel->stok_gudang_id)->first();
            if ($rekap) {
                $rekap->out += $request->jumlah_rusak;
                $rekap->save();
            }
        } else {
            $StokGudangModel->jumlah -= $request->jumlah_rusak;
            $StokGudangModel->save();

            $rekap = RekapModel::where('stok_gudang_id', $StokGudangModel->stok_gudang_id)->first();
            if ($rekap) {
                $rekap->out += $request->jumlah_rusak;
                $rekap->save();
            }
        }

        return redirect()->route('input_barang_rusak')->with([
            'success_rusak' => 'Barang rusak berhasil diperbarui!',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $query = BarangRusakModel::with('stokGudang')->where('pop', Auth::user()->KLModel->pop);

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
            $query->where('qr_code', $request->id); // Cari berdasarkan qr_code
        }


        $results = $query->get()->map(function ($barangRusak) {
            return [
                'id' => $barangRusak->id,
                'kode_barang' => $barangRusak->stokGudang->kode_barang ?? null,
                'kategori' => $barangRusak->stokGudang->kategori ?? null,
                'nama_barang' => $barangRusak->stokGudang->nama_barang ?? null,
                'seri' => $barangRusak->stokGudang->seri ?? null,
                'jumlah' => $barangRusak->jumlah ?? null, // Ambil dari stokGudang
                'foto' => $barangRusak->foto ?? null,
                'kondisi' => $barangRusak->kondisi ?? null,
                'penyebab' => $barangRusak->penyebab ?? null,
                'input_by' => $barangRusak->input_by ?? null,
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
        BarangRusakModel::where('id', $id)->delete();
        return redirect()->route('tabel_barang_rusak')->with(['success_rusak' => 'Data Berhasil Dihapus!']);
    }
}
