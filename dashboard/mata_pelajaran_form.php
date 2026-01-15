<?php
require_once '../config/database.php';
checkLogin();

$conn = getConnection();
$edit = false;
$mapel = null;

// Get all jurusan for dropdown
$query_jurusan = "SELECT * FROM jurusan ORDER BY kode_jurusan ASC";
$result_jurusan = $conn->query($query_jurusan);

// Check if edit mode
if (isset($_GET['edit'])) {
    $edit = true;
    $id = secure($_GET['edit']);
    $query = "SELECT * FROM mata_pelajaran WHERE id = '$id'";
    $result = $conn->query($query);
    $mapel = $result->fetch_assoc();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode_mapel = secure($_POST['kode_mapel']);
    $nama_mapel = secure($_POST['nama_mapel']);
    $jurusan_id = !empty($_POST['jurusan_id']) ? secure($_POST['jurusan_id']) : 'NULL';
    $deskripsi = secure($_POST['deskripsi']);
    
    if (isset($_POST['id']) && !empty($_POST['id'])) {
        // Update
        $id = secure($_POST['id']);
        if ($jurusan_id == 'NULL') {
            $query = "UPDATE mata_pelajaran SET 
                      kode_mapel = '$kode_mapel',
                      nama_mapel = '$nama_mapel',
                      jurusan_id = NULL,
                      deskripsi = '$deskripsi'
                      WHERE id = '$id'";
        } else {
            $query = "UPDATE mata_pelajaran SET 
                      kode_mapel = '$kode_mapel',
                      nama_mapel = '$nama_mapel',
                      jurusan_id = '$jurusan_id',
                      deskripsi = '$deskripsi'
                      WHERE id = '$id'";
        }
        $success_msg = 'Data mata pelajaran berhasil diupdate!';
    } else {
        // Insert
        if ($jurusan_id == 'NULL') {
            $query = "INSERT INTO mata_pelajaran (kode_mapel, nama_mapel, jurusan_id, deskripsi) 
                      VALUES ('$kode_mapel', '$nama_mapel', NULL, '$deskripsi')";
        } else {
            $query = "INSERT INTO mata_pelajaran (kode_mapel, nama_mapel, jurusan_id, deskripsi) 
                      VALUES ('$kode_mapel', '$nama_mapel', '$jurusan_id', '$deskripsi')";
        }
        $success_msg = 'Data mata pelajaran berhasil ditambahkan!';
    }
    
    if ($conn->query($query)) {
        $_SESSION['success'] = $success_msg;
        redirect('mata_pelajaran.php');
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
    <title><?php echo $edit ? 'Edit' : 'Tambah'; ?> Mata Pelajaran - SMKN 2 Bengkalis</title>
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
                    <a class="nav-link" href="jurusan.php">
                        <i class="bi bi-book"></i> Data Jurusan
                    </a>
                    <a class="nav-link active" href="mata_pelajaran.php">
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
                            <i class="bi bi-journal-text"></i> <?php echo $edit ? 'Edit' : 'Tambah'; ?> Mata Pelajaran
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
                                        Form <?php echo $edit ? 'Edit' : 'Tambah'; ?> Mata Pelajaran
                                    </h5>
                                </div>
                                <div class="card-body p-4">
                                    <form method="POST" action="">
                                        <?php if ($edit): ?>
                                            <input type="hidden" name="id" value="<?php echo $mapel['id']; ?>">
                                        <?php endif; ?>
                                        
                                        <div class="mb-3">
                                            <label for="kode_mapel" class="form-label">
                                                Kode Mata Pelajaran <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" id="kode_mapel" 
                                                   name="kode_mapel" required
                                                   value="<?php echo $edit ? $mapel['kode_mapel'] : ''; ?>"
                                                   placeholder="Contoh: TKJ-01">
                                            <small class="text-muted">Kode unik untuk mata pelajaran</small>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="nama_mapel" class="form-label">
                                                Nama Mata Pelajaran <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" id="nama_mapel" 
                                                   name="nama_mapel" required
                                                   value="<?php echo $edit ? $mapel['nama_mapel'] : ''; ?>"
                                                   placeholder="Contoh: Administrasi Infrastruktur Jaringan">
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="jurusan_id" class="form-label">
                                                Jurusan
                                            </label>
                                            <select class="form-select" id="jurusan_id" name="jurusan_id">
                                                <option value="">- Pilih Jurusan (Opsional) -</option>
                                                <?php while ($jurusan = $result_jurusan->fetch_assoc()): ?>
                                                    <option value="<?php echo $jurusan['id']; ?>"
                                                            <?php echo ($edit && $mapel['jurusan_id'] == $jurusan['id']) ? 'selected' : ''; ?>>
                                                        <?php echo $jurusan['kode_jurusan'] . ' - ' . $jurusan['nama_jurusan']; ?>
                                                    </option>
                                                <?php endwhile; ?>
                                            </select>
                                            <small class="text-muted">Pilih jurusan yang terkait dengan mata pelajaran ini</small>
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label for="deskripsi" class="form-label">
                                                Deskripsi <span class="text-danger">*</span>
                                            </label>
                                            <textarea class="form-control" id="deskripsi" name="deskripsi" 
                                                      rows="5" required
                                                      placeholder="Deskripsi singkat tentang mata pelajaran..."><?php echo $edit ? $mapel['deskripsi'] : ''; ?></textarea>
                                        </div>
                                        
                                        <div class="d-flex gap-2">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="bi bi-save"></i> Simpan
                                            </button>
                                            <a href="mata_pelajaran.php" class="btn btn-secondary">
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
