<?php
require_once '../config/database.php';

$conn = getConnection();

// Get profile sekolah
$query_profile = "SELECT * FROM profile_sekolah LIMIT 1";
$result_profile = $conn->query($query_profile);
$profile = $result_profile->fetch_assoc();

// Get all jurusan
$query_jurusan = "SELECT * FROM jurusan ORDER BY kode_jurusan ASC";
$result_jurusan = $conn->query($query_jurusan);

// Get count
$count_jurusan = $result_jurusan->num_rows;

$query_count_mapel = "SELECT COUNT(*) as total FROM mata_pelajaran";
$result_count = $conn->query($query_count_mapel);
$count_mapel = $result_count->fetch_assoc()['total'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $profile ? $profile['nama_sekolah'] : 'SMKN 2 Bengkalis'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #667eea;
            --secondary-color: #764ba2;
        }
        
        /* Navbar Styles */
        .navbar-custom {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 15px 0;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 24px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .nav-link {
            color: #333;
            font-weight: 500;
            margin: 0 10px;
            transition: color 0.3s;
        }
        
        .nav-link:hover {
            color: var(--primary-color);
        }
        
        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 100px 0;
            position: relative;
            overflow: hidden;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="rgba(255,255,255,0.1)" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,138.7C960,139,1056,117,1152,101.3C1248,85,1344,75,1392,69.3L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') no-repeat bottom;
            background-size: cover;
        }
        
        .hero-content {
            position: relative;
            z-index: 1;
        }
        
        /* Stats Cards */
        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transition: transform 0.3s;
            margin-top: -50px;
            position: relative;
            z-index: 2;
        }
        
        .stat-card:hover {
            transform: translateY(-10px);
        }
        
        .stat-icon {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            margin-bottom: 15px;
        }
        
        .stat-number {
            font-size: 48px;
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        /* Section Styles */
        .section {
            padding: 80px 0;
        }
        
        .section-title {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 15px;
            color: #333;
        }
        
        .section-subtitle {
            color: #666;
            font-size: 18px;
            margin-bottom: 50px;
        }
        
        /* Jurusan Cards */
        .jurusan-card {
            border-radius: 15px;
            border: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: all 0.3s;
            height: 100%;
            overflow: hidden;
        }
        
        .jurusan-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }
        
        .jurusan-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 25px;
            text-align: center;
        }
        
        .jurusan-code {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        /* Footer */
        .footer {
            background: #2c3e50;
            color: white;
            padding: 50px 0 20px;
        }
        
        .footer-title {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 20px;
        }
        
        .footer-link {
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            display: block;
            margin-bottom: 10px;
            transition: color 0.3s;
        }
        
        .footer-link:hover {
            color: white;
        }
        
        .btn-admin {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            padding: 10px 25px;
            color: white;
            font-weight: 600;
            border-radius: 25px;
            transition: transform 0.3s;
        }
        
        .btn-admin:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="bi bi-mortarboard"></i> <?php echo $profile ? $profile['nama_sekolah'] : 'SMKN 2 Bengkalis'; ?>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#beranda">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#tentang">Tentang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#jurusan">Jurusan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#kontak">Kontak</a>
                    </li>
                    <li class="nav-item ms-3">
                        <a href="../login.php" class="btn btn-admin">
                            <i class="bi bi-shield-lock"></i> Admin Login
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- Hero Section -->
    <section class="hero-section" id="beranda">
        <div class="container hero-content">
            <div class="row align-items-center">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="display-4 fw-bold mb-4">
                        Selamat Datang di<br>
                        <?php echo $profile ? $profile['nama_sekolah'] : 'SMKN 2 Bengkalis'; ?>
                    </h1>
                    <p class="lead mb-4">
                        <?php echo $profile ? $profile['visi'] : 'Menjadi SMK yang unggul, berkarakter, dan berdaya saing global'; ?>
                    </p>
                    <a href="#jurusan" class="btn btn-light btn-lg px-5">
                        <i class="bi bi-arrow-down-circle"></i> Jelajahi Jurusan
                    </a>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Statistics Section -->
    <section class="container">
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="stat-card">
                    <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                        <i class="bi bi-book"></i>
                    </div>
                    <div class="stat-number"><?php echo $count_jurusan; ?></div>
                    <h5 class="text-muted">Program Keahlian</h5>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="stat-card">
                    <div class="stat-icon bg-success bg-opacity-10 text-success">
                        <i class="bi bi-journal-text"></i>
                    </div>
                    <div class="stat-number"><?php echo $count_mapel; ?></div>
                    <h5 class="text-muted">Mata Pelajaran</h5>
                </div>
            </div>
        </div>
    </section>
    
    <!-- About Section -->
    <section class="section bg-light" id="tentang">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Tentang Kami</h2>
                <p class="section-subtitle">Mengenal lebih dekat SMKN 2 Bengkalis</p>
            </div>
            
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="stat-icon bg-primary bg-opacity-10 text-primary me-3">
                                    <i class="bi bi-eye"></i>
                                </div>
                                <h4 class="mb-0">Visi</h4>
                            </div>
                            <p class="text-muted">
                                <?php echo $profile ? nl2br($profile['visi']) : 'Visi belum tersedia'; ?>
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="stat-icon bg-success bg-opacity-10 text-success me-3">
                                    <i class="bi bi-flag"></i>
                                </div>
                                <h4 class="mb-0">Misi</h4>
                            </div>
                            <p class="text-muted">
                                <?php echo $profile ? nl2br($profile['misi']) : 'Misi belum tersedia'; ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="stat-icon bg-warning bg-opacity-10 text-warning me-3">
                                    <i class="bi bi-clock-history"></i>
                                </div>
                                <h4 class="mb-0">Sejarah</h4>
                            </div>
                            <p class="text-muted mb-0">
                                <?php echo $profile ? nl2br($profile['sejarah']) : 'Sejarah belum tersedia'; ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Jurusan Section -->
    <section class="section" id="jurusan">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Program Keahlian</h2>
                <p class="section-subtitle">Pilih program keahlian yang sesuai dengan minat dan bakatmu</p>
            </div>
            
            <div class="row">
                <?php if ($result_jurusan->num_rows > 0): ?>
                    <?php while ($jurusan = $result_jurusan->fetch_assoc()): ?>
                        <div class="col-lg-6 mb-4">
                            <div class="jurusan-card card">
                                <div class="jurusan-header">
                                    <div class="jurusan-code"><?php echo $jurusan['kode_jurusan']; ?></div>
                                    <h5 class="mb-0"><?php echo $jurusan['nama_jurusan']; ?></h5>
                                </div>
                                <div class="card-body p-4">
                                    <p class="text-muted mb-4"><?php echo $jurusan['deskripsi']; ?></p>
                                    <a href="jurusan_detail.php?id=<?php echo $jurusan['id']; ?>" class="btn btn-outline-primary">
                                        Lihat Detail <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="col-12 text-center">
                        <p class="text-muted">Belum ada data jurusan tersedia</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    
    <!-- Contact Section -->
    <section class="section bg-light" id="kontak">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Kontak Kami</h2>
                <p class="section-subtitle">Hubungi kami untuk informasi lebih lanjut</p>
            </div>
            
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-md-4 mb-4 text-center">
                            <div class="stat-icon bg-primary bg-opacity-10 text-primary mx-auto mb-3">
                                <i class="bi bi-geo-alt"></i>
                            </div>
                            <h5>Alamat</h5>
                            <p class="text-muted">
                                <?php echo $profile ? $profile['alamat'] : 'Alamat belum tersedia'; ?>
                            </p>
                        </div>
                        
                        <div class="col-md-4 mb-4 text-center">
                            <div class="stat-icon bg-success bg-opacity-10 text-success mx-auto mb-3">
                                <i class="bi bi-telephone"></i>
                            </div>
                            <h5>Telepon</h5>
                            <p class="text-muted">
                                <?php echo $profile ? $profile['telepon'] : '-'; ?>
                            </p>
                        </div>
                        
                        <div class="col-md-4 mb-4 text-center">
                            <div class="stat-icon bg-warning bg-opacity-10 text-warning mx-auto mb-3">
                                <i class="bi bi-envelope"></i>
                            </div>
                            <h5>Email</h5>
                            <p class="text-muted">
                                <?php echo $profile ? $profile['email'] : '-'; ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5 class="footer-title">
                        <?php echo $profile ? $profile['nama_sekolah'] : 'SMKN 2 Bengkalis'; ?>
                    </h5>
                    <p class="text-white-50">
                        <?php echo $profile ? substr($profile['visi'], 0, 100) . '...' : ''; ?>
                    </p>
                </div>
                
                <div class="col-md-4 mb-4">
                    <h5 class="footer-title">Menu</h5>
                    <a href="#beranda" class="footer-link">Beranda</a>
                    <a href="#tentang" class="footer-link">Tentang</a>
                    <a href="#jurusan" class="footer-link">Jurusan</a>
                    <a href="#kontak" class="footer-link">Kontak</a>
                </div>
                
                <div class="col-md-4 mb-4">
                    <h5 class="footer-title">Kontak</h5>
                    <p class="text-white-50">
                        <i class="bi bi-geo-alt me-2"></i>
                        <?php echo $profile ? $profile['alamat'] : '-'; ?>
                    </p>
                    <p class="text-white-50">
                        <i class="bi bi-telephone me-2"></i>
                        <?php echo $profile ? $profile['telepon'] : '-'; ?>
                    </p>
                    <p class="text-white-50">
                        <i class="bi bi-envelope me-2"></i>
                        <?php echo $profile ? $profile['email'] : '-'; ?>
                    </p>
                </div>
            </div>
            
            <hr class="bg-white-50">
            
            <div class="text-center text-white-50">
                <p class="mb-0">
                    &copy; <?php echo date('Y'); ?> <?php echo $profile ? $profile['nama_sekolah'] : 'SMKN 2 Bengkalis'; ?>. 
                    All rights reserved.
                </p>
            </div>
        </div>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html>
