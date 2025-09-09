@extends('layouts.app')

@section('title', 'Tambah Barang Masuk')

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
                <h1>Tambah Barang Masuk</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
                    <div class="breadcrumb-item active"><a href="#">Bank Sampah</a></div>
                    <div class="breadcrumb-item active"><a href="{{ route('bank-sampah.barang-masuk.index') }}">Barang Masuk</a></div>
                    <div class="breadcrumb-item">Tambah</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Form Tambah Barang Masuk</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('bank-sampah.barang-masuk.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="tanggal">Tanggal <span class="text-danger">*</span></label>
                                                <input type="date" class="form-control @error('tanggal') is-invalid @enderror" 
                                                       id="tanggal" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required>
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
                                                       id="pemasok" name="pemasok" value="{{ old('pemasok') }}" 
                                                       placeholder="Masukkan nama pemasok" required>
                                                @error('pemasok')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Multi Barang Section -->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Daftar Barang <span class="text-danger">*</span></label>
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <h6 class="mb-0">Item Barang</h6>
                                                    <button type="button" class="btn btn-success btn-sm" id="addBarangBtn">
                                                        <i class="fas fa-plus"></i> Tambah Barang
                                                    </button>
                                                </div>
                                                
                                                <div id="barangContainer">
                                                    <!-- Item barang pertama -->
                                                    <div class="barang-item border rounded p-3 mb-3" data-index="0">
                                                        <div class="row">
                                                            <div class="col-md-12 mb-2">
                                                                <div class="d-flex justify-content-between align-items-center">
                                                                    <h6 class="mb-0">Barang #1</h6>
                                                                    <button type="button" class="btn btn-danger btn-sm remove-barang" style="display: none;">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label>Nama Barang <span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control nama-barang" 
                                                                           name="barang[0][nama_barang]" 
                                                                           placeholder="Masukkan nama barang" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>Quantity <span class="text-danger">*</span></label>
                                                                    <input type="number" step="0.01" class="form-control qty-input" 
                                                                           name="barang[0][qty]" 
                                                                           placeholder="0.00" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>Satuan <span class="text-danger">*</span></label>
                                                                    <select class="form-control satuan-select" name="barang[0][satuan]" required>
                                                                        <option value="">Pilih Satuan</option>
                                                                        <option value="kg">Kg</option>
                                                                        <option value="pcs">Pcs</option>
                                                                        <option value="liter">Liter</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>Harga Beli <span class="text-danger">*</span></label>
                                                                    <input type="number" step="0.01" class="form-control harga-input" 
                                                                           name="barang[0][harga_beli]" 
                                                                           placeholder="0.00" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Total Pembelian</label>
                                                                    <input type="text" class="form-control total-item" 
                                                                           placeholder="Akan dihitung otomatis" readonly>
                                                                </div>
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
                                                <label for="grand_total">Grand Total Pembelian</label>
                                                <input type="text" class="form-control" id="grand_total" 
                                                       placeholder="Akan dihitung otomatis" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="dokumentasi">Dokumentasi</label>
                                                <input type="file" class="form-control @error('dokumentasi') is-invalid @enderror" 
                                                       id="dokumentasi" name="dokumentasi" accept="image/*">
                                                <small class="form-text text-muted">Format: JPG, JPEG, PNG, GIF. Maksimal 2MB.</small>
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
                                                <i class="fas fa-save"></i> Simpan
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
            let barangIndex = 1;

            // Function to calculate total for individual item
            function calculateItemTotal(item) {
                const qty = parseFloat(item.find('.qty-input').val()) || 0;
                const harga = parseFloat(item.find('.harga-input').val()) || 0;
                const total = qty * harga;
                
                item.find('.total-item').val('Rp ' + total.toLocaleString('id-ID', {
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                }));
                
                calculateGrandTotal();
            }

            // Function to calculate grand total
            function calculateGrandTotal() {
                let grandTotal = 0;
                $('.barang-item').each(function() {
                    const qty = parseFloat($(this).find('.qty-input').val()) || 0;
                    const harga = parseFloat($(this).find('.harga-input').val()) || 0;
                    grandTotal += qty * harga;
                });
                
                $('#grand_total').val('Rp ' + grandTotal.toLocaleString('id-ID', {
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                }));
            }

            // Function to update item numbers
            function updateItemNumbers() {
                $('.barang-item').each(function(index) {
                    $(this).find('h6').first().text('Barang #' + (index + 1));
                    $(this).attr('data-index', index);
                    
                    // Update input names
                    $(this).find('input, select').each(function() {
                        const name = $(this).attr('name');
                        if (name) {
                            const newName = name.replace(/\[\d+\]/, '[' + index + ']');
                            $(this).attr('name', newName);
                        }
                    });
                });
                
                // Show/hide remove buttons
                const itemCount = $('.barang-item').length;
                if (itemCount > 1) {
                    $('.remove-barang').show();
                } else {
                    $('.remove-barang').hide();
                }
            }

            // Add new barang item
            $('#addBarangBtn').click(function() {
                const newItem = `
                    <div class="barang-item border rounded p-3 mb-3" data-index="${barangIndex}">
                        <div class="row">
                            <div class="col-md-12 mb-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">Barang #${barangIndex + 1}</h6>
                                    <button type="button" class="btn btn-danger btn-sm remove-barang">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Nama Barang <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control nama-barang" 
                                           name="barang[${barangIndex}][nama_barang]" 
                                           placeholder="Masukkan nama barang" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Quantity <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" class="form-control qty-input" 
                                           name="barang[${barangIndex}][qty]" 
                                           placeholder="0.00" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Satuan <span class="text-danger">*</span></label>
                                    <select class="form-control satuan-select" name="barang[${barangIndex}][satuan]" required>
                                        <option value="">Pilih Satuan</option>
                                        <option value="kg">Kg</option>
                                        <option value="pcs">Pcs</option>
                                        <option value="liter">Liter</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Harga Beli <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" class="form-control harga-input" 
                                           name="barang[${barangIndex}][harga_beli]" 
                                           placeholder="0.00" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Total Pembelian</label>
                                    <input type="text" class="form-control total-item" 
                                           placeholder="Akan dihitung otomatis" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                
                $('#barangContainer').append(newItem);
                barangIndex++;
                updateItemNumbers();
            });

            // Remove barang item
            $(document).on('click', '.remove-barang', function() {
                $(this).closest('.barang-item').remove();
                updateItemNumbers();
                calculateGrandTotal();
            });

            // Calculate totals when qty or harga changes
            $(document).on('input', '.qty-input, .harga-input', function() {
                const item = $(this).closest('.barang-item');
                calculateItemTotal(item);
            });

            // Initial calculation
            calculateGrandTotal();
        });
    </script>
@endpush