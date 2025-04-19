<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');

// VNPay Configuration
$vnp_TmnCode = "6448J9KM"; // Merchant ID
$vnp_HashSecret = "SVNGVSURPDMNKHKCARGKTYPSZVYJREHU"; // Secret Key
$vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html"; // VNPay URL (use the sandbox URL for testing)
$vnp_Returnurl = "http://localhost:80/chatbot/finish.php"; // Return URL after payment
$vnp_apiUrl = "http://sandbox.vnpayment.vn/merchant_webapi/merchant.html"; // API URL for VNPay
$apiUrl = "https://sandbox.vnpayment.vn/merchant_webapi/api/transaction"; // Production API URL (when live)
$startTime = date("YmdHis");
$expire = date('YmdHis', strtotime('+15 minutes', strtotime($startTime))); // Expiration time of payment link
?>
