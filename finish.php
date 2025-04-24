<?php
require('inc/db_connect.php');  // Gọi file kết nối CSDL
session_start();

echo "<script>alert('Payment successful!');</script>";

// Kiểm tra xem booking_id có tồn tại trong bảng bookings không
$booking_id = $_SESSION['bookingId'];
$sql_check_booking = "SELECT * FROM bookings WHERE booking_id = ?";
$stmt_check = $conn->prepare($sql_check_booking);
$stmt_check->bind_param("i", $booking_id);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows == 0) {
    echo "<script>alert('Booking not found!'); window.location.href = 'mybooking.php';</script>";
    die();
}

// Thêm thông tin thanh toán vào bảng Payments
$insert_q = "INSERT INTO Payments (booking_id, amount, payment_method, status) VALUES (?,?,?,?)";
$stmt2 = $conn->prepare($insert_q);

// Kiểm tra xem câu lệnh có được chuẩn bị thành công không
if ($stmt2 === false) {
    // In ra lỗi SQL nếu không chuẩn bị câu lệnh được
    echo "Error preparing statement: " . $conn->error;
    die();
}

$total = $_SESSION['amount'];
$payment_method = "Online";
$status = "completed";

// Gắn tham số cho câu lệnh SQL
$stmt2->bind_param("idss", $booking_id, $total, $payment_method, $status);

// Thực thi câu lệnh
if (!$stmt2->execute()) {
    // Kiểm tra và in ra lỗi nếu thực thi câu lệnh không thành công
    echo "Error executing query: " . $stmt2->error;
    die();
}

// Cập nhật trạng thái trong bảng Bookings sang 'completed'
$update_q = "UPDATE Bookings SET status = ? WHERE booking_id = ?";
$stmt3 = $conn->prepare($update_q);

// Kiểm tra xem câu lệnh có được chuẩn bị thành công không
if ($stmt3 === false) {
    // In ra lỗi SQL nếu không chuẩn bị câu lệnh được
    echo "Error preparing update statement: " . $conn->error;
    die();
}

$new_status = "paid";
$stmt3->bind_param("si", $new_status, $booking_id);
$stmt3->execute();

// Sau khi cập nhật, bạn có thể chuyển hướng hoặc thông báo cho người dùng
echo "<script>window.location.href = 'mybooking.php';</script>";
die();
?>
