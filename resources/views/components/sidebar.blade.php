@auth
<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
        <a href="">
            <div style="line-height: 2;">
                <div style="font-size: 16px; font-weight: 600;">Bank Sampah</div>
                <div style="font-size: 14px; font-weight: 500;">Purwokeling</div>
            </div>
        </a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
        <a href="">BSP</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="{{ Request::is('home') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('home') }}"><i class="fas fa-fire"></i><span>Dashboard</span></a>
            </li>
            @if (Auth::user()->role == 'superadmin')
            <li class="menu-header">Hak Akses</li>
            <li class="{{ Request::is('hakakses') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('hakakses') }}"><i class="fas fa-user-shield"></i> <span>Hak Akses</span></a>
            </li>
            @endif
            <!-- profile ganti password -->
            <li class="menu-header">Profile</li>
            <li class="{{ Request::is('profile/edit') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('profile/edit') }}"><i class="far fa-user"></i> <span>Profile</span></a>
            </li>
            <li class="{{ Request::is('profile/change-password') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('profile/change-password') }}"><i class="fas fa-key"></i> <span>Ganti Password</span></a>
            </li>
            
            <!-- Bank Sampah Menu -->
            @if(auth()->user()->role == 'admin' || auth()->user()->role == 'superadmin')
            <li class="menu-header">Bank Sampah</li>
            <li class="dropdown {{ Request::is('bank-sampah/*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-recycle"></i><span>Bank Sampah</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('bank-sampah/barang-masuk*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('bank-sampah/barang-masuk') }}">Barang Masuk</a>
                    </li>
                    <li class="{{ Request::is('bank-sampah/stok-barang*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('bank-sampah/stok-barang') }}">Stok Barang</a>
                    </li>
                    <li class="{{ Request::is('bank-sampah/penjualan*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('bank-sampah/penjualan') }}">Penjualan</a>
                    </li>
                </ul>
            </li>
            @endif
            
            @if(auth()->user()->role == 'superadmin')
            <li class="menu-header">Maggot</li>
            <li class="dropdown {{ Request::is('maggot/*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-bug"></i><span>Maggot</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('maggot/log-sheet-harian*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('maggot/log-sheet-harian') }}">Log Sheet Harian</a>
                    </li>
                    <li class="{{ Request::is('maggot/pembelian*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('maggot/pembelian') }}">Pembelian</a>
                    </li>
                    <li class="{{ Request::is('maggot/penjualan-maggot*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('maggot/penjualan') }}">Penjualan Maggot</a>
                    </li>
                </ul>
            </li>
            @endif

            <!-- Profile Usaha Menu -->
            @if(auth()->user()->role == 'admin' || auth()->user()->role == 'superadmin')
            <li class="menu-header">Profile Usaha</li>
            <li class="dropdown {{ Request::is('profile-usaha/*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-building"></i><span>Profile Usaha</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('profile-usaha/tentang-kami*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('profile-usaha/tentang-kami') }}">Tentang Kami</a>
                    </li>
                </ul>
            </li>
            @endif
            

        </ul>
    </aside>
</div>
@endauth
