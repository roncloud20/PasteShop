<?php
// Redirect if not login

$pagetitle = "Logout";
require_once('assets/header.php');
if(!isset($_SESSION['user_id'])) {
    // header("Location: login.php");
    echo "<script>window.location.href = 'login.php';</script>";
}

session_destroy();
echo "<script>window.location.href = 'login.php';</script>";
?>