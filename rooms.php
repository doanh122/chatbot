<?php
require('inc/db_connect.php');
require('inc/header.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Rooms</title>
  <?php require('inc/links.php'); ?>

  <style>
    .card {
      border-radius: 12px;
      overflow: hidden;
      transition: all 0.3s ease;
    }

    .card:hover {
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
    }

    .card-img-container {
      width: 100%;
      height: 250px;
      overflow: hidden;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .card-img-container img {
      object-fit: cover;
      height: 100%;
      width: 100%;
      border-radius: 0.25rem 0 0 0.25rem;
    }

    .card-body p, .card-body ul {
      font-size: 15px;
      line-height: 1.6;
      color: #444;
    }

    .card-body h5 {
      font-size: 20px;
      font-weight: bold;
      margin-bottom: 12px;
      text-transform: capitalize;
    }

    .status-available {
      color: #198754;
      font-weight: bold;
    }

    .status-occupied {
      color: #dc3545;
      font-weight: bold;
    }

    .status-maintenance {
      color: #6c757d;
      font-weight: bold;
    }

    .btn {
      border-radius: 6px;
      padding: 6px 18px;
      font-size: 14px;
    }

    .btn-outline-dark:hover {
      background-color: #212529;
      color: #fff;
    }
  </style>
</head>
<body class="bg-light">

<div class="my-5 px-4">
  <h2 class="fw-bold h-font text-center">Our Rooms</h2>
  <div class="h-line bg-dark"></div>
</div>

<div class="container">
  <div class="row">

    <!-- Filter -->
    <div class="col-lg-3">
      <div class="bg-white p-3 rounded shadow-sm mb-4">
        <h5 class="mb-3">Accommodation Type</h5>
        <?php
        $types = ['all' => 'All', 'room' => 'Room', 'suite' => 'Suite', 'villa' => 'Villa'];
        foreach ($types as $value => $label) {
          echo '
            <div class="form-check mb-2">
              <input class="form-check-input" type="radio" name="accom_filter" value="'.$value.'" id="filter_'.$value.'" '.($value=='all' ? 'checked' : '').'>
              <label class="form-check-label" for="filter_'.$value.'">'.$label.'</label>
            </div>';
        }
        ?>
      </div>

      <div class="bg-white p-3 rounded shadow-sm mb-4">
        <h5 class="mb-3">Facilities</h5>
        <?php
        $facs = ['wifi' => 'Wi-Fi', 'pool' => 'Pool', 'parking' => 'Parking'];
        foreach ($facs as $val => $text) {
          echo '
            <div class="form-check mb-2">
              <input class="form-check-input facility-filter" type="checkbox" value="'.$val.'" id="facility_'.$val.'">
              <label class="form-check-label" for="facility_'.$val.'">'.$text.'</label>
            </div>';
        }
        ?>
      </div>

      <div class="bg-white p-3 rounded shadow-sm mb-4">
        <h5 class="mb-3">Guests</h5>
        <input type="number" id="guest_filter" class="form-control shadow-none" placeholder="" min="1">
      </div>
    </div>

    <!-- Rooms List -->
    <div class="col-lg-9">
      <div class="row">
        <?php
        $query = "SELECT * FROM Rooms";
        $result = mysqli_query($conn, $query);

        while ($row = mysqli_fetch_assoc($result)) {
          $room_type = strtolower($row['room_type']);
          $status = strtolower($row['status']);
          $status_class = 'status-' . $status;
        ?>
          <div class="col-md-12 mb-4 room-card" data-room-type="<?php echo $room_type; ?>" data-facilities="<?php echo strtolower($row['facilities']); ?>" data-guests="<?php echo $row['room_songuoi']; ?>">
            <div class="card border-0 shadow">
              <div class="row g-0">
                <div class="col-md-4 card-img-container">
                  <img src="images/accom/<?php echo $room_type; ?>/<?php echo $row['room_number']; ?>.jpg" 
                       class="img-fluid rounded-start" 
                       alt="<?php echo $room_type; ?> image">
                </div>
                <div class="col-md-8">
                  <div class="card-body">
                    <h5 class="card-title">
                      <?php echo ucfirst($room_type); ?> (Room <?php echo $row['room_number']; ?>)
                    </h5>
                    <p><strong>Area:</strong> <?php echo $row['room_dientich']; ?> — 
                       <strong>Max:</strong> <?php echo $row['room_songuoi']; ?> guests</p>
                    <p><strong>Status:</strong> <span class="<?php echo $status_class; ?>"><?php echo ucfirst($status); ?></span></p>
                    <p><strong>Facilities:</strong> <?php echo ucwords(str_replace(',', ', ', $row['facilities'])); ?></p>
                    <p><strong>Description:</strong></p>
                    <ul><li><?php echo $row['description']; ?></li></ul>
                    <p><strong>Price:</strong> <?php echo number_format($row['price'], 0, '.', ','); ?> VND</p>

                    <div class="d-flex gap-2 mt-3">
                      <a href="room_detail.php?room_id=<?php echo $row['room_id']; ?>" class="btn btn-outline-dark">More Detail</a>
                      <a href="booking.php?room_id=<?php echo $row['room_id']; ?>" class="btn btn-dark">Booking</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>

  </div>
</div>

<?php require('inc/footer.php'); ?>

<script>
  // Filter by room type
  document.querySelectorAll('input[name="accom_filter"]').forEach(function (radio) {
    radio.addEventListener('change', function () {
      const selectedType = this.value;
      const allCards = document.querySelectorAll('.room-card');

      allCards.forEach(function (card) {
        const type = card.getAttribute('data-room-type');
        card.style.display = (selectedType === 'all' || type === selectedType) ? 'block' : 'none';
      });
    });
  });

  // Filter by facilities
  document.querySelectorAll('.facility-filter').forEach(function (checkbox) {
    checkbox.addEventListener('change', function () {
      const selectedFacilities = Array.from(document.querySelectorAll('.facility-filter:checked')).map(input => input.value);
      const allCards = document.querySelectorAll('.room-card');

      allCards.forEach(function (card) {
        const facilities = card.getAttribute('data-facilities').split(',');
        const matches = selectedFacilities.every(facility => facilities.includes(facility));
        card.style.display = (selectedFacilities.length === 0 || matches) ? 'block' : 'none';
      });
    });
  });

  // Filter by guests
  document.getElementById('guest_filter').addEventListener('input', function () {
    const selectedGuests = this.value;
    const allCards = document.querySelectorAll('.room-card');

    allCards.forEach(function (card) {
      const roomGuests = parseInt(card.getAttribute('data-guests'));
      card.style.display = (selectedGuests === '' || roomGuests >= selectedGuests) ? 'block' : 'none';
    });
  });

  // Initial filter setup based on the default radio button value
  const defaultSelectedType = document.querySelector('input[name="accom_filter"]:checked').value;
  const allCards = document.querySelectorAll('.room-card');
  allCards.forEach(function (card) {
    const type = card.getAttribute('data-room-type');
    if (defaultSelectedType === 'all' || type === defaultSelectedType) {
      card.style.display = 'block';
    } else {
      card.style.display = 'none';
    }
  });
</script>

</body>
</html>
