<?php
// Thông tin kết nối database
$hname = 'localhost';  
$uname = 'root';      
$pass = '';            
$db = 'final';     

// Bật chế độ báo lỗi chi tiết cho MySQLi
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    // Kết nối đến database
    $con = new mysqli($hname, $uname, $pass, $db);
    $con->set_charset("utf8mb4"); // Đảm bảo sử dụng UTF-8
} catch (Exception $e) {
    die("Lỗi kết nối database: " . $e->getMessage());
}

// Hàm lọc dữ liệu đầu vào để tránh XSS
function filtration($data) {
    if (!is_array($data)) {
        return trim(htmlspecialchars(strip_tags($data), ENT_QUOTES, 'UTF-8'));
    }

    foreach ($data as $key => $value) {
        $data[$key] = trim(htmlspecialchars(strip_tags($value), ENT_QUOTES, 'UTF-8'));
    }
    return $data;
}

// Hàm thực hiện truy vấn SELECT
function select($sql, $values = [], $datatypes = "") {
    $con = $GLOBALS['con'];
    
    if ($stmt = $con->prepare($sql)) {
        if (!empty($values) && !empty($datatypes)) {
            $stmt->bind_param($datatypes, ...$values);
        }

        if ($stmt->execute()) {
            $res = $stmt->get_result();
            $stmt->close();
            return $res;
        } else {
            $stmt->close();
            die("Lỗi khi thực thi truy vấn - Select");
        }
    } else {
        die("Lỗi khi chuẩn bị truy vấn - Select");
    }
}

// Hàm thực hiện truy vấn INSERT, UPDATE, DELETE
function executeQuery($sql, $values = [], $datatypes = "") {
    $con = $GLOBALS['con'];
    
    if ($stmt = $con->prepare($sql)) {
        if (!empty($values) && !empty($datatypes)) {
            $stmt->bind_param($datatypes, ...$values);
        }

        if ($stmt->execute()) {
            $affected_rows = $stmt->affected_rows;
            $stmt->close();
            return $affected_rows;
        } else {
            $stmt->close();
            die("Lỗi khi thực thi truy vấn - ExecuteQuery");
        }
    } else {
        die("Lỗi khi chuẩn bị truy vấn - ExecuteQuery");
    }
}
?>
