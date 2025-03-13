<?php

namespace App\Http\Controllers\Print;

use App\Http\Controllers\Controller;
use App\Models\BarangMasukModel;
use App\Models\StokGudangModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Milon\Barcode\DNS1D;
use Milon\Barcode\DNS2D;
use Illuminate\Support\Str;

class PrintControlller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = session('temp_items', []);
        return view('barcode', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // Ambil itemIds dari request
        $itemIds = $request->input('itemIds');

        // Pastikan itemIds selalu menjadi array
        if (is_string($itemIds)) {
            // Jika itemIds adalah string, ubah menjadi array
            $itemIds = explode(',', $itemIds); // Misalnya, "1,2,3" menjadi [1, 2, 3]
        } elseif (!is_array($itemIds)) {
            // Jika bukan string atau array, kembalikan error
            return response()->json(['message' => 'Data item tidak valid!'], 400);
        }

        // Buat instance dari DNS2D untuk menghasilkan barcode
        $dns2d = new DNS2D();

        // Ambil atau inisialisasi session temp_items
        $tempItems = session('temp_items', []);

        // Proses setiap item ID yang ada di dalam array itemIds
        foreach ($itemIds as $id) {
            $item = StokGudangModel::find($id);

            if ($item) {
                $jumlahBarang = max(1, intval($item->jumlah));
                for ($i = 1; $i <= $jumlahBarang; $i++) {
                    $uniqueIdentifier = "{$item->id}-" . Str::random(14) . time();
                    $barcodeHtml = $dns2d->getBarcodeHTML($uniqueIdentifier, 'QRCODE', 4, 4);

                    session()->push('temp_items', [
                        'id' => $item->id,
                        'nama_barang' => $item->nama_barang,
                        'seri' => $item->seri,
                        'lokasi' => $item->lokasi,
                        'foto' => $item->foto,
                        'barcodeHtml' => $barcodeHtml,
                        'barcode_no' => $i,
                    ]);
                }
            }
        }

        $items = session('temp_items', []);
        return view('barcode', compact('items'));
    }





    public function printbarcode()
    {
        ini_set('memory_limit', '2G');
        ini_set('max_execution_time', 300);

        $isPrinting = request()->has('is_printing') ? true : false;

        $items = session('temp_items', []);
        $pdf = Pdf::loadView('barcode', compact('items'))
            ->set_option('defaultPaperSize', 'F4')
            ->set_option('dpi', 150)  // Mengatur dpi gambar untuk mengurangi ukuran file
            ->set_option('isHtml5ParserEnabled', true) // Menggunakan parser HTML5
            ->set_option('isPhpEnabled', false); // Menonaktifkan PHP di dalam dompdf (jika tidak diperlukan)


        $pdf->set_option('defaultPaperSize', 'F4');

        return $pdf->download('Print_Barcode ' . now()->format('d-m-Y') . '.pdf');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
