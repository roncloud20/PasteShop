<?php
// Redirect if not login

$pagetitle = "Login to your account";
require_once('assets/header.php');
if(!isset($_SESSION['user_id'])) {
    // header("Location: login.php");
    echo "<script>window.location.href = 'login.php';</script>";
}

?>

<h1 class="text-3xl font-bold">Welcome <?= $_SESSION['firstname'] ?></h1>
<h1 class="text-3xl font-bold">Welcome <?= $_SESSION['user_role'] ?></h1>
<!-- <h1 class="text-3xl font-bold">Welcome to Dashboard</h1> -->