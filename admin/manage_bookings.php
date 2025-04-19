<?php
require('inc/db_connect.php');

// Process actions: delete, add, edit
$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($action === 'delete' && isset($_GET['id'])) {
    // Delete booking by booking_id
    $id = intval($_GET['id']);
    $sql_delete = "DELETE FROM bookings WHERE booking_id = $id";
    if ($conn->query($sql_delete)) {
        header("Location: manage_bookings.php");
        exit;
    } else {
        $error = "Deletion failed: " . $conn->error;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action_type']) && $_POST['action_type'] == 'add') {
        // Add a new booking
        $user_id   = intval($_POST['user_id']);
        $room_id   = intval($_POST['room_id']);
        $check_in  = $conn->real_escape_string($_POST['check_in']);
        $check_out = $conn->real_escape_string($_POST['check_out']);
        $total_price = floatval($_POST['total_price']);
        $status    = $conn->real_escape_string($_POST['status']);

        $sql_insert = "INSERT INTO bookings (user_id, room_id, check_in, check_out, total_price, status)
                       VALUES ($user_id, $room_id, '$check_in', '$check_out', $total_price, '$status')";
        if ($conn->query($sql_insert)) {
            header("Location: manage_bookings.php");
            exit;
        } else {
            $error = "Addition failed: " . $conn->error;
        }
    } elseif (isset($_POST['action_type']) && $_POST['action_type'] == 'edit') {
        // Edit an existing booking
        $booking_id = intval($_POST['booking_id']);
        $user_id   = intval($_POST['user_id']);
        $room_id   = intval($_POST['room_id']);
        $check_in  = $conn->real_escape_string($_POST['check_in']);
        $check_out = $conn->real_escape_string($_POST['check_out']);
        $total_price = floatval($_POST['total_price']);
        $status    = $conn->real_escape_string($_POST['status']);

        $sql_update = "UPDATE bookings 
                       SET user_id=$user_id, room_id=$room_id, check_in='$check_in', check_out='$check_out', 
                           total_price=$total_price, status='$status'
                       WHERE booking_id=$booking_id";
        if ($conn->query($sql_update)) {
            header("Location: manage_bookings.php");
            exit;
        } else {
            $error = "Update failed: " . $conn->error;
        }
    }
}

// Fetch users for the dropdown
$users = [];
$sql_users = "SELECT user_id, full_name FROM users";
$result_users = $conn->query($sql_users);
if ($result_users && $result_users->num_rows > 0) {
    while ($row = $result_users->fetch_assoc()) {
        $users[] = $row;
    }
}

