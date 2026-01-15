<?php
require_once '../config/database.php';
checkLogin();

$conn = getConnection();

// Handle Delete
if (isset($_GET['delete'])) {
    $id = secure($_GET['delete']);
    $query = "DELETE FROM mata_pelajaran WHERE id = '$id'";
    if ($conn->query($query)) {
        $_SESSION['success'] = 'Data mata pelajaran berhasil dihapus!';
    } else {
        $_SESSION['error'] = 'Gagal menghapus data mata pelajaran!';
    }
    redirect('mata_pelajaran.php');
}

// Get all mata pelajaran with jurusan
$query = "SELECT mp.*, j.nama_jurusan, j.kode_jurusan 
          FROM mata_pelajaran mp 
          LEFT JOIN jurusan j ON mp.jurusan_id = j.id 
          ORDER BY mp.kode_mapel ASC";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mata Pelajaran - SMKN 2 Bengkalis</title>
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
        
        .table-card {
            border-radius: 15px;
            border: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .btn-action {
            padding: 5px 10px;
            font-size: 14px;
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
                            <i class="bi bi-journal-text"></i> Data Mata Pelajaran
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
                    
                    <div class="card table-card">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Daftar Mata Pelajaran</h5>
                            <a href="mata_pelajaran_form.php" class="btn btn-primary">
                                <i class="bi bi-plus-circle"></i> Tambah Mata Pelajaran
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="5%">No</th>
                                            <th width="12%">Kode Mapel</th>
                                            <th width="25%">Nama Mata Pelajaran</th>
                                            <th width="15%">Jurusan</th>
                                            <th width="30%">Deskripsi</th>
                                            <th width="13%" class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($result->num_rows > 0): ?>
                                            <?php $no = 1; while ($row = $result->fetch_assoc()): ?>
                                                <tr>
                                                    <td><?php echo $no++; ?></td>
                                                    <td><span class="badge bg-success"><?php echo $row['kode_mapel']; ?></span></td>
                                                    <td><strong><?php echo $row['nama_mapel']; ?></strong></td>
                                                    <td>
                                                        <?php if ($row['nama_jurusan']): ?>
                                                            <span class="badge bg-primary">
                                                                <?php echo $row['kode_jurusan']; ?>
                                                            </span>
                                                        <?php else: ?>
                                                            <span class="text-muted">-</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?php echo substr($row['deskripsi'], 0, 80) . '...'; ?></td>
                                                    <td class="text-center">
                                                        <a href="mata_pelajaran_form.php?edit=<?php echo $row['id']; ?>" 
                                                           class="btn btn-sm btn-warning btn-action">
                                                            <i class="bi bi-pencil"></i>
                                                        </a>
                                                        <a href="mata_pelajaran.php?delete=<?php echo $row['id']; ?>" 
                                                           class="btn btn-sm btn-danger btn-action"
                                                           onclick="return confirm('Yakin ingin menghapus mata pelajaran ini?')">
                                                            <i class="bi bi-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endwhile; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="6" class="text-center text-muted py-4">
                                                    <i class="bi bi-inbox" style="font-size: 48px;"></i>
                                                    <p class="mt-2">Belum ada data mata pelajaran</p>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
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
