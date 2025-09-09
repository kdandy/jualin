<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Barang Masuk Bank Sampah</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }
        .header h2 {
            margin: 5px 0;
            font-size: 14px;
            font-weight: normal;
        }
        .info {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: center;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .total-row {
            font-weight: bold;
            background-color: #f9f9f9;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>BANK SAMPAH PURWOKELING</h1>
        <h2>Laporan Barang Masuk</h2>
        <p>Tanggal Cetak: {{ date('d/m/Y H:i:s') }}</p>
    </div>

    <div class="info">
        <p><strong>Total Data:</strong> {{ $barangMasuks->count() }} transaksi</p>
        @if($barangMasuks->count() > 0)
            <p><strong>Periode:</strong> {{ $barangMasuks->min('tanggal')->format('d/m/Y') }} - {{ $barangMasuks->max('tanggal')->format('d/m/Y') }}</p>
        @endif
    </div>

    @if($barangMasuks->count() > 0)
        <table>
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="12%">Tanggal</th>
                    <th width="18%">Pemasok</th>
                    <th width="20%">Nama Barang</th>
                    <th width="8%">Qty</th>
                    <th width="8%">Satuan</th>
                    <th width="14%">Harga Beli</th>
                    <th width="15%">Total Pembelian</th>
                </tr>
            </thead>
            <tbody>
                @php $grandTotal = 0; @endphp
                @foreach($barangMasuks as $index => $barangMasuk)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td class="text-center">{{ $barangMasuk->tanggal->format('d/m/Y') }}</td>
                        <td>{{ $barangMasuk->pemasok }}</td>
                        <td>{{ $barangMasuk->nama_barang }}</td>
                        <td class="text-right">{{ number_format($barangMasuk->qty, 2, ',', '.') }}</td>
                        <td class="text-center">{{ $barangMasuk->satuan }}</td>
                        <td class="text-right">Rp {{ number_format($barangMasuk->harga_beli, 0, ',', '.') }}</td>
                        <td class="text-right">Rp {{ number_format($barangMasuk->total_pembelian, 0, ',', '.') }}</td>
                    </tr>
                    @php $grandTotal += $barangMasuk->total_pembelian; @endphp
                @endforeach
                <tr class="total-row">
                    <td colspan="7" class="text-center"><strong>TOTAL KESELURUHAN</strong></td>
                    <td class="text-right"><strong>Rp {{ number_format($grandTotal, 0, ',', '.') }}</strong></td>
                </tr>
            </tbody>
        </table>
    @else
        <p style="text-align: center; margin: 50px 0;">Tidak ada data barang masuk untuk ditampilkan.</p>
    @endif

    <div class="footer">
        <p>Dicetak pada: {{ date('d/m/Y H:i:s') }}</p>
        <br><br>
        <p>_________________________</p>
        <p>Penanggung Jawab</p>
    </div>
</body>
</html>