@extends('layouts.app')

@section('title', 'Pembelian Maggot')

@push('css')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
@endpush

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Pembelian Maggot</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Maggot</a></div>
                    <div class="breadcrumb-item">Pembelian</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Data Pembelian</h4>
                                <div class="card-header-action">
                                    <a href="{{ route('maggot.pembelian.export-pdf') }}" class="btn btn-success mr-2">
                                        <i class="fas fa-file-pdf"></i> Export PDF
                                    </a>
                                    <a href="{{ route('maggot.pembelian.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus"></i> Tambah
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                @if(session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('success') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif

                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal</th>
                                                <th>Keterangan</th>
                                                <th>Qty</th>
                                                <th>Harga</th>
                                                <th>Total</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($pembelians as $pembelian)
                                                <tr>
                                                    <td>{{ $pembelian->no }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($pembelian->tanggal)->format('d/m/Y') }}</td>
                                                    <td>{{ $pembelian->keterangan }}</td>
                                                    <td>{{ number_format($pembelian->qty) }}</td>
                                                    <td>Rp {{ number_format($pembelian->harga, 0, ',', '.') }}</td>
                                                    <td>Rp {{ number_format($pembelian->total, 0, ',', '.') }}</td>
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <a href="{{ route('maggot.pembelian.show', $pembelian->id) }}" class="btn btn-info btn-sm">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                            
                                                            @if(auth()->user()->role === 'superadmin')
                                                                <a href="{{ route('maggot.pembelian.edit', $pembelian->id) }}" class="btn btn-warning btn-sm">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                            @endif

                                                            <form action="{{ route('maggot.pembelian.destroy', $pembelian->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger btn-sm">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="7" class="text-center">Tidak ada data pembelian</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                
                                <div class="d-flex justify-content-center">
                                    {{ $pembelians->links() }}
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
    <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script>
        $(document).ready(function() {
            $('#table-1').DataTable({
                "pageLength": 10,
                "responsive": true,
                "language": {
                    "search": "Cari:",
                    "lengthMenu": "Tampilkan _MENU_ data per halaman",
                    "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    "paginate": {
                        "first": "Pertama",
                        "last": "Terakhir",
                        "next": "Selanjutnya",
                        "previous": "Sebelumnya"
                    }
                }
            });
        });
    </script>
@endpush