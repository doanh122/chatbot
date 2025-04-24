<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings</title>
    <?php require('inc/links.php'); ?>
    <style>
        .card-img-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }
        .card-img-container img {
            max-width: 100%;
            max-height: 100%;
            object-fit: cover;
        }
        .dadangnhap {
            display: none;
        }
    </style>
</head>
<body class="bg-light">

<?php
require('inc/header.php');
$user_id = $_SESSION['user']['user_id'];

// Lấy thông tin booking của người dùng
$sql = "SELECT b.*, r.room_number, r.room_type, r.room_dientich, r.room_songuoi, r.price AS room_price 
        FROM Bookings b 
        JOIN Rooms r ON b.room_id = r.room_id 
        WHERE b.user_id = ? 
        ORDER BY b.booking_date DESC";

$stmt = $con->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="my-5 px-4">
    <h2 class="fw-bold h-font text-center">Your Bookings</h2>
    <div class="h-line bg-dark"></div>
</div>

<div class="container">
    <?php if($result->num_rows > 0): ?>
        <div class="row">
            <?php while($booking = $result->fetch_assoc()): ?>
                <div class="col-md-6 mb-4">
                    <div class="card shadow">
                        <div class="row g-0">
                            <div class="col-md-4 card-img-container">
                                <?php
                                $room_number = $booking['room_number'];
                                $room_type = strtolower($booking['room_type']); // room, suite, villa
                                $room_img_path = "images/accom/{$room_type}/{$room_number}.jpg"; // Lấy ảnh phòng dựa vào room_number

                                ?>
                                <img src="<?php echo $room_img_path; ?>"
                                     class="img-fluid rounded-start"
                                     alt="Room Image"
                                     onerror="this.onerror=null;this.src='images/101.jpg';"> <!-- Sử dụng ảnh mặc định nếu không có ảnh phòng -->
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo ucfirst($booking['room_type']); ?> (Room <?php echo $booking['room_number']; ?>)</h5>
                                    <p>
                                        <strong>Area:</strong> <?php echo $booking['room_dientich']; ?> <br>
                                        <strong>Capacity:</strong> Maximum <?php echo $booking['room_songuoi']; ?> people <br>
                                        <strong>Price:</strong> <?php echo number_format($booking['room_price'], 0, '.', ','); ?> VND 
                                    </p>
                                    <hr>
                                    <p>
                                        <strong>Check-in:</strong> <?php echo $booking['check_in']; ?> <br>
                                        <strong>Check-out:</strong> <?php echo $booking['check_out']; ?> <br>
                                        <strong>Date of booking:</strong> <?php echo $booking['booking_date']; ?> <br>
                                        <strong>Total:</strong> <?php echo number_format($booking['total_price'], 0, '.', ','); ?> VND
                                    </p>
                                    <?php if($booking['status'] == "paid"): ?>
                                        <button class="btn btn-success" disabled>Paid</button> <!-- Xanh lá cho Paid -->
                                    <?php elseif($booking['status'] == "cancelled"): ?>
                                        <button class="btn btn-danger" disabled>Cancelled</button> <!-- Đỏ cho Cancelled -->
                                    <?php else: ?>
                                        <a href="booking/process_payment.php?booking_id=<?php echo $booking['booking_id']; ?>&total=<?php echo $booking['total_price']; ?>" 
                                        class="btn btn-primary">Pay</a> <!-- Xanh dương cho Pay -->
                                        <a href="mybooking.php?action=cancel&booking_id=<?php echo $booking['booking_id']; ?>" 
                                        class="btn btn-warning"
                                        onclick="return confirm('Are you sure you want to cancel this booking?');">Cancel</a> <!-- Vàng cho Cancel -->
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p class="text-center">You have not booked any rooms yet.</p>
    <?php endif; ?>
</div>

<?php
// Handle cancel action
if (isset($_GET['action']) && $_GET['action'] == 'cancel' && isset($_GET['booking_id'])) {
    $booking_id = intval($_GET['booking_id']);
    $user_id = $_SESSION['user']['user_id'];

    $cancelSql = "UPDATE Bookings SET status = 'cancelled' WHERE booking_id = ? AND user_id = ?";
    $stmtCancel = $con->prepare($cancelSql);
    $stmtCancel->bind_param("ii", $booking_id, $user_id);
    if ($stmtCancel->execute()) {
        echo "<script>alert('Booking cancelled successfully'); window.location.href = 'mybooking.php';</script>";
    } else {
        echo "<script>alert('Failed to cancel booking');</script>";
    }
}
?>

<?php require('inc/footer.php'); ?>
<?php mysqli_close($con); ?>

<script src="./js/auth.js"></script>
</body>
</html>
