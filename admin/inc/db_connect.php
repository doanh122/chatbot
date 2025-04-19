<?php
$host = 'localhost';       // Tên host, thường là localhost
$db_name = 'hotel';     // Tên CSDL
$user = 'root';            // Tên tài khoản
$pass = '';                // Mật khẩu

// Tạo kết nối
$conn = mysqli_connect($host, $user, $pass, $db_name);

// Kiểm tra kết nối
if (!$conn) {
    die("Kết nối CSDL thất bại: " . mysqli_connect_error());
}
?>
