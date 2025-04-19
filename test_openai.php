<?php
$ch = curl_init("https://api.openai.com/v1/models");
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        "Authorization: Bearer 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"
    ]
]);
$response = curl_exec($ch);
if (!$response) {
    echo "❌ Lỗi CURL: " . curl_error($ch);
} else {
    echo "✅ Kết nối OpenAI thành công: " . $response;
}
?>
