<?php
session_start();
require_once "config.php";

// Hiển thị lỗi (giúp debug khi chạy localhost)
ini_set('display_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');
$input = json_decode(file_get_contents("php://input"), true);
$user_input = trim($input["message"] ?? "Hello");

// Khởi tạo hội thoại nếu chưa có
if (!isset($_SESSION["history"])) {
    $_SESSION["history"] = [
        ["role" => "system", "content" => "You are a friendly hotel assistant. Please respond in a clear and concise manner in English. Hãy trả lời ngắn gọn, rõ ràng và lịch sự bằng tiếng Enệt."]
    ];
}

$_SESSION["history"][] = ["role" => "user", "content" => $user_input];

// Gửi hội thoại đến OpenAI
$payload = [
    "model" => "gpt-3.5-turbo",
    "messages" => $_SESSION["history"],
    "temperature" => 0.7
];

$ch = curl_init("https://api.openai.com/v1/chat/completions");
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_HTTPHEADER => [
        "Content-Type: application/json",
        "Authorization: Bearer " . OPENAI_API_KEY
    ],
    CURLOPT_POSTFIELDS => json_encode($payload),
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1

]);

$response = curl_exec($ch);

// 👉 Kiểm tra lỗi CURL (kết nối thất bại)
if (!$response) {
    echo json_encode(["reply" => "❌ Lỗi kết nối tới OpenAI: " . curl_error($ch)]);
    curl_close($ch);
    exit;
}

curl_close($ch);

// 👉 Kiểm tra lỗi JSON
$data = json_decode($response, true);
if (!isset($data["choices"][0]["message"]["content"])) {
    echo json_encode(["reply" => "❌ Lỗi phản hồi từ OpenAI: " . $response]);
    exit;
}

// ✅ Có phản hồi hợp lệ
$reply = $data["choices"][0]["message"]["content"];
$_SESSION["history"][] = ["role" => "assistant", "content" => $reply];

// 👉 Lưu vào CSDL
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $stmt = $pdo->prepare("INSERT INTO chat_history (user_message, bot_reply) VALUES (?, ?)");
    $stmt->execute([$user_input, $reply]);
} catch (Exception $e) {
    // Tùy chọn: log lỗi vào file
    // file_put_contents('error_log.txt', $e->getMessage());
}

echo json_encode(["reply" => $reply]);
?>
