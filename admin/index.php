<?php 
  require('inc/ess.php');
  require('inc/db_config.php');
//   session_start();
  

  

   if (isset($_SESSION['adminLogin']) && $_SESSION['adminLogin'] == true) {
    redirect('dashboard.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <?php require ('inc/links.php'); ?>

    <style>
        /* Center the login form */
        .login-form {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 500px;
            padding: 30px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Add some padding to the form elements */
        .login-form input,
        .login-form button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        /* Custom button color */
        .custom-bg {
            background-color:rgb(0, 0, 0);
            border-color:rgb(255, 255, 255);
        }

        /* Button hover effect */
        .custom-bg:hover {
            background-color:rgb(74, 74, 74);
            border-color:rgb(255, 255, 255);
        }

        /* Form title style */
        .login-form h4 {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #333;
        }

        body {
            background-color:rgb(11, 65, 98);
        }
    </style>
</head>

<body>

<div class="login-form text-center">
    <form method="POST">
        <h4>ADMIN LOGIN</h4>

        <div class="mb-3">
            <input type="text" name="admin_name" class="form-control shadow-none text-center" placeholder="Admin Name" required>
        </div>

        <div class="mb-4">
            <input type="password" name="admin_pass" class="form-control shadow-none text-center" placeholder="Password" required>
        </div>

        <button type="submit" name="login" class="btn text-white custom-bg shadow-none">LOGIN</button>
    </form>
</div>

<?php

if (isset($_POST['login'])) {
    $frm_data = filtration($_POST);

    $query = "SELECT * FROM `admin_cred` WHERE `admin_name`=? AND `admin_pass`=?";
    $values = [$frm_data['admin_name'], $frm_data['admin_pass']];

    $res = select($query, $values, "ss");
    if ($res->num_rows == 1) {
        $row = mysqli_fetch_assoc($res);
       
        $_SESSION['adminLogin'] = true;
        $_SESSION['adminId'] = $row['sr_no'];
        redirect('dashboard.php');
    } else {
        echo "<script>alert('Login failed!');</script>";
    }
}

?>

<?php require ('inc/script.php'); ?>

</body>
</html>
