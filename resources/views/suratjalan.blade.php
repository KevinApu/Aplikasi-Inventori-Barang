<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Stok Barang</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
        }

        .kertas {
            height: 855px;
            position: relative;
            width: 100%;
            max-width: 640px;
            margin: 0 auto;
            padding: 10px;
            margin-top: 0.5rem;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        header {
            text-align: center;
            border-bottom: 1px solid #000;
            padding-bottom: 10px;
        }

        header h1 {
            margin: 0;
            font-size: 20px;
        }

        header p {
            margin: 5px 0;
            font-size: 14px;
        }

        .info {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }

        .info p {
            margin: 5px 0;
            font-size: 14px;
        }

        h2 {
            text-align: center;
            margin-top: 20px;
            text-decoration: underline;
        }

        table {
            width: 100%;
            page-break-inside: avoid;
            border-collapse: collapse;
            margin-top: 10px;
            margin-bottom: 20px;
        }

        table th,
        table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        table th {
            background-color: #2c3e50;
            color: #fff;
            text-align: center;
        }

        .signature-section {
            display: flex;
            justify-content: space-between;
            position: absolute;
            /* Menyelaraskan signature di tengah */
            width: 100%;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            page-break-inside: avoid;
        }

        .signature {
            display: inline-block;
            width: 30%;
            vertical-align: top;
            margin-top: 50px;
        }

        .signature p {
            margin: 0;
            font-size: 12px;
        }

        /* Tanggal Styling */
        .signature p.tanggal {
            font-size: 12px;
            text-align: center;
            margin-bottom: -13px;
            /* Jarak bawah */
        }

        /* Diketahui Oleh Styling */
        .signature p:nth-child(1) {
            font-size: 12px;
            text-align: center;
            margin-top: -1px;
            /* Jarak atas yang lebih besar */
        }

        .signature p:nth-child(2) {
            margin-top: 90px;
            font-size: 11px;
            text-align: center;
            font-weight: bold;
        }

        /* Garis Styling */
        .signature hr {
            border: 0.5px solid #000;
            width: 90%;
            margin-top: 1px;
        }

        .print-button {
            position: fixed;
            bottom: 16px;
            right: 16px;
            background: linear-gradient(90deg, #3b82f6, #1d4ed8);
            /* Gradient biru */
            color: white;
            font-weight: bold;
            padding: 12px 24px;
            border-radius: 50px;
            /* Membuat tombol menjadi oval */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            /* Bayangan ringan */
            text-decoration: none;
            font-size: 16px;
            transition: transform 0.3s ease, box-shadow 0.3s ease, background 0.3s ease;
        }

        .print-button:hover {
            background: linear-gradient(90deg, #2563eb, #1e40af);
            /* Gradient lebih gelap */
            transform: translateY(-4px);
            /* Mengangkat tombol saat di-hover */
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
            /* Bayangan lebih tegas */
        }

        .print-button:active {
            transform: translateY(2px);
            /* Efek klik */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            /* Bayangan lebih kecil */
        }

        .print-button:focus {
            outline: none;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.5);
            /* Fokus dengan warna biru */
        }
    </style>
</head>

<body>
    <div class="kertas">
        <header>
            <h1>SURAT JALAN</h1>
        </header>
        <section class="info">
            <div class="left">
                <p><strong>Kepada: </strong>{{ $result->first()->nama_pengaju }}</p>
                <p><strong>Alamat: </strong>{{$alamat}}</p>
            </div>
            <div class="right">
                <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::now()->format('d F Y') }}</span></p>
                <p><strong>No. Surat: </strong>{{ $nomorUrut }}.015/SSI-{{ $kodePop }}/11/2024</p>
            </div>
        </section>
        <h2>SURAT JALAN</h2>
        <table class="simple-table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Barang</th>
                    <th>Seri</th>
                    <th>Jumlah</th>
                    @if($result->where('rasio', '!=', null)->isNotEmpty())
                    <th>Satuan</th>
                    @endif
                    <th>Catatan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($result as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->nama_barang }}</td>
                    <td>{{ $item->seri }}</td>
                    <td>{{ $item->jumlah }} {{ $item->satuan }}</td>
                    @if($result->where('rasio', '!=', null)->isNotEmpty())
                    <td>{{ $item->rasio ?? '-' }}</td>
                    @endif
                    <td>{{ $item->catatan ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>

        </table>
        <div class="signature-section">
            <div class="signature">
                <p>Penerima</p>
                <p>{{ $kepalakantor }}</p>
                <hr>
                <p>Kepala Kantor</p>
            </div>

            <!-- Signature 2 -->
            <div class="signature">
                <p>Bagian Pengiriman</p>
                <p>{{ $result->first()->namakurir }}</p>
                <hr>
            </div>

            <!-- Signature 3 -->
            <div class="signature">
                <p>Pengirim</p>
                <p>{{ $result->first()->pengirim }}</p>
                <hr>
            </div>
        </div>
    </div>
    @if(!request()->has('is_printing'))
    <a class="print-button" href="{{ route('print.suratjalan') }}?is_printing=true">🖨️ Print Barcode</a>
    @endif
</body>
<script>
    // Fungsi untuk format tanggal
    function getFormattedDate() {
        const date = new Date();
        const day = String(date.getDate()).padStart(2, '0');
        const monthNames = [
            "Januari", "Februari", "Maret", "April", "Mei", "Juni",
            "Juli", "Agustus", "September", "Oktober", "November", "Desember"
        ];
        const month = monthNames[date.getMonth()];
        const year = date.getFullYear();
        return `${day} ${month} ${year}`;
    }

    // Fungsi untuk nomor surat otomatis
    function getFormattedNoSurat() {
        const date = new Date();
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0'); // Bulan dalam format angka
        let nomorUrut = 1; // Contoh: Dimulai dari 1. (Anda bisa gunakan localStorage untuk menyimpan counter)

        // Format menjadi tiga digit (001, 002, dll.)
        const nomorUrutFormatted = String(nomorUrut).padStart(3, '0');
        const angkaTetap = "015"; // Angka tetap setelah titik
        return `${nomorUrutFormatted}.${angkaTetap}/SSI-PCT/${month}/${year}`;
    }

    // Menampilkan tanggal dan nomor surat
    document.getElementById('tanggal').textContent = getFormattedDate();
    document.getElementById('noSurat').textContent = getFormattedNoSurat();
</script>

</html>