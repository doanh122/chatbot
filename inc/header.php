 
<?php
require('admin/inc/db_config.php');
require('admin/inc/ess.php');

// Xử lý khi người dùng ấn nút "Login" trên form
if(isset($_POST['login'])){
    // session_start();
    // Lấy dữ liệu từ form
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $pass = $_POST['password'];

    // Kiểm tra tài khoản trong CSDL
    $sql = "SELECT * FROM users WHERE email=? LIMIT 1";
    $stmt = mysqli_prepare($con, $sql);  // Sử dụng $con từ db_connect.php
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);

    // Nếu tìm thấy email
    if(mysqli_num_rows($res) == 1){
        $row = mysqli_fetch_assoc($res);
        $userData = [
            'user_id' => $row['user_id'],
            'email'   => $row['email']
        ];
        $userJson = json_encode($userData);
        // Nếu mật khẩu đúng (lưu ý: đang so sánh plaintext, bạn nên chuyển sang hash càng sớm càng tốt)
        if($pass == $row['pass']){
            $_SESSION['user'] = $userData;
            echo "<script>
                    localStorage.setItem('user','$userJson');
                    alert('Login successful!');
                    window.location.href='index.php';
                  </script>";
        } else {
            // Sai mật khẩu
            echo "<script>alert('Wrong password!');</script>";
        }
    } else {
        // Không tìm thấy email
        echo "<script>alert('Account does not exist!');</script>";
    }
}



//================== XỬ LÝ ĐĂNG KÝ (Register) ==================//
if(isset($_POST['register'])){
    // Lấy dữ liệu từ form
    $full_name = trim($_POST['full_name']);
    $email     = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $phone     = trim($_POST['phone']);
    $address   = trim($_POST['address']);
    $dob       = isset($_POST['dob']) ? $_POST['dob'] : null; // nếu có cột trong DB
    $pass      = $_POST['password'];
    $cpass     = $_POST['cpassword'];

    // Kiểm tra Password và Confirm Password
    if($pass !== $cpass){
        echo "<script>alert('Password and confirm password do not match!');</script>";
        exit();
    }

    // Kiểm tra email đã tồn tại chưa (tránh đăng ký trùng)
    $checkSql = "SELECT * FROM users WHERE email=? LIMIT 1";
    $checkStmt = mysqli_prepare($con, $checkSql);
    mysqli_stmt_bind_param($checkStmt, "s", $email);
    mysqli_stmt_execute($checkStmt);
    $checkRes = mysqli_stmt_get_result($checkStmt);

    if(mysqli_num_rows($checkRes) > 0){
        // Email đã có trong hệ thống
        echo "<script>alert('Email already exists! Please use another email.');</script>";
        exit();
    }

     // Kiểm tra email đã tồn tại chưa (tránh đăng ký trùng)
     $checkSql = "SELECT * FROM users WHERE username=? LIMIT 1";
     $checkStmt = mysqli_prepare($con, $checkSql);
     mysqli_stmt_bind_param($checkStmt, "s", $full_name);
     mysqli_stmt_execute($checkStmt);
     $checkRes = mysqli_stmt_get_result($checkStmt);
 
     if(mysqli_num_rows($checkRes) > 0){
         // Email đã có trong hệ thống
         echo "<script>alert('Username already exists! Please use another username.');</script>";
         exit();
     }

    // Mã hóa (hash) password
    // Trong ví dụ cũ bạn đang lưu plain text, bây giờ nên dùng password_hash:
    // $hashedPass = password_hash($pass, PASSWORD_DEFAULT);

    // Chuẩn bị câu lệnh INSERT
    // Ở đây, mình giả sử bạn muốn đặt vai trò (role) mặc định cho khách hàng là 'customer'
    // Cột "username" nếu không dùng thì bỏ qua, hoặc tự tạo
    $insertSql = "INSERT INTO users (full_name, username, pass, role, email, phone, address, created_at) 
                  VALUES (?,?,?,?,?,?,?,NOW())";
    $insertStmt = mysqli_prepare($con, $insertSql);

    // Với username, mình tạm để null hoặc chuỗi rỗng, do form không có input cho username
    $username = "xuanngoc";

    // role = "customer"
    $role = "customer";

    mysqli_stmt_bind_param($insertStmt, "sssssss", 
        $full_name, 
        $full_name, 
        $pass, 
        $role, 
        $email, 
        $phone, 
        $address
    );

    $queryInsert = mysqli_stmt_execute($insertStmt);

    if($queryInsert){
        // Đăng ký thành công
        $newUserId = mysqli_insert_id($con);
        
        // // Có thể tự đăng nhập luôn, hoặc yêu cầu user đăng nhập lại
        // $_SESSION['user'] = [
        //     'user_id'   => $newUserId,
        //     'email'     => $email,
        //     'full_name' => $full_name
        // ];

        // $userJson = json_encode($_SESSION['user']);
        // localStorage.setItem('user','$userJson');
        echo "<script>
                alert('Registration successful!');
                window.location.href='index.php';
              </script>";
    } else {
        // Có lỗi khi INSERT
        echo "<script>alert('Registration failed! Please try again.');</script>";
    }
}
?>
 
 <!-- Navbar -->
 <nav class="navbar navbar-expand-lg navbar-light bg-light px-lg-3 py-lg-2 shadow-sm sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand me-5 fw-bold" href="index.php">Red Distinct</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active me-2" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link me-2" href="rooms.php">Rooms</a>
                    </li>
                 
                    <li class="nav-item">
                        <a class="nav-link me-2" href="contact.php">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link me-2" href="about.php">About us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link me-2" href="mybooking.php">Booking</a>
                    </li>
                </ul>
                <div class="d-flex chuadangnhap">
                   
                    <button style="width: 65px;" type="button" class="btn btn-outline-dark shadow-none me-lg-3 me-3" data-bs-toggle="modal" data-bs-target="#loginModal">
                        Login
                    </button>

                    <button style="width: 90px;" type="button" class="btn btn-outline-dark shadow-none  me-lg-3 me-3" data-bs-toggle="modal" data-bs-target="#registerModal">
                        Register
                    </button>
                </div>
                <!-- <div class="d-flex dadangnhap">
                    <button onclick="logout()" style="width: 70px;" type="button" class="btn btn-outline-dark shadow-none me-lg-3 me-3">
                        Logout
                    </button>
                </div> -->
            </div>
        </div>
