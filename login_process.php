<?php
session_start();
require_once 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = secure($_POST['username']);
    $password = $_POST['password'];
    
    $conn = getConnection();
    $query = "SELECT * FROM admin WHERE username = '$username'";
    $result = $conn->query($query);
    
    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();
        
        if (password_verify($password, $admin['password'])) {
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];
            $_SESSION['admin_nama'] = $admin['nama_lengkap'];
            
            redirect('dashboard/index.php');
        } else {
            $_SESSION['error'] = 'Password salah!';
            redirect('login.php');
        }
    } else {
        $_SESSION['error'] = 'Username tidak ditemukan!';
        redirect('login.php');
    }
    
    $conn->close();
} else {
    redirect('login.php');
}
?>
