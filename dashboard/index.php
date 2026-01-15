<?php
require_once '../config/database.php';
checkLogin();

$conn = getConnection();

// Hitung statistik
$query_jurusan = "SELECT COUNT(*) as total FROM jurusan";
$result_jurusan = $conn->query($query_jurusan);
$total_jurusan = $result_jurusan->fetch_assoc()['total'];

$query_mapel = "SELECT COUNT(*) as total FROM mata_pelajaran";
$result_mapel = $conn->query($query_mapel);
$total_mapel = $result_mapel->fetch_assoc()['total'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - SMKN 2 Bengkalis</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #667eea;
            --secondary-color: #764ba2;
        }
        
        body {
            background-color: #f8f9fa;
        }
        
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
        }
        
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 12px 20px;
            margin: 5px 15px;
            border-radius: 8px;
            transition: all 0.3s;
        }
        
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: rgba(255,255,255,0.2);
            color: white;
        }
        
        .sidebar .nav-link i {
            margin-right: 10px;
            width: 20px;
        }
        
        .stat-card {
            border-radius: 15px;
            border: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        
        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }
        
        .navbar-brand {
            font-weight: 700;
            color: var(--primary-color) !important;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 p-0 sidebar">
                <div class="text-center py-4">
                    <h4 class="fw-bold">SMKN 2 Bengkalis</h4>
                    <small>Dashboard Admin</small>
                </div>
                <nav class="nav flex-column mt-4">
                    <a class="nav-link active" href="index.php">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                    <a class="nav-link" href="profile.php">
                        <i class="bi bi-building"></i> Profile Sekolah
                    </a>
                    <a class="nav-link" href="jurusan.php">
                        <i class="bi bi-book"></i> Data Jurusan
                    </a>
                    <a class="nav-link" href="mata_pelajaran.php">
                        <i class="bi bi-journal-text"></i> Mata Pelajaran
                    </a>
                    <hr class="text-white mx-3">
                    <a class="nav-link" href="../profile/" target="_blank">
                        <i class="bi bi-globe"></i> Lihat Website
                    </a>
                    <a class="nav-link" href="../logout.php" onclick="return confirm('Yakin ingin logout?')">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </a>
                </nav>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-10">
                <nav class="navbar navbar-light bg-white shadow-sm mb-4">
                    <div class="container-fluid">
                        <span class="navbar-brand mb-0 h1">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </span>
                        <span class="text-muted">
                            <i class="bi bi-person-circle"></i> 
                            Selamat datang, <strong><?php echo $_SESSION['admin_nama']; ?></strong>
                        </span>
                    </div>
                </nav>
                
                <div class="container-fluid px-4">
                    <!-- Statistics Cards -->
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <div class="card stat-card">
                                <div class="card-body d-flex align-items-center">
                                    <div class="stat-icon bg-primary bg-opacity-10 text-primary me-3">
                                        <i class="bi bi-book"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="text-muted mb-1">Total Jurusan</h6>
                                        <h2 class="mb-0"><?php echo $total_jurusan; ?></h2>
                                    </div>
                                    <a href="jurusan.php" class="btn btn-sm btn-outline-primary">
                                        Kelola <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <div class="card stat-card">
                                <div class="card-body d-flex align-items-center">
                                    <div class="stat-icon bg-success bg-opacity-10 text-success me-3">
                                        <i class="bi bi-journal-text"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="text-muted mb-1">Total Mata Pelajaran</h6>
                                        <h2 class="mb-0"><?php echo $total_mapel; ?></h2>
                                    </div>
                                    <a href="mata_pelajaran.php" class="btn btn-sm btn-outline-success">
                                        Kelola <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Quick Actions -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header bg-white">
                                    <h5 class="mb-0"><i class="bi bi-lightning"></i> Menu Cepat</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3 mb-3">
                                            <a href="profile.php" class="text-decoration-none">
                                                <div class="card text-center h-100 border-primary">
                                                    <div class="card-body">
                                                        <i class="bi bi-building text-primary" style="font-size: 40px;"></i>
                                                        <h6 class="mt-3">Profile Sekolah</h6>
                                                        <small class="text-muted">Kelola informasi sekolah</small>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        
                                        <div class="col-md-3 mb-3">
                                            <a href="jurusan.php" class="text-decoration-none">
                                                <div class="card text-center h-100 border-success">
                                                    <div class="card-body">
                                                        <i class="bi bi-book text-success" style="font-size: 40px;"></i>
                                                        <h6 class="mt-3">Data Jurusan</h6>
                                                        <small class="text-muted">Kelola data jurusan</small>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        
                                        <div class="col-md-3 mb-3">
                                            <a href="mata_pelajaran.php" class="text-decoration-none">
                                                <div class="card text-center h-100 border-warning">
                                                    <div class="card-body">
                                                        <i class="bi bi-journal-text text-warning" style="font-size: 40px;"></i>
                                                        <h6 class="mt-3">Mata Pelajaran</h6>
                                                        <small class="text-muted">Kelola mata pelajaran</small>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        
                                        <div class="col-md-3 mb-3">
                                            <a href="../profile/" target="_blank" class="text-decoration-none">
                                                <div class="card text-center h-100 border-info">
                                                    <div class="card-body">
                                                        <i class="bi bi-globe text-info" style="font-size: 40px;"></i>
                                                        <h6 class="mt-3">Lihat Website</h6>
                                                        <small class="text-muted">Preview website public</small>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
