<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Penjualan Bank Sampah</title>
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
        <h2>Laporan Penjualan</h2>
        <p>Tanggal Cetak: {{ date('d/m/Y H:i:s') }}</p>
    </div>

    <div class="info">
        <p><strong>Total Data:</strong> {{ $penjualans->count() }} transaksi</p>
        @if($penjualans->count() > 0)
            <p><strong>Periode:</strong> {{ $penjualans->min('tanggal')->format('d/m/Y') }} - {{ $penjualans->max('tanggal')->format('d/m/Y') }}</p>
        @endif
    </div>

    @if($penjualans->count() > 0)
        <table>
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="15%">Tanggal</th>
                    <th width="20%">Nama Barang</th>
                    <th width="10%">Satuan</th>
                    <th width="10%">Qty</th>
                    <th width="15%">Harga Satuan</th>
                    <th width="15%">Total Harga</th>
                    <th width="10%">Status</th>
                </tr>
            </thead>
            <tbody>
                @php $grandTotal = 0; @endphp
                @foreach($penjualans as $index => $penjualan)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td class="text-center">{{ $penjualan->tanggal->format('d/m/Y') }}</td>
                        <td>{{ $penjualan->nama_barang }}</td>
                        <td class="text-center">{{ $penjualan->satuan }}</td>
                        <td class="text-right">{{ number_format($penjualan->qty, 0, ',', '.') }}</td>
                        <td class="text-right">Rp {{ number_format($penjualan->harga_satuan, 0, ',', '.') }}</td>
                        <td class="text-right">Rp {{ number_format($penjualan->total_harga, 0, ',', '.') }}</td>
                        <td class="text-center">
                            @if($penjualan->status == 'pending')
                                Pending
                            @elseif($penjualan->status == 'completed')
                                Selesai
                            @else
                                Dibatalkan
                            @endif
                        </td>
                    </tr>
                    @php $grandTotal += $penjualan->total_harga; @endphp
                @endforeach
                <tr class="total-row">
                    <td colspan="6" class="text-center"><strong>TOTAL KESELURUHAN</strong></td>
                    <td class="text-right"><strong>Rp {{ number_format($grandTotal, 0, ',', '.') }}</strong></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    @else
        <p style="text-align: center; margin: 50px 0;">Tidak ada data penjualan untuk ditampilkan.</p>
    @endif

    <div class="footer">
        <p>Dicetak pada: {{ date('d/m/Y H:i:s') }}</p>
        <br><br>
        <p>_________________________</p>
        <p>Penanggung Jawab</p>
    </div>
</body>
</html>