@extends('layouts.app')

@section('title', 'Penjualan')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Penjualan</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
                    <div class="breadcrumb-item active"><a href="#">Bank Sampah</a></div>
                    <div class="breadcrumb-item">Penjualan</div>
                </div>
            </div>

            <div class="section-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Data Penjualan</h4>
                                <div class="card-header-action">
                                    <a href="{{ route('bank-sampah.penjualan.export-pdf') }}" class="btn btn-success mr-2">
                                        <i class="fas fa-file-pdf"></i> Export PDF
                                    </a>
                                    <a href="{{ route('bank-sampah.penjualan.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus"></i> Tambah
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal</th>
                                                <th>Nama Barang</th>
                                                <th>Qty</th>
                                                <th>Harga Jual</th>
                                                <th>Total Penjualan</th>
                                                <th>Laba</th>
                                                <th>Stok Awal</th>
                                                <th>Stok Akhir</th>
                                                <th>Dokumen</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($penjualans as $index => $penjualan)
                                                <tr>
                                                    <td>{{ $penjualans->firstItem() + $index }}</td>
                                                    <td>{{ $penjualan->tanggal->format('d/m/Y') }}</td>
                                                    <td>{{ $penjualan->nama_barang }}</td>
                                                    <td>{{ number_format($penjualan->qty, 2) }} {{ $penjualan->satuan }}</td>
                                                    <td>Rp {{ number_format($penjualan->harga_jual, 0, ',', '.') }}</td>
                                                    <td>Rp {{ number_format($penjualan->total_penjualan, 0, ',', '.') }}</td>
                                                    <td>Rp {{ number_format($penjualan->laba, 0, ',', '.') }}</td>
                                                    <td>{{ number_format($penjualan->stok_awal, 2) }} {{ $penjualan->satuan }}</td>
                                                    <td>{{ number_format($penjualan->stok_akhir, 2) }} {{ $penjualan->satuan }}</td>
                                                    <td>
                                                        @if($penjualan->dokumen)
                                                            <a href="{{ $penjualan->dokumen }}" target="_blank" class="btn btn-sm btn-info">
                                                                <i class="fas fa-file"></i>
                                                            </a>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('bank-sampah.penjualan.show', $penjualan->id) }}" class="btn btn-sm btn-info">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        
                                                        @if(auth()->user()->role === 'superadmin')
                                                            <a href="{{ route('bank-sampah.penjualan.edit', $penjualan->id) }}" class="btn btn-sm btn-warning">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                        @endif
                                                        <form action="{{ route('bank-sampah.penjualan.destroy', $penjualan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="11" class="text-center">Tidak ada data penjualan</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                
                                <!-- Pagination -->
                                <div class="d-flex justify-content-center">
                                    {{ $penjualans->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraries -->
@endpush