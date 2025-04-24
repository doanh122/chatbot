<?php
require('inc/db_connect.php');
$action = $_GET['action'] ?? '';

if ($action === 'delete' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "DELETE FROM payments WHERE payment_id = $id";
    if ($conn->query($sql)) {
        header("Location: manage_payment.php");
        exit;
    } else {
        $error = "Deletion failed: " . $conn->error;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $booking_id = intval($_POST['booking_id']);
    $amount = floatval($_POST['amount']);
    $payment_method = $conn->real_escape_string($_POST['payment_method']);
    $status = $conn->real_escape_string($_POST['status']);
    $payment_date = date('Y-m-d H:i:s');

    if ($_POST['action_type'] == 'add') {
        $sql = "INSERT INTO payments (booking_id, amount, payment_method, status, payment_date) 
                VALUES ($booking_id, $amount, '$payment_method', '$status', '$payment_date')";
    } elseif ($_POST['action_type'] == 'edit') {
        $payment_id = intval($_POST['payment_id']);
        $sql = "UPDATE payments SET booking_id=$booking_id, amount=$amount, 
                payment_method='$payment_method', status='$status', payment_date='$payment_date' 
                WHERE payment_id=$payment_id";
    }

    if ($conn->query($sql)) {
        header("Location: manage_payment.php");
        exit;
    } else {
        $error = "Database error: " . $conn->error;
    }
}

// Lấy danh sách booking cho dropdown
$bookings = [];
$booking_sql = "SELECT booking_id FROM bookings";
$res_booking = $conn->query($booking_sql);
if ($res_booking && $res_booking->num_rows > 0) {
    while ($row = $res_booking->fetch_assoc()) {
        $bookings[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Payment Management - Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php require('inc/links.php'); ?>
</head>
<body class="bg-light">
<?php require('inc/header.php'); ?>
<div class="container-fluid" id="main-content">
  <div class="col-lg-10 ms-auto p-4 overflow-hidden">
    <h2 class="mb-4">Payment Management</h2>

    <?php if (isset($error)): ?>
      <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <?php if ($action === 'add' || ($action === 'edit' && isset($_GET['id']))): ?>
      <?php
        $payment_data = [
            'payment_id' => '',
            'booking_id' => '',
            'amount' => '',
            'payment_method' => '',
            'status' => ''
        ];
        if ($action === 'edit') {
            $id = intval($_GET['id']);
            $sql_edit = "SELECT * FROM payments WHERE payment_id = $id";
            $res_edit = $conn->query($sql_edit);
            if ($res_edit && $res_edit->num_rows > 0) {
                $payment_data = $res_edit->fetch_assoc();
            }
        }
      ?>
      <div class="card">
        <div class="card-header bg-<?php echo $action === 'add' ? 'success' : 'warning'; ?> text-white">
          <?php echo $action === 'add' ? 'Add New Payment' : 'Edit Payment'; ?>
        </div>
        <div class="card-body">
          <form action="manage_payment.php" method="post">
            <input type="hidden" name="action_type" value="<?php echo $action; ?>">
            <?php if ($action === 'edit'): ?>
              <input type="hidden" name="payment_id" value="<?php echo $payment_data['payment_id']; ?>">
            <?php endif; ?>

            <div class="mb-3">
              <label class="form-label">Booking ID</label>
              <select class="form-select" name="booking_id" required>
                <option value="">-- Select Booking ID --</option>
                <?php foreach ($bookings as $booking): ?>
                  <option value="<?php echo $booking['booking_id']; ?>" <?php if ($booking['booking_id'] == $payment_data['booking_id']) echo 'selected'; ?>>
                    <?php echo $booking['booking_id']; ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">Amount</label>
              <input type="number" class="form-control" name="amount" step="0.01" required value="<?php echo $payment_data['amount']; ?>">
            </div>
            <div class="mb-3">
              <label class="form-label">Payment Method</label>
              <input type="text" class="form-control" name="payment_method" required value="<?php echo $payment_data['payment_method']; ?>">
            </div>
            <div class="mb-3">
              <label class="form-label">Status</label>
              <input type="text" class="form-control" name="status" required value="<?php echo $payment_data['status']; ?>">
            </div>
            <button type="submit" class="btn btn-<?php echo $action === 'add' ? 'success' : 'warning'; ?>">
              <?php echo $action === 'add' ? 'Add Payment' : 'Update Payment'; ?>
            </button>
            <a href="manage_payment.php" class="btn btn-secondary">Cancel</a>
          </form>
        </div>
      </div>
    <?php else: ?>
      <!-- Hiển thị danh sách payment -->
      <div class="card">
        <div class="card-header bg-primary text-white">Payment List</div>
        <div class="card-body">
          <?php
            $sql = "SELECT * FROM payments ORDER BY payment_date DESC";
            $res = $conn->query($sql);
            if ($res && $res->num_rows > 0):
          ?>
          <table class="table table-bordered table-hover">
            <thead class="table-light">
              <tr>
                <th>Payment ID</th>
                <th>Booking ID</th>
                <th>Payment Date</th>
                <th>Amount</th>
                <th>Method</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php while($row = $res->fetch_assoc()): ?>
              <tr>
                <td><?php echo $row['payment_id']; ?></td>
                <td><?php echo $row['booking_id']; ?></td>
                <td><?php echo $row['payment_date']; ?></td>
                <td>$<?php echo number_format($row['amount'], 2); ?></td>
                <td><?php echo htmlspecialchars($row['payment_method']); ?></td>
                <td><?php echo htmlspecialchars($row['status']); ?></td>
                <td>
                  <a href="manage_payment.php?action=edit&id=<?php echo $row['payment_id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                  <a href="manage_payment.php?action=delete&id=<?php echo $row['payment_id']; ?>" class="btn btn-sm btn-danger"
                     onclick="return confirm('Are you sure you want to delete this payment?');">Delete</a>
                </td>
              </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
          <?php else: ?>
            <p class="text-center">No payments found.</p>
          <?php endif; ?>
        </div>
      </div>
      <div class="mt-3">
        <a href="manage_payment.php?action=add" class="btn btn-success">Add New Payment</a>
      </div>
    <?php endif; ?>
  </div>
</div>
<?php require('inc/script.php'); ?>
</body>
</html>

<?php $conn->close(); ?>
