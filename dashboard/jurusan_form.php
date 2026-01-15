<?php
require_once '../config/database.php';
checkLogin();

$conn = getConnection();
$edit = false;
$jurusan = null;

// Check if edit mode
if (isset($_GET['edit'])) {
    $edit = true;
    $id = secure($_GET['edit']);
    $query = "SELECT * FROM jurusan WHERE id = '$id'";
    $result = $conn->query($query);
    $jurusan = $result->fetch_assoc();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode_jurusan = secure($_POST['kode_jurusan']);
    $nama_jurusan = secure($_POST['nama_jurusan']);
    $deskripsi = secure($_POST['deskripsi']);
    
    if (isset($_POST['id']) && !empty($_POST['id'])) {
        // Update
        $id = secure($_POST['id']);
        $query = "UPDATE jurusan SET 
                  kode_jurusan = '$kode_jurusan',
                  nama_jurusan = '$nama_jurusan',
                  deskripsi = '$deskripsi'
                  WHERE id = '$id'";
        $success_msg = 'Data jurusan berhasil diupdate!';
    } else {
        // Insert
        $query = "INSERT INTO jurusan (kode_jurusan, nama_jurusan, deskripsi) 
                  VALUES ('$kode_jurusan', '$nama_jurusan', '$deskripsi')";
        $success_msg = 'Data jurusan berhasil ditambahkan!';
    }
    
    if ($conn->query($query)) {
        $_SESSION['success'] = $success_msg;
        redirect('jurusan.php');
    } else {
        $_SESSION['error'] = 'Gagal menyimpan data: ' . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $edit ? 'Edit' : 'Tambah'; ?> Jurusan - SMKN 2 Bengkalis</title>
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
                    <a class="nav-link" href="profile.php">
                        <i class="bi bi-building"></i> Profile Sekolah
                    </a>
                    <a class="nav-link active" href="jurusan.php">
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
                            <i class="bi bi-book"></i> <?php echo $edit ? 'Edit' : 'Tambah'; ?> Jurusan
                        </span>
                        <span class="text-muted">
                            <i class="bi bi-person-circle"></i> 
                            <?php echo $_SESSION['admin_nama']; ?>
                        </span>
                    </div>
                </nav>
                
                <div class="container-fluid px-4">
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show">
                            <i class="bi bi-exclamation-triangle"></i> <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>
                    
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="card form-card">
                                <div class="card-header bg-white">
                                    <h5 class="mb-0">
                                        <i class="bi bi-<?php echo $edit ? 'pencil' : 'plus-circle'; ?>"></i>
                                        Form <?php echo $edit ? 'Edit' : 'Tambah'; ?> Jurusan
                                    </h5>
                                </div>
                                <div class="card-body p-4">
                                    <form method="POST" action="">
                                        <?php if ($edit): ?>
                                            <input type="hidden" name="id" value="<?php echo $jurusan['id']; ?>">
                                        <?php endif; ?>
                                        
                                        <div class="mb-3">
                                            <label for="kode_jurusan" class="form-label">
                                                Kode Jurusan <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" id="kode_jurusan" 
                                                   name="kode_jurusan" required
                                                   value="<?php echo $edit ? $jurusan['kode_jurusan'] : ''; ?>"
                                                   placeholder="Contoh: TKJ">
                                            <small class="text-muted">Kode singkat jurusan (maksimal 10 karakter)</small>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="nama_jurusan" class="form-label">
                                                Nama Jurusan <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" id="nama_jurusan" 
                                                   name="nama_jurusan" required
                                                   value="<?php echo $edit ? $jurusan['nama_jurusan'] : ''; ?>"
                                                   placeholder="Contoh: Teknik Komputer dan Jaringan">
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label for="deskripsi" class="form-label">
                                                Deskripsi <span class="text-danger">*</span>
                                            </label>
                                            <textarea class="form-control" id="deskripsi" name="deskripsi" 
                                                      rows="5" required
                                                      placeholder="Deskripsi singkat tentang jurusan..."><?php echo $edit ? $jurusan['deskripsi'] : ''; ?></textarea>
                                        </div>
                                        
                                        <div class="d-flex gap-2">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="bi bi-save"></i> Simpan
                                            </button>
                                            <a href="jurusan.php" class="btn btn-secondary">
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
