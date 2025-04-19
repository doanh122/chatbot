<!-- Footer -->
<footer class="footer mt-auto py-4 bg-white">
  <div class="container">
    <div class="row">
      <!-- HOTEL Section -->
      <div class="col-lg-4 p-4">
        <h3 class="h-font fw-bold fs-3 mb-2">HOTEL</h3>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quos voluptate vero sed tempore illo atque beatae asperiores, adipisci dicta quia nisi voluptates impedit perspiciatis, nobis libero culpa error officiis totam?</p>
      </div>

      <!-- Links Section -->
      <div class="col-lg-4 p-4">
        <h5 class="mb-3">Links</h5>
        <a href="index.php" class="d-inline-block mb-2 text-dark text-decoration-none">Home</a><br>
        <a href="about.php" class="d-inline-block mb-2 text-dark text-decoration-none">About Us</a><br>
        <a href="rooms.php" class="d-inline-block mb-2 text-dark text-decoration-none">Rooms</a><br>
        <a href="contact.php" class="d-inline-block mb-2 text-dark text-decoration-none">Contact</a><br>
      </div>

      <!-- Contact Section -->
      <div class="col-lg-4 p-4">
        <h5 class="mb-3">Contact</h5>
        <p><strong>Phone:</strong> +84 090348343</p>
        <p><strong>Email:</strong> <a href="mailto:contact@hotel.com" class="text-dark">contact@hotel.com</a></p>
        <p><strong>Address:</strong> 12 Street, City, Vietnam</p>
      </div>

      <!-- Flw Section -->


      <div class="col-lg-4 p-4">
    <h5 class="mb-3">Follow us</h5>
   
    <a href="#" class="d-inline-block text-dark text-decoration-none mb-2">
        <i class="bi bi-facebook me-1"></i> Facebook
    </a><br>

    <a href="#" class="d-inline-block text-dark text-decoration-none mb-2">
    <i class="bi bi-twitter-x"></i> X
    </a><br>
    
    <a href="#" class="d-inline-block text-dark text-decoration-none">
        <i class="bi bi-instagram me-1"></i> Instagram
    </a><br>
</div>

    </div>
  </div>
</footer>

<!-- Bootstrap Script -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


<style>
  /* Footer Styling */
.footer {
    background-color: #f8f9fa; /* Màu nền nhẹ */
    color: #333; /* Màu chữ tối */
    padding: 50px 0; /* Tăng khoảng cách trên và dưới */
    border-top: 1px solid #ddd; /* Đường viền trên */
}

.footer .h-font {
    font-family: "Poppins", sans-serif;
}

.footer h3, .footer h5 {
    color: #000; /* Màu đen đậm để tiêu đề nổi bật */
}

.footer p, .footer a {
    font-size: 15px;
    color: #555;
}

.footer a {
    text-decoration: none;
    transition: color 0.3s ease-in-out;
}

.footer a:hover {
    color: #007bff; /* Hiệu ứng hover màu xanh */
}

/* Căn chỉnh các cột */
.footer .row {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
}

/* Chỉnh khoảng cách giữa các cột */
.footer .col-lg-4 {
    flex: 1;
    min-width: 250px;
    margin-bottom: 20px;
}

/* Responsive Footer */
@media (max-width: 768px) {
    .footer .row {
        flex-direction: column;
        text-align: center;
    }

    .footer .col-lg-4 {
        margin-bottom: 30px;
    }
}

</style>