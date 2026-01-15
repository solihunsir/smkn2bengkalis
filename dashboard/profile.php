<?php
require_once '../config/database.php';
checkLogin();

$conn = getConnection();

// Get profile sekolah
$query = "SELECT * FROM profile_sekolah LIMIT 1";
$result = $conn->query($query);
$profile = $result->fetch_assoc();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_sekolah = secure($_POST['nama_sekolah']);
    $alamat = secure($_POST['alamat']);
    $telepon = secure($_POST['telepon']);
    $email = secure($_POST['email']);
    $visi = secure($_POST['visi']);
    $misi = secure($_POST['misi']);
    $sejarah = secure($_POST['sejarah']);
    
    if ($profile) {
        // Update existing profile
        $query = "UPDATE profile_sekolah SET 
                  nama_sekolah = '$nama_sekolah',
                  alamat = '$alamat',
                  telepon = '$telepon',
                  email = '$email',
                  visi = '$visi',
                  misi = '$misi',
                  sejarah = '$sejarah'
                  WHERE id = " . $profile['id'];
    } else {
        // Insert new profile
        $query = "INSERT INTO profile_sekolah 
                  (nama_sekolah, alamat, telepon, email, visi, misi, sejarah) 
                  VALUES ('$nama_sekolah', '$alamat', '$telepon', '$email', '$visi', '$misi', '$sejarah')";
    }
    
    if ($conn->query($query)) {
        $_SESSION['success'] = 'Profile sekolah berhasil disimpan!';
        redirect('profile.php');
    } else {
        $_SESSION['error'] = 'Gagal menyimpan profile: ' . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Sekolah - SMKN 2 Bengkalis</title>
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
        
        .form-card {
            border-radius: 15px;
            border: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
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
                    <a class="nav-link" href="index.php">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                    <a class="nav-link active" href="profile.php">
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
                            <i class="bi bi-building"></i> Profile Sekolah
                        </span>
                        <span class="text-muted">
                            <i class="bi bi-person-circle"></i> 
                            <?php echo $_SESSION['admin_nama']; ?>
                        </span>
                    </div>
                </nav>
                
                <div class="container-fluid px-4">
                    <?php if (isset($_SESSION['success'])): ?>
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="bi bi-check-circle"></i> <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show">
                            <i class="bi bi-exclamation-triangle"></i> <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>
                    
                    <div class="row justify-content-center">
                        <div class="col-md-10">
                            <div class="card form-card">
                                <div class="card-header bg-white">
                                    <h5 class="mb-0">
                                        <i class="bi bi-pencil"></i> Kelola Profile Sekolah
                                    </h5>
                                </div>
                                <div class="card-body p-4">
                                    <form method="POST" action="">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="nama_sekolah" class="form-label">
                                                    Nama Sekolah <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control" id="nama_sekolah" 
                                                       name="nama_sekolah" required
                                                       value="<?php echo $profile ? $profile['nama_sekolah'] : ''; ?>">
                                            </div>
                                            
                                            <div class="col-md-6 mb-3">
                                                <label for="telepon" class="form-label">
                                                    Telepon
                                                </label>
                                                <input type="text" class="form-control" id="telepon" 
                                                       name="telepon"
                                                       value="<?php echo $profile ? $profile['telepon'] : ''; ?>">
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="email" class="form-label">
                                                    Email
                                                </label>
                                                <input type="email" class="form-control" id="email" 
                                                       name="email"
                                                       value="<?php echo $profile ? $profile['email'] : ''; ?>">
                                            </div>
                                            
                                            <div class="col-md-6 mb-3">
                                                <label for="alamat" class="form-label">
                                                    Alamat <span class="text-danger">*</span>
                                                </label>
                                                <textarea class="form-control" id="alamat" name="alamat" 
                                                          rows="3" required><?php echo $profile ? $profile['alamat'] : ''; ?></textarea>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="visi" class="form-label">
                                                Visi <span class="text-danger">*</span>
                                            </label>
                                            <textarea class="form-control" id="visi" name="visi" 
                                                      rows="3" required><?php echo $profile ? $profile['visi'] : ''; ?></textarea>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="misi" class="form-label">
                                                Misi <span class="text-danger">*</span>
                                            </label>
                                            <textarea class="form-control" id="misi" name="misi" 
                                                      rows="5" required><?php echo $profile ? $profile['misi'] : ''; ?></textarea>
                                            <small class="text-muted">Gunakan enter untuk memisahkan setiap poin misi</small>
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label for="sejarah" class="form-label">
                                                Sejarah Sekolah <span class="text-danger">*</span>
                                            </label>
                                            <textarea class="form-control" id="sejarah" name="sejarah" 
                                                      rows="5" required><?php echo $profile ? $profile['sejarah'] : ''; ?></textarea>
                                        </div>
                                        
                                        <div class="d-flex gap-2">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="bi bi-save"></i> Simpan Perubahan
                                            </button>
                                            <a href="index.php" class="btn btn-secondary">
                                                <i class="bi bi-arrow-left"></i> Kembali
                                            </a>
                                        </div>
                                    </form>
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
