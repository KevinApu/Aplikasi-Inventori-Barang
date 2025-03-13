<?php

namespace App\Http\Controllers;

use App\Http\Requests\BarangKeluarRequest;
use App\Models\BarangKeluarModel;
use App\Models\StokGudangModel\kategori;
use App\Models\StokGudangModelModel;
use App\Models\RekapModel;
use App\Models\StokGudangModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BarangKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('Tabelview.Tabelbarangkeluar');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $order = BarangKeluarModel::with('stokGudang')
            ->where('status_order', 0)
            ->where('output_by', Auth::user()->username)->get();
        return view('Inputview.inputbarangkeluar', ['order' => $order]);
    }

    public function order($id)
    {
        $barcodePart = explode('-', $id);
        $part1 = $barcodePart[0]; // Bagian pertama dari barcode (ID)
        $uniqueCode = $barcodePart[1];

        // Mencari barang berdasarkan 'pop' dan 'id' dari barcode
        $barangMasuk = StokGudangModel::where('pop', Auth::user()->KLModel->pop)->where('id', $part1)->first();

        if (!$barangMasuk) {
            return response()->json(['message' => 'Barang tidak ditemukan.', 'alert_type' => 'error']);
        }

        if (($barangMasuk->satuan == 'roll' || $barangMasuk->satuan == 'pack') && BarangKeluarModel::where('stok_gudang_id', $barangMasuk->id)->exists()) {
            return response()->json(['message' => 'Barang sudah ditambahkan.', 'alert_type' => 'error']);
        }

        if (($barangMasuk->satuan == 'pcs' || $barangMasuk->satuan == 'unit') && BarangKeluarModel::where('qr_code', $uniqueCode)->exists()) {
            return response()->json(['message' => 'Barang sudah ditambahkan.', 'alert_type' => 'error']);
        }

        $exists = BarangKeluarModel::where('qr_code', $id)
            ->where('pop', Auth::user()->KLModel->pop)
            ->exists();

        if ($exists) {
            return response()->json(['message' => 'Barang sudah tercatat sebagai barang yang telah dikeluarkan.', 'alert_type' => 'error']);
        }

        BarangKeluarModel::create([
            'stok_gudang_id' => $barangMasuk->id,
            'output_by' => Auth::user()->username,
            'pop' => Auth::user()->KLModel->pop,
            'qr_code' => $id,
        ]);

        return response()->json(['message' => 'Barang berhasil ditambahkan.', 'alert_type' => 'success']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BarangKeluarRequest $request)
    {
        $jumlaharray = $request->input('jumlah');

        foreach ($jumlaharray as $id => $jumlah) {
            $nama_customer = $request->input('ID') . '_' . $request->input('namacustomer');
            $barangKeluar = BarangKeluarModel::where('id', $id)->first();
            $StokGudangModel = StokGudangModel::find($barangKeluar->stok_gudang_id);

            BarangKeluarModel::where('id', $id)->update([
                'jumlah' => $jumlah,
                'lokasi' => $request->lokasi,
                'nama_customer' => $nama_customer,
                'keterangan' => $request->keterangan,
                'status_order' => 1,
            ]);

            if ($StokGudangModel->satuan == 'pack' || $StokGudangModel->satuan == 'roll') {
                $StokGudangModel->hasil = $StokGudangModel->hasil - $jumlah;
                $roll = $StokGudangModel->hasil / $StokGudangModel->rasio;
                $nilaiGenap = ceil($roll);
                $StokGudangModel->jumlah = $nilaiGenap;
                $StokGudangModel->detail_jumlah = $StokGudangModel->hasil % $StokGudangModel->rasio;
                $StokGudangModel->save();


                $rekap = RekapModel::where('stok_gudang_id', $barangKeluar->stok_gudang_id)->first();
                if ($rekap) {
                    $rekap->out += $jumlah;
                    $rekap->save();
                }
            } else {
                $StokGudangModel->jumlah -= $jumlah;
                $StokGudangModel->save();

                $rekap = RekapModel::where('stok_gudang_id', $barangKeluar->stok_gudang_id)->first();
                if ($rekap) {
                    $rekap->out += $jumlah; // Update jumlah dengan penambahan
                    $rekap->save();
                }
            }
        }
        return redirect()->route('input_barang_keluar')->with([
            'success' => 'Data Berhasil Diorder!'
        ]);
    }


    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $query = BarangKeluarModel::with('stokGudang')
            ->where('status_order', 1)
            ->where('pop', Auth::user()->KLModel->pop);

        // Filter berdasarkan kategori, nama barang, dan seri dari stok_gudang
        if ($request->namabarang) {
            $query->whereHas('stokGudang', function ($q) use ($request) {
                $q->where('nama_barang', 'like', '%' . $request->namabarang . '%');
            });
        }

        if ($request->seri) {
            $query->whereHas('stokGudang', function ($q) use ($request) {
                $q->where('seri', 'like', '%' . $request->seri . '%');
            });
        }

        if ($request->nama_customer) {
            $query->where('nama_customer', 'like', '%' . $request->nama_customer . '%');
        }

        if ($request->id) {
            // Memisahkan id dan qr_code
            $parts = explode('-', $request->id);

            if (count($parts) == 2) {
                $id = $parts[0];        // ID dari inputan
                $qr_code = $parts[1];   // QR Code dari inputan

                $query->whereHas('stokGudang', function ($q) use ($id) {
                    $q->where('id', $id);  // ID dari stok_gudang
                })->where('qr_code', $qr_code);
            } else {
                return redirect()->back()->with('error', 'Format ID tidak valid');
            }
        }

        $results = $query->get()->map(function ($barangKeluar) {
            return [
                'id' => $barangKeluar->id,
                'kode_barang' => $barangKeluar->stokGudang->kode_barang ?? null,
                'kategori' => $barangKeluar->stokGudang->kategori ?? null,
                'nama_barang' => $barangKeluar->stokGudang->nama_barang ?? null,
                'seri' => $barangKeluar->stokGudang->seri ?? null,
                'jumlah' => $barangKeluar->jumlah ?? null, // Ambil dari stokGudang
                'hasil' => $barangKeluar->stokGudang->hasil ?? null,
                'foto' => $barangKeluar->stokGudang->foto ?? null,
                'lokasi' => $barangKeluar->lokasi ?? null,
                'nama_customer' => $barangKeluar->nama_customer ?? null,
                'output_by' => $barangKeluar->output_by ?? null,
                'created_at' => $barangKeluar->created_at->format('Y-m-d H:i:s'),
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

    public function destroy_order($id)
    {
        BarangKeluarModel::where('id', $id)
            ->where('status_order', 0)
            ->delete();
        return redirect()->route('input_barang_keluar');
    }

    public function destroy($id)
    {
        BarangKeluarModel::where('id', $id)
            ->where('status_order', 1)
            ->delete();
        return redirect()->route('tabel_barang_keluar')->with(['success_hapus' => 'Data Berhasil Dihapus!']);
    }
}
