<?php
session_start();

function adminLogin() {
    if (!isset($_SESSION['adminLogin']) || $_SESSION['adminLogin'] !== true) {
        echo "<script>
                window.location.href='index.php';
              </script>";
        exit;
    }
}

function redirect($url) {
    echo "<script>
            window.location.href='$url';
          </script>";
    exit;
}

function alert($type, $msg) {
    echo <<<alert
        <div class="alert alert-$type alert-dismissible fade show custom-alert" role="alert">
            <strong class="me-3">$msg</strong> 
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    alert;
}
?>
