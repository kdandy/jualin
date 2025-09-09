@extends('layouts.app')

@section('title', 'Detail Pembelian Maggot')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Detail Pembelian Maggot</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="{{ route('maggot.pembelian.index') }}">Maggot</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('maggot.pembelian.index') }}">Pembelian</a></div>
                    <div class="breadcrumb-item active">Detail</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Detail Pembelian</h4>
                                <div class="card-header-action">
                                    <a href="{{ route('maggot.pembelian.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left"></i> Kembali
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td width="30%"><strong>No Pembelian</strong></td>
                                                <td width="5%">:</td>
                                                <td>{{ $pembelian->no }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Tanggal</strong></td>
                                                <td>:</td>
                                                <td>{{ $pembelian->tanggal->format('d/m/Y') }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Keterangan</strong></td>
                                                <td>:</td>
                                                <td>{{ $pembelian->keterangan }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td width="30%"><strong>Quantity</strong></td>
                                                <td width="5%">:</td>
                                                <td>{{ number_format($pembelian->qty, 0, ',', '.') }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Harga</strong></td>
                                                <td>:</td>
                                                <td>Rp {{ number_format($pembelian->harga, 0, ',', '.') }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Total</strong></td>
                                                <td>:</td>
                                                <td><span class="badge badge-success badge-lg">Rp {{ number_format($pembelian->total, 0, ',', '.') }}</span></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                
                                <hr>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <small class="text-muted">
                                            <strong>Dibuat:</strong> {{ $pembelian->created_at->format('d/m/Y H:i:s') }}
                                        </small>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <small class="text-muted">
                                            <strong>Diupdate:</strong> {{ $pembelian->updated_at->format('d/m/Y H:i:s') }}
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