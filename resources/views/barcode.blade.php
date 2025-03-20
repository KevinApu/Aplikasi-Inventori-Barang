<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
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

        .warning-box {
            border: 2px solid #ff5c5c;
            border-radius: 8px;
            padding: 20px;
            background-color: #fff3f3;
            color: #333;
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 20px auto;
        }

        .warning-title {
            color: #d10000;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 15px;
            text-align: center;
            text-transform: uppercase;
        }

        .warning-list {
            list-style-type: disc;
            padding-left: 20px;
            line-height: 1.6;
        }

        .warning-list li {
            margin-bottom: 10px;
            font-size: 16px;
            color: #555;
        }

        .warning-list li::marker {
            color: #d10000;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div style="width: 100%; max-width: 1200px; margin: 0 auto; margin-top: 1rem; background-color: #faf8fc; display: flex; justify-content: center; align-items: center; flex-direction: column; text-align: center;">
        <h1 style="font-size: 24px; font-weight: bold; text-align: center; margin-bottom: 1rem;">Daftar Barang Masuk</h1>

        @if(!request()->has('is_printing'))
        <div class="warning-box">
            <h2 class="warning-title">Peringatan</h2>
            <ul class="warning-list">
                <li>Segera cetak dan tempel barcode pada barang setelah generate barcode selesai.</li>
                <li>Hindari menunda proses penempelan barcode, karena generate ulang barcode dapat menghasilkan kode yang berbeda, sehingga data barang menjadi tidak sesuai.</li>
                <li>Penempelan barcode tepat waktu memastikan akurasi data dan kemudahan pelacakan barang di sistem.</li>
                <li>Proses generate PDF dapat membutuhkan waktu lebih lama jika jumlah barang yang dicetak banyak. Harap bersabar sampai proses selesai.</li>
            </ul>
        </div>
        @endif

        @if(isset($items) && count($items) > 0)
        <div style="display: flex; justify-content: center; align-items: center; width: 100%;">
            <table style="border-collapse: collapse; margin: auto;">
                @foreach(array_chunk($items, 5) as $itemChunk)
                <tr>
                    @foreach($itemChunk as $item)
                    <td style="border: 2px dashed #a8a7a9; padding: 0.5rem; text-align: center;">
                        <h2 style="font-weight: 600; font-size: 12px;">{{ $item['nama_barang'] }}</h2>

                        <div style="display: flex; justify-content: center; align-items: center; width: 100%; text-align: center;">
                            <div style="display: flex; justify-content: center; align-items: center;">
                                {!! $item['barcodeHtml'] !!}
                            </div>
                        </div>

                        <p style="font-size: 10px; text-align: center;">{{ $item['kode_barcode'] }}</p>
                    </td>
                    @endforeach
                </tr>
                @endforeach
            </table>
        </div>
        @else
        <p style="color: #9ca3af; text-align: center;">Belum ada barang yang ditambahkan.</p>
        @endif




        @if(!request()->has('is_printing'))
        <a class="print-button" href="{{ route('print.barcode') }}?is_printing=true">🖨️ Print Barcode</a>
        @endif
    </div>
</body>

</html>