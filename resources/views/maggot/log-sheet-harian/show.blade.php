@extends('layouts.app')

@section('title', 'Detail Log Sheet Harian')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Detail Log Sheet Harian</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Maggot</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('maggot.log-sheet-harian.index') }}">Log Sheet Harian</a></div>
                    <div class="breadcrumb-item">Detail</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Detail Log Sheet Harian - {{ $logSheetHarian->tanggal->format('d/m/Y') }}</h4>
                                <div class="card-header-action">
                                    <a href="{{ route('maggot.log-sheet-harian.edit', $logSheetHarian->id) }}" class="btn btn-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a href="{{ route('maggot.log-sheet-harian.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left"></i> Kembali
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td width="200"><strong>Tanggal</strong></td>
                                                <td>: {{ $logSheetHarian->tanggal->format('d/m/Y') }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Media</strong></td>
                                                <td>: {{ $logSheetHarian->media ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Suhu Ruang/Wadah</strong></td>
                                                <td>: {{ $logSheetHarian->suhu }}°C</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Kelembapan Ruang/Wadah</strong></td>
                                                <td>: {{ $logSheetHarian->kelembapan }}%</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Berat Limbah</strong></td>
                                                <td>: {{ $logSheetHarian->berat_limbah }} kg</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td width="200"><strong>Fase Kehidupan</strong></td>
                                                <td>: {{ $logSheetHarian->fase_kehidupan }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Jenis Sampah</strong></td>
                                                <td>: {{ $logSheetHarian->jenis_sampah ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Berat Kasgot</strong></td>
                                                <td>: {{ $logSheetHarian->berat_kasgot }} kg</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Dibuat</strong></td>
                                                <td>: {{ $logSheetHarian->created_at->format('d/m/Y H:i') }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Diperbarui</strong></td>
                                                <td>: {{ $logSheetHarian->updated_at->format('d/m/Y H:i') }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                @if($logSheetHarian->dokumentasi)
                                    <div class="row mt-4">
                                        <div class="col-12">
                                            <h5>Dokumentasi</h5>
                                            <div class="mt-2">
                                                @php
                                                    $extension = pathinfo($logSheetHarian->dokumentasi, PATHINFO_EXTENSION);
                                                    $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png']);
                                                @endphp
                                                
                                                @if($isImage)
                                                    <img src="{{ $logSheetHarian->dokumentasi }}" 
                                                         alt="Dokumentasi" class="img-fluid" style="max-width: 500px; max-height: 400px;">
                                                @else
                                                    <a href="{{ $logSheetHarian->dokumentasi }}" 
                                                       target="_blank" class="btn btn-info">
                                                        <i class="fas fa-file-pdf"></i> Lihat Dokumen
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
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