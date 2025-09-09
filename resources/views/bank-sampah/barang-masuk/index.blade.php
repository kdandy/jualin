@extends('layouts.app')

@section('title', 'Barang Masuk')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Barang Masuk</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
                    <div class="breadcrumb-item active"><a href="#">Bank Sampah</a></div>
                    <div class="breadcrumb-item">Barang Masuk</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Data Barang Masuk</h4>
                                <div class="card-header-action">
                                    <a href="{{ route('bank-sampah.barang-masuk.export-pdf') }}" class="btn btn-success mr-2">
                                        <i class="fas fa-file-pdf"></i> Export PDF
                                    </a>
                                    <a href="{{ route('bank-sampah.barang-masuk.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus"></i> Tambah
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                @if (session('success'))
                                    <div class="alert alert-success alert-dismissible show fade">
                                        <div class="alert-body">
                                            <button class="close" data-dismiss="alert">
                                                <span>&times;</span>
                                            </button>
                                            {{ session('success') }}
                                        </div>
                                    </div>
                                @endif

                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th>Tanggal</th>
                                                <th>Pemasok</th>
                                                <th>Nama Barang</th>
                                                <th>Qty</th>
                                                <th>Harga Beli</th>
                                                <th>Total Pembelian</th>
                                                <th>Dokumentasi</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($barangMasuks as $index => $barang)
                                                <tr>
                                                    <td class="text-center">{{ $barangMasuks->firstItem() + $index }}</td>
                                                    <td>{{ $barang->tanggal->format('d/m/Y') }}</td>
                                                    <td>{{ $barang->pemasok }}</td>
                                                    <td>{{ $barang->nama_barang }}</td>
                                                    <td>{{ number_format($barang->qty, 2) }} {{ $barang->satuan }}</td>
                                                    <td>Rp {{ number_format($barang->harga_beli, 0, ',', '.') }}</td>
                                                    <td>Rp {{ number_format($barang->total_pembelian, 0, ',', '.') }}</td>
                                                    <td>
                                                        @if($barang->dokumentasi)
                                                            <a href="{{ $barang->dokumentasi }}" target="_blank" class="btn btn-sm btn-info">
                                                                <i class="fas fa-eye"></i> Lihat
                                                            </a>
                                                        @else
                                                            <span class="text-muted">Tidak ada</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <a href="{{ route('bank-sampah.barang-masuk.show', $barang->id) }}" class="btn btn-sm btn-info">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                            
                                                            @if(auth()->user()->role === 'superadmin')
                                                                <a href="{{ route('bank-sampah.barang-masuk.edit', $barang->id) }}" class="btn btn-sm btn-warning">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                            @endif
                                                            
                                                            <form action="{{ route('bank-sampah.barang-masuk.destroy', $barang->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-danger">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                
                                <div class="d-flex justify-content-center">
                                    {{ $barangMasuks->links() }}
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
    <!-- JS Libraies -->
    <script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>
@endpush