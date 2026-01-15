<?php
// Test koneksi database
echo "<h1>Test Koneksi Database SMKN 2 Bengkalis</h1>";

// Konfigurasi
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'smk2bengkalis';

echo "<h3>Step 1: Test Koneksi MySQL</h3>";
$conn = new mysqli($host, $user, $pass);

if ($conn->connect_error) {
    echo "❌ <strong style='color:red;'>GAGAL:</strong> Koneksi MySQL gagal: " . $conn->connect_error . "<br>";
    die();
} else {
    echo "✅ <strong style='color:green;'>BERHASIL:</strong> Koneksi MySQL berhasil!<br><br>";
}

echo "<h3>Step 2: Test Database 'smk2bengkalis'</h3>";
$db_selected = $conn->select_db($dbname);

if (!$db_selected) {
    echo "❌ <strong style='color:red;'>GAGAL:</strong> Database '$dbname' tidak ditemukan!<br>";
    echo "<strong>Solusi:</strong> Silakan buat database dengan nama 'smk2bengkalis' dan import file database.sql<br><br>";
    
    echo "<h3>Cara Membuat Database:</h3>";
    echo "<ol>";
    echo "<li>Buka <a href='http://localhost/phpmyadmin' target='_blank'>http://localhost/phpmyadmin</a></li>";
    echo "<li>Klik 'New' atau 'Database'</li>";
    echo "<li>Nama database: <strong>smk2bengkalis</strong></li>";
    echo "<li>Klik 'Create'</li>";
    echo "<li>Klik database yang baru dibuat</li>";
    echo "<li>Klik tab 'Import'</li>";
    echo "<li>Pilih file <strong>database.sql</strong></li>";
    echo "<li>Klik 'Go'</li>";
    echo "</ol>";
    
    $conn->close();
    die();
} else {
    echo "✅ <strong style='color:green;'>BERHASIL:</strong> Database '$dbname' ditemukan!<br><br>";
}

echo "<h3>Step 3: Test Tabel 'admin'</h3>";
$result = $conn->query("SHOW TABLES LIKE 'admin'");

if ($result->num_rows == 0) {
    echo "❌ <strong style='color:red;'>GAGAL:</strong> Tabel 'admin' tidak ditemukan!<br>";
    echo "<strong>Solusi:</strong> Database belum di-import! Silakan import file database.sql<br><br>";
    $conn->close();
    die();
} else {
    echo "✅ <strong style='color:green;'>BERHASIL:</strong> Tabel 'admin' ditemukan!<br><br>";
}

echo "<h3>Step 4: Test Data Admin</h3>";
$result = $conn->query("SELECT * FROM admin");

if ($result->num_rows == 0) {
    echo "❌ <strong style='color:red;'>GAGAL:</strong> Data admin kosong!<br>";
    echo "<strong>Solusi:</strong> Jalankan query berikut di phpMyAdmin:<br>";
    echo "<code>INSERT INTO admin (username, password, nama_lengkap) VALUES ('admin', '\$2y\$10\$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator');</code><br><br>";
    $conn->close();
    die();
} else {
    echo "✅ <strong style='color:green;'>BERHASIL:</strong> Data admin ditemukan!<br>";
    
    echo "<h4>Data Admin yang Ada:</h4>";
    echo "<table border='1' cellpadding='10' style='border-collapse: collapse;'>";
    echo "<tr><th>ID</th><th>Username</th><th>Nama Lengkap</th><th>Password Hash</th></tr>";
    
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td><strong>" . $row['username'] . "</strong></td>";
        echo "<td>" . $row['nama_lengkap'] . "</td>";
        echo "<td style='font-size:10px;'>" . substr($row['password'], 0, 30) . "...</td>";
        echo "</tr>";
    }
    echo "</table><br>";
}

echo "<h3>Step 5: Test Password Verification</h3>";
$test_password = 'admin123';
$result = $conn->query("SELECT * FROM admin WHERE username = 'admin'");

