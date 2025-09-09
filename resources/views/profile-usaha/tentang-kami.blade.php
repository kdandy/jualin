@extends('layouts.app')

@section('title', 'Tentang Kami')

@push('css')
    <!-- CSS Libraries -->
@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Tentang Kami</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ url('/home') }}">Dashboard</a></div>
                <div class="breadcrumb-item active"><a href="#">Profile Usaha</a></div>
                <div class="breadcrumb-item">Tentang Kami</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Bank Sampah Purwokeling</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="text-justify">
                                        <p><strong>Bank Sampah Purwokeling</strong> berdiri pada <strong>26 Desember 2022</strong> sebagai bentuk kepedulian terhadap kondisi lingkungan dan untuk menjawab kebutuhan akan sistem pengelolaan sampah yang lebih terstruktur di tingkat masyarakat. Dengan semangat gotong royong dan semangat inovasi, Bank Sampah Purwokeling hadir untuk memberikan solusi konkret dalam pengelolaan sampah, khususnya di lingkungan RW X Kelurahan Purwoyoso.</p>
                                        
                                        <p>Salah satu inovasi unggulan kami adalah pengembangan <strong>budidaya maggot BSF (Black Soldier Fly)</strong> yang terbukti efektif dan ramah lingkungan dalam menguraikan sampah organik. Maggot mampu mengurangi volume limbah organik secara signifikan sekaligus menghasilkan komoditas bernilai ekonomi seperti pakan ternak.</p>
                                        
                                        <p>Dalam pengembangannya, Bank Sampah Purwokeling didukung oleh <strong>KKN Tematik TIM 145 Kelompok 5 Universitas Diponegoro</strong>, yang berperan aktif dalam pembuatan program kerja, budidaya maggot, serta digitalisasi pencatatan transaksi bank sampah. Digitalisasi ini memungkinkan proses pencatatan dan edukasi masyarakat dapat dilakukan secara mudah, akurat, dan transparan.</p>
                                        
                                        <h5 class="mt-4 mb-3"><strong>Anggota KKN Tematik TIM 145 Kelompok 5</strong></h5>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <ul class="list-unstyled">
                                                    <li><i class="fas fa-user text-primary mr-2"></i>Muhamad Haykal Arraya H</li>
                                                    <li><i class="fas fa-user text-primary mr-2"></i>Riski Akbar F</li>
                                                    <li><i class="fas fa-user text-primary mr-2"></i>Silvie Herliawan Putri</li>
                                                    <li><i class="fas fa-user text-primary mr-2"></i>Annora Ramaniya Simanjuntak</li>
                                                    <li><i class="fas fa-user text-primary mr-2"></i>Parsa Ghania Maheswari</li>
                                                </ul>
                                            </div>
                                            <div class="col-md-6">
                                                <ul class="list-unstyled">
                                                    <li><i class="fas fa-user text-primary mr-2"></i>Ninna Nikita Dewi</li>
                                                    <li><i class="fas fa-user text-primary mr-2"></i>Muhammad Radja Abdiel Halim Hibatullah</li>
                                                    <li><i class="fas fa-user text-primary mr-2"></i>Nesya Shafa Nabila Wardani</li>
                                                    <li><i class="fas fa-user text-primary mr-2"></i>Anik Sukma</li>
                                                </ul>
                                            </div>
                                        </div>
                                        
                                        <h5 class="mt-4 mb-3"><strong>Dasar Hukum</strong></h5>
                                        <p>Bank Sampah Purwokeling berjalan seiring dengan ketentuan dan peraturan yang berlaku, antara lain:</p>
                                        <ul>
                                            <li><i class="fas fa-gavel text-success mr-2"></i>Undang-Undang Nomor 18 Tahun 2008 tentang Pengelolaan Sampah</li>
                                            <li><i class="fas fa-gavel text-success mr-2"></i>Peraturan Daerah Kota Semarang Nomor 6 Tahun 2012 tentang Pengelolaan Sampah</li>
                                            <li><i class="fas fa-gavel text-success mr-2"></i>Surat Keputusan Lurah Purwoyoso Kecamatan Ngaliyan Kota Semarang Nomor 660/246/XII/2022 tentang Pembentukan Bank Sampah "Purwokeling" RW X Kelurahan Purwoyoso</li>
                                        </ul>
                                        
                                        <p class="mt-4">Kami percaya bahwa perubahan besar dapat dimulai dari langkah kecil. Melalui partisipasi aktif masyarakat dalam pengelolaan sampah, Bank Sampah Purwokeling mengajak seluruh elemen warga untuk menciptakan lingkungan yang bersih, sehat, dan berkelanjutan, serta memanfaatkan potensi ekonomi dari sampah secara bijak.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <!-- JS Libraies -->
@endpush