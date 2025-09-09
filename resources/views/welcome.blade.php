<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Bank Sampah Purwokeling — Solusi Pengelolaan Sampah Modern</title>

  <!-- Google Fonts: Inter, Poppins & Nunito -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;600&family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet">
  <!-- Bootstrap 5.3 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
  <!-- Animate.css -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
  <!-- AOS (Animate On Scroll) -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css">

  <!-- Custom CSS -->
  <style>
    :root {
      --primary-color: #16a085;
      --secondary-color: #1abc9c;
      --accent-color: #0d7377;
      --light-bg: #ffffff;
      --text-color: #2c3e50;
      --gray-light: #f8f9fa;
      --gray-medium: #6c757d;
      --shadow-light: 0 2px 10px rgba(0,0,0,0.08);
      --shadow-medium: 0 4px 20px rgba(0,0,0,0.12);
    }
    
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    
    body {
      font-family: 'Inter', 'Poppins', sans-serif;
      background: var(--light-bg);
      color: var(--text-color);
      line-height: 1.6;
      font-weight: 400;
    }
    
    /* HERO SECTION */
    .hero {
      min-height: 100vh;
      background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      padding: 0 2rem;
      color: #fff;
      position: relative;
    }
    
    .hero::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="%23ffffff" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>') repeat;
      opacity: 0.3;
    }
    
    .hero-content {
      position: relative;
      z-index: 2;
      max-width: 800px;
    }
    
    .hero h1 {
      font-size: clamp(2.5rem, 5vw, 4rem);
      font-weight: 700;
      margin-bottom: 1.5rem;
      letter-spacing: -0.02em;
    }
    
    .hero p {
      font-size: clamp(1.1rem, 2.5vw, 1.3rem);
      margin-bottom: 2.5rem;
      opacity: 0.95;
      font-weight: 300;
      line-height: 1.7;
    }
    
    .btn-cta {
      background: rgba(255, 255, 255, 0.95);
      color: var(--primary-color);
      padding: 1rem 2.5rem;
      border: none;
      border-radius: 50px;
      font-weight: 600;
      font-size: 1.1rem;
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
      backdrop-filter: blur(10px);
      border: 2px solid rgba(255, 255, 255, 0.2);
      text-decoration: none;
      display: inline-block;
    }
    
    .btn-cta:hover {
      background: rgba(255, 255, 255, 1);
      color: var(--accent-color);
      transform: translateY(-2px);
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }
    
    /* SECTION STYLE */
    .section {
      padding: 6rem 0;
    }
    
    .section-title {
      font-size: clamp(2rem, 4vw, 2.8rem);
      font-weight: 700;
      margin-bottom: 3rem;
      letter-spacing: -0.02em;
      color: var(--text-color);
    }
    
    .section-subtitle {
      font-size: 1.2rem;
      color: var(--gray-medium);
      margin-bottom: 4rem;
      font-weight: 300;
    }
    
    /* FEATURE CARDS */
    .feature-card {
      border: none;
      border-radius: 20px;
      box-shadow: var(--shadow-light);
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
      background: #fff;
      padding: 2.5rem 2rem;
      height: 100%;
      border: 1px solid rgba(22, 160, 133, 0.08);
    }
    
    .feature-card:hover {
      transform: translateY(-8px);
      box-shadow: var(--shadow-medium);
      border-color: rgba(22, 160, 133, 0.15);
    }
    
    .feature-card i {
      font-size: 2.5rem;
      margin-bottom: 1.5rem;
      display: block;
    }
    
    .feature-card h5 {
      font-size: 1.4rem;
      font-weight: 600;
      margin-bottom: 1rem;
      color: var(--text-color);
    }
    
    .feature-card p {
      color: var(--gray-medium);
      line-height: 1.7;
      font-size: 0.95rem;
    }
    /* ABOUT SECTION */
    .about-text {
      font-size: 1.1rem;
      line-height: 1.8;
      color: var(--gray-medium);
      margin-bottom: 1.5rem;
    }
    
    .about-highlight {
      background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
      border-radius: 20px;
      padding: 2.5rem;
      color: white;
      text-align: center;
    }
    
    .about-highlight h4 {
      font-size: 1.5rem;
      font-weight: 600;
      margin-bottom: 1.5rem;
    }
    
    .about-highlight p {
      font-size: 1rem;
      line-height: 1.7;
      opacity: 0.95;
    }
    
    /* TEAM SECTION */
    .team-intro {
      max-width: 800px;
      margin: 0 auto;
    }
    
    .team-intro .lead {
      font-size: 1.2rem;
      line-height: 1.7;
      color: var(--gray-medium);
    }
    
    /* FOOTER */
    footer {
      background: var(--text-color);
      color: #fff;
      padding: 4rem 0 2rem;
    }
    
    footer h5, footer h6 {
      color: #fff;
      font-weight: 600;
      margin-bottom: 1.5rem;
    }
    
    footer p {
      color: rgba(255, 255, 255, 0.8);
      line-height: 1.6;
      margin-bottom: 0.5rem;
    }
    
    footer i {
      color: var(--secondary-color);
      margin-right: 0.5rem;
      width: 16px;
    }
    
    footer hr {
      border-color: rgba(255, 255, 255, 0.1);
      margin: 2rem 0;
    }
    
    /* RESPONSIVE */
    @media (max-width: 768px) {
      .hero {
        padding: 0 1rem;
      }
      
      .section {
        padding: 4rem 0;
      }
      
      .feature-card {
        margin-bottom: 2rem;
      }
      
      .about-highlight {
        padding: 2rem 1.5rem;
      }
    }
  </style>
