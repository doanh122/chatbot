<?php
require('inc/db_connect.php');
// Kiểm tra kết nối cơ sở dữ liệu
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process actions: delete, add, edit
$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($action === 'delete' && isset($_GET['id'])) {
    // Delete user by id
    $id = intval($_GET['id']);
    $sql_delete = "DELETE FROM users WHERE user_id = $id";
    if ($conn->query($sql_delete)) {
        header("Location: manage_users.php");
        exit;
    } else {
        $error = "Deletion failed: " . $conn->error;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action_type']) && $_POST['action_type'] == 'add') {
        // Add new user
        $full_name = $conn->real_escape_string($_POST['full_name']);
        $username  = $conn->real_escape_string($_POST['username']);
        $email     = $conn->real_escape_string($_POST['email']);
        $phone     = $conn->real_escape_string($_POST['phone']);
        $address   = $conn->real_escape_string($_POST['address']);
        $role      = $conn->real_escape_string($_POST['role']);
        // Hash password before saving to the database
        $pass      = $_POST['pass'];

        $sql_insert = "INSERT INTO users (full_name, username, email, phone, address, role, pass)
                       VALUES ('$full_name', '$username', '$email', '$phone', '$address', '$role', '$pass')";
        if ($conn->query($sql_insert)) {
            header("Location: manage_users.php");
            exit;
        } else {
            $error = "Addition failed: " . $conn->error;
        }
    } elseif (isset($_POST['action_type']) && $_POST['action_type'] == 'edit') {
        // Edit user
        $id        = intval($_POST['user_id']);
        $full_name = $conn->real_escape_string($_POST['full_name']);
        $username  = $conn->real_escape_string($_POST['username']);
        $email     = $conn->real_escape_string($_POST['email']);
        $phone     = $conn->real_escape_string($_POST['phone']);
        $address   = $conn->real_escape_string($_POST['address']);
        $role      = $conn->real_escape_string($_POST['role']);

        // If password field is not empty then update it
        $sql_update = "UPDATE users SET full_name='$full_name', username='$username', email='$email', phone='$phone', address='$address', role='$role'";
        if (!empty($_POST['pass'])) {
            $pass = $_POST['pass'];
            $sql_update .= ", pass='$pass'";
        }
        $sql_update .= " WHERE user_id=$id";

        if ($conn->query($sql_update)) {
            header("Location: manage_users.php");
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
  <title>User Management - Admin</title>
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
      <h2 class="mb-4">User Management</h2>
      
      <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
      <?php endif; ?>
      
      <?php if ($action === 'add'): ?>
        <!-- Add User Form -->
        <div class="card">
          <div class="card-header bg-success text-white">Add New User</div>
          <div class="card-body">
            <form action="manage_users.php" method="post">
              <input type="hidden" name="action_type" value="add">
              <div class="mb-3">
                <label for="full_name" class="form-label">Full Name</label>
                <input type="text" class="form-control" name="full_name" required>
              </div>
              <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" name="username" required>
              </div>
              <div class="mb-3">
                <label for="pass" class="form-label">Password</label>
                <input type="password" class="form-control" name="pass" required>
              </div>
              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" required>
              </div>
              <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control" name="phone">
              </div>
              <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" name="address">
              </div>
              <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select class="form-select" name="role" required>
                  <option value="customer">Customer</option>
                  <option value="admin">Admin</option>
                </select>
              </div>
              <button type="submit" class="btn btn-success">Add</button>
              <a href="manage_users.php" class="btn btn-secondary">Cancel</a>
            </form>
          </div>
        </div>
      
      <?php elseif ($action === 'edit' && isset($_GET['id'])): ?>
        <?php
          $id = intval($_GET['id']);
          $sql_single = "SELECT * FROM users WHERE user_id = $id";
          $res_single = $conn->query($sql_single);
          if ($res_single && $res_single->num_rows > 0) {
              $data = $res_single->fetch_assoc();
          } else {
              echo '<div class="alert alert-danger">User not found.</div>';
          }
        ?>
        <?php if (isset($data)): ?>
          <!-- Edit User Form -->
          <div class="card">
            <div class="card-header bg-warning text-white">Edit User</div>
            <div class="card-body">
              <form action="manage_users.php" method="post">
                <input type="hidden" name="action_type" value="edit">
                <input type="hidden" name="user_id" value="<?php echo $data['user_id']; ?>">
                <div class="mb-3">
                  <label for="full_name" class="form-label">Full Name</label>
                  <input type="text" class="form-control" name="full_name" value="<?php echo htmlspecialchars($data['full_name']); ?>" required>
                </div>
                <div class="mb-3">
                  <label for="username" class="form-label">Username</label>
                  <input type="text" class="form-control" name="username" value="<?php echo htmlspecialchars($data['username']); ?>" required>
                </div>
                <div class="mb-3">
                  <label for="pass" class="form-label">Password (Leave blank if not changing)</label>
                  <input type="password" class="form-control" name="pass">
                </div>
                <div class="mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($data['email']); ?>" required>
                </div>
                <div class="mb-3">
                  <label for="phone" class="form-label">Phone</label>
                  <input type="text" class="form-control" name="phone" value="<?php echo htmlspecialchars($data['phone']); ?>">
                </div>
                <div class="mb-3">
                  <label for="address" class="form-label">Address</label>
                  <input type="text" class="form-control" name="address" value="<?php echo htmlspecialchars($data['address']); ?>">
                </div>
                <div class="mb-3">
                  <label for="role" class="form-label">Role</label>
                  <select class="form-select" name="role" required>
                    <option value="customer" <?php if($data['role'] == 'customer') echo 'selected'; ?>>Customer</option>
                    <option value="admin" <?php if($data['role'] == 'admin') echo 'selected'; ?>>Admin</option>
                  </select>
                </div>
                <button type="submit" class="btn btn-warning">Update</button>
                <a href="manage_users.php" class="btn btn-secondary">Cancel</a>
              </form>
            </div>
          </div>
        <?php endif; ?>
      
      <?php else: ?>
        <!-- Display User List -->
        <div class="card">
          <div class="card-header bg-primary text-white">User List</div>
          <div class="card-body">
          <?php
$sql = "SELECT user_id, full_name, username, email, phone, address, role, created_at FROM users";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0):
?>
    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Full Name</th>
                <th>Username</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Role</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['user_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['username']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['phone']); ?></td>
                    <td><?php echo htmlspecialchars($row['address']); ?></td>
                    <td><?php echo htmlspecialchars($row['role']); ?></td>
                    <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                    <td>
                        <a href="manage_users.php?action=edit&id=<?php echo $row['user_id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="manage_users.php?action=delete&id=<?php echo $row['user_id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php else: ?>
    <p class="text-center">No users found.</p>
<?php endif; ?>
          </div>
        </div>
        <div class="mt-3">
          <a href="manage_users.php?action=add" class="btn btn-success">Add New User</a>
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
