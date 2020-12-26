<?php
// logout part
session_start();
$username = $_SESSION['username'];
echo $username;
header("Location:index.php");