if ($result->num_rows > 0) {
    $admin = $result->fetch_assoc();
    
    echo "Username: <strong>" . $admin['username'] . "</strong><br>";
    echo "Password yang ditest: <strong>" . $test_password . "</strong><br>";
    echo "Password hash di database: <code style='font-size:10px;'>" . $admin['password'] . "</code><br><br>";
    
    if (password_verify($test_password, $admin['password'])) {
        echo "✅ <strong style='color:green;'>BERHASIL:</strong> Password 'admin123' cocok!<br>";
        echo "<strong>Login seharusnya bisa dengan:</strong><br>";
        echo "Username: <strong>admin</strong><br>";
        echo "Password: <strong>admin123</strong><br><br>";
    } else {
        echo "❌ <strong style='color:red;'>GAGAL:</strong> Password hash tidak cocok!<br>";
        echo "<strong>Solusi:</strong> Password hash di database salah. Jalankan query berikut untuk reset password:<br><br>";
        
        $new_hash = password_hash('admin123', PASSWORD_DEFAULT);
        echo "<code>UPDATE admin SET password = '$new_hash' WHERE username = 'admin';</code><br><br>";
        
        echo "Atau klik tombol di bawah untuk reset otomatis:<br>";
        echo "<form method='POST' action='test_connection.php'>";
        echo "<input type='hidden' name='reset_password' value='1'>";
        echo "<button type='submit' style='padding:10px 20px; background:#dc3545; color:white; border:none; border-radius:5px; cursor:pointer;'>Reset Password Admin</button>";
        echo "</form>";
    }
}

// Handle reset password
if (isset($_POST['reset_password'])) {
    $new_hash = password_hash('admin1234', PASSWORD_DEFAULT);
    $update = $conn->query("UPDATE admin SET password = '$new_hash' WHERE username = 'admin'");
    
    if ($update) {
        echo "<br><div style='background:#d4edda; border:1px solid #c3e6cb; padding:15px; border-radius:5px; color:#155724;'>";
        echo "✅ <strong>BERHASIL!</strong> Password admin telah direset ke 'admin123'<br>";
        echo "Silakan refresh halaman ini atau <a href='login.php'>login sekarang</a>";
        echo "</div>";
    } else {
        echo "<br><div style='background:#f8d7da; border:1px solid #f5c6cb; padding:15px; border-radius:5px; color:#721c24;'>";
        echo "❌ <strong>GAGAL!</strong> Error: " . $conn->error;
        echo "</div>";
    }
}

echo "<br><hr><br>";
echo "<h3>📊 Kesimpulan:</h3>";

$all_check = true;

// Check all again
$conn2 = new mysqli($host, $user, $pass, $dbname);
if ($conn2->connect_error) {
    echo "❌ Koneksi database gagal<br>";
    $all_check = false;
} else {
    $table_check = $conn2->query("SHOW TABLES LIKE 'admin'");
    if ($table_check->num_rows == 0) {
        echo "❌ Tabel admin tidak ada<br>";
        $all_check = false;
    } else {
        $admin_check = $conn2->query("SELECT * FROM admin WHERE username = 'admin'");
        if ($admin_check->num_rows == 0) {
            echo "❌ Data admin tidak ada<br>";
            $all_check = false;
        } else {
            $admin_data = $admin_check->fetch_assoc();
            if (!password_verify('admin123', $admin_data['password'])) {
                echo "❌ Password hash tidak cocok<br>";
                $all_check = false;
            }
        }
    }
    $conn2->close();
}

if ($all_check) {
    echo "<div style='background:#d4edda; border:2px solid #28a745; padding:20px; border-radius:10px;'>";
    echo "<h2 style='color:#155724; margin:0;'>🎉 SEMUA BERHASIL!</h2>";
    echo "<p style='color:#155724; margin:10px 0 0 0;'>Database terkoneksi dengan baik. Login seharusnya bisa dilakukan!</p>";
    echo "<a href='login.php' style='display:inline-block; margin-top:15px; padding:12px 25px; background:#28a745; color:white; text-decoration:none; border-radius:5px; font-weight:bold;'>🔐 Login Sekarang</a>";
    echo "</div>";
} else {
    echo "<div style='background:#f8d7da; border:2px solid #dc3545; padding:20px; border-radius:10px;'>";
    echo "<h2 style='color:#721c24; margin:0;'>⚠️ ADA MASALAH!</h2>";
    echo "<p style='color:#721c24; margin:10px 0 0 0;'>Perbaiki error di atas terlebih dahulu.</p>";
    echo "</div>";
}

$conn->close();

echo "<br><hr><br>";
echo "<p><small>File test ini: <strong>test_connection.php</strong> - Hapus file ini setelah selesai debugging</small></p>";
?>
