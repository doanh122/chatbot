<?php

require('../inc/db_config.php');
require('../inc/ess.php');
adminLogin();

// Set header JSON để trình duyệt hiểu đây là dữ liệu JSON
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Lấy thông tin chung
if (isset($_POST['get_general'])) {
    $q = "SELECT * FROM `settings` WHERE `sr_no`=?";
    $values = [1];
    $res = select($q, $values, "i");

    if (!$res) {
        echo json_encode(["error" => "Lỗi truy vấn dữ liệu"]);
        exit;
    }

    $data = mysqli_fetch_assoc($res);
    echo json_encode($data);
    exit;
}

if (isset($_POST['upd_general'])) {
    error_log("PHP script is triggered");
    $site_title = isset($_POST['site_title']) ? mysqli_real_escape_string($con, $_POST['site_title']) : '';
    $site_about = isset($_POST['site_about']) ? mysqli_real_escape_string($con, $_POST['site_about']) : '';

    if (empty($site_title) || empty($site_about)) {
        echo json_encode(["error" => "Thiếu dữ liệu cần thiết"]);
        exit;
    }

    $q = "UPDATE `settings` SET `site_tittle` = ?, `site_about` = ? WHERE `sr_no` = 1";
    
    $stmt = mysqli_prepare($con, $q);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ss", $site_title, $site_about);
        $res = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        if ($res) {
            echo json_encode(["success" => "Cập nhật thành công"]);
        } else {
            echo json_encode(["error" => "Cập nhật thất bại"]);
        }
    } else {
        echo json_encode(["error" => "Lỗi truy vấn"]);
    }
    
    exit;
}


if (isset($_POST['upd_general1'])) {
    error_log("PHP script is triggered");
    $address_inp = isset($_POST['address_inp']) ? mysqli_real_escape_string($con, $_POST['address_inp']) : '';
    $pn1 = isset($_POST['pn1']) ? mysqli_real_escape_string($con, $_POST['pn1']) : '';
    $email_inp = isset($_POST['email_inp']) ? mysqli_real_escape_string($con, $_POST['email_inp']) : '';
    $fb_inp = isset($_POST['fb_inp']) ? mysqli_real_escape_string($con, $_POST['fb_inp']) : '';
    $tw_inp = isset($_POST['tw_inp']) ? mysqli_real_escape_string($con, $_POST['tw_inp']) : '';
    $ig_inp = isset($_POST['ig_inp']) ? mysqli_real_escape_string($con, $_POST['ig_inp']) : '';
    $iframe_inp = isset($_POST['iframe_inp']) ? mysqli_real_escape_string($con, $_POST['iframe_inp']) : '';
    

    if (empty($address_inp) || empty($email_inp) || empty($pn1) || empty($fb_inp)) {
        echo json_encode(["error" => "Thiếu dữ liệu cần thiết"]);
        exit;
    }

    $q = "UPDATE `contact_detail` SET `address` = ?, `pn` = ?, `email` = ?, `fb` = ?, `tw` = ?, `ig` = ?, `iframe` = ? WHERE `sr_no` = 1";
    
    $stmt = mysqli_prepare($con, $q);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sisssss", $address_inp, $pn1, $email_inp, $fb_inp, $tw_inp, $ig_inp, $iframe_inp);
        $res = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        if ($res) {
            echo json_encode(["success" => "Cập nhật thành công"]);
        } else {
            echo json_encode(["error" => "Cập nhật thất bại"]);
        }
    } else {
        echo json_encode(["error" => "Lỗi truy vấn"]);
    }
    
    exit;
}

// Lấy thông tin liên hệ
if (isset($_POST['get_contacts'])) {
    $q = "SELECT * FROM `contact_detail` WHERE `sr_no`=?";
    $values = [1];
    $res = select($q, $values, "i");

    if (!$res) {
        echo json_encode(["error" => "Lỗi truy vấn dữ liệu"]);
        exit;
    }

    $data = mysqli_fetch_assoc($res);
    echo json_encode($data);
    exit;
}

echo json_encode(["error" => "Không có hành động hợp lệ"]);
exit;
?>




