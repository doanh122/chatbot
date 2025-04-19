<?php
    include("../inc/db_connect.php");
    require_once('config_vnpay.php');
    session_start();
    $user_id = $_SESSION['user']['user_id'];
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    
    // Get booking_id and total from URL
    $booking_id = isset($_GET['booking_id']) ? $_GET['booking_id'] : null;
    $total = isset($_GET['total']) ? $_GET['total'] : null;
    
    // Check if booking_id and total are valid
    if ($booking_id && $total) {
        $_SESSION['amount'] = $total;
        $_SESSION['bookingId'] = $booking_id;
        $order_value = $total;

        // Generate order_code
        $order_code = uniqid(); // Generates a unique ID for the order
        $_SESSION['order_code'] = $order_code;

        // VNPay Transaction Details
        $vnp_TxnRef = $order_code; // Transaction reference code
        $vnp_Amount = $order_value * 100; // Amount in VND
        $vnp_Locale = "vn"; // Language setting (Vietnamese)
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR']; // Customer's IP Address

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => "Transaction payment: " . $vnp_TxnRef,
            "vnp_OrderType" => "other",
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
            "vnp_ExpireDate" => $expire
        );

        // Add bank code if specified
        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";

        // Prepare data for hashing
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        // Build final URL
        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        // Redirect to VNPay for payment
        header('Location: ' . $vnp_Url);
        die();
    } else {
        echo "Invalid booking or amount.";
    }
?>
