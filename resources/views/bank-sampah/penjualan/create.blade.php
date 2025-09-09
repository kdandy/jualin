@extends('layouts.app')

@section('title', 'Tambah Penjualan')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
@endpush

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Tambah Penjualan</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
                    <div class="breadcrumb-item active"><a href="#">Bank Sampah</a></div>
                    <div class="breadcrumb-item active"><a href="{{ route('bank-sampah.penjualan.index') }}">Penjualan</a></div>
                    <div class="breadcrumb-item">Tambah</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Form Tambah Penjualan</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('bank-sampah.penjualan.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="tanggal">Tanggal <span class="text-danger">*</span></label>
                                                <input type="date" class="form-control @error('tanggal') is-invalid @enderror" 
                                                       id="tanggal" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                                                @error('tanggal')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="nama_barang">Nama Barang <span class="text-danger">*</span></label>
                                                <select class="form-control select2 @error('nama_barang') is-invalid @enderror" 
                                                        id="nama_barang" name="nama_barang_selector" required>
                                                    <option value="">Pilih Nama Barang</option>
                                                    @foreach($stokBarangs as $stok)
                                                        <option value="{{ $stok->nama_barang }}|{{ $stok->satuan }}" 
                                                                data-nama="{{ $stok->nama_barang }}"
                                                                data-satuan="{{ $stok->satuan }}" 
                                                                data-stok="{{ $stok->total_qty }}"
                                                                {{ old('nama_barang') == $stok->nama_barang ? 'selected' : '' }}>
                                                            {{ $stok->nama_barang }} ({{ $stok->satuan }}) - Stok: {{ number_format($stok->total_qty, 2) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="qty">Qty <span class="text-danger">*</span></label>
                                                <input type="number" step="0.01" class="form-control @error('qty') is-invalid @enderror" 
                                                       id="qty" name="qty" value="{{ old('qty') }}" required>
                                                @error('qty')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="satuan">Satuan</label>
                                                <input type="text" class="form-control" id="satuan" name="satuan_display" 
                                                       value="{{ old('satuan') }}" readonly>
                                                <input type="hidden" id="satuan_hidden" name="satuan" value="{{ old('satuan') }}">
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="stok_tersedia">Stok Tersedia</label>
                                                <input type="text" class="form-control" id="stok_tersedia" readonly>
                                                <input type="hidden" id="stok_awal" name="stok_awal" value="{{ old('stok_awal') }}">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="harga_jual">Harga Jual <span class="text-danger">*</span></label>
                                                <input type="number" step="0.01" class="form-control @error('harga_jual') is-invalid @enderror" 
                                                       id="harga_jual" name="harga_jual" value="{{ old('harga_jual') }}" required>
                                                @error('harga_jual')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="total_penjualan">Total Penjualan</label>
                                                <input type="number" step="0.01" class="form-control" 
                                                       id="total_penjualan" name="total_penjualan" value="{{ old('total_penjualan') }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="laba">Laba</label>
                                                <input type="number" step="0.01" class="form-control" 
                                                       id="laba" name="laba" value="{{ old('laba') }}" readonly>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="stok_akhir">Stok Akhir</label>
                                                <input type="number" step="0.01" class="form-control" 
                                                       id="stok_akhir" name="stok_akhir" value="{{ old('stok_akhir') }}" readonly>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="dokumen">Dokumen</label>
                                                <input type="file" class="form-control @error('dokumen') is-invalid @enderror" 
                                                       id="dokumen" name="dokumen" accept=".pdf,.jpg,.jpeg,.png">
                                                <small class="form-text text-muted">Format: PDF, JPG, JPEG, PNG. Maksimal 2MB.</small>
                                                @error('dokumen')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save"></i> Simpan
                                        </button>
                                        <a href="{{ route('bank-sampah.penjualan.index') }}" class="btn btn-secondary">
                                            <i class="fas fa-arrow-left"></i> Kembali
                                        </a>
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
    <!-- JS Libraries -->
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('library/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    
    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('.select2').select2({
                placeholder: 'Pilih Nama Barang',
                allowClear: true,
                width: '100%',
                closeOnSelect: true,
                minimumResultsForSearch: Infinity
            });
            
            // Handle nama barang selection
            $('#nama_barang').on('change', function() {
                var selectedOption = $(this).find('option:selected');
                var namaBarang = selectedOption.data('nama');
                var satuan = selectedOption.data('satuan');
                var stok = selectedOption.data('stok');
                
                // Set hidden fields for nama_barang and satuan
                $('#nama_barang_hidden').val(namaBarang || '');
                $('#satuan_hidden').val(satuan || '');
                $('#satuan').val(satuan || '');
                $('#stok_tersedia').val(stok ? parseFloat(stok).toFixed(2) + ' ' + satuan : '');
                $('#stok_awal').val(stok || 0);
                
                // Auto-fill qty with available stock
                $('#qty').val(stok ? parseFloat(stok).toFixed(2) : '');
                
                // Reset calculations
                calculateTotal();
            });
            
            // Handle qty and harga_jual changes
            $('#qty, #harga_jual').on('input', function() {
                calculateTotal();
            });
            
            function calculateTotal() {
                var qty = parseFloat($('#qty').val()) || 0;
                var hargaJual = parseFloat($('#harga_jual').val()) || 0;
                var stokAwal = parseFloat($('#stok_awal').val()) || 0;
                
                // Calculate total penjualan
                var totalPenjualan = qty * hargaJual;
                $('#total_penjualan').val(totalPenjualan.toFixed(2));
                
                // Calculate stok akhir
                var stokAkhir = stokAwal - qty;
                $('#stok_akhir').val(stokAkhir.toFixed(2));
                
                // For now, set laba as 20% of total penjualan (you can adjust this logic)
                var laba = totalPenjualan * 0.2;
                $('#laba').val(laba.toFixed(2));
            }
        });
    </script>
@endpush