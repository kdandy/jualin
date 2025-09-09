<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Penjualan Maggot</title>
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
        .info {
            margin-bottom: 20px;
        }
        .info p {
            margin: 5px 0;
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
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN PENJUALAN MAGGOT</h1>
    </div>
    
    <div class="info">
        <p><strong>Tanggal Cetak:</strong> {{ date('d/m/Y H:i:s') }}</p>
        <p><strong>Total Data:</strong> {{ $penjualans->count() }} record</p>
        <p><strong>Periode:</strong> 
            @if(request('start_date') && request('end_date'))
                {{ date('d/m/Y', strtotime(request('start_date'))) }} - {{ date('d/m/Y', strtotime(request('end_date'))) }}
            @else
                Semua Data
            @endif
        </p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">No. Penjualan</th>
                <th width="15%">Tanggal</th>
                <th width="25%">Produk</th>
                <th width="10%">Qty (kg)</th>
                <th width="15%">Harga/kg</th>
                <th width="15%">Total</th>
            </tr>
        </thead>
        <tbody>
            @php $grandTotal = 0; @endphp
            @forelse($penjualans as $index => $penjualan)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $penjualan->no }}</td>
                    <td class="text-center">{{ date('d/m/Y', strtotime($penjualan->tanggal)) }}</td>
                    <td>{{ $penjualan->produk }}</td>
                    <td class="text-center">{{ number_format($penjualan->qty) }}</td>
                    <td class="text-right">Rp {{ number_format($penjualan->harga, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($penjualan->total, 0, ',', '.') }}</td>
                </tr>
                @php $grandTotal += $penjualan->total; @endphp
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data penjualan</td>
                </tr>
            @endforelse
            
            @if($penjualans->count() > 0)
                <tr class="total-row">
                    <td colspan="6" class="text-center"><strong>GRAND TOTAL</strong></td>
                    <td class="text-right"><strong>Rp {{ number_format($grandTotal, 0, ',', '.') }}</strong></td>
                </tr>
            @endif
        </tbody>
    </table>
</body>
</html>