@extends('layouts.app')

@section('title', 'Detail Barang Masuk')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Detail Barang Masuk</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
                    <div class="breadcrumb-item active"><a href="#">Bank Sampah</a></div>
                    <div class="breadcrumb-item active"><a href="{{ route('bank-sampah.barang-masuk.index') }}">Barang Masuk</a></div>
                    <div class="breadcrumb-item">Detail</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Detail Barang Masuk</h4>
                                <div class="card-header-action">
                                    <a href="{{ route('bank-sampah.barang-masuk.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left"></i> Kembali
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <table class="table table-borderless">
                                            <tbody>
                                                <tr>
                                                    <td width="200"><strong>Tanggal</strong></td>
                                                    <td>: {{ $barangMasuk->tanggal->format('d F Y') }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Pemasok</strong></td>
                                                    <td>: {{ $barangMasuk->pemasok }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Nama Barang</strong></td>
                                                    <td>: {{ $barangMasuk->nama_barang }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Quantity</strong></td>
                                                    <td>: {{ number_format($barangMasuk->qty, 2) }} {{ $barangMasuk->satuan }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Harga Beli</strong></td>
                                                    <td>: Rp {{ number_format($barangMasuk->harga_beli, 0, ',', '.') }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Total Pembelian</strong></td>
                                                    <td>: <span class="badge badge-success badge-lg">Rp {{ number_format($barangMasuk->total_pembelian, 0, ',', '.') }}</span></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Dibuat pada</strong></td>
                                                    <td>: {{ $barangMasuk->created_at->format('d F Y H:i') }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Terakhir diupdate</strong></td>
                                                    <td>: {{ $barangMasuk->updated_at->format('d F Y H:i') }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4>Dokumentasi</h4>
                                            </div>
                                            <div class="card-body text-center">
                                                @if($barangMasuk->dokumentasi)
                                                    <img src="{{ $barangMasuk->dokumentasi }}" 
                                                         alt="Dokumentasi {{ $barangMasuk->nama_barang }}" 
                                                         class="img-fluid rounded" 
                                                         style="max-height: 300px; cursor: pointer;"
                                                         onclick="showImageModal('{{ $barangMasuk->dokumentasi }}', '{{ addslashes($barangMasuk->nama_barang) }}');">
                                                    <br><br>
                                                    <a href="{{ $barangMasuk->dokumentasi }}" 
                                                       target="_blank" class="btn btn-primary btn-sm">
                                                        <i class="fas fa-download"></i> Download
                                                    </a>
                                                @else
                                                    <div class="empty-state" data-height="300">
                                                        <div class="empty-state-icon">
                                                            <i class="fas fa-image"></i>
                                                        </div>
                                                        <h2>Tidak ada dokumentasi</h2>
                                                        <p class="lead">Dokumentasi untuk barang ini belum tersedia.</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Image Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Dokumentasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" alt="" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script>
        function showImageModal(imageSrc, altText) {
            $('#modalImage').attr('src', imageSrc);
            $('#modalImage').attr('alt', 'Dokumentasi ' + altText);
            $('#imageModalLabel').text('Dokumentasi - ' + altText);
            $('#imageModal').modal('show');
        }
    </script>
@endpush