// Fetch rooms for the dropdown
$rooms = [];
$sql_rooms = "SELECT room_id, room_number FROM rooms";
$result_rooms = $conn->query($sql_rooms);
if ($result_rooms && $result_rooms->num_rows > 0) {
    while ($row = $result_rooms->fetch_assoc()) {
        $rooms[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Booking Management - Admin</title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Include Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .container {
      margin-top: 50px;
    }
    .table th, .table td {
      vertical-align: middle;
    }
  </style>
  <?php require('inc/links.php'); ?>
</head>
<body class="bg-light">
  <?php require('inc/header.php'); ?>
  <div class="container-fluid" id="main-content">
    <div class="col-lg-10 ms-auto p-4 overflow-hidden">
      <h2 class="mb-4">Booking Management</h2>
      
      <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
      <?php endif; ?>

      <?php if ($action === 'add'): ?>
        <!-- Add Booking Form -->
        <div class="card">
          <div class="card-header bg-success text-white">Add New Booking</div>
          <div class="card-body">
            <form action="manage_bookings.php" method="post">
              <input type="hidden" name="action_type" value="add">
              
              <div class="mb-3">
                <label for="user_id" class="form-label">User</label>
                <select class="form-select" name="user_id" required>
                  <option value="">-- Select User --</option>
                  <?php foreach ($users as $user): ?>
                    <option value="<?php echo $user['user_id']; ?>"><?php echo htmlspecialchars($user['full_name']); ?></option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="mb-3">
                <label for="room_id" class="form-label">Room</label>
                <select class="form-select" name="room_id" required>
                  <option value="">-- Select Room --</option>
                  <?php foreach ($rooms as $room): ?>
                    <option value="<?php echo $room['room_id']; ?>"><?php echo htmlspecialchars($room['room_number']); ?></option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="mb-3">
                <label for="check_in" class="form-label">Check In Date</label>
                <input type="date" class="form-control" name="check_in" required>
              </div>
              <div class="mb-3">
                <label for="check_out" class="form-label">Check Out Date</label>
                <input type="date" class="form-control" name="check_out" required>
              </div>
              <div class="mb-3">
                <label for="total_price" class="form-label">Total Price</label>
                <input type="number" step="0.01" class="form-control" name="total_price" required>
              </div>
              <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <input type="text" class="form-control" name="status" placeholder="e.g., pending, confirmed" required>
              </div>
              <button type="submit" class="btn btn-success">Add Booking</button>
              <a href="manage_bookings.php" class="btn btn-secondary">Cancel</a>
            </form>
          </div>
        </div>

      <?php elseif ($action === 'edit' && isset($_GET['id'])): ?>
        <?php
          $booking_id = intval($_GET['id']);
          $sql_single = "SELECT * FROM bookings WHERE booking_id = $booking_id";
          $res_single = $conn->query($sql_single);
          if ($res_single && $res_single->num_rows > 0) {
              $data = $res_single->fetch_assoc();
          } else {
              echo '<div class="alert alert-danger">Booking not found.</div>';
          }
        ?>
        <?php if (isset($data)): ?>
          <!-- Edit Booking Form -->
          <div class="card">
            <div class="card-header bg-warning text-white">Edit Booking</div>
            <div class="card-body">
              <form action="manage_bookings.php" method="post">
                <input type="hidden" name="action_type" value="edit">
                <input type="hidden" name="booking_id" value="<?php echo $data['booking_id']; ?>">

                <div class="mb-3">
                  <label for="user_id" class="form-label">User</label>
                  <select class="form-select" name="user_id" required>
                    <option value="">-- Select User --</option>
                    <?php foreach ($users as $user): ?>
                      <option value="<?php echo $user['user_id']; ?>" <?php if($data['user_id'] == $user['user_id']) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($user['full_name']); ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>

                <div class="mb-3">
                  <label for="room_id" class="form-label">Room</label>
                  <select class="form-select" name="room_id" required>
                    <option value="">-- Select Room --</option>
                    <?php foreach ($rooms as $room): ?>
                      <option value="<?php echo $room['room_id']; ?>" <?php if($data['room_id'] == $room['room_id']) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($room['room_number']); ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>

                <div class="mb-3">
                  <label for="check_in" class="form-label">Check In Date</label>
                  <input type="date" class="form-control" name="check_in" value="<?php echo htmlspecialchars($data['check_in']); ?>" required>
                </div>
                <div class="mb-3">
                  <label for="check_out" class="form-label">Check Out Date</label>
                  <input type="date" class="form-control" name="check_out" value="<?php echo htmlspecialchars($data['check_out']); ?>" required>
                </div>
                <div class="mb-3">
                  <label for="total_price" class="form-label">Total Price</label>
                  <input type="number" step="0.01" class="form-control" name="total_price" value="<?php echo htmlspecialchars($data['total_price']); ?>" required>
                </div>
                <div class="mb-3">
                  <label for="status" class="form-label">Status</label>
                  <input type="text" class="form-control" name="status" value="<?php echo htmlspecialchars($data['status']); ?>" required>
                </div>
                <button type="submit" class="btn btn-warning">Update Booking</button>
                <a href="manage_bookings.php" class="btn btn-secondary">Cancel</a>
              </form>
            </div>
          </div>
        <?php endif; ?>

      <?php else: ?>
        <!-- Display Booking List -->
        <div class="card">
          <div class="card-header bg-primary text-white">Booking List</div>
          <div class="card-body">
            <?php
              // Join with users and rooms to display additional details
              $sql = "SELECT b.booking_id, u.full_name, r.room_number, b.check_in, b.check_out, b.booking_date, b.total_price, b.status 
                      FROM bookings b 
                      INNER JOIN users u ON b.user_id = u.user_id 
                      INNER JOIN rooms r ON b.room_id = r.room_id";
              $result = $conn->query($sql);
              if ($result && $result->num_rows > 0):
            ?>
              <table class="table table-bordered table-hover">
                <thead class="table-light">
                  <tr>
                    <th>Booking ID</th>
                    <th>User</th>
                    <th>Room</th>
                    <th>Check In</th>
                    <th>Check Out</th>
                    <th>Booking Date</th>
                    <th>Total Price</th>
                    <th>Status</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                      <td><?php echo htmlspecialchars($row['booking_id']); ?></td>
                      <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                      <td><?php echo htmlspecialchars($row['room_number']); ?></td>
                      <td><?php echo htmlspecialchars($row['check_in']); ?></td>
                      <td><?php echo htmlspecialchars($row['check_out']); ?></td>
                      <td><?php echo htmlspecialchars($row['booking_date']); ?></td>
                      <td><?php echo htmlspecialchars($row['total_price']); ?></td>
                      <td><?php echo htmlspecialchars($row['status']); ?></td>
                      <td>
                        <a href="manage_bookings.php?action=edit&id=<?php echo $row['booking_id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="manage_bookings.php?action=delete&id=<?php echo $row['booking_id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this booking?');">Delete</a>
                      </td>
                    </tr>
                  <?php endwhile; ?>
                </tbody>
              </table>
            <?php else: ?>
              <p class="text-center">No bookings found.</p>
            <?php endif; ?>
          </div>
        </div>
        <div class="mt-3">
          <a href="manage_bookings.php?action=add" class="btn btn-success">Add New Booking</a>
        </div>
      <?php endif; ?>
      
    </div>
  </div>

  <!-- Include Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <?php require('inc/script.php'); ?>
</body>
</html>

<?php
$conn->close();
?>
