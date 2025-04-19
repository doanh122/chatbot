<?php
$type = $_GET['type'] ?? 'room';

// Dữ liệu mẫu (sau này có thể thay bằng truy vấn từ database)
$detailData = [
  'room' => [
    'title' => 'Room',
    'desc' => 'Our deluxe rooms offer modern Indochine design, ocean view windows, and all-day sunlight. Perfect for couples and solo travelers.',
    'img' => 'images/accom/room/main.jpg'
  ],
  'suite' => [
    'title' => 'Suite',
    'desc' => 'Spacious suites with garden or pool views, classic wood decor, and separate living areas. Great for families or longer stays.',
    'img' => 'images/accom/suite/main.jpg'
  ],
  'villa' => [
    'title' => 'Villa',
    'desc' => 'Private villas with lush gardens, private pools, and tranquil surroundings. Ideal for romantic getaways or luxury escapes.',
    'img' => 'images/accom/villa/main.jpg'
  ]
];

$data = $detailData[$type] ?? $detailData['room'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= $data['title'] ?> - Accommodation Detail</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .accom-img {
      border-radius: 10px;
      width: 100%;
      height: 400px;
      object-fit: cover;
    }
  </style>
</head>
<body>

  <div class="container my-5">
    <h2 class="text-center fw-bold mb-4"><?= $data['title'] ?></h2>
    
    <div class="row justify-content-center">
      <div class="col-md-8">
        <img src="<?= $data['img'] ?>" class="accom-img mb-4" alt="<?= $data['title'] ?>">
        <p class="fs-5"><?= $data['desc'] ?></p>
        <a href="index.php#accommodation" class="btn btn-outline-primary mt-3">← Back to Accommodation</a>
      </div>
    </div>
  </div>

</body>
</html>
