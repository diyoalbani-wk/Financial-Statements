<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Laporan Keuangan</title>
        <style>
            body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
            h2 { text-align: center; }
            table { width: 100%; border-collapse: collapse; margin-top: 20px; }
            table, th, td { border: 1px solid #000; }
            th { background: #f2f2f2; padding: 6px; }
            td { padding: 5px; }
            .text-right { text-align: right; }
            .text-center { text-align: center; }
        </style>
    </head>
    <body>

        <h2>LAPORAN KEUANGAN</h2>
        <p style="text-align:center;">
            Dicetak: {{ now()->format('d F Y') }}
        </p>

        <table>
            <thead> 
                <tr>
                    <th>Tanggal</th>
                    <th>Tipe</th>
                    <th>Kategori</th>
                    <th>Nominal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($incomes as $income)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($income->tanggal)->format('d M Y') }}</td>
                    <td class="text-center">Pemasukan</td>
                    <td>{{ $income->kategori }}</td>
                    <td class="text-right">Rp {{ number_format($income->nominal,0,',','.') }}</td>
                </tr>
                @endforeach

                @foreach($outcomes as $outcome)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($outcome->tanggal)->format('d M Y') }}</td>
                    <td class="text-center">Pengeluaran</td>
                    <td>{{ $outcome->kategori }}</td>
                    <td class="text-right">Rp {{ number_format($outcome->nominal,0,',','.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </body>
</html>