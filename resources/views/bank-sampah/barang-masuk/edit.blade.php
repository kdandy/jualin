@extends('layouts.app')

@section('title', 'Edit Barang Masuk')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
@endpush

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Barang Masuk</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
                    <div class="breadcrumb-item active"><a href="#">Bank Sampah</a></div>
                    <div class="breadcrumb-item active"><a href="{{ route('bank-sampah.barang-masuk.index') }}">Barang Masuk</a></div>
                    <div class="breadcrumb-item">Edit</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Form Edit Barang Masuk</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('bank-sampah.barang-masuk.update', $barangMasuk->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="tanggal">Tanggal <span class="text-danger">*</span></label>
                                                <input type="date" class="form-control @error('tanggal') is-invalid @enderror" 
                                                       id="tanggal" name="tanggal" value="{{ old('tanggal', $barangMasuk->tanggal) }}" required>
                                                @error('tanggal')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="pemasok">Pemasok <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control @error('pemasok') is-invalid @enderror" 
                                                       id="pemasok" name="pemasok" value="{{ old('pemasok', $barangMasuk->pemasok) }}" 
                                                       placeholder="Masukkan nama pemasok" required>
                                                @error('pemasok')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Single Barang Section for Edit -->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Data Barang <span class="text-danger">*</span></label>
                                                
                                                <div class="border rounded p-3 mb-3">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>Nama Barang <span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control @error('nama_barang') is-invalid @enderror" 
                                                                       name="nama_barang" value="{{ old('nama_barang', $barangMasuk->nama_barang) }}"
                                                                       placeholder="Masukkan nama barang" required>
                                                                @error('nama_barang')
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>Quantity <span class="text-danger">*</span></label>
                                                                <input type="number" step="0.01" class="form-control @error('qty') is-invalid @enderror qty-input" 
                                                                       name="qty" value="{{ old('qty', $barangMasuk->qty) }}"
                                                                       placeholder="0.00" required>
                                                                @error('qty')
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>Satuan <span class="text-danger">*</span></label>
                                                                <select class="form-control @error('satuan') is-invalid @enderror satuan-select" name="satuan" required>
                                                                    <option value="">Pilih Satuan</option>
                                                                    <option value="kg" {{ old('satuan', $barangMasuk->satuan) == 'kg' ? 'selected' : '' }}>Kg</option>
                                                                    <option value="pcs" {{ old('satuan', $barangMasuk->satuan) == 'pcs' ? 'selected' : '' }}>Pcs</option>
                                                                    <option value="liter" {{ old('satuan', $barangMasuk->satuan) == 'liter' ? 'selected' : '' }}>Liter</option>
                                                                </select>
                                                                @error('satuan')
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>Harga Beli <span class="text-danger">*</span></label>
                                                                <input type="number" step="0.01" class="form-control @error('harga_beli') is-invalid @enderror harga-input" 
                                                                       name="harga_beli" value="{{ old('harga_beli', $barangMasuk->harga_beli) }}"
                                                                       placeholder="0.00" required>
                                                                @error('harga_beli')
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Total Pembelian</label>
                                                                <input type="text" class="form-control total-item" 
                                                                       value="Rp {{ number_format($barangMasuk->total_pembelian, 0, ',', '.') }}"
                                                                       placeholder="Akan dihitung otomatis" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="dokumentasi">Dokumentasi</label>
                                                <input type="file" class="form-control @error('dokumentasi') is-invalid @enderror" 
                                                       id="dokumentasi" name="dokumentasi" accept="image/*">
                                                <small class="form-text text-muted">Format: JPG, JPEG, PNG, GIF. Maksimal 2MB. Kosongkan jika tidak ingin mengubah.</small>
                                                @if($barangMasuk->dokumentasi)
                                                    <div class="mt-2">
                                                        <small class="text-info">File saat ini: <a href="{{ $barangMasuk->dokumentasi }}" target="_blank">Lihat Dokumentasi</a></small>
                                                    </div>
                                                @endif
                                                @error('dokumentasi')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="d-flex justify-content-between">
                                            <a href="{{ route('bank-sampah.barang-masuk.index') }}" class="btn btn-secondary">
                                                <i class="fas fa-arrow-left"></i> Batal
                                            </a>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-save"></i> Update
                                            </button>
                                        </div>
                                    </div>
                                </form>
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
    <script src="{{ asset('library/cleave.js/dist/cleave.min.js') }}"></script>
    <script src="{{ asset('library/cleave.js/dist/addons/cleave-phone.us.js') }}"></script>
    <script src="{{ asset('library/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('library/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script>
    <script src="{{ asset('library/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
    <script src="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script>
        $(document).ready(function() {
            // Function to calculate total
            function calculateTotal() {
                const qty = parseFloat($('.qty-input').val()) || 0;
                const harga = parseFloat($('.harga-input').val()) || 0;
                const total = qty * harga;
                
                $('.total-item').val('Rp ' + total.toLocaleString('id-ID', {
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                }));
            }

            // Calculate total when qty or harga changes
            $('.qty-input, .harga-input').on('input', function() {
                calculateTotal();
            });

            // Initial calculation
            calculateTotal();
        });
    </script>
@endpush