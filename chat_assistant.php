<?php
/**************************************************************
 * 1. Lấy câu hỏi từ người dùng (ví dụ qua AJAX hoặc POST)
 **************************************************************/
$user_input = $_POST['message'] ?? 'Tôi muốn tìm phòng đôi, giá trên 1 triệu, cho 5 người hoặc diện tích 45m2.';

require_once 'config.php';
$api_key = OPENAI_API_KEY;

// Prompt system đã được tinh chỉnh rõ ràng
$system_prompt = <<<EOT
You are an AI assistant for a hotel booking website.
We have a table named "rooms" with the following columns:
- room_id (int)
- room_number (string)
- room_dientich (string)
- room_songuoi (int)
- room_type (string)
- price (decimal)
- status (string)
- description (text)
- room_img (string)

When interpreting the user's query regarding price:
- If the user says "giá trên X" or "cao hơn X", set "min_price" = X (meaning price >= X).
- If the user says "giá dưới X" or "thấp hơn X", set "max_price" = X (meaning price <= X).
- If the user says "khoảng X đến Y", set "min_price" = X and "max_price" = Y.
- If unclear, set both to null.

The user will ask in Vietnamese about finding suitable rooms.
Your task is to extract the search criteria from the user's request.
Return ONLY a valid JSON object with the following keys:
"room_type": string or null,
"max_price": number or null,
"min_price": number or null,
"status": string or null,
"number_of_people": number or null,
"keywords": array of strings or an empty array.

Do not include any additional text.
User query: "$user_input"
EOT;


$data_extract = [
    "model" => "gpt-3.5-turbo",
    "messages" => [
        ["role" => "system", "content" => $system_prompt],
        ["role" => "user", "content" => $user_input]
    ],
    "temperature" => 0.2
];

$ch = curl_init("https://api.openai.com/v1/chat/completions");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Authorization: Bearer $api_key"
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data_extract));
$response_extract = curl_exec($ch);
curl_close($ch);

// Parse kết quả trích xuất tiêu chí
$result_extract = json_decode($response_extract, true);
$criteria_text = $result_extract['choices'][0]['message']['content'] ?? '{}';

// Cố gắng parse JSON mà GPT trả về
$criteria = json_decode($criteria_text, true);
if (json_last_error() !== JSON_ERROR_NONE) {
    // Nếu parse JSON lỗi, gán giá trị mặc định là một object với các key cần thiết
    $criteria = [
        "room_type" => null,
        "max_price" => null,
        "min_price" => null,
        "status" => null,
        "number_of_people" => null,
        "keywords" => []
    ];
}

// 1. Lấy giá trị room_type từ $criteria
$room_type = $criteria['room_type'] ?? null;

// 2. Map từ tiếng Việt sang giá trị trong DB
$mapping = [
    'phòng đơn' => 'Single',
    'phòng đôi' => 'Double',
    'phòng suite' => 'Suite'
];

// Nếu $room_type nằm trong mảng mapping thì gán lại
if ($room_type && isset($mapping[mb_strtolower($room_type)])) {
    $room_type = $mapping[mb_strtolower($room_type)];
}

// 3. Gán ngược vào $criteria (không bắt buộc, nhưng hữu ích để đồng bộ)
$criteria['room_type'] = $room_type;


/**************************************************************
 * 3. Từ "criteria" build câu lệnh SQL truy vấn DB
 **************************************************************/
$room_type        = $room_type ?? null;
$max_price        = $criteria['max_price'] ?? null;
$min_price        = $criteria['min_price'] ?? null;
$status           = $criteria['status'] ?? 'available'; // mặc định là available
$number_of_people = $criteria['number_of_people'] ?? null;
$keywords         = $criteria['keywords'] ?? [];

// Kết nối DB (sử dụng PDO, chỉnh sửa tham số theo cấu hình của bạn)
$pdo = new PDO("mysql:host=localhost;dbname=hotel;charset=utf8", "root", "");

// Xây dựng câu lệnh SQL
$sql = "SELECT * FROM rooms WHERE 1=1";
$params = [];

if ($status) {
    $sql .= " AND status = :status";
    $params[':status'] = $status;
}
if ($room_type) {
    $sql .= " AND room_type = :room_type";
    $params[':room_type'] = $room_type;
}
if ($number_of_people) {
    $sql .= " AND room_songuoi >= :number_of_people";
    $params[':number_of_people'] = $number_of_people;
}
if ($max_price) {
    $sql .= " AND price <= :max_price";
    $params[':max_price'] = $max_price;
}
if ($min_price) {
    $sql .= " AND price >= :min_price";
    $params[':min_price'] = $min_price;
}
foreach ($keywords as $idx => $keyword) {
    $keyParam = ":keyword$idx";
    $sql .= " AND description LIKE $keyParam";
    $params[$keyParam] = "%$keyword%";
}

// Chuẩn bị và thực hiện câu lệnh SQL
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);

/**************************************************************
 * 4. (Tuỳ chọn) Gửi thông tin phòng ngược cho ChatGPT
 *    để tạo câu trả lời "thân thiện" hơn cho người dùng
 **************************************************************/
$rooms_json = json_encode($rooms, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

// Prompt cho bước tạo câu trả lời cuối cùng đã được tinh chỉnh
$system_prompt_answer = <<<EOT
You are an AI assistant for a hotel booking website.
Based on the following rooms data from our database:
$rooms_json

Please respond in Vietnamese with a clear and friendly summary describing the available rooms that match the user's request.
If no rooms are available, state "Không có phòng phù hợp."
Do not include any extra explanation.
EOT;

$data_answer = [
    "model" => "gpt-3.5-turbo",
    "messages" => [
        ["role" => "system", "content" => $system_prompt_answer],
        ["role" => "user", "content" => "Hãy tư vấn cho tôi dựa trên danh sách phòng trên."]
    ],
    "temperature" => 0.5
];

$ch = curl_init("https://api.openai.com/v1/chat/completions");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Authorization: Bearer $api_key"
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data_answer));
$response_answer = curl_exec($ch);
curl_close($ch);

$result_answer = json_decode($response_answer, true);
$final_text = $result_answer['choices'][0]['message']['content'] ?? 'Không thể tạo câu trả lời.';

// Trả kết quả cuối cùng cho client dưới dạng JSON
header('Content-Type: application/json; charset=UTF-8');
echo json_encode([
    'criteria' => $criteria,
    'rooms' => $rooms,
    'assistant_answer' => $final_text
], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
?>
