@extends('layouts.app')

@section('title', 'Dashboard')

@push('css')
<style>
    :root {
        --primary-color: #4f46e5;
        --secondary-color: #6366f1;
        --success-color: #10b981;
        --warning-color: #f59e0b;
        --danger-color: #ef4444;
        --info-color: #3b82f6;
        --light-color: #f3f4f6;
        --dark-color: #1f2937;
        --gray-50: #f9fafb;
        --gray-100: #f3f4f6;
        --gray-200: #e5e7eb;
        --gray-300: #d1d5db;
        --gray-600: #4b5563;
        --gray-700: #374151;
        --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
    
    .dashboard-card {
        border: none;
        border-radius: 12px;
        box-shadow: var(--shadow);
        margin-bottom: 25px;
        background: white;
        transition: all 0.3s ease;
        border: 1px solid var(--gray-200);
    }
    
    .dashboard-card:hover {
        transform: translateY(-1px);
        box-shadow: var(--shadow-lg);
    }
    
    .dashboard-card .card-header {
        background: var(--gray-50);
        border-bottom: 1px solid var(--gray-200);
        padding: 20px 25px;
        border-radius: 12px 12px 0 0;
    }
    
    .stat-card {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        padding: 25px;
        border-radius: 12px;
        text-align: center;
        box-shadow: var(--shadow);
        transition: all 0.3s ease;
        margin-bottom: 20px;
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }
    
    .stat-card.stat-card-success {
        background: linear-gradient(135deg, var(--success-color), #059669);
    }
    
    .stat-card.stat-card-info {
        background: linear-gradient(135deg, var(--info-color), #2563eb);
    }
    
    .stat-card.stat-card-warning {
        background: linear-gradient(135deg, var(--warning-color), #d97706);
    }
    
    .stat-icon {
        font-size: 2.5rem;
        opacity: 0.8;
        margin-bottom: 15px;
    }
    
    .stat-number {
        font-size: 2.2rem;
        font-weight: 700;
        margin-bottom: 5px;
    }
    
    .stat-label {
        font-size: 0.9rem;
        opacity: 0.9;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    .welcome-card {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        border-radius: 16px;
        padding: 40px;
        margin-bottom: 30px;
        text-align: center;
        position: relative;
        overflow: hidden;
        box-shadow: var(--shadow-lg);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .welcome-card::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: radial-gradient(circle at 20% 20%, rgba(255,255,255,0.1) 0%, transparent 50%),
                    radial-gradient(circle at 80% 80%, rgba(255,255,255,0.05) 0%, transparent 50%);
        pointer-events: none;
        opacity: 0.8;
    }
    
    .welcome-title {
        font-size: 2.5rem;
        font-weight: 300;
        margin-bottom: 10px;
        position: relative;
        z-index: 1;
    }
    
    .welcome-subtitle {
        font-size: 1.1rem;
        opacity: 0.9;
        position: relative;
        z-index: 1;
    }
    
    .activity-card {
        border: none;
        border-radius: 12px;
        box-shadow: var(--shadow);
        margin-bottom: 25px;
        background: white;
        border: 1px solid var(--gray-200);
        transition: all 0.3s ease;
    }
    
    .activity-card:hover {
        transform: translateY(-1px);
        box-shadow: var(--shadow-lg);
    }
    
    .activity-card .card-header {
        background: var(--gray-50);
        border-bottom: 1px solid var(--gray-200);
        padding: 20px 25px;
        border-radius: 12px 12px 0 0;
    }
    
    .activity-item {
        display: flex;
        align-items: flex-start;
        padding: 20px 0;
        border-bottom: 1px solid var(--gray-200);
        transition: all 0.2s ease;
    }
    
    .activity-item:last-child {
        border-bottom: none;
    }
    
    .activity-item:hover {
        background: var(--gray-50);
        margin: 0 -25px;
        padding: 20px 25px;
        border-radius: 8px;
    }
    
    .activity-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        flex-shrink: 0;
    }
    
    .activity-icon i {
        color: white;
        font-size: 16px;
    }
    
    .activity-content {
        flex: 1;
    }
    
    .activity-title {
        font-weight: 600;
        color: var(--dark-color);
        margin-bottom: 5px;
        font-size: 15px;
    }
    
    .activity-desc {
        color: var(--gray-600);
        font-size: 14px;
        margin-bottom: 5px;
        line-height: 1.4;
    }
    
    .activity-time {
        color: var(--gray-600);
        font-size: 12px;
        font-weight: 500;
    }
    
    .activity-icon.success {
        background: linear-gradient(135deg, var(--success-color), #059669);
    }
    
    .activity-icon.info {
        background: linear-gradient(135deg, var(--info-color), #2563eb);
    }
    
    .activity-icon.warning {
        background: linear-gradient(135deg, var(--warning-color), #d97706);
    }
    
    .quick-action-btn {
        display: block;
        padding: 25px 20px;
        text-align: center;
        background: white;
        border: 1px solid var(--gray-200);
        border-radius: 12px;
        color: var(--gray-600);
        text-decoration: none;
        transition: all 0.3s ease;
        font-weight: 500;
        box-shadow: var(--shadow);
        margin-bottom: 15px;
    }
    
    .quick-action-btn i {
        font-size: 24px;
        display: block;
        color: var(--gray-600);
    }
    
    .quick-action-btn:hover {
        border-color: var(--primary-color);
        color: var(--primary-color);
        text-decoration: none;
        transform: translateY(-1px);
        box-shadow: var(--shadow-lg);
        background: var(--gray-50);
    }
    
    .quick-action-btn:hover i {
        color: var(--primary-color);
    }
    
    .quick-action-icon {
        font-size: 2rem;
        margin-bottom: 10px;
        display: block;
    }
    
    .section-title {
        font-size: 1.4rem;
        font-weight: 600;
        color: #2d3436;
        margin-bottom: 20px;
        position: relative;
        padding-left: 15px;
    }
    
    .section-title::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 4px;
        height: 20px;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        border-radius: 2px;
    }
    
    .main-content {
        background: #f8f9fa;
        min-height: 100vh;
    }
    
    .main-content .section-body {
        padding: 0;
    }
</style>
@endpush

@section('content')
<!-- Responsive Dashboard Header with Navigation -->
<div class="section-header bg-white shadow-sm" style="border-radius: 10px; padding: 15px 20px; margin-bottom: 20px;">
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center w-100">
        <div class="mb-3 mb-lg-0">
            <h1 class="mb-1 h3 h1-lg" style="color: #4f46e5; font-weight: 600;">
                <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
            </h1>
            <div class="section-header-breadcrumb mb-0">
                <div class="breadcrumb-item active">Dashboard Overview</div>
            </div>
        </div>
        
        <!-- Mobile Menu Toggle -->
        <button class="btn btn-outline-primary d-lg-none mb-3" type="button" data-toggle="collapse" data-target="#dashboardNav" aria-controls="dashboardNav" aria-expanded="false">
            <i class="fas fa-bars"></i> Menu
        </button>
        
        <!-- Navigation Menu -->
        <div class="collapse d-lg-flex" id="dashboardNav">
            <div class="navbar-nav d-flex flex-column flex-lg-row">
                @if(auth()->user()->role == 'admin' || auth()->user()->role == 'superadmin')
                <div class="nav-item dropdown mb-2 mb-lg-0 mr-lg-3">
                    <a class="nav-link dropdown-toggle" href="#" id="bankSampahDropdown" role="button" data-toggle="dropdown">
                        <i class="fas fa-recycle mr-1"></i><span class="d-lg-inline">Bank Sampah</span>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ url('bank-sampah/barang-masuk') }}">
                            <i class="fas fa-plus-circle mr-2"></i>Barang Masuk
                        </a>
                        <a class="dropdown-item" href="{{ url('bank-sampah/stok-barang') }}">
                            <i class="fas fa-boxes mr-2"></i>Stok Barang
                        </a>
                        <a class="dropdown-item" href="{{ url('bank-sampah/penjualan') }}">
                            <i class="fas fa-shopping-cart mr-2"></i>Penjualan
                        </a>
                    </div>
                </div>
                @endif
                
                @if(auth()->user()->role == 'superadmin')
                <div class="nav-item dropdown mb-2 mb-lg-0 mr-lg-3">
                    <a class="nav-link dropdown-toggle" href="#" id="maggotDropdown" role="button" data-toggle="dropdown">
                        <i class="fas fa-bug mr-1"></i><span class="d-lg-inline">Maggot</span>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ url('maggot/log-sheet-harian') }}">
                            <i class="fas fa-clipboard-list mr-2"></i>Log Sheet Harian
                        </a>
                        <a class="dropdown-item" href="{{ url('maggot/pembelian') }}">
                            <i class="fas fa-shopping-bag mr-2"></i>Pembelian
                        </a>
                        <a class="dropdown-item" href="{{ url('maggot/penjualan-maggot') }}">
                            <i class="fas fa-hand-holding-usd mr-2"></i>Penjualan Maggot
                        </a>
                    </div>
                </div>
                
                <a class="nav-link mb-2 mb-lg-0 mr-lg-3" href="{{ url('hakakses') }}">
                    <i class="fas fa-user-shield mr-1"></i><span class="d-lg-inline">Hak Akses</span>
                </a>
                @endif
                
                <a class="nav-link mb-2 mb-lg-0" href="{{ url('profile-usaha/tentang-kami') }}">
                    <i class="fas fa-building mr-1"></i><span class="d-lg-inline">Profile Usaha</span>
                </a>
            </div>
        </div>
    </div>
</div>

@if (session('status'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle mr-2"></i>
        {{ session('status') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<!-- Welcome Section -->
<div class="row">
    <div class="col-12">
        <div class="welcome-card">
            <h2 class="welcome-title">Selamat Datang, {{ auth()->user()->name }}!</h2>
            <p class="welcome-subtitle">Kelola sistem Bank Sampah Purwokeling dengan mudah dan efisien</p>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row">
    @if(isset($data['bank_sampah']))
        <!-- Bank Sampah Statistics -->
        <div class="col-lg-{{ auth()->user()->role == 'superadmin' ? '3' : '4' }} col-md-6 col-sm-6 col-12">
            <div class="stat-card stat-card-info">
                <div class="stat-icon">
                    <i class="fas fa-recycle"></i>
                </div>
                <div class="stat-number">{{ number_format($data['bank_sampah']['total_sampah_bulan_ini'], 1) }}</div>
                <div class="stat-label">Kg Sampah (Bulan Ini)</div>
            </div>
        </div>
        <div class="col-lg-{{ auth()->user()->role == 'superadmin' ? '3' : '4' }} col-md-6 col-sm-6 col-12">
            <div class="stat-card stat-card-success">
                <div class="stat-icon">
                    <i class="fas fa-coins"></i>
                </div>
                <div class="stat-number">Rp {{ number_format($data['bank_sampah']['total_penjualan'], 0, ',', '.') }}</div>
                <div class="stat-label">Total Penjualan Bank Sampah</div>
            </div>
        </div>
        <div class="col-lg-{{ auth()->user()->role == 'superadmin' ? '3' : '4' }} col-md-6 col-sm-6 col-12">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="stat-number">{{ $data['bank_sampah']['total_transaksi_bulan_ini'] }}</div>
                <div class="stat-label">Transaksi (Bulan Ini)</div>
            </div>
        </div>
    @endif
    
    @if(isset($data['maggot']))
        <!-- Maggot Statistics (Superadmin only) -->
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="stat-card stat-card-warning">
                <div class="stat-icon">
                    <i class="fas fa-bug"></i>
                </div>
                <div class="stat-number">{{ number_format($data['maggot']['total_produksi_bulan_ini'], 1) }}kg</div>
                <div class="stat-label">Produksi Maggot (Bulan Ini)</div>
            </div>
        </div>
        @if(auth()->user()->role == 'superadmin')
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="stat-card stat-card-success">
                <div class="stat-icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <div class="stat-number">Rp {{ number_format($data['maggot']['total_penjualan'], 0, ',', '.') }}</div>
                <div class="stat-label">Total Penjualan Maggot</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <div class="stat-number">{{ $data['maggot']['total_log_sheet_bulan_ini'] }}</div>
                <div class="stat-label">Log Sheet (Bulan Ini)</div>
            </div>
        </div>
        @endif
    @endif
</div>

<!-- Main Content Row -->
<div class="row">
    <!-- Quick Actions -->
    <div class="col-lg-4 col-md-6">
        <div class="card dashboard-card">
            <div class="card-header">
                <h4 class="section-title">Aksi Cepat</h4>
            </div>
            <div class="card-body">
                @if(auth()->user()->role == 'admin' || auth()->user()->role == 'superadmin')
                    <!-- Bank Sampah Actions -->
                    <a href="{{ url('bank-sampah/barang-masuk/create') }}" class="quick-action-btn">
                        <i class="fas fa-plus-circle quick-action-icon"></i>
                        <strong>Tambah Barang Masuk</strong>
                    </a>
                    <a href="{{ url('bank-sampah/penjualan/create') }}" class="quick-action-btn">
                        <i class="fas fa-shopping-cart quick-action-icon"></i>
                        <strong>Tambah Penjualan</strong>
                    </a>
                    <a href="{{ url('bank-sampah/stok-barang') }}" class="quick-action-btn">
                        <i class="fas fa-boxes quick-action-icon"></i>
                        <strong>Lihat Stok Barang</strong>
                    </a>
                @endif
                
                @if(auth()->user()->role == 'superadmin')
                    <!-- Maggot Actions -->
                    <a href="{{ url('maggot/log-sheet-harian/create') }}" class="quick-action-btn">
                        <i class="fas fa-bug quick-action-icon"></i>
                        <strong>Tambah Log Sheet</strong>
                    </a>
                    <a href="{{ url('maggot/penjualan-maggot/create') }}" class="quick-action-btn">
                        <i class="fas fa-money-bill-wave quick-action-icon"></i>
                        <strong>Penjualan Maggot</strong>
                    </a>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Recent Activities -->
    <div class="col-lg-8 col-md-6">
        <div class="card dashboard-card activity-card">
            <div class="card-header">
                <h4 class="section-title">Aktivitas Terbaru</h4>
            </div>
            <div class="card-body">
                @if(isset($data['aktivitas_terbaru']) && count($data['aktivitas_terbaru']) > 0)
                    @foreach($data['aktivitas_terbaru'] as $aktivitas)
                        <div class="activity-item">
                            @php
                                $gradientColors = [
                                    'success' => 'linear-gradient(135deg, #10b981, #059669)',
                                    'info' => 'linear-gradient(135deg, #06b6d4, #0891b2)',
                                    'warning' => 'linear-gradient(135deg, #f59e0b, #d97706)',
                                    'default' => 'linear-gradient(135deg, #3b82f6, #2563eb)'
                                ];
                                $gradient = $gradientColors[$aktivitas['color']] ?? $gradientColors['default'];
                            @endphp
                            <div class="activity-icon" style="background: {!! $gradient !!};">
                                <i class="{{ $aktivitas['icon'] }}"></i>
                            </div>
                            <div class="activity-content">
                                <div class="activity-title">{{ $aktivitas['title'] }}</div>
                                <div class="activity-desc">{{ $aktivitas['description'] }}</div>
                                <div class="activity-time">{{ $aktivitas['time'] }}</div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Belum ada aktivitas terbaru</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
