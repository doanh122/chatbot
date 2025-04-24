<?php
require('inc/db_connect.php');
require('inc/header.php');

// Fetch the room details from the URL
if (isset($_GET['room_id']) && is_numeric($_GET['room_id'])) {
    $room_id = $_GET['room_id'];
    $query = "SELECT * FROM Rooms WHERE room_id = $room_id";
    $result = mysqli_query($conn, $query);
    $room = mysqli_fetch_assoc($result);

    // Check if room exists
    if (!$room) {
        echo "<script>alert('Room not found'); window.location.href='rooms.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('Invalid room ID'); window.location.href='rooms.php';</script>";
    exit;
}

// Handle form submission for booking
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = 1;  // Assuming the user is logged in, replace with actual session user ID
    $room_id = $_POST['room_id'];
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];
    $adults = $_POST['adults'];
    $children = $_POST['children'];
    $total_price = $_POST['total_price'];  // This can be calculated based on room price and number of nights
    $note = $_POST['note'];
    
    $booking_date = date('Y-m-d H:i:s'); // Current timestamp for booking date
    $status = 'pending'; // Assuming the default status is 'pending'

    $query = "INSERT INTO Bookings (user_id, room_id, check_in, check_out, booking_date, total_price, status, adults, children, note) 
              VALUES ('$user_id', '$room_id', '$check_in', '$check_out', '$booking_date', '$total_price', '$status', '$adults', '$children', '$note')";
    
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Booking confirmed!'); window.location.href='booking_success.php';</script>";
    } else {
        echo "<script>alert('Booking failed. Please try again later.'); window.location.href='booking.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book Room - <?php echo $room['room_number']; ?></title>
    <?php require('inc/links.php'); ?>
    <style>
        .booking-form input, .booking-form select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
        }

        .btn {
            width: 100%;
            padding: 12px;
            background-color: #212529;
            color: white;
            font-size: 16px;
            border-radius: 6px;
        }
        
        .btn:hover {
            background-color: #333;
        }
    </style>
</head>
<body class="bg-light">

<div class="container my-5">
    <h2 class="fw-bold h-font text-center">Booking Details - Room <?php echo $room['room_number']; ?></h2>
    <div class="h-line bg-dark"></div>

    <div class="row">
        <!-- Room details -->
        <div class="col-lg-6">
            <div class="card mb-4 shadow">
                <div class="row g-0">
                    <div class="col-md-4 card-img-container">
                        <img src="images/accom/<?php echo strtolower($room['room_type']); ?>/<?php echo $room['room_number']; ?>.jpg" class="img-fluid rounded-start" alt="Room Image">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo ucfirst($room['room_type']); ?> (Room <?php echo $room['room_number']; ?>)</h5>
                            <p><strong>Area:</strong> <?php echo $room['room_dientich']; ?> — <strong>Max:</strong> <?php echo $room['room_songuoi']; ?> guests</p>
                            <p><strong>Status:</strong> <?php echo ucfirst($room['status']); ?></p>
                            <p><strong>Price:</strong> <?php echo number_format($room['price'], 0, '.', ','); ?> VND</p>
                            <p><strong>Description:</strong> <?php echo $room['description']; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Booking Form -->
        <div class="col-lg-6">
            <div class="bg-white p-4 rounded shadow-sm">
                <h4 class="mb-3">Book This Room</h4>
                <form class="booking-form" action="booking.php" method="POST">
                    <input type="hidden" name="room_id" value="<?php echo $room['room_id']; ?>">
                    <input type="hidden" name="room_number" value="<?php echo $room['room_number']; ?>">

                    <label for="check_in">Check-in Date</label>
                    <input type="date" id="check_in" name="check_in" required>

                    <label for="check_out">Check-out Date</label>
                    <input type="date" id="check_out" name="check_out" required>

                    <label for="adults">Number of Adults</label>
                    <input type="number" id="adults" name="adults" min="1" value="1" required>

                    <label for="children">Number of Children</label>
                    <input type="number" id="children" name="children" min="0" value="0">

                    <label for="total_price">Total Price (VND)</label>
                    <input type="number" id="total_price" name="total_price" value="<?php echo $room['price']; ?>" readonly>

                
                    <button type="submit" class="btn">Confirm Booking</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require('inc/footer.php'); ?>

</body>
</html>
