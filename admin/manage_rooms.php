<?php
require('inc/db_connect.php');

// Process actions: delete, add, edit
$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($action === 'delete' && isset($_GET['id'])) {
    // Delete room by id
    $id = intval($_GET['id']);
    $sql_delete = "DELETE FROM rooms WHERE room_id = $id";
    if ($conn->query($sql_delete)) {
        header("Location: manage_rooms.php");
        exit;
    } else {
        $error = "Deletion failed: " . $conn->error;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action_type']) && $_POST['action_type'] == 'add') {
        // Add new room
        $room_number   = $conn->real_escape_string($_POST['room_number']);
        $room_dientich = $conn->real_escape_string($_POST['room_dientich']);
        $room_songuoi  = intval($_POST['room_songuoi']);
        $room_type     = $conn->real_escape_string($_POST['room_type']);
        $price         = floatval($_POST['price']);
        $status        = $conn->real_escape_string($_POST['status']);
        $description   = $conn->real_escape_string($_POST['description']);
        $room_img      = $conn->real_escape_string($_POST['room_img']);

        $sql_insert = "INSERT INTO rooms (room_number, room_dientich, room_songuoi, room_type, price, status, description, room_img)
                       VALUES ('$room_number', '$room_dientich', $room_songuoi, '$room_type', $price, '$status', '$description', '$room_img')";
        if ($conn->query($sql_insert)) {
            header("Location: manage_rooms.php");
            exit;
        } else {
            $error = "Addition failed: " . $conn->error;
        }
    } elseif (isset($_POST['action_type']) && $_POST['action_type'] == 'edit') {
        // Edit room information
        $id = intval($_POST['room_id']);
        $room_number   = $conn->real_escape_string($_POST['room_number']);
        $room_dientich = $conn->real_escape_string($_POST['room_dientich']);
        $room_songuoi  = intval($_POST['room_songuoi']);
        $room_type     = $conn->real_escape_string($_POST['room_type']);
        $price         = floatval($_POST['price']);
        $status        = $conn->real_escape_string($_POST['status']);
        $description   = $conn->real_escape_string($_POST['description']);
        $room_img      = $conn->real_escape_string($_POST['room_img']);

        $sql_update = "UPDATE rooms 
                       SET room_number='$room_number', room_dientich='$room_dientich', room_songuoi=$room_songuoi, room_type='$room_type', price=$price, status='$status', description='$description', room_img='$room_img'
                       WHERE room_id=$id";
        if ($conn->query($sql_update)) {
            header("Location: manage_rooms.php");
            exit;
        } else {
            $error = "Update failed: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Room Management - Admin</title>
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
      <h2 class="mb-4">Room Management</h2>
      
      <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
      <?php endif; ?>
      
      <?php if ($action === 'add'): ?>
        <!-- Add Room Form -->
        <div class="card">
          <div class="card-header bg-success text-white">Add New Room</div>
          <div class="card-body">
            <form action="manage_rooms.php" method="post">
              <input type="hidden" name="action_type" value="add">
              <div class="mb-3">
                <label for="room_number" class="form-label">Room Number</label>
                <input type="text" class="form-control" name="room_number" required>
              </div>
              <div class="mb-3">
                <label for="room_dientich" class="form-label">Room Area</label>
                <input type="text" class="form-control" name="room_dientich" required>
              </div>
              <div class="mb-3">
                <label for="room_songuoi" class="form-label">Capacity</label>
                <input type="number" class="form-control" name="room_songuoi" required>
              </div>
              <div class="mb-3">
                <label for="room_type" class="form-label">Room Type</label>
                <input type="text" class="form-control" name="room_type" required>
              </div>
              <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" step="0.01" class="form-control" name="price" required>
              </div>
              <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" name="status" required>
                  <option value="available">Available</option>
                  <option value="occupied">Occupied</option>
                  <option value="maintenance">Maintenance</option>
                </select>
              </div>
              <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" name="description" rows="3"></textarea>
              </div>
              <div class="mb-3">
                <label for="room_img" class="form-label">Image Link</label>
                <input type="text" class="form-control" name="room_img">
              </div>
              <button type="submit" class="btn btn-success">Add Room</button>
              <a href="manage_rooms.php" class="btn btn-secondary">Cancel</a>
            </form>
          </div>
        </div>
      
      <?php elseif ($action === 'edit' && isset($_GET['id'])): ?>
        <?php
          $id = intval($_GET['id']);
          $sql_single = "SELECT * FROM rooms WHERE room_id = $id";
          $res_single = $conn->query($sql_single);
          if ($res_single && $res_single->num_rows > 0) {
              $data = $res_single->fetch_assoc();
          } else {
              echo '<div class="alert alert-danger">Room not found.</div>';
          }
        ?>
        <?php if (isset($data)): ?>
          <!-- Edit Room Form -->
          <div class="card">
            <div class="card-header bg-warning text-white">Edit Room Information</div>
            <div class="card-body">
              <form action="manage_rooms.php" method="post">
                <input type="hidden" name="action_type" value="edit">
                <input type="hidden" name="room_id" value="<?php echo $data['room_id']; ?>">
                <div class="mb-3">
                  <label for="room_number" class="form-label">Room Number</label>
                  <input type="text" class="form-control" name="room_number" value="<?php echo htmlspecialchars($data['room_number']); ?>" required>
                </div>
                <div class="mb-3">
                  <label for="room_dientich" class="form-label">Room Area</label>
                  <input type="text" class="form-control" name="room_dientich" value="<?php echo htmlspecialchars($data['room_dientich']); ?>" required>
                </div>
                <div class="mb-3">
                  <label for="room_songuoi" class="form-label">Capacity</label>
                  <input type="number" class="form-control" name="room_songuoi" value="<?php echo htmlspecialchars($data['room_songuoi']); ?>" required>
                </div>
                <div class="mb-3">
                  <label for="room_type" class="form-label">Room Type</label>
                  <input type="text" class="form-control" name="room_type" value="<?php echo htmlspecialchars($data['room_type']); ?>" required>
                </div>
                <div class="mb-3">
                  <label for="price" class="form-label">Price</label>
                  <input type="number" step="0.01" class="form-control" name="price" value="<?php echo htmlspecialchars($data['price']); ?>" required>
                </div>
                <div class="mb-3">
                  <label for="status" class="form-label">Status</label>
                  <select class="form-select" name="status" required>
                    <option value="available" <?php if($data['status'] == 'available') echo 'selected'; ?>>Available</option>
                    <option value="occupied" <?php if($data['status'] == 'occupied') echo 'selected'; ?>>Occupied</option>
                    <option value="maintenance" <?php if($data['status'] == 'maintenance') echo 'selected'; ?>>Maintenance</option>
                  </select>
                </div>
                <div class="mb-3">
                  <label for="description" class="form-label">Description</label>
                  <textarea class="form-control" name="description" rows="3"><?php echo htmlspecialchars($data['description']); ?></textarea>
                </div>
                <div class="mb-3">
                  <label for="room_img" class="form-label">Image Link</label>
                  <input type="text" class="form-control" name="room_img" value="<?php echo htmlspecialchars($data['room_img']); ?>">
                </div>
                <button type="submit" class="btn btn-warning">Update Room</button>
                <a href="manage_rooms.php" class="btn btn-secondary">Cancel</a>
              </form>
            </div>
          </div>
        <?php endif; ?>
      
      <?php else: ?>
        <!-- Display Room List -->
        <div class="card">
          <div class="card-header bg-primary text-white">Room List</div>
          <div class="card-body">
            <?php
              $sql = "SELECT room_id, room_number, room_dientich, room_songuoi, room_type, price, status, description, room_img FROM rooms";
              $result = $conn->query($sql);
              if ($result && $result->num_rows > 0):
            ?>
              <table class="table table-bordered table-hover">
                <thead class="table-light">
                  <tr>
                    <th>ID</th>
                    <th>Room Number</th>
                    <th>Room Area</th>
                    <th>Capacity</th>
                    <th>Room Type</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th style="width: 215px;">Description</th>
                    <th>Image</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                      <td><?php echo htmlspecialchars($row['room_id']); ?></td>
                      <td><?php echo htmlspecialchars($row['room_number']); ?></td>
                      <td><?php echo htmlspecialchars($row['room_dientich']); ?></td>
                      <td><?php echo htmlspecialchars($row['room_songuoi']); ?></td>
                      <td><?php echo htmlspecialchars($row['room_type']); ?></td>
                      <td><?php echo htmlspecialchars($row['price']); ?></td>
                      <td><?php echo htmlspecialchars($row['status']); ?></td>
                      <td style="width: 215px;"><?php echo htmlspecialchars($row['description']); ?></td>
                      
                      <td>
                        <?php if (!empty($row['room_img'])): ?>
                          <img src="../images/accom/<?php echo htmlspecialchars($row['room_type']); ?>/<?php echo htmlspecialchars($row['room_img']); ?>" alt="Room Image" style="max-width: 80px;">
                        <?php else: ?>
                          <p>No image</p>
                        <?php endif; ?>
                      </td>

                      <td>
                        <a href="manage_rooms.php?action=edit&id=<?php echo $row['room_id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="manage_rooms.php?action=delete&id=<?php echo $row['room_id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this room?');">Delete</a>
                      </td>
                    </tr>
                  <?php endwhile; ?>
                </tbody>
              </table>
            <?php else: ?>
              <p class="text-center">No rooms found.</p>
            <?php endif; ?>
          </div>
        </div>
        <div class="mt-3">
          <a href="manage_rooms.php?action=add" class="btn btn-success">Add New Room</a>
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
