@extends('layouts.app')

@section('title', 'Log Sheet Harian Maggot')

@push('css')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
@endpush

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Log Sheet Harian Maggot</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Maggot</a></div>
                    <div class="breadcrumb-item">Log Sheet Harian</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Data Log Sheet Harian</h4>
                                <div class="card-header-action">
                                    <a href="{{ route('maggot.log-sheet-harian.create') }}" class="btn btn-primary">
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
                                    <table class="table table-striped" id="table-1">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No</th>
                                                <th>Tanggal</th>
                                                <th>Suhu Ruang/Wadah (°C)</th>
                                                <th>Kelembapan Ruang/Wadah (%)</th>
                                                <th>Fase Kehidupan</th>
                                                <th>Jenis Sampah</th>
                                                <th>Berat Limbah (kg)</th>
                                                <th>Berat Kasgot (kg)</th>
                                                <th>Dokumentasi</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($logSheets as $index => $logSheet)
                                                <tr>
                                                    <td class="text-center">{{ $logSheets->firstItem() + $index }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($logSheet->tanggal)->format('d/m/Y') }}</td>
                                                    <td>{{ $logSheet->suhu }}°C</td>
                                                    <td>{{ $logSheet->kelembapan }}%</td>
                                                    <td>{{ $logSheet->fase_kehidupan }}</td>
                                                    <td>{{ $logSheet->jenis_sampah ?? '-' }}</td>
                                                    <td>{{ $logSheet->berat_limbah }} kg</td>
                                                    <td>{{ $logSheet->berat_kasgot }} kg</td>
                                                    <td>
                                                        @if($logSheet->dokumentasi)
                                                            <a href="{{ $logSheet->dokumentasi }}" 
                                                               target="_blank" class="btn btn-sm btn-info">
                                                                <i class="fas fa-file"></i> Lihat
                                                            </a>
                                                        @else
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <a href="{{ route('maggot.log-sheet-harian.show', $logSheet->id) }}" 
                                                               class="btn btn-sm btn-info">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                            
                                                            @if(auth()->user()->role === 'superadmin')
                                                                <a href="{{ route('maggot.log-sheet-harian.edit', $logSheet->id) }}" 
                                                                   class="btn btn-sm btn-warning">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                            @endif

                                                            <form action="{{ route('maggot.log-sheet-harian.destroy', $logSheet->id) }}" 
                                                                  method="POST" class="d-inline" 
                                                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-danger">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="10" class="text-center">Tidak ada data</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                
                                <div class="d-flex justify-content-center">
                                    {{ $logSheets->links() }}
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