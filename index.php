<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Hiro Hotel - HOME</title>
  <?php require('inc/links.php'); ?>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />

  <!-- CUSTOM CSS -->
  <style>
    /* ===== Booking Form ===== */
    .availability-form {
      margin-top: -50px;
      z-index: 2;
      position: relative;
    }

    @media screen and (max-width: 575px) {
      .availability-form {
        margin-top: 25px;
        padding: 0 35px;
      }
    }

    /* ===== Chatbot Floating UI ===== */
    .chatbot-icon {
      position: fixed;
      bottom: 20px;
      right: 20px;
      font-size: 28px;
      background-color: #0078FF;
      color: #fff;
      padding: 12px;
      border-radius: 50%;
      cursor: pointer;
      z-index: 1060;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    }

    .chatbot-frame {
      display: none;
      position: fixed;
      bottom: 90px;
      right: 20px;
      width: 340px;
      height: 500px;
      border: none;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      z-index: 1050;
    }

    /* ===== Suggestion Topics Block ===== */
    .suggestion-topics {
      margin: 10px 0;
      padding: 15px;
      border: 1px solid #ccc;
      background-color: #f9f9f9;
      border-radius: 5px;
    }

    .suggestion-topics p {
      font-size: 16px;
      font-weight: bold;
      margin: 0 0 10px;
    }

    .suggestion-topics ul {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      list-style: none;
      padding: 0;
      margin: 0;
    }

    .suggestion-topics li button {
      background-color: #007bff;
      color: #fff;
      border: none;
      padding: 8px 12px;
      border-radius: 4px;
      font-size: 14px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .suggestion-topics li button:hover {
      background-color: #0056b3;
    }
  </style>
</head>

<body class="bg-muted">
  <?php require('inc/header.php'); ?>

  <!-- Swiper Carousel -->
  <div class="container-fluid px-lg-4">
    <div class="swiper swiper-container">
      <div class="swiper-wrapper">
        <div class="swiper-slide">
          <img src="images/bia/1.jpg" class="w-100 d-block" />
        </div>
        <div class="swiper-slide">
          <img src="images/bia/2.jpg" class="w-100 d-block" />
        </div>
      </div>
      <div class="swiper-pagination"></div>
    </div>
  </div>

  <!-- Booking Availability -->
  <div class="container availability-form">
    <div class="row">
      <div class="col-lg-12 bg-white shadow p-4 rounded">
        <h5 class="mb-4">Check Booking Availability</h5>
        <form class="row align-item-end">
          <div class="col-lg-3">
            <label class="form-label fw-semibold">Check-in</label>
            <input type="date" class="form-control shadow-none" />
          </div>
          <div class="col-lg-3">
            <label class="form-label fw-semibold">Check-out</label>
            <input type="date" class="form-control shadow-none" />
          </div>
          <div class="col-lg-3">
            <label class="form-label fw-semibold">Guests</label>
            <select class="form-select shadow-none">
              <?php for ($i = 1; $i <= 10; $i++) echo "<option value='$i'>$i</option>"; ?>
            </select>
          </div>
          <div class="col-lg-12 d-flex justify-content-center mt-3">
            <button type="submit" class="btn text-white shadow-none custom-bg">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  


<!-- ACCOMMODATION Section -->
<h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-fontt">ACCOMMODATION</h2>
<div class="container">
  <p class="text-center mt-3 mb-4">
    Choose your setting for tropical bliss at Red Distinct, with rooms and suites located in the main building, and pool villas around gardens.
  </p>
  <div class="row justify-content-center">

    <?php
    // Danh sách các loại chỗ ở: Room → Suite → Villa
    $accommodations = [
      [
        "img" => "images/accom/room/main.jpg",
        "title" => "Room",
        "desc" => "Awaken to the sunrise with panoramic ocean views, modern comforts, and elegant Indochine interiors."
      ],
      [
        "img" => "images/accom/suite/main.jpg",
        "title" => "Suite",
        "desc" => "Relax in spacious suites with garden views, combining timeless design and luxurious comfort."
      ],
      [
        "img" => "images/accom/villa/main.jpg",
        "title" => "Villa",
        "desc" => "Enjoy ultimate privacy in lush tropical gardens, with private pools and stylish villa layouts."
      ]
    ];

    foreach ($accommodations as $acc) {
      echo '
      <div class="col-lg-4 col-md-6 my-3">
        <div class="card border-0 shadow" style="max-width: 350px; margin: auto;">
          <img src="' . htmlspecialchars($acc["img"]) . '" class="card-img-top" alt="' . htmlspecialchars($acc["title"]) . '">
          <div class="card-body">
            <h5 class="card-title">' . htmlspecialchars($acc["title"]) . '</h5>
            <p class="card-text">' . htmlspecialchars($acc["desc"]) . '</p>
            <div class="d-flex justify-content-evenly mb-2">
              <a href="#" class="btn btn-sm btn-outline-dark shadow-none">Details</a>
            </div>
          </div>
        </div>
      </div>';
    }
    ?>

  </div>
</div>


  </div>
</div>


  <div class="d-flex justify-content-evenly mb-4">
    <button id="viewMoreBtn" class="btn btn-sm btn-outline-dark rounded-0 fw-bold shadow-none">View More</button>
  </div>
</div>

<!-- JS to toggle visibility -->
<script>
  document.getElementById('viewMoreBtn').addEventListener('click', function () {
    const extraRooms = document.querySelectorAll('.extra-room');
    extraRooms.forEach(room => room.classList.toggle('d-none'));

    // Optional: Toggle button text
    const btn = document.getElementById('viewMoreBtn');
    if (btn.innerText === 'View More') {
      btn.innerText = 'View Less';
    } else {
      btn.innerText = 'View More';
    }
  });
</script>





  <!-- Facilities -->
  <div class="my-5 px-4">
    <h2 class="fw-bold h-font text-center">Facilities</h2>
    <div class="h-line h-bg-dark"></div>
    <p class="text-center mt-3">
    Experience a memorable vacation with blue sea, white sand and attentive service from our staff. What's more wonderful is to immerse yourself in captivating moments at the infinity pool or with daily entertainment activities.
    </p>
  </div>

  <div class="container">
    <!-- 3 Facilities Blocks -->
    <?php
    $facilities = [
      ["Swimming Pool", "about/1.jpg", "The swimming pool is located in a fresh and modern setting. With a spacious design, the pool is surrounded by relaxing loungers, allowing visitors to enjoy the sunshine or relax under the shade of trees. The water in the pool is always kept clean and cool, bringing absolute comfort to swimmers."],
      ["Cuisine", "about/5.jpg", "Awaken your taste buds with a rich culinary journey, from the flavors of local ingredients to Western dishes. It is a special focus on the dining experience, with signature dishes carefully crafted by passionate chefs using creative cooking styles. With spaces that highlight the original beauty of nature, our restaurants and bars are an attractive destination for any dining occasion or intimate gathering."],
      ["Fitness Centre", "about/4.jpg", "Keep up your exercise routine with our air-conditioned facility overlooking the tropical landscape. Our fitness centre comes fully equipped with state-of-the-art Precor technology, including cardiovascular training machines, treadmills, bench presses and free weights."]
    ];
    $reverse = false;
    foreach ($facilities as $f) {
      echo '
      <div class="row justify-content-between align-items-center ' . ($reverse ? 'flex-row-reverse' : '') . '">
        <div class="col-lg-6 col-md-6 mb-4">
          <h3 class="mb-3">' . $f[0] . '</h3>
          <p>' . $f[2] . '</p>
        </div>
        <div class="col-lg-5 col-md-5 mb-4">
          <img src="images/' . $f[1] . '" class="w-100 rounded">
        </div>
      </div>';
      $reverse = !$reverse;
    }
    ?>
  </div>

 <!-- Contact Section -->
 <?php
$contact_q = "SELECT iframe, pn, email, fb, tw, ig FROM `contact_detail` WHERE `sr_no` = ?";
$value = [1];
$contact_r = select($contact_q, $value, 'i');
if ($contact_r) {
    $contact_data = mysqli_fetch_assoc($contact_r);
} else {
    echo "Không có dữ liệu liên hệ.";
    exit; // Ngừng chạy nếu không có dữ liệu
}
?>

<h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">Reach Us</h2>

<div class="container">
  <div class="row align-items-center">
    
    <!-- Google Map -->
    <div class="col-lg-8 col-md-12 mb-4">
      <div class="rounded overflow-hidden shadow-sm">
        <iframe 
          src="<?= !empty($contact_data['iframe']) ? $contact_data['iframe'] : '#' ?>" 
          class="w-100" 
          height="320" 
          style="border:0;" 
          allowfullscreen="" 
          loading="lazy" 
          referrerpolicy="no-referrer-when-downgrade">
        </iframe>
      </div>
    </div>

    <!-- Contact Info -->
    <div class="col-lg-4 col-md-12">
      <div class="bg-white p-4 rounded shadow-sm mb-3">
        <h5 class="mb-3">Contact</h5>
        <a href="tel:<?= !empty($contact_data['pn']) ? $contact_data['pn'] : '#' ?>" class="text-decoration-none text-dark d-block mb-2">
          <i class="bi bi-telephone-fill me-2"></i><?= !empty($contact_data['pn']) ? $contact_data['pn'] : 'No phone number available' ?>
        </a>
      </div>

      <div class="bg-white p-4 rounded shadow-sm">
        <h5 class="mb-3">Follow us</h5>
        <div class="d-flex gap-2 flex-wrap">
          <?php
          $socials = [
            'fb' => ['icon' => 'facebook', 'label' => 'Facebook'],
            'tw' => ['icon' => 'twitter-x', 'label' => 'Twitter'],
            'ig' => ['icon' => 'instagram', 'label' => 'Instagram']
          ];

          foreach ($socials as $key => $data) {
            if (!empty($contact_data[$key])) {
              echo '
                <a href="' . $contact_data[$key] . '" target="_blank" class="text-decoration-none">
                  <span class="badge bg-light text-dark fs-6 p-2">
                    <i class="bi bi-' . $data['icon'] . ' me-1"></i>' . $data['label'] . '
                  </span>
                </a>';
            }
          }
          ?>
        </div>
      </div>
    </div>

  </div>
</div>



   <!-- Chatbot Button + Frame -->
   <div class="chatbot-icon" onclick="toggleChat()">💬</div>
  <iframe id="chatFrame" class="chatbot-frame" src="chat_ui.php"></iframe>



  <script>
    // JavaScript toggle chatbot visibility
    function toggleChat() {
      const chatFrame = document.getElementById("chatFrame");
      chatFrame.style.display = (chatFrame.style.display === "block") ? "none" : "block";
    }
  </script>

  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <script>
    var swiper = new Swiper(".swiper-container", {
      spaceBetween: 30,
      effect: "fade",
      loop: true,
      autoplay: { delay: 3000 }
    });
  </script>

  <!-- Footer + Scripts -->
  <?php require('inc/footer.php'); ?>
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <script>
    var swiper = new Swiper(".swiper-container", {
      spaceBetween: 30,
      effect: "fade",
      loop: true,
      autoplay: { delay: 3000 }
    });

    function toggleChat() {
      const chatFrame = document.getElementById("chatFrame");
      chatFrame.style.display = (chatFrame.style.display === "block") ? "none" : "block";
    }
  </script>
</body>

</html>



