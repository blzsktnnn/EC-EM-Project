<?php
$host="localhost";
$username="root";
$password="";
$db="supps";
$conn = mysqli_connect($host, $username, $password, $db) or die(mysqli_connect_error());
// Connecting to db, if the db not exist >> ERROR