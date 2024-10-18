<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nota Kecil</title>

    <?php
    $style = '
    <style>
        * {
            font-family: "consolas", sans-serif;
        }
        p {
            display: block;
            margin: 3px;
            font-size: 10pt;
        }
        table td {
            font-size: 9pt;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }

        @media print {
            @page {
                margin: 0;
                size: 75mm;
            }
            html, body {
                width: 70mm;
            }
            .btn-print {
                display: none;
            }
        }
    </style>
    ';
    ?>

    {!! $style !!}
</head>
<body onload="window.print()">
    <button class="btn-print" style="position: absolute; right: 1rem; top: 1rem;" onclick="window.print()">Print</button>
    <div class="text-center">
        <h3 style="margin-bottom: 5px;">{{ strtoupper($setting->nama_perusahaan) }}</h3>
        <p>{{ strtoupper($setting->alamat) }}</p>
    </div>
    <br>
    <div>
        <p style="float: left;">{{ date('d-m-Y') }}</p>
        <p style="float: right">{{ strtoupper(auth()->user()->name) }}</p>
    </div>
    <div class="clear-both" style="clear: both;"></div>
    <p>No: {{ tambah_nol_didepan($penjualan->id_penjualan, 10) }}</p>
    <p class="text-center">===================================</p>
    
    <br>
    <table width="100%" style="border: 0;">
        @foreach ($detail as $item)
            <tr>
                <td colspan="3">{{ $item->produk->nama_produk }}</td>
                <td>{{ $item->jumlah }} x {{ format_uang($item->harga_jual) }}</td>
                <td></td>
                <td class="text-right">{{ format_uang($item->subtotal) }}</td>
                <!-- kondisi untuk menampilkan harga produk yang telah didiskonkan (apabila produk yang dipilih memiliki diskon) -->
                <!-- @if ($item->produk->diskon)
                    <td class="text-right">{{ format_uang($item->jumlah * $item->harga_jual - ($item->produk->diskon / 100) * $item->jumlah * $item->harga_jual) }}</td>
                @else
                    <td class="text-right">{{ format_uang($item->jumlah * $item->harga_jual) }}</td>
                @endif  -->
            </tr>
            @if ($item->produk->diskon > 0)
            <tr>
                <td>Disc. {{ format_uang($item->produk->diskon) }}%</td>
            </tr>
            @endif
        @endforeach
    </table>
    <p class="text-center">-----------------------------------</p>

    <table width="100%" style="border: 0;">

        <!-- dikarenakan dihalaman ini tidak menggunakan php,maka minta laravel untuk memanggil php,untuk pendeklarasian variabel untuk menimpan nilai total harga (hanya untuk di tampilan nota,tdak dimasukan ke database) -->
        @php
            $total = 0;
        @endphp
        
        <!-- perulangan untuk mengambil item dari produk,untuk pengakumulasian total harga  -->
        @foreach ($detail as $item)
            @php
                $total += $item->jumlah * $item->harga_jual
            @endphp
            <!-- panggil variabel yang sudah dideklarasikan,untuk nantinya disimpan sebagai total harga -->
        @endforeach

        <tr>
            <td>Total Harga:</td>
            <td class="text-right">{{ format_uang($total) }}</td>
        </tr>
        <tr>
            <td>Total Item:</td>
            <td class="text-right">{{ format_uang($penjualan->total_item) }}</td>
        </tr>
        <tr>
            <td>Diskon Member:</td>
            <td class="text-right">{{ format_uang($penjualan->diskon) }}%</td> <!-- Tampilkan 2 desimal -->
        </tr>
        <tr>
            <td>Total Diskon:</td>
            <td class="text-right">{{ format_uang($penjualan->total_diskon) }}</td>
        </tr>
        <tr>
            <td>Total Bayar :</td>
            <td class="text-right">{{ format_uang($penjualan->bayar) }}</td>
        </tr>
        <tr>
            <td>Diterima:</td>
            <td class="text-right">{{ format_uang($penjualan->diterima) }}</td>
        </tr>
        <tr>
            <td>Kembali:</td>
            <td class="text-right">{{ format_uang($penjualan->diterima - $penjualan->bayar) }}</td>
        </tr>
    </table>
    
    
    

    <p class="text-center">===================================</p>
    <p class="text-center">-- TERIMA KASIH --</p>

    <script>
        let body = document.body;
        let html = document.documentElement;
        let height = Math.max(
                body.scrollHeight, body.offsetHeight,
                html.clientHeight, html.scrollHeight, html.offsetHeight
            );

        document.cookie = "innerHeight=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
        document.cookie = "innerHeight="+ ((height + 50) * 0.264583);
    </script>
</body>
</html>
