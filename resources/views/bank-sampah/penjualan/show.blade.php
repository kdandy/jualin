@extends('layouts.app')

@section('title', 'Detail Penjualan')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Detail Penjualan</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
                    <div class="breadcrumb-item active"><a href="#">Bank Sampah</a></div>
                    <div class="breadcrumb-item active"><a href="{{ route('bank-sampah.penjualan.index') }}">Penjualan</a></div>
                    <div class="breadcrumb-item">Detail</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Detail Penjualan #{{ $penjualan->id }}</h4>
                                <div class="card-header-action">
                                    <a href="{{ route('bank-sampah.penjualan.edit', $penjualan->id) }}" class="btn btn-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a href="{{ route('bank-sampah.penjualan.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left"></i> Kembali
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td width="30%"><strong>Tanggal</strong></td>
                                                <td>: {{ $penjualan->tanggal->format('d/m/Y') }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Nama Barang</strong></td>
                                                <td>: {{ $penjualan->nama_barang }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Qty</strong></td>
                                                <td>: {{ number_format($penjualan->qty, 2) }} {{ $penjualan->satuan }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Satuan</strong></td>
                                                <td>: {{ $penjualan->satuan }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Harga Jual</strong></td>
                                                <td>: Rp {{ number_format($penjualan->harga_jual, 2, ',', '.') }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td width="30%"><strong>Total Penjualan</strong></td>
                                                <td>: Rp {{ number_format($penjualan->total_penjualan, 2, ',', '.') }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Laba</strong></td>
                                                <td>: Rp {{ number_format($penjualan->laba, 2, ',', '.') }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Stok Awal</strong></td>
                                                <td>: {{ number_format($penjualan->stok_awal, 2) }} {{ $penjualan->satuan }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Stok Akhir</strong></td>
                                                <td>: {{ number_format($penjualan->stok_akhir, 2) }} {{ $penjualan->satuan }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Dokumen</strong></td>
                                                <td>: 
                                                    @if($penjualan->dokumen)
                                                        <a href="{{ $penjualan->dokumen }}" target="_blank" class="btn btn-sm btn-info">
                                                            <i class="fas fa-download"></i> Lihat Dokumen
                                                        </a>
                                                    @else
                                                        <span class="text-muted">Tidak ada dokumen</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                
                                <hr>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <small class="text-muted">
                                            <strong>Dibuat:</strong> {{ $penjualan->created_at->format('d/m/Y H:i:s') }}
                                        </small>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <small class="text-muted">
                                            <strong>Diupdate:</strong> {{ $penjualan->updated_at->format('d/m/Y H:i:s') }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection