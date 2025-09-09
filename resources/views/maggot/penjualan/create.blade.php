@extends('layouts.app')

@section('title', 'Tambah Penjualan Maggot')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Tambah Penjualan Maggot</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="{{ route('maggot.penjualan.index') }}">Maggot</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('maggot.penjualan.index') }}">Penjualan</a></div>
                    <div class="breadcrumb-item active">Tambah</div>
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
                                <form action="{{ route('maggot.penjualan.store') }}" method="POST">
                                    @csrf
                                    
                                    <div class="form-group row">
                                        <label for="no" class="col-sm-3 col-form-label">No Penjualan <span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control @error('no') is-invalid @enderror" 
                                                   id="no" name="no" value="{{ old('no') }}" 
                                                   placeholder="Masukkan nomor penjualan" required>
                                            @error('no')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="tanggal" class="col-sm-3 col-form-label">Tanggal <span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="date" class="form-control @error('tanggal') is-invalid @enderror" 
                                                   id="tanggal" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                                            @error('tanggal')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="produk" class="col-sm-3 col-form-label">Produk <span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control @error('produk') is-invalid @enderror" 
                                                   id="produk" name="produk" value="{{ old('produk') }}" 
                                                   placeholder="Masukkan nama produk" required>
                                            @error('produk')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="qty" class="col-sm-3 col-form-label">Quantity <span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="number" class="form-control @error('qty') is-invalid @enderror" 
                                                   id="qty" name="qty" value="{{ old('qty') }}" 
                                                   placeholder="Masukkan jumlah" min="1" required>
                                            @error('qty')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="harga" class="col-sm-3 col-form-label">Harga <span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="number" class="form-control @error('harga') is-invalid @enderror" 
                                                   id="harga" name="harga" value="{{ old('harga') }}" 
                                                   placeholder="Masukkan harga" min="0" step="0.01" required>
                                            @error('harga')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="total" class="col-sm-3 col-form-label">Total</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="total" name="total_display" 
                                                   placeholder="Total akan dihitung otomatis" readonly>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-9 offset-sm-3">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-save"></i> Simpan
                                            </button>
                                            <a href="{{ route('maggot.penjualan.index') }}" class="btn btn-secondary">
                                                <i class="fas fa-arrow-left"></i> Kembali
                                            </a>
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
    <script>
        $(document).ready(function() {
            // Calculate total when qty or harga changes
            $('#qty, #harga').on('input', function() {
                var qty = parseFloat($('#qty').val()) || 0;
                var harga = parseFloat($('#harga').val()) || 0;
                var total = qty * harga;
                
                $('#total').val(total.toLocaleString('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0
                }));
            });
        });
    </script>
@endpush