@php
    $bulanList = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
        4 => 'April', 5 => 'Mei', 6 => 'Juni',
        7 => 'Juli', 8 => 'Agustus', 9 => 'September',
        10 => 'Oktober', 11 => 'November', 12 => 'Desember',
    ];
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body style="margin:0;padding:0;background-color:#f8fafc;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="padding:40px 10px;">
        <tr>
            <td align="center">

                <table width="100%" cellpadding="0" cellspacing="0" style="max-width:560px;background:#ffffff;border:1px solid #e2e8f0;border-radius:12px;overflow:hidden;box-shadow:0 4px 6px -1px rgba(0,0,0,0.05);">

                    <tr>
                        <td height="4" style="background:#FFA500;"></td>
                    </tr>

                    <tr>
                        <td style="padding:40px;">

                            <div style="color:#64748b;font-size:12px;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;margin-bottom:8px;">
                                Financial Report
                            </div>

                            <h1 style="color:#1e293b;font-size:24px;font-weight:800;margin:0;">
                                Laporan Keuangan Anda
                            </h1>

                            <div style="height:1px;background:#f1f5f9;margin:24px 0;"></div>

                            <p style="color:#475569;font-size:15px;line-height:1.6;margin:0 0 20px 0;">
                                Halo, <strong>{{ $nama }}</strong><br><br>

                                Laporan keuangan Anda telah tersedia.<br>
                                Kami telah merangkum aktivitas keuangan Anda selama periode tersebut untuk memudahkan peninjauan.
                            </p>

                            <table width="100%" cellpadding="16" cellspacing="0" style="background:#f8fafc;border-radius:8px;border:1px solid #f1f5f9;">
                                <tr>
                                    <td>

                                        <table width="100%" cellpadding="0" cellspacing="0">
                                            <tr>

                                                <td width="50%" style="padding:6px;" valign="top">
                                                    <table width="100%" cellpadding="14" cellspacing="0" style="background:#f8fafc;border:1px solid #eef2f7;border-radius:10px;">
                                                        <tr>
                                                            <td>
                                                                <div style="color:#94a3b8;font-size:11px;text-transform:uppercase;font-weight:600;">
                                                                    Bulan
                                                                </div>
                                                                <div style="color:#1e293b;font-size:16px;font-weight:700;margin-top:6px;">
                                                                    {{ $bulanList[(int) $bulan] ?? '' }}
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>

                                                <td width="50%" style="padding:6px;" valign="top">
                                                    <table width="100%" cellpadding="14" cellspacing="0" style="background:#fff7ed;border:1px solid #fed7aa;border-radius:10px;">
                                                        <tr>
                                                            <td>
                                                                <div style="color:#fb923c;font-size:11px;text-transform:uppercase;font-weight:600;">
                                                                    Tahun
                                                                </div>
                                                                <div style="color:#1e293b;font-size:16px;font-weight:700;margin-top:6px;">
                                                                    {{ $tahun }}
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>

                                            </tr>
                                        </table>

                                    </td>
                                </tr>
                            </table>

                            <p style="color:#475569;font-size:14px;line-height:1.6;margin:24px 0 0 0;">
                                Rincian lengkap transaksi dapat Anda lihat pada lampiran <strong>PDF</strong> yang disertakan dalam email ini.
                            </p>

                            <p style="color:#475569;font-size:14px;line-height:1.6;margin:16px 0 0 0;">
                                Apabila Anda memiliki pertanyaan atau membutuhkan bantuan lebih lanjut, silakan menghubungi tim kami.
                            </p>

                            <table width="100%" cellpadding="0" cellspacing="0" style="margin-top:32px;">
                                <tr>
                                    <td>
                                        <p style="color:#1e293b;font-size:14px;font-weight:600;margin:0;">
                                            Dukungan Tim Keuangan
                                        </p>
                                        <p style="color:#94a3b8;font-size:13px;margin:2px 0 0 0;">
                                            Jawa Tengah, Indonesia
                                        </p>
                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>

                    <tr>
                        <td style="padding:0 40px 40px 40px;">
                            <div style="border-top:1px solid #f1f5f9;padding-top:24px;text-align:center;">
                                <p style="color:#94a3b8;font-size:11px;line-height:1.5;margin:0;">
                                    Email ini dikirim secara otomatis. Mohon tidak membalas email ini. Jika Anda merasa tidak seharusnya menerima email ini, silakan abaikan atau hubungi admin.
                                </p>
                            </div>
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>
</html>