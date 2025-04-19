<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Jalan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 9px;
            line-height: 1.2;
            margin: 0;
            padding: 10px;
            max-width: 100%;
        }
        .logo {
            max-height: 40px;
            display: block;
            margin-bottom: 2px;
        }
        .company-name {
            font-size: 11px;
            font-weight: bold;
            margin-bottom: 2px;
            color: #3c6e47;
        }
        .company-address {
            font-size: 8px;
            margin-bottom: 1px;
        }
        .document-title {
            font-size: 12px;
            font-weight: bold;
            text-align: center;
            margin: 8px 0;
            text-decoration: underline;
        }
        .detail-table {
            width: 100%;
            margin: 2px 0;
        }
        .detail-table td {
            padding: 2px 0;
            font-size: 8px;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .items-table th, .items-table td {
            border: 1px solid #ddd;
            padding: 4px;
            text-align: left;
            font-size: 8px;
        }
        .items-table th {
            background-color: #f2f2f2;
        }
        .signature-area {
            margin-top: 20px;
        }
        .signature-line {
            width: 80px;
            border-top: 1px solid #000;
            margin-top: 20px;
            display: inline-block;
        }
        .container {
            width: 100%;
        }
        .text-center {
            text-align: center;
        }
        .float-left {
            float: left;
        }
        .float-right {
            float: right;
            text-align: right;
        }
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
        .mb-20 {
            margin-bottom: 10px;
        }
        .header-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }
        .company-info {
            width: 100%;
        }
        .shipping-info {
            width: 100%;
        }
        .logo-container {
            display: flex;
            align-items: center;
            margin-bottom: 5px;
        }
        .logo-text {
            font-size: 16px;
            font-weight: bold;
        }
        .logo-text span:first-child {
            color: #3c6e47;
        }
        .logo-text span:nth-child(2) {
            color: #f39c12;
        }
        .logo-text span:last-child {
            color: #3c6e47;
        }
        .no-surat {
            font-size: 8px;
            margin-bottom: 2px;
        }
        .tanggal {
            font-size: 8px;
            margin-bottom: 2px;
        }
        .header-box {
            border: 0.5px solid #383737;
            padding: 3px; /* Slightly larger padding */
            width: 100px;
            font-size: 8px; /* Specific size for header boxes */
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header with company and shipping info in one row -->
        <div class="header-container">
        <div class="logo-container">
            <img src="data:image/png;base64,{{ $logoImage }}" alt="Logo" class="logo">
        </div>
        <div class="clearfix mb-20" >
            <div class="float-left">
                <div class="company-info">
                    <div class="company-name">{{$data->company}}</div>
                    <div class="company-address">{{$data->alamat_company}}</div>
                    {{-- <div class="company-address">Kec. Wonokerto Kab. Sidoarjo Jawa Timur</div> --}}
                    <div class="company-address">Telp: {{$data->no_telp}} ({{$data->owner}}), Email: {{$data->email_company}}</div>
                </div>
            </div>

            <div class="float-right">
                <div class="shipping-info">
                    <table class="detail-table">
                        <tr>
                            <td width="80">Kepada</td>
                            <td width="10">:</td>
                            <td>{{ $suratJalan->nama_penerima }}</td>
                        </tr>
                        <tr>
                            <td width="80">Jenis Kendaraan</td>
                            <td width="10">:</td>
                            <td>{{ $suratJalan->jenis_kendaraan }}</td>
                        </tr>
                        <tr>
                            <td>No. Pol</td>
                            <td>:</td>
                            <td>{{ $suratJalan->no_pol }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        </div>
        <div class="header-box">{{$suratJalan->no_surat}}</div>
        <div class="header-box">{{$suratJalan->tanggal}}</div>
        <!-- Document Title -->
        <div class="document-title">SURAT JALAN</div>

        <!-- Items Table -->
        <table class="items-table">
            <thead>
                <tr>
                    <th width="40%">Banyaknya</th>
                    <th width="60%">Nama Barang</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="height: 30px;">{{$suratJalan->jumlah}}</td>
                    <td>{{$suratJalan->nama_produk}}</td>
                </tr>
            </tbody>
        </table>

        <!-- Signatures -->
        <div class="clearfix mb-20" style="margin-top: 15px;">
            <div class="float-left">
                <div>Dibuat oleh,</div>
                <div class="signature-line">{{ $suratJalan->dibuat_oleh }}</div>
            </div>

            <div class="float-right">
                <div>Tanda terima,</div>
                <div class="signature-line"></div>
            </div>
        </div>
    </div>
</body>
</html>