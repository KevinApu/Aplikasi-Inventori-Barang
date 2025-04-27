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
        $part1 = $barcodePart[0];

        $barangMasuk = StokGudangModel::where('pop', Auth::user()->KLModel->pop)->where('id', $part1)->first();

        if (!$barangMasuk) {
            return response()->json([
                'message' => 'Barang tidak ditemukan.',
                'alert_type' => 'error'
            ], 400);
        }

        if (BarangKeluarModel::where('stok_gudang_id', $barangMasuk->id)
            ->where('output_by', Auth::user()->username)
            ->where('status_order', 0)
            ->exists()
        ) {
            return response()->json([
                'message' => 'Barang sudah ditambahkan.',
                'alert_type' => 'error'
            ], 400);
        }

        BarangKeluarModel::create([
            'stok_gudang_id' => $barangMasuk->id,
            'output_by' => Auth::user()->username,
            'pop' => Auth::user()->KLModel->pop,
        ]);

        return response()->json([
            'message' => 'Barang berhasil ditambahkan.',
            'alert_type' => 'success'
        ], 200); // atau bisa dihilangkan karena 200 adalah default
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BarangKeluarRequest $request)
    {
        // dd($request->jumlah);
        foreach ($request->jumlah as $id => $jumlah) {
            $nama_customer = $request->input('ID') . '_' . $request->input('namacustomer');

            $barangKeluar = BarangKeluarModel::find($id);
            if (!$barangKeluar) continue;

            $stokGudang = StokGudangModel::find($barangKeluar->stok_gudang_id);
            if (!$stokGudang) continue;

            $existingData = BarangKeluarModel::where('nama_customer', $nama_customer)
                ->where('lokasi', $request->lokasi)
                ->where('pop', Auth::user()->KLModel->pop)
                ->get();

            $isUpdated = false;

            if ($existingData->isNotEmpty()) {
                foreach ($existingData as $data) {
                    if ($data->stok_gudang_id == $barangKeluar->stok_gudang_id) {
                        $data->update([
                            'jumlah' => $jumlah,
                        ]);
                        $isUpdated = true;
                        break;
                    }
                }
            }

            if ($isUpdated) {
                $barangKeluar->delete(); // hapus setelah update selesai
            } else {
                $barangKeluar->update([
                    'jumlah'        => $jumlah,
                    'lokasi'        => $request->lokasi,
                    'nama_customer' => $nama_customer,
                    'keterangan'    => $request->keterangan,
                    'status_order'  => 1,
                ]);
            }

            // Update stok gudang
            if (in_array($stokGudang->satuan, ['pack', 'roll'])) {
                $stokGudang->hasil -= $jumlah;
                $roll = $stokGudang->hasil / $stokGudang->rasio;
                $stokGudang->jumlah = ceil($roll);
                $stokGudang->detail_jumlah = $stokGudang->hasil % $stokGudang->rasio;
            } else {
                $stokGudang->jumlah -= $jumlah;
            }
            $stokGudang->save();

            // Update rekap
            $rekap = RekapModel::where('stok_gudang_id', $barangKeluar->stok_gudang_id)->first();
            if ($rekap) {
                $rekap->out += $jumlah;
                $rekap->save();
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

        if ($request->lokasi) {
            $query->where('lokasi', 'like', '%' . $request->lokasi . '%');
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
