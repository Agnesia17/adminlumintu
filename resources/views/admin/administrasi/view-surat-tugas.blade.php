<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Tugas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
        }

        .letterhead {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo {
            max-width: 100px;
            margin-bottom: 10px;
        }

        .company-name {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .company-details {
            font-size: 12px;
            color: #555;
        }

        .divider {
            border-top: 2px solid #000;
            margin: 20px 0;
        }

        .letter-title {
            text-align: center;
            font-weight: bold;
            margin: 5px 0;
        }

        .letter-number {
            text-align: center;
            margin-bottom: 10px;
        }

        .info-grid {
            margin-left: 20px;
            margin-bottom: 20px;
        }

        .info-row {
            margin-bottom: 5px;
        }

        .label {
            display: inline-block;
            width: 100px;
        }

        .content {
            margin: 20px 0;
            text-align: justify;
        }

        .signature {
            margin-top: 50px;
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="letterhead">
        @if(isset($logoImage))
            <img src="data:image/png;base64,{{ $logoImage }}" alt="Logo" class="logo">
        @endif
        <div class="company-name">{{$data->company}}</div>
        <div class="company-details">
            {{$data->alamat_company}}<br>
            Telp: {{$data->no_telp}} ({{$data->owner}}), E-mail: {{$data->email_company}}
        </div>
    </div>

    <div class="divider"></div>

    <div class="letter-title">SURAT TUGAS</div>
    <div class="letter-number">{{ $suratTugas->no_surat }}</div>

    <div class="content">
        <p>Yang bertanda tangan di bawah ini:</p>
        <div class="info-grid">
            <div class="info-row">
                <span class="label">Nama</span>: {{$data->owner}}
            </div>
            <div class="info-row">
                <span class="label">Jabatan</span>: Direktur {{$data->company}}
            </div>
        </div>

        <p>Dengan ini menunjuk kepada saudara:</p>
        <div class="info-grid">
            <div class="info-row">
                <span class="label">Nama</span>: {{ $suratTugas->nama }}
            </div>
            <div class="info-row">
                <span class="label">No. KTP</span>: {{ $suratTugas->no_ktp }}
            </div>
            <div class="info-row">
                <span class="label">Alamat</span>: {{ $suratTugas->alamat }}
            </div>
        </div>

        <p>
            Kami menunjuk saudara tersebut di atas sebagai supplier kami untuk mengumpulkan UCO (Used Cooking Oil) atau minyak jelantah, PAO (Palm Acid Oil), CPO (Crude Palm Oil) Dll. Minyak tersebut tidak untuk dikonsumsi oleh manusia tetapi dipergunakan untuk bahan baku pembuatan Biodiesel dan bahan baku pakan ternak.
        </p>

        <p>Surat tugas ini berlaku sampai akhir <strong>{{ $suratTugas->masa }}</strong>.</p>
        
        <p><em><strong>Note:</strong> Surat tugas ini sudah tidak berlaku apabila melebihi masa aktif yang telah ditentukan.</em></p>

        <p>Demikian surat tugas ini kami buat untuk dipergunakan sebagaimana mestinya.</p>
    </div>

    <div class="signature">
        <p>Sidoarjo, {{ $tanggal }}</p>
       <br>
        <p>{{$data->owner}}</p>
    </div>
</body>
</html>