</nav>

    <!-- Login Modal -->
    <div class="modal fade" id="loginModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="bi bi-person-circle"></i>
                        </h5>
                        <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control shadow-none" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control shadow-none" required>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <button type="submit" name="login" class="btn btn-dark shadow-none">Login</button>
                            <a href="javascript:void(0)" class="text-secondary text-decoration-none">Forgot password?</a>
                        </div>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>

   <!-- Register Modal -->
<div class="modal fade" id="registerModal" ...>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- 
                Để form gửi dữ liệu lên server khi ấn nút Register,
                bạn cần thêm method="POST" và name="register" (hoặc tương tự).
            -->
            <form method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-person-lines-fill fs-3 me-2"></i>
                    </h5>
                    <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <!-- Name -->
                            <div class="col-md-6 ps-0 mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" name="full_name" class="form-control shadow-none" required>
                            </div>
                            <!-- Email -->
                            <div class="col-md-6 ps-0 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control shadow-none" required>
                            </div>
                            <!-- Phone -->
                            <div class="col-md-6 ps-0 mb-3">
                                <label class="form-label">Phone Number</label>
                                <input type="text" name="phone" class="form-control shadow-none" required>
                            </div>
                            <!-- Date of birth (nếu có cột trong DB) -->
                            <div class="col-md-6 p-0 mb-3">
                                <label class="form-label">Date of birth</label>
                                <input type="date" name="dob" class="form-control shadow-none">
                            </div>
                            <!-- Address -->
                            <div class="col-md-12 p-0 mb-3">
                                <label class="form-label">Address</label>
                                <textarea name="address" class="form-control shadow-none" rows="1" required></textarea>
                            </div>
                            <!-- Password -->
                            <div class="col-md-6 ps-0 mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control shadow-none" required>
                            </div>
                            <!-- Confirm Password -->
                            <div class="col-md-6 ps-0 mb-3">
                                <label class="form-label">Confirm Password</label>
                                <input type="password" name="cpassword" class="form-control shadow-none" required>
                            </div>
                            <div class="text-center my-1">
                                <!-- Nút submit tên "register" -->
                                <button type="submit" name="register" class="btn btn-dark shadow-none">Register</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form> <!-- /form -->
        </div>
    </div>
</div>


   
    