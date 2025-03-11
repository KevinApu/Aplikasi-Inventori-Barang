<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Rekap Barang</title>
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
            padding-bottom: 100px;
            page-break-inside: avoid;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 20px;
            margin: 0;
            background-color: #fff;
            padding-bottom: 2px;
            font-weight: bold;
        }

        .periode {
            font-size: 14px;
            text-align: center;
            margin-top: 20px;
            /* Sesuaikan margin-top agar tidak tumpang tindih dengan elemen lainnya */
            margin-bottom: 60px;
            position: relative;
            z-index: 1;
            /* Pastikan periode di bawah signature-table */
        }

        .simple-table {
            width: 100%;
            page-break-inside: avoid;
            font-size: 12px;
            border-collapse: collapse;
            margin-top: 8rem;
            margin-bottom: 0;
            page-break-inside: avoid;
        }

        .simple-table th,
        .simple-table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #333;
        }

        .simple-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .simple-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .signature-table {
            width: 100%;
            position: fixed;
            bottom: 10px;
            margin-top: 2rem;   
            /* Posisi footer dari bawah halaman */
            z-index: 10;
            page-break-before: always;
            /* Pastikan signature-table di atas elemen lain */
        }

        .signature-table td {
            width: 50%;
            text-align: center;
        }

        .signature-header {
            font-weight: bold;
        }

        .signature-name {
            margin-top: 100px;
            /* Jarak untuk tanda tangan */
        }

        .signature-date {
            margin-top: 80px;
            /* Jarak untuk tanggal dan tanda tangan kepala kantor */
        }

        .signature-hr {
            width: 70%;
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
        <div class="container">
            <table class="simple-table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Barang</th>
                        <th>Stok Awal</th>
                        <th>In</th>
                        <th>Out</th>
                        <th>Sisa</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rekapData as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->stokGudang->nama_barang}}</td>
                        <td>{{ $item->stok_awal}}</td>
                        <td>{{ $item->in ?? '0'}}</td>
                        <td>{{ $item->out ?? '0'}}</td>
                        @if ($item->stokGudang->satuan === 'roll' || $item->stokGudang->satuan === 'pack')
                        <td>{{ $item->stokGudang->hasil}}</td>
                        @else
                        <td>{{ $item->stokGudang->jumlah}}</td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @if(!request()->has('is_printing'))
    <a class="print-button" href="{{ route('print.laporan.rekap') }}?is_printing=true">Print</a>
    @endif
</body>

</html>