<?php
require('inc/db_connect.php');
require('inc/header.php');

if (!isset($_GET['room_id'])) {
    echo "<script>alert('Room not found'); window.location.href='rooms.php';</script>";
    exit;
}

$room_id = intval($_GET['room_id']);
$stmt = $con->prepare("SELECT * FROM Rooms WHERE room_id = ?");
$stmt->bind_param("i", $room_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "<script>alert('Room not found'); window.location.href='rooms.php';</script>";
    exit;
}

$row = $result->fetch_assoc();
$room = [
    'room_id' => $row['room_id'],
    'room_number' => $row['room_number'],
    'room_type' => $row['room_type'],
    'room_dientich' => $row['room_dientich'],
    'room_songuoi' => $row['room_songuoi'],
    'price' => $row['price'],
    'description' => $row['description'],
    'facilities' => explode(',', $row['facilities']),
    'status' => $row['status']
];
$room_type = strtolower($room['room_type']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Room Detail</title>
  <?php require('inc/links.php'); ?>
</head>
<body class="bg-light">
<div class="container my-4">
  <a href="rooms.php" class="btn btn-outline-secondary mb-3">&larr; Back to Rooms</a>
  <h2 class="fw-bold text-center mb-4">Room Details</h2>
  <div class="row">
    <!-- Carousel -->
    <div class="col-lg-6 mb-4">
      <div id="roomCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="images/accom/<?= htmlspecialchars($room_type) ?>/main.jpg" class="d-block w-100" alt="Main Room Image" style="height: 400px; object-fit: cover;">
          </div>
          <div class="carousel-item">
            <img src="images/accom/<?= htmlspecialchars($room_type) ?>/1.jpg" class="d-block w-100" alt="Image 1" style="height: 400px; object-fit: cover;">
          </div>
          <div class="carousel-item">
            <img src="images/accom/<?= htmlspecialchars($room_type) ?>/2.jpg" class="d-block w-100" alt="Image 2" style="height: 400px; object-fit: cover;">
          </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#roomCarousel" data-bs-slide="prev">
          <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#roomCarousel" data-bs-slide="next">
          <span class="carousel-control-next-icon"></span>
        </button>
      </div>
    </div>

    <!-- Room Info -->
    <div class="col-lg-6">
      <h3><?= ucfirst(htmlspecialchars($room['room_type'])) ?> (Room <?= htmlspecialchars($room['room_number']) ?>)</h3>
      <p><strong>Area:</strong> <?= htmlspecialchars($room['room_dientich']) ?> &mdash; <strong>Capacity:</strong> <?= htmlspecialchars($room['room_songuoi']) ?> people</p>
      <p><strong>Status:</strong> <?= ucfirst(htmlspecialchars($room['status'])) ?></p>
      <p><strong>Price:</strong> <?= number_format($room['price'], 0, '.', ',') ?> VND / night</p>
      <p><strong>Description:</strong> <?= htmlspecialchars($room['description']) ?></p>
      <p><strong>Facilities:</strong></p>
      <ul>
        <?php foreach ($room['facilities'] as $fac): ?>
          <li><?= htmlspecialchars(trim($fac)) ?></li>
        <?php endforeach; ?>
      </ul>

      <!-- Booking form -->
      <form method="POST" class="mt-4" onsubmit="return validateBookingForm();">
        <input type="hidden" name="room_id" value="<?= $room['room_id'] ?>">
        <div class="row g-2">
          <div class="col-md-6">
            <label class="form-label">Check-In</label>
            <input type="date" name="check_in" id="check_in" class="form-control" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Check-Out</label>
            <input type="date" name="check_out" id="check_out" class="form-control" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Adults</label>
            <input type="number" name="adults" id="adults" class="form-control" min="1" value="1">
          </div>
          <div class="col-md-6">
            <label class="form-label">Children</label>
            <input type="number" name="children" id="children" class="form-control" min="0" value="0">
          </div>
          <div class="col-12">
            <label class="form-label">Other Notes</label>
            <textarea name="note" class="form-control" rows="2"></textarea>
          </div>
        </div>
        <button type="submit" class="btn btn-dark mt-3">Book Now</button>
      </form>
    </div>
  </div>
</div>

<?php
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (!isset($_SESSION['user'])) {
      echo "<script>alert('Please log in first'); window.location.href = 'login.php';</script>";
      exit;
  }

  $room_id = $_POST['room_id'];
  $check_in = $_POST['check_in'];
  $check_out = $_POST['check_out'];
  $adults = $_POST['adults'];
  $children = $_POST['children'];
  $note = $_POST['note'];
  $status = 'unpaid';
  $user_id = $_SESSION['user']['user_id'];

  if (strtotime($check_in) >= strtotime($check_out)) {
      echo "<script>alert('Check-out date must be after check-in date.');</script>";
  } else {
      // Calculate the total number of nights
      $check_in_date = strtotime($check_in);
      $check_out_date = strtotime($check_out);
      $total_nights = ($check_out_date - $check_in_date) / (60 * 60 * 24); // Convert seconds to days

      // Calculate total price (price per night * number of nights * number of adults)
      $total_price = $room['price'] * $total_nights;;// * $adults;

      // Insert the booking into the database
      $insert_query = "INSERT INTO bookings (user_id, room_id, check_in, check_out, adults, children, note, status, total_price) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
      $stmt = $con->prepare($insert_query);
      $stmt->bind_param("iissiiisi", $user_id, $room_id, $check_in, $check_out, $adults, $children, $note, $status, $total_price);

      // $insert_query = "INSERT INTO bookings (user_id, room_id, check_in, check_out, adults, children, note, status) 
      //                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
      // $stmt = $con->prepare($insert_query);
      // $stmt->bind_param("iissiiis", $user_id, $room_id, $check_in, $check_out, $adults, $children, $note, $status);

      if ($stmt->execute()) {
          echo "<script>alert('Booking successful!'); window.location.href = 'mybooking.php';</script>";
      } else {
          echo "<script>alert('Booking failed: " . $stmt->error . "');</script>";
      }
  }
}

?>

<script>
// Form validation function
function validateBookingForm() {
  const checkIn = new Date(document.getElementById("check_in").value);
  const checkOut = new Date(document.getElementById("check_out").value);
  const adults = parseInt(document.getElementById("adults").value);
  const children = parseInt(document.getElementById("children").value);
  const maxGuests = <?= $room['room_songuoi'] ?>;

  if (!checkIn || !checkOut || checkOut <= checkIn) {
    alert("Check-out must be after check-in.");
    return false;
  }
  if (adults + children > maxGuests) {
    alert("Total guests exceed room capacity.");
    return false;
  }
  return true;
}
</script>

<?php require('inc/footer.php'); ?>
</body>
</html>
