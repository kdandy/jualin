@extends('layouts.app')

@section('title', 'Tambah Log Sheet Harian')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
@endpush

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Tambah Log Sheet Harian</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Maggot</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('maggot.log-sheet-harian.index') }}">Log Sheet Harian</a></div>
                    <div class="breadcrumb-item">Tambah</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Form Tambah Log Sheet Harian</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('maggot.log-sheet-harian.store') }}" method="POST" enctype="multipart/form-data">
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
                                                <label for="media">Media</label>
                                                <input type="text" class="form-control @error('media') is-invalid @enderror" 
                                                       id="media" name="media" value="{{ old('media') }}" 
                                                       placeholder="Contoh: Sampah organik, dedak, dll">
                                                @error('media')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="suhu">Suhu Ruang/Wadah (°C) <span class="text-danger">*</span></label>
                                                <input type="number" step="0.01" min="0" max="100" 
                                                       class="form-control @error('suhu') is-invalid @enderror" 
                                                       id="suhu" name="suhu" value="{{ old('suhu') }}" required>
                                                @error('suhu')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="kelembapan">Kelembapan Ruang/Wadah (%) <span class="text-danger">*</span></label>
                                                <input type="number" step="0.01" min="0" max="100" 
                                                       class="form-control @error('kelembapan') is-invalid @enderror" 
                                                       id="kelembapan" name="kelembapan" value="{{ old('kelembapan') }}" required>
                                                @error('kelembapan')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="berat_limbah">Berat Limbah (kg) <span class="text-danger">*</span></label>
                                                <input type="number" step="0.01" min="0" 
                                                       class="form-control @error('berat_limbah') is-invalid @enderror" 
                                                       id="berat_limbah" name="berat_limbah" value="{{ old('berat_limbah') }}" required>
                                                @error('berat_limbah')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="fase_kehidupan">Fase Kehidupan <span class="text-danger">*</span></label>
                                                <select class="form-control select2 @error('fase_kehidupan') is-invalid @enderror" 
                                                        id="fase_kehidupan" name="fase_kehidupan" required>
                                                    <option value="">Pilih Fase Kehidupan</option>
                                                    @foreach($faseKehidupan as $key => $value)
                                                        <option value="{{ $key }}" {{ old('fase_kehidupan') == $key ? 'selected' : '' }}>
                                                            {{ $value }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('fase_kehidupan')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="jenis_sampah">Jenis Sampah</label>
                                                <input type="text" class="form-control @error('jenis_sampah') is-invalid @enderror" 
                                                       id="jenis_sampah" name="jenis_sampah" value="{{ old('jenis_sampah') }}" 
                                                       placeholder="Contoh: Sayuran, buah-buahan, dll">
                                                @error('jenis_sampah')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="berat_kasgot">Berat Kasgot (kg) <span class="text-danger">*</span></label>
                                                <input type="number" step="0.01" min="0" 
                                                       class="form-control @error('berat_kasgot') is-invalid @enderror" 
                                                       id="berat_kasgot" name="berat_kasgot" value="{{ old('berat_kasgot') }}" required>
                                                @error('berat_kasgot')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="dokumentasi">Dokumentasi</label>
                                        <input type="file" class="form-control @error('dokumentasi') is-invalid @enderror" 
                                               id="dokumentasi" name="dokumentasi" accept=".pdf,.jpg,.jpeg,.png">
                                        <small class="form-text text-muted">Format yang diizinkan: PDF, JPG, JPEG, PNG. Maksimal 2MB.</small>
                                        @error('dokumentasi')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <div class="d-flex justify-content-between">
                                            <a href="{{ route('maggot.log-sheet-harian.index') }}" class="btn btn-secondary">
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
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('library/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

    <!-- Page Specific JS File -->
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
@endpush