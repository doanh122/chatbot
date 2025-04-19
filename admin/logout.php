<?php
require('inc/ess.php');

session_start();
session_destroy();
redirect('index.php');
?>
