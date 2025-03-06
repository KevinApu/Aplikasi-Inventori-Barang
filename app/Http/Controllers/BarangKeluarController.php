<?php

namespace App\Http\Controllers;

use App\Http\Requests\BarangKeluarRequest;
use App\Models\BarangKeluarModel;
use App\Models\StokGudangModel\kategori;
use App\Models\StokGudangModelModel;
use App\Models\Order;
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
        $order = Order::with('stokGudang')
            ->where('pop', Auth::user()->pop)->get();
        return view('Inputview.inputbarangkeluar', ['order' => $order]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BarangKeluarRequest $request)
    {
        $jumlaharray = $request->input('jumlah');
        $qr_code = $request->input('qr_code');
        $stok_gudang_id = $request->input('stok_gudang_id');
        $output_by = Auth::user()->username;

        foreach ($jumlaharray as $id => $jumlah) {
            $nama_customer = $request->input('ID') . '_' . $request->input('namacustomer');
            $qr_code_value = isset($qr_code[$id]) ? $qr_code[$id] : null;
            $stok_gudang = isset($stok_gudang_id[$id]) ? $stok_gudang_id[$id] : null;
            $StokGudangModel = StokGudangModel::find($stok_gudang);
            

            $exists = BarangKeluarModel::where('id', $id)
                ->where('qr_code', $qr_code_value)
                ->where('pop', Auth::user()->pop) // Memeriksa pop juga
                ->exists();

            if ($exists) {
                // Jika kombinasi ID dan QR Code sudah ada, tampilkan error
                return redirect()->back()->with('error', 'Barang sudah tercatat sebagai barang yang telah dikeluarkan.');
            }


            // Simpan data ke database untuk setiap barang
            BarangKeluarModel::create([
                'stok_gudang_id' => $stok_gudang,
                'jumlah' => $jumlah,  // Jumlah dari input
                'lokasi' => $request->input('lokasi'),
                'nama_customer' => $nama_customer,
                'output_by' => $output_by,
                'keterangan' => $request->input('keterangan'),
                'pop' => Auth::user()->pop,
                'qr_code' => $qr_code_value,  // Gunakan qr_code yang sesuai
            ]);

            // Hapus order berdasarkan qr_code
            if ($qr_code_value) {
                Order::where('qr_code', $qr_code_value)->delete();
            }

            if ($StokGudangModel->satuan == 'pack' || $StokGudangModel->satuan == 'roll') {
                $StokGudangModel->hasil = $StokGudangModel->hasil - $jumlah;
                $roll = $StokGudangModel->hasil / $StokGudangModel->rasio;
                $nilaiGenap = ceil($roll);
                $StokGudangModel->jumlah = $nilaiGenap;
                $StokGudangModel->detail_jumlah = $StokGudangModel->hasil % $StokGudangModel->rasio;
                $StokGudangModel->save();


                $rekap = RekapModel::where('stok_gudang_id', $stok_gudang)->first();
                if ($rekap) {
                    $rekap->out += $jumlah;
                    $rekap->save();
                }
            } else {
                $StokGudangModel->jumlah -= $jumlah;
                $StokGudangModel->save();

                $rekap = RekapModel::where('stok_gudang_id', $stok_gudang)->first();
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
            ->where('pop', Auth::user()->pop);

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
    public function destroy($id)
    {
        BarangKeluarModel::where('id', $id)->delete();
        return redirect()->route('tabel_barang_keluar')->with(['success_hapus' => 'Data Berhasil Dihapus!']);
    }
}
