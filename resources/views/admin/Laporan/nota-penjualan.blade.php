<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
           @page {
            size: 21.5cm 29.7cm;
            /* Ukuran kertas */
            margin: 0.5cm;
            /* Mengurangi margin agar lebih muat */
        }
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        .header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .header-left {
            width: 50%;
        }
        .header-right {
            width: 50%;
            text-align: right;
        }
        .invoice-box {
            border: 1px solid #ccc;
            padding: 10px;
            display: inline-block;
            margin-bottom: 10px;
        }
        .logo {
            max-width: 150px;
        }
        .invoice-title {
            text-align: center;
            font-weight: bold;
            font-size: 24px;
            margin: 20px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
            text-align: left;
        }
        .total-row {
            font-weight: bold;
        }
        .payment-info {
            margin-bottom: 20px;
        }
        .signature {
            display: flex;
            justify-content: space-between;
            margin-top: 50px;
        }
        .signature-box {
            width: 45%;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="header-left">
                <div class="invoice-box">
                    INV/01/LEP/0001/2025
                </div>
                <div class="invoice-box">
                    01 Januari 2025
                </div>
                <h3>Tagihan kepada</h3>
                <p>
                    Direktur CV. Fish farms & hatcheries<br>
                    Ngudi Lor RT.03 61351 Kabupaten Mojokerto Jawa Timur<br>
                    Telp. 0822-09098-0909
                </p>
            </div>
            <div class="header-right">
                <img src="{{ asset('images/lep-logo.png') }}" alt="LEP Logo" class="logo">
                <h3>LUMINTU ENERGI PERSADA,CV</h3>
                <p>
                    Pergudangan Minyak Babe Ds. Wonoayu RT.02 RW. 01 (Barat KUD)<br>
                    Kec. Wonoayu Kab. Sidoarjo Jawa Timur<br>
                    Telp. 0813-3093-6218 (Babe Suwarno), Email: lumintu.babe@gmail.com
                </p>
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
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                </tr>
                <tr>
                    <td colspan="3" class="total-row">TOTAL</td>
                    <td>-</td>
                </tr>
            </tbody>
        </table>

        <div class="payment-info">
            <p>
                <strong>Pembayaran ke :</strong><br>
                Bank BCA a/n SUWARNO<br>
                0183153436
            </p>
            <p>
                <strong>Pesan :</strong><br>
                Pembayaran wajib diselesaikan maksimal 10 hari setelah invoice<br>
                ini dikonfirmasi oleh pihak yang bersangkutan
            </p>
        </div>

        <div class="signature">
            <div class="signature-box">
                <p>Dibuat oleh,</p>
                <br><br><br>
                <p>( &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; )</p>
            </div>
            <div class="signature-box">
                <p>Tanda terima,</p>
                <br><br><br>
                <p>( &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; )</p>
            </div>
        </div>
    </div>
</body>
</html>