</head>
<body>

  <!-- HERO SECTION -->
  <section class="hero">
    <div class="hero-content">
      <h1 class="animate__animated animate__fadeInDown">Bank Sampah Purwokeling</h1>
      <p class="animate__animated animate__fadeInUp">
        Sampah bukanlah akhir dari sebuah siklus, tetapi awal dari peluang baru — baik dari sisi lingkungan maupun ekonomi.
      </p>
      <a href="{{ route('login') }}" class="btn btn-cta animate__animated animate__zoomIn">Bergabung Sekarang</a>
    </div>
  </section>

  <!-- LAYANAN SECTION -->
  <section class="section" id="layanan" style="background: var(--gray-light);">
    <div class="container">
      <div class="text-center mb-5">
        <h2 class="section-title" data-aos="fade-up">Layanan Kami</h2>
        <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">Solusi inovatif untuk pengelolaan sampah yang berkelanjutan</p>
      </div>
      <div class="row g-4">
        <div class="col-md-4" data-aos="flip-up">
          <div class="card feature-card p-4 text-center">
            <i class="fas fa-recycle" style="color: var(--primary-color);"></i>
            <h5 class="card-title mt-3">Tabungan Sampah</h5>
            <p class="card-text">
              Sistem tabungan sampah yang terstruktur dan transparan. Sampah Anda menjadi sumber penghasilan melalui pencatatan digital.
            </p>
          </div>
        </div>
        <div class="col-md-4" data-aos="flip-up" data-aos-delay="100">
          <div class="card feature-card p-4 text-center">
            <i class="fas fa-bug" style="color: var(--gold-color);"></i>
            <h5 class="card-title mt-3">Budidaya Maggot</h5>
            <p class="card-text">
              Inovasi budidaya maggot (larva Black Soldier Fly) untuk menguraikan limbah organik dengan cepat dan ramah lingkungan.
            </p>
          </div>
        </div>
        <div class="col-md-4" data-aos="flip-up" data-aos-delay="200">
          <div class="card feature-card p-4 text-center">
            <i class="fas fa-laptop" style="color: var(--secondary-color);"></i>
            <h5 class="card-title mt-3">Sistem Digital</h5>
            <p class="card-text">
              Digitalisasi sistem bank sampah untuk proses pencatatan, penukaran, dan edukasi yang mudah dan transparan.
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- TENTANG KAMI SECTION -->
  <section class="section" id="tentang">
    <div class="container">
      <div class="row align-items-center g-5">
        <div class="col-lg-6" data-aos="fade-right">
          <h2 class="section-title">Tentang Bank Sampah Purwokeling</h2>
          <p class="about-text">
            Bank Sampah Purwokeling berdiri pada <strong>26 Desember 2022</strong> sebagai bentuk kepedulian terhadap kondisi lingkungan dan untuk menjawab kebutuhan akan sistem pengelolaan sampah yang lebih terstruktur di tingkat masyarakat.
          </p>
          <p class="about-text">
            Dengan semangat gotong royong dan semangat inovasi, Bank Sampah Purwokeling hadir untuk memberikan solusi konkret dalam pengelolaan sampah, khususnya di lingkungan RW X Kelurahan Purwoyoso.
          </p>
          <p class="about-text">
            Kami percaya bahwa perubahan besar dapat dimulai dari langkah kecil. Melalui partisipasi aktif masyarakat dalam pengelolaan sampah, Bank Sampah Purwokeling mengajak seluruh elemen warga untuk menciptakan lingkungan yang bersih, sehat, dan berkelanjutan.
          </p>
        </div>
        <div class="col-lg-6" data-aos="fade-left">
          <div class="about-highlight">
            <h4>Inovasi Maggot BSF</h4>
            <p>
              Salah satu inovasi unggulan kami adalah pengembangan budidaya maggot BSF (Black Soldier Fly) yang terbukti efektif dan ramah lingkungan dalam menguraikan sampah organik. Maggot mampu mengurangi volume limbah organik secara signifikan sekaligus menghasilkan komoditas bernilai ekonomi seperti pakan ternak.
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- TIM SECTION -->
  <section class="section" id="tim" style="background: var(--gray-light);">
    <div class="container">
      <div class="text-center mb-5">
        <h2 class="section-title" data-aos="fade-up">Tim Pengembang</h2>
        <div class="team-intro" data-aos="fade-up" data-aos-delay="100">
          <p class="lead">
            Dalam pengembangannya, Bank Sampah Purwokeling didukung oleh <strong>KKN Tematik TIM 145 Kelompok 5 Universitas Diponegoro</strong>, yang berperan aktif dalam pembuatan program kerja, budidaya maggot, serta digitalisasi pencatatan transaksi bank sampah.
          </p>
        </div>
      </div>
      <div class="row g-4">
         <div class="col-md-4" data-aos="flip-up">
           <div class="feature-card text-center">
             <i class="fas fa-university" style="color: var(--primary-color);"></i>
             <h5>KKN Tematik TIM 145 Kelompok 5</h5>
             <p>
               Tim Kuliah Kerja Nyata Tematik 145 Kelompok 5 Universitas Diponegoro yang berperan aktif dalam pengembangan sistem digital dan budidaya maggot.
             </p>
           </div>
         </div>
         <div class="col-md-4" data-aos="flip-up" data-aos-delay="100">
           <div class="feature-card text-center">
             <i class="fas fa-users" style="color: var(--secondary-color);"></i>
             <h5>Masyarakat Purwokeling</h5>
             <p>
               Partisipasi aktif masyarakat dalam program bank sampah dan budidaya maggot untuk lingkungan yang lebih bersih.
             </p>
           </div>
         </div>
         <div class="col-md-4" data-aos="flip-up" data-aos-delay="200">
           <div class="feature-card text-center">
             <i class="fas fa-handshake" style="color: var(--accent-color);"></i>
             <h5>Kemitraan</h5>
             <p>
               Kolaborasi dengan berbagai pihak untuk menciptakan ekosistem pengelolaan sampah yang berkelanjutan.
             </p>
           </div>
         </div>
      </div>
    </div>
  </section>

  <!-- FOOTER -->
  <footer>
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <h5 class="mb-3">Bank Sampah Purwokeling</h5>
          <p class="mb-2">Solusi pengelolaan sampah modern untuk lingkungan yang lebih bersih dan ekonomi yang berkelanjutan.</p>
          <p class="mb-0"><i class="fas fa-calendar"></i> Berdiri sejak 26 Desember 2022</p>
        </div>
        <div class="col-md-6">
          <h6 class="mb-3">Kontak</h6>
          <p class="mb-1"><i class="fas fa-envelope"></i> info@banksampahpurwokeling.id</p>
          <p class="mb-1"><i class="fas fa-phone"></i> +62 xxx-xxxx-xxxx</p>
          <p class="mb-0"><i class="fas fa-map-marker-alt"></i> Purwokeling, Indonesia</p>
        </div>
      </div>
      <hr class="my-4">
      <div class="text-center">
        <p class="mb-1">&copy; {{ date('Y') }} Bank Sampah Purwokeling. All Rights Reserved.</p>
        <p class="mb-0">Didukung oleh KKN Tematik TIM 145 Kelompok 5 Universitas Diponegoro</p>
      </div>
    </div>
  </footer>

  <!-- JS Libraries -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
  <script>
    AOS.init({
      once: true,
      duration: 800,
    });
  </script>
</body>
</html>
