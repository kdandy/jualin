@extends('layouts.app')

@section('title', 'Penjualan Maggot')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Penjualan Maggot</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="#">Maggot</a></div>
                    <div class="breadcrumb-item active">Penjualan</div>
                </div>
            </div>

            <div class="section-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible show fade">
                        <div class="alert-body">
                            <button class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                            {{ session('success') }}
                        </div>
                    </div>
                @endif

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Data Penjualan Maggot</h4>
                                <div class="card-header-action">
                                    <a href="{{ route('maggot.penjualan.export-pdf') }}" class="btn btn-success mr-2">
                                        <i class="fas fa-file-pdf"></i> Export PDF
                                    </a>
                                    <a href="{{ route('maggot.penjualan.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus"></i> Tambah Penjualan
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th>No Penjualan</th>
                                                <th>Tanggal</th>
                                                <th>Produk</th>
                                                <th>Qty</th>
                                                <th>Harga</th>
                                                <th>Total</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($penjualans as $index => $penjualan)
                                                <tr>
                                                    <td class="text-center">{{ $index + 1 }}</td>
                                                    <td>{{ $penjualan->no }}</td>
                                                    <td>{{ $penjualan->tanggal->format('d/m/Y') }}</td>
                                                    <td>{{ $penjualan->produk }}</td>
                                                    <td>{{ number_format($penjualan->qty, 0, ',', '.') }}</td>
                                                    <td>Rp {{ number_format($penjualan->harga, 0, ',', '.') }}</td>
                                                    <td><span class="badge badge-success">Rp {{ number_format($penjualan->total, 0, ',', '.') }}</span></td>
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <a href="{{ route('maggot.penjualan.show', $penjualan->id) }}" 
                                                               class="btn btn-info btn-sm" title="Detail">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                            
                                                            @if(auth()->user()->role === 'superadmin')
                                                                <a href="{{ route('maggot.penjualan.edit', $penjualan->id) }}" 
                                                                   class="btn btn-warning btn-sm" title="Edit">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                            @endif

                                                            <form action="{{ route('maggot.penjualan.destroy', $penjualan->id) }}" 
                                                                  method="POST" style="display: inline-block;" 
                                                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="8" class="text-center">Tidak ada data penjualan</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                
                                @if($penjualans->hasPages())
                                    <div class="d-flex justify-content-center">
                                        {{ $penjualans->links() }}
                                    </div>
                                @endif
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
    <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('library/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('library/datatables.net-select-bs4/js/select.bootstrap4.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/modules-datatables.js') }}"></script>
@endpush