<!-- nota-pembelian.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Pembelian - {{ $notaNumber }}</title>
    <style>
        @page {
            size: 21.5cm 11cm;
            /* Ukuran kertas */
            margin: 0.5cm;
            /* Mengurangi margin agar lebih muat */
        }

        body {
            font-family: Arial, sans-serif;
            line-height: 1.2;
            font-size: 9pt;
            /* Ukuran font dikurangi */
            margin: 0;
            padding: 0;
        }

        .logo-text {
            text-align: center;
            margin: 5px 0;
        }

        .logo-text img {
            width: 100px;
            /* Perkecil ukuran logo */
        }

        .header {
            text-align: center;
            margin-bottom: 5px;
        }

        .header h1 {
            font-size: 10pt;
            font-weight: bold;
            margin: 3px 0;
        }

        .address {
            text-align: center;
            font-size: 8pt;
            line-height: 1.1;
            margin-bottom: 10px;
        }

        .info-container {
            margin: 5px 0;
            width: 100%;
            font-size: 9pt;
        }

        .info-left {
            float: left;
        }

        .info-right {
            float: right;
            text-align: right;
        }

        .clear {
            clear: both;
        }

        .title {
            text-align: center;
            font-weight: bold;
            font-size: 10pt;
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9pt;
        }

        table th,
        table td {
            border: 1px solid black;
            padding: 4px;
            /* Kurangi padding agar tabel tidak terlalu besar */
            text-align: center;
        }

        .total-row {
            margin-top: 5px;
            font-size: 9pt;
        }

        .total-label {
            float: left;
            font-weight: bold;
        }

        .total-amount {
            float: right;
        }

        .signature-section {
            margin-top: 20px;
            width: 100%;
            font-size: 9pt;
        }

        .signature-left {
            float: left;
            width: 45%;
            text-align: center;
        }

        .signature-right {
            float: right;
            width: 45%;
            text-align: center;
        }

        .signature-space {
            margin-top: 20px;
        }

        .total-row-header th:first-child {
            text-align: left;
            border-right: none;
        }

        .total-row-header th:nth-child(2),
        .total-row-header th:nth-child(3) {
            border-left: none;
        }
    </style>


</head>

<body>
    <div class="logo-text">
        <img src="data:image/png;base64,{{ $logoImage }}" alt="logoapp" style="width: 110px;">
    </div>

    <div class="header">
        <h1>LUMINTU ENERGI PERSADA, CV</h1>
    </div>

    <div class="address">
        Pergudangan Minyak Babe Ds. Wonoayu RT.02 RW.01 (Barat KUD)<br>
        Kec. Wonoayu Kab. Sidoarjo Jawa Timur<br>
        Telp. 0813-3093-6218 (Babe Suwarno), Email: lumintu.babe@gmail.com
    </div>

    <div class="info-container">
        <div class="info-left">
            Nota No: {{ $notaNumber }}
        </div>
        <div class="info-right">
            Tgl: {{ $tanggal }}<br>
            Kepada: {{ $pembelian->nama_supplier }}
        </div>
        <div class="clear"></div>
    </div>

    <div class="title">PEMBELIAN BARANG</div>

    <table>
        <thead>
            <tr>
                <th width="20%">Banyaknya</th>
                <th width="35%">Nama Barang</th>
                <th width="20%">Harga</th>
                <th width="25%">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $pembelian->jumlah }} Kg</td>
                <td>{{ $pembelian->nama_produk }}</td>
                <td>Rp {{ number_format($pembelian->harga_beli, 2, ',', '.') }}</td>
                <td>Rp {{ number_format($pembelian->total, 2, ',', '.') }}</td>
            </tr>
        </tbody>
        <thead>
            <tr class="total-row-header">
                <th colspan="2">TOTAL</th>
                <th></th>
                <th>Rp {{ number_format($pembelian->total, 2, ',', '.') }}</th>
            </tr>
        </thead>
    </table>
    <div class="signature-section">
        <div class="signature-left">
            <p>Dibuat oleh,</p>
            <div class="signature-space mt-5"></div>

            <p>(CV LUMINTU ENERGI PERSADA)</p>
        </div>
        <div class="signature-right">
            <p>Tanda terima,</p>
            <div class="signature-space mt-5"></div>

            <p>({{ $pembelian->nama_supplier }})</p>
        </div>
        <div class="clear"></div>
    </div>
</body>

</html>