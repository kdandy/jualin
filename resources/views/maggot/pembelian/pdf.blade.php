<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pembelian Maggot</title>
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
        <h1>LAPORAN PEMBELIAN MAGGOT</h1>
    </div>
    
    <div class="info">
        <p><strong>Tanggal Cetak:</strong> {{ date('d/m/Y H:i:s') }}</p>
        <p><strong>Total Data:</strong> {{ $pembelians->count() }} record</p>
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
                <th width="15%">No. Pembelian</th>
                <th width="15%">Tanggal</th>
                <th width="35%">Keterangan</th>
                <th width="10%">Qty</th>
                <th width="10%">Harga</th>
                <th width="10%">Total</th>
            </tr>
        </thead>
        <tbody>
            @php $grandTotal = 0; @endphp
            @forelse($pembelians as $index => $pembelian)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $pembelian->no }}</td>
                    <td class="text-center">{{ date('d/m/Y', strtotime($pembelian->tanggal)) }}</td>
                    <td>{{ $pembelian->keterangan }}</td>
                    <td class="text-center">{{ number_format($pembelian->qty) }}</td>
                    <td class="text-right">Rp {{ number_format($pembelian->harga, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($pembelian->total, 0, ',', '.') }}</td>
                </tr>
                @php $grandTotal += $pembelian->total; @endphp
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data pembelian</td>
                </tr>
            @endforelse
            
            @if($pembelians->count() > 0)
                <tr class="total-row">
                    <td colspan="6" class="text-center"><strong>GRAND TOTAL</strong></td>
                    <td class="text-right"><strong>Rp {{ number_format($grandTotal, 0, ',', '.') }}</strong></td>
                </tr>
            @endif
        </tbody>
    </table>
</body>
</html>