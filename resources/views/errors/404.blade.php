<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Halaman Tidak Ditemukan — Bank Sampah Purwokeling</title>

  <!-- Google Fonts: Inter, Poppins & Nunito -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;600&family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet">
  <!-- Bootstrap 5.3 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
  <!-- Animate.css -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

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
      overflow-x: hidden;
    }
    
    /* ERROR SECTION */
    .error-section {
      min-height: 100vh;
      background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      padding: 2rem;
      color: #fff;
      position: relative;
    }
    
    .error-section::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="%23ffffff" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>') repeat;
      opacity: 0.3;
    }
    
    .error-content {
      position: relative;
      z-index: 2;
      max-width: 600px;
    }
    
    .error-icon {
      font-size: 8rem;
      margin-bottom: 2rem;
      opacity: 0.9;
      animation: bounce 2s infinite;
    }
    
    .error-code {
      font-size: clamp(4rem, 8vw, 8rem);
      font-weight: 700;
      margin-bottom: 1rem;
      letter-spacing: -0.02em;
      text-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }
    
    .error-title {
      font-size: clamp(1.5rem, 3vw, 2.5rem);
      font-weight: 600;
      margin-bottom: 1.5rem;
      opacity: 0.95;
    }
    
    .error-description {
      font-size: clamp(1rem, 2vw, 1.2rem);
      margin-bottom: 3rem;
      opacity: 0.9;
      font-weight: 300;
      line-height: 1.7;
    }
    
    .btn-home {
      background: rgba(255, 255, 255, 0.95);
      color: var(--primary-color);
      padding: 1rem 2.5rem;
      border: none;
      border-radius: 50px;
      font-weight: 600;
      font-size: 1.1rem;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      transition: all 0.3s ease;
      box-shadow: var(--shadow-medium);
    }
    
    .btn-home:hover {
      background: #fff;
      color: var(--accent-color);
      transform: translateY(-2px);
      box-shadow: 0 6px 25px rgba(0,0,0,0.15);
      text-decoration: none;
    }
    
    .btn-back {
      background: transparent;
      color: #fff;
      padding: 0.8rem 2rem;
      border: 2px solid rgba(255, 255, 255, 0.3);
      border-radius: 50px;
      font-weight: 500;
      font-size: 1rem;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      transition: all 0.3s ease;
      margin-left: 1rem;
    }
    
    .btn-back:hover {
      background: rgba(255, 255, 255, 0.1);
      border-color: rgba(255, 255, 255, 0.5);
      color: #fff;
      text-decoration: none;
    }
    
    /* Floating elements */
    .floating-element {
      position: absolute;
      opacity: 0.1;
      animation: float 6s ease-in-out infinite;
    }
    
    .floating-element:nth-child(1) {
      top: 20%;
      left: 10%;
      animation-delay: 0s;
    }
    
    .floating-element:nth-child(2) {
      top: 60%;
      right: 15%;
      animation-delay: 2s;
    }
    
    .floating-element:nth-child(3) {
      bottom: 20%;
      left: 20%;
      animation-delay: 4s;
    }
    
    @keyframes float {
      0%, 100% {
        transform: translateY(0px);
      }
      50% {
        transform: translateY(-20px);
      }
    }
    
    @keyframes bounce {
      0%, 20%, 50%, 80%, 100% {
        transform: translateY(0);
      }
      40% {
        transform: translateY(-10px);
      }
      60% {
        transform: translateY(-5px);
      }
    }
    
    /* Responsive */
    @media (max-width: 768px) {
      .error-section {
        padding: 1rem;
      }
      
      .error-icon {
        font-size: 5rem;
      }
      
      .btn-back {
        margin-left: 0;
        margin-top: 1rem;
        display: block;
      }
    }
  </style>
</head>
<body>
  <div class="error-section">
    <!-- Floating Elements -->
    <div class="floating-element">
      <i class="fas fa-recycle" style="font-size: 3rem;"></i>
    </div>
    <div class="floating-element">
      <i class="fas fa-leaf" style="font-size: 2.5rem;"></i>
    </div>
    <div class="floating-element">
      <i class="fas fa-seedling" style="font-size: 2rem;"></i>
    </div>
    
    <div class="error-content animate__animated animate__fadeInUp">
      <div class="error-icon">
        <i class="fas fa-search"></i>
      </div>
      
      <div class="error-code animate__animated animate__bounceIn animate__delay-1s">
        404
      </div>
      
      <h1 class="error-title animate__animated animate__fadeInUp animate__delay-2s">
        Halaman Tidak Ditemukan
      </h1>
      
      <p class="error-description animate__animated animate__fadeInUp animate__delay-3s">
        Maaf, halaman yang Anda cari tidak dapat ditemukan. Mungkin halaman tersebut telah dipindahkan, dihapus, atau URL yang Anda masukkan salah.
      </p>
      
      <div class="animate__animated animate__fadeInUp animate__delay-4s">
        <a href="{{ url('/') }}" class="btn-home">
          <i class="fas fa-home"></i>
          Kembali ke Beranda
        </a>
        <a href="javascript:history.back()" class="btn-back">
          <i class="fas fa-arrow-left"></i>
          Kembali
        </a>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>