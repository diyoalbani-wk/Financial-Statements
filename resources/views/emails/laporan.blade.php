<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Keuangan</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; background-color: #f9f9f9; padding: 20px;">

    <div style="max-width:600px; margin:auto; background:#ffffff; padding:20px; border:1px solid #eee; border-radius:8px;">

        <h2 style="text-align:center; color:#333;">
            📊 Laporan Keuangan
        </h2>

        <p>Halo,</p>

        <p>
            {{ $pesan ?? 'Berikut kami lampirkan laporan keuangan Anda.' }}
        </p>

        <p>
            <strong>Periode:</strong>
            {{ $bulan }} / {{ $tahun }}
        </p>

        <p>
            File PDF laporan keuangan sudah kami lampirkan pada email ini.
        </p>

        <br>

        <p>Terima kasih.</p>

        <hr>

        <p style="font-size:12px; color:gray; text-align:center;">
            Email ini dikirim otomatis oleh sistem, mohon tidak membalas email ini.
        </p>

    </div>

</body>
</html>