<?php
session_start();

// Hủy tất cả dữ liệu phiên
session_unset();
session_destroy();

// Chuyển hướng về trang chủ sau khi đăng xuất
header("Location: index.php");  // Hoặc trang mà bạn muốn người dùng quay lại sau khi đăng xuất
exit;
?>
