<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hiro Hotel - Contact </title>
    <?php require ('inc/links.php'); ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

  
</head>

<body class ="bg-light">

 <?php require('inc/header.php'); ?>


 <!-- Contact Us Section -->
 <div class="container my-5 text-center">
        <h2 class="fw-bold">Contact Us</h2>
        <div class="h-line bg-dark mx-auto" style="width: 100px; height: 2px;"></div>
        <p class="mt-3 w-75 mx-auto">
            We are here to assist you with any inquiries or reservations. Feel free to reach out to us at any time.
        </p>
    </div>

    <!-- Contact Details Section -->
    <div class="container text-center">
        <p class="mb-2">
            <i class="bi bi-geo-alt-fill"></i> 
             Vietnam
        </p>
        <p class="mb-2">
            <i class="bi bi-telephone-fill"></i> 
            +(84 234) 3 681 688 (Front Office) <br>
            <span class="text-muted">Working hours: 24/7</span>
        </p>
        <p class="mb-2">
            <i class="bi bi-telephone-fill"></i> 
            +(84 234) 3 819 397 (Reservation Office) <br>
            <span class="text-muted">Working hours: 08:00 - 17:00</span>
        </p>
        <p class="mb-2">
            <i class="bi bi-envelope-fill"></i> 
            <a href="mailto:info@hotel.com" class="text-dark">info@hotel.com</a>
        </p>
    </div>

    <!-- Google Maps Section -->
    <div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-8 p-4 mb-lg-0 mb-3 bg-white rounded">
            <iframe class="w-100 rounded" height="320px" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3929.408900557843!2d105.75547457573028!3d9.983041973324875!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31a08960c9fbe639%3A0x5bb6467de866d109!2sBTEC%20FPT!5e0!3m2!1svi!2s!4v1740825774231!5m2!1svi!2s" loading="lazy"></iframe>
                <h5> Address </h5>
                <a href ="https://maps.app.goo.gl/DFwGVyjGL8ye849p8" target ="_blank" class="d-inline-block text-decoration-none text-dark" >  
                    <i class="bi bi-geo-alt-fill"></i> BTEC 
                </a>

                <h5 class="mt-4">Email</h5>
                <a href="mailto:hotel@gmail.com" class="d-inline-block text-decoration-none text-dark">
                   <i class="bi bi-envelope-fill"></i> hotel@gmail.com
                </a>

                <h5 class="mt-4">Follow us</h5>
<a href="#" class="d-inline-block text-dark fs-5 me-2">
<i class="bi bi-twitter-x"></i> 
</a>
<a href="#" class="d-inline-block text-dark fs-5 me-2">
  <i class="bi bi-facebook me-1"></i>
</a>
<a href="#" class="d-inline-block text-dark fs-5">
  <i class="bi bi-instagram me-1"></i>
</a>




        </div>
    </div>
</div>


 <!-- Contact Form Section -->
 <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-6 px-4">
                <div class="bg-white rounded shadow p-4">
                    <h5>Send a message</h5>
                    <form>
                        <div class="mt-3">
                            <label class="form-label" style="font-weight: 500;">Name</label>
                            <input type="text" class="form-control shadow-none">
                        </div>
                        <div class="mt-3">
                            <label class="form-label" style="font-weight: 500;">Email</label>
                            <input type="email" class="form-control shadow-none">
                        </div>
                        <div class="mt-3">
                            <label class="form-label" style="font-weight: 500;">Subject</label>
                            <input type="text" class="form-control shadow-none">
                        </div>
                        <div class="mt-3">
                            <label class="form-label" style="font-weight: 500;">Message</label>
                            <textarea class="form-control shadow-none" rows="4"></textarea>
                        </div>
                        <div class="mt-3 text-center">
                            <button type="submit" class="btn btn-dark">Send Message</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
 
<br>

 <?php require('inc/footer.php'); ?>


 
</body>

</html>
