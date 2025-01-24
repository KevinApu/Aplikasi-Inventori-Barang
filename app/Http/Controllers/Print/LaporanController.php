<?php

namespace App\Http\Controllers\Print;

use App\Http\Controllers\Controller;
use App\Models\BarangMasukModel;
use App\Models\KLModel;
use App\Models\PengirimanModel;
use App\Models\RekapModel;
use App\Models\RequestBarangModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function viewlaporan(Request $request)
    {
        $barangmasuk = session('barangMasukData');
        if (!$barangmasuk) {
            return redirect()->route('tabel_barang_masuk');
        }
        $kepalaKantor = DB::table('kantor_layanan')->where('pop', Auth::user()->pop)->value('kepalakantor');

        $firstDate = Carbon::parse($barangmasuk->min('created_at'))->format('d F Y');
        $lastDate = Carbon::parse($barangmasuk->max('created_at'))->format('d F Y');

        // Mengirimkan data ke view
        return view('laporan', compact('barangmasuk', 'firstDate', 'lastDate', 'kepalaKantor'));
    }

    public function printlaporan()
    {
        $barangmasuk = session('barangMasukData');
        if (!$barangmasuk) {
            return redirect()->route('tabel_barang_masuk')->with('error', 'Data barang masuk tidak ditemukan!');
        }

        $firstDate = Carbon::parse($barangmasuk->min('created_at'))->format('d F Y');
        $lastDate = Carbon::parse($barangmasuk->max('created_at'))->format('d F Y');
        $kepalaKantor = DB::table('kantor_layanan')->where('pop', Auth::user()->pop)->value('kepalakantor');

        $pdf = new \Mpdf\Mpdf([
            'format' => [210, 330], // F4
            'margin_top' => 15,
            'margin_bottom' => 15,
            'margin_left' => 15,
            'margin_right' => 15,
        ]);

        $headerHTML = '
    <div style="text-align: center;">
        <h1>LAPORAN BARANG MASUK</h1>
        <p>Periode: ' . ($firstDate === $lastDate ? $firstDate : "$firstDate - $lastDate") . '</p>
    </div>';
        $pdf->SetHTMLHeader($headerHTML);
        $pdf->SetHTMLFooter('<div style="text-align: center;">{PAGENO}</div>');

        $htmlContent = view('laporan', compact('barangmasuk', 'firstDate', 'lastDate', 'kepalaKantor'))->render();
        $pdf->WriteHTML($htmlContent);

        $availableHeight = $pdf->y; // Posisi Y terakhir yang digunakan untuk konten
        $pageHeight = 330 - 15 - 15; // Tinggi halaman dikurangi margin atas dan bawah
        $requiredHeight = 50; // Tinggi yang dibutuhkan untuk footer dan tanda tangan

        $footerHTML = '
        <div style="text-align: center; margin-top: 50px;">
            <table style="width: 100%; text-align: center;">
                <tr>
                    <td style="width: 50%; text-align: center;">
                        <p class="signature-header">Dibuat oleh</p>
                        <br><br><br><br>
                        <p class="signature-name" style="font-weight: bold;">' . Auth::user()->username . '</p>
                        <hr style="width: 70%;">
                    </td>
                    <td style="width: 50%; text-align: center;">
                        <p class="signature-header">Pacitan, ' . Carbon::now()->format('d F Y') . '</p>
                        <p class="signature-header">Diketahui oleh</p>
                        <br><br><br><br>
                        <p class="signature-name" style="font-weight: bold;">' . $kepalaKantor . '</p>
                        <hr style="width: 70%;">
                        <p>Kepala Kantor</p>
                    </td>
                </tr>
            </table>
        </div>';
        

        if ($availableHeight + $requiredHeight <= $pageHeight) {
            // Jika ruang cukup, tambahkan footer pada halaman terakhir
            $pdf->WriteHTML($footerHTML);
        } else {
            // Jika ruang tidak cukup, tambahkan halaman baru dan kemudian footer
            $pdf->AddPage();
            $pdf->SetY($pageHeight - $requiredHeight);  // Set posisi Y footer pada halaman baru
            $pdf->WriteHTML($footerHTML);
        }

        $fileName = Auth::user()->username . now()->format('d-m-Y') . '_laporanbarangmasuk.pdf';
        return $pdf->Output($fileName, 'I');
    }



    public function viewlaporanrekap()
    {
        $rekapData = RekapModel::where('pop', Auth::user()->pop)->get();

        $startOfMonth = Carbon::now()->startOfMonth()->format('Y-m-d'); // Awal bulan
        $endOfMonth = Carbon::now()->endOfMonth()->format('Y-m-d'); // Akhir bulan
        $kepalakantor = KLModel::where('pop', Auth::user()->pop)->value('kepalakantor');

        $periode = "$startOfMonth s/d $endOfMonth";

        return view('laporanrekap', compact('rekapData', 'periode', 'kepalakantor'));
    }

    public function printlaporanrekap()
    {
        $rekapData = RekapModel::where('pop', Auth::user()->pop)->get();

        $startOfMonth = Carbon::now()->startOfMonth()->format('Y-m-d'); // Awal bulan
        $endOfMonth = Carbon::now()->endOfMonth()->format('Y-m-d'); // Akhir bulan
        $kepalakantor = KLModel::where('pop', Auth::user()->pop)->value('kepalakantor');

        $isPrinting = request()->has('is_printing') ? true : false;

        $periode = "$startOfMonth s/d $endOfMonth";

        $pdf = new \Mpdf\Mpdf([
            'format' => [210, 330],
        ]);

        $headerHTML = '
        <div class="header" style="text-align: center;">
            <h1>LAPORAN REKAP BARANG</h1>
            </div>
            <p class="periode">Periode: ' .
            ("$periode") .
            '</p>';

        // Atur header dan footer awal
        $pdf->SetHTMLHeader($headerHTML);
        $pdf->SetHTMLFooter('<div style="text-align: center;">{PAGENO}</div>');

        // Render konten utama ke PDF
        $htmlContent = view('laporanrekap', compact('rekapData', 'periode', 'kepalakantor'))->render();
        $pdf->WriteHTML($htmlContent);

        $lokasi = KLModel::where('pop', Auth::user()->pop)->value('lokasi');
        return $pdf->Output(Auth::user()->username . '_' . $lokasi . '_laporanrekap.pdf', 'D'); // 'I' untuk stream PDF ke browser
    }

    public function viewsuratjalan()
    {
        $lokasi = KLModel::where('pop', Auth::user()->pop)->value('lokasi');

        $result = PengirimanModel::where('tujuan', $lokasi)->get();

        $alamat = KLModel::where('pop', Auth::user()->pop)->value('alamat');
        $kepalakantor = KLModel::where('pop', Auth::user()->pop)->value('kepalakantor');

        $tanggal = now(); // Ambil tanggal dan waktu saat ini
        $month = $tanggal->format('m'); // Bulan (01-12)
        $year = $tanggal->format('Y');

        $nomorUrutFormatted = $this->getNomorUrut($lokasi, $month, $year);
        $tanggal = now(); // Ambil tanggal dan waktu saat ini

        return view('suratjalan', [
            'result' => $result,
            'kodePop' => $lokasi,
            'nomorUrut' => $nomorUrutFormatted,
            'tanggal' => $tanggal,
            'alamat' => $alamat,
            'kepalakantor' => $kepalakantor,
        ]);
    }

    private function getNomorUrut($lokasi, $month, $year)
    {
        $nomorUrut = RequestBarangModel::where('pop', $lokasi)
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->distinct('created_at')
            ->count();
        $nomorUrutFormatted = str_pad($nomorUrut, 3, '0', STR_PAD_LEFT);
        return $nomorUrutFormatted;
    }



    public function printsuratjalan()
    {
        $lokasi = KLModel::where('pop', Auth::user()->pop)->value('lokasi');
        $result = PengirimanModel::where('tujuan', $lokasi)->get();
        $alamat = KLModel::where('pop', Auth::user()->pop)->value('alamat');
        $kepalakantor = KLModel::where('pop', Auth::user()->pop)->value('kepalakantor');

        $tanggal = now(); // Ambil tanggal dan waktu saat ini
        $month = $tanggal->format('m'); // Bulan (01-12)
        $year = $tanggal->format('Y');

        $nomorUrutFormatted = $this->getNomorUrut($lokasi, $month, $year);
        $tanggal = now();
        // Ambil tanggal dan waktu saat ini
        $isPrinting = request()->has('is_printing') ? true : false;


        $pdf = Pdf::loadView(   
            'suratjalan',
            [
                'result' => $result,
                'kodePop' => $lokasi,
                'nomorUrut' => $nomorUrutFormatted,
                'alamat' => $alamat,
                'kepalakantor' => $kepalakantor,
            ]
        );

        $pdf->set_option('defaultPaperSize', 'F4');
        $lokasi = KLModel::where('pop', Auth::user()->pop)->value('lokasi');
        return $pdf->download(Auth::user()->username . '_' . $lokasi . '_suratjalan.pdf');
    }
}
