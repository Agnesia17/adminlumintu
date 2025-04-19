<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Nota Penjualan - {{$notaNumber}}</title>
    <style>
        @page {
            margin: 0cm 0cm;
        }
        body {
            margin-top: 2cm;
            margin-left: 2cm;
            margin-right: 2cm;
            margin-bottom: 2cm;
            font-family: Arial, sans-serif;
            font-size: 14px; /* Increased from 12px */
        }
        .header-box {
            border: 1px solid #000;
            padding: 6px; /* Slightly larger padding */
            margin-bottom: 6px;
            width: 210px;
            font-size: 13px; /* Specific size for header boxes */
        }
        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }
        .left-section {
            float: left;
            width: 48%;
        }
        .right-section {
            float: right;
            width: 48%;
            text-align: right;
        }
        .invoice-title {
            text-align: center;
            font-weight: bold;
            font-size: 22px; /* Increased from 18px */
            margin: 25px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table th {
            border: 1px solid #000;
            padding: 7px;
            font-size: 15px; /* Larger font for headers */
            background-color: #f9f9f9;
        }
        table td {
            border: 1px solid #000;
            padding: 7px;
            font-size: 14px; /* Consistent with body text */
        }
        .footer-signature {
            margin-top: 60px;
        }
        .left-sign {
            float: left;
            width: 45%;
            text-align: center;
            font-size: 15px; /* Larger font for signatures */
        }
        .right-sign {
            float: right;
            width: 45%;
            text-align: center;
            font-size: 15px; /* Larger font for signatures */
        }
        .payment-info {
            margin-top: 25px;
            font-size: 14px;
            line-height: 1.5;
        }
        .message-info {
            margin-top: 25px;
            font-size: 14px;
            line-height: 1.5;
        }
        .company-name {
            font-size: 16px; /* Larger font for company name */
            font-weight: bold;
            margin-bottom: 5px;
        }
        .address-details {
            font-size: 13px;
            line-height: 1.4;
        }
        .total-row {
            font-weight: bold;
            font-size: 15px;
        }
    </style>
</head>
<body>
    <div class="clearfix">
        <div class="left-section">
            <div class="header-box">{{ $notaNumber }}</div>
            <div class="header-box">{{ $tanggal }}</div>
            
            <div style="margin-top: 20px;">
                <strong style="font-size: 15px;">Tagihan kepada</strong><br>
                <div style="font-size: 14px; line-height: 1.5; margin-top: 5px;">
                    {{$penjualan->nama_pembeli}}<br>
                    {{$penjualan->alamat}}<br>
                    Telp: {{$penjualan->no_telepon}}
                </div>
            </div>
        </div>
        
        <div class="right-section">
            @if(!empty($logoImage))
                <img src="data:image/png;base64,{{ $logoImage }}" width="110">
            @endif
            <div class="company-name">{{$data->company}}</div>
            <div class="address-details">
                {{$data->alamat_company}}<br>
              
                Telp: {{$data->no_telp}} ({{$data->owner}})<br>
                Email: {{$data->email_company}}
            </div>
        </div>
    </div>
    
    <div class="invoice-title">INVOICE</div>
    
    <table>
        <thead>
            <tr>
                <th>Banyaknya</th>
                <th>Nama Barang</th>
                <th>Harga</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <!-- Tengah -->
                <td style="text-align: center;">{{$penjualan->jumlah}}</td>
                <td style="text-align: center;">{{$penjualan->nama_produk}}</td>
                
                <!-- Kanan -->
                <td style="text-align: right;">{{number_format($penjualan->harga_jual, 2, ',', '.') }}</td>
                <td style="text-align: right;">{{number_format($penjualan->total, 2, ',', '.')}}</td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: right; font-weight: bold;" class="total-row">TOTAL</td>
                <td class="total-row" style="text-align: right;">{{number_format($penjualan->total, 2, ',', '.')}}</td>
            </tr>
        </tbody>
    </table>
    
    <div class="payment-info">
        <strong style="font-size: 15px;">Pembayaran ke :</strong><br>
        Bank BCA a/n SUWARNO<br>
        0193151436
    </div>
    
    <div class="message-info">
        <strong style="font-size: 15px;">Pesan:</strong><br>
        Pembayaran wajib diselesaikan maksimal 10 hari setelah invoice<br>
        ini diterbitkan demi pihak yang bersangkutan
    </div>
    
    <div class="footer-signature clearfix">
        <div class="left-sign">
            <div>Dibuat oleh,</div>
            <div style="margin-top: 50px;">( {{$data->owner}} )</div>
        </div>
        
        <div class="right-sign">
            <div>Tanda terima,</div>
            <div style="margin-top: 50px;">( {{$penjualan->nama_pembeli}} )</div>
        </div>
    </div>
</body>
</html>