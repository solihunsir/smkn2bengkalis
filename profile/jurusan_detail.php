<?php
require_once '../config/database.php';

$conn = getConnection();

// Get jurusan ID
if (!isset($_GET['id'])) {
    redirect('index.php');
}

$id = secure($_GET['id']);

// Get jurusan detail
$query_jurusan = "SELECT * FROM jurusan WHERE id = '$id'";
$result_jurusan = $conn->query($query_jurusan);

if ($result_jurusan->num_rows == 0) {
    redirect('index.php');
}

$jurusan = $result_jurusan->fetch_assoc();

// Get mata pelajaran for this jurusan
$query_mapel = "SELECT * FROM mata_pelajaran WHERE jurusan_id = '$id' ORDER BY kode_mapel ASC";
$result_mapel = $conn->query($query_mapel);

// Get profile
$query_profile = "SELECT * FROM profile_sekolah LIMIT 1";
$result_profile = $conn->query($query_profile);
$profile = $result_profile->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $jurusan['nama_jurusan']; ?> - <?php echo $profile ? $profile['nama_sekolah'] : 'SMKN 2 Bengkalis'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #667eea;
            --secondary-color: #764ba2;
        }
        
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
        
        .hero-jurusan {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 80px 0;
        }
        
        .jurusan-code-large {
            font-size: 72px;
            font-weight: 700;
            opacity: 0.3;
            position: absolute;
            right: 50px;
            top: 50%;
            transform: translateY(-50%);
        }
        
        .mapel-card {
            border-radius: 10px;
            border: none;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            transition: all 0.3s;
            margin-bottom: 20px;
        }
        
        .mapel-card:hover {
            transform: translateX(10px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
        }
        
        .mapel-icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="bi bi-mortarboard"></i> <?php echo $profile ? $profile['nama_sekolah'] : 'SMKN 2 Bengkalis'; ?>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php#beranda">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php#tentang">Tentang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php#jurusan">Jurusan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php#kontak">Kontak</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- Hero Section -->
    <section class="hero-jurusan position-relative">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <a href="index.php#jurusan" class="btn btn-outline-light btn-sm mb-3">
                        <i class="bi bi-arrow-left"></i> Kembali ke Jurusan
                    </a>
                    <div class="badge bg-white text-primary mb-3 px-3 py-2">
                        <?php echo $jurusan['kode_jurusan']; ?>
                    </div>
                    <h1 class="display-4 fw-bold mb-4">
                        <?php echo $jurusan['nama_jurusan']; ?>
                    </h1>
                    <p class="lead">
                        <?php echo $jurusan['deskripsi']; ?>
                    </p>
                </div>
            </div>
            <div class="jurusan-code-large d-none d-lg-block">
                <?php echo $jurusan['kode_jurusan']; ?>
            </div>
        </div>
    </section>
    
    <!-- Mata Pelajaran Section -->
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Mata Pelajaran</h2>
                <p class="text-muted">Daftar mata pelajaran yang dipelajari di jurusan <?php echo $jurusan['nama_jurusan']; ?></p>
            </div>
            
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <?php if ($result_mapel->num_rows > 0): ?>
                        <?php $colors = ['primary', 'success', 'warning', 'info', 'danger']; $i = 0; ?>
                        <?php while ($mapel = $result_mapel->fetch_assoc()): ?>
                            <div class="mapel-card card">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-start">
                                        <div class="mapel-icon bg-<?php echo $colors[$i % 5]; ?> bg-opacity-10 text-<?php echo $colors[$i % 5]; ?> me-3">
                                            <i class="bi bi-journal-text"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <h5 class="mb-0"><?php echo $mapel['nama_mapel']; ?></h5>
                                                <span class="badge bg-<?php echo $colors[$i % 5]; ?>">
                                                    <?php echo $mapel['kode_mapel']; ?>
                                                </span>
                                            </div>
                                            <p class="text-muted mb-0">
                                                <?php echo $mapel['deskripsi']; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php $i++; ?>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="bi bi-inbox text-muted" style="font-size: 64px;"></i>
                            <p class="text-muted mt-3">Belum ada mata pelajaran untuk jurusan ini</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    
    <!-- CTA Section -->
    <section class="bg-light py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h3 class="fw-bold mb-2">Tertarik dengan jurusan <?php echo $jurusan['nama_jurusan']; ?>?</h3>
                    <p class="text-muted mb-0">Hubungi kami untuk informasi lebih lanjut tentang pendaftaran</p>
                </div>
                <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                    <a href="index.php#kontak" class="btn btn-primary btn-lg px-5">
                        <i class="bi bi-telephone"></i> Hubungi Kami
                    </a>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container text-center">
            <p class="mb-0">
                &copy; <?php echo date('Y'); ?> <?php echo $profile ? $profile['nama_sekolah'] : 'SMKN 2 Bengkalis'; ?>. 
                All rights reserved.
            </p>
        </div>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
