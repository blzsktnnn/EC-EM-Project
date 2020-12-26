<?php
include "db_config.php";
define("SALT1", "wtSHSU890381IC4");
define("SALT2", "4CITAcywut46a");
$let=0;
// login check part
if (empty($_POST['username']) or empty($_POST['password'])){
    header("Location:index.php?l=1");
    $let++;
}

$username = $_POST['username'];
$password = $_POST['password'];

$password_temp = SALT1 . "$password" . SALT2;
$password_decrypt = md5($password_temp);

$sql = "SELECT user_name, password,status FROM users";
$result = $conn->query($sql);
$num = 0;
$stat=0;
if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        if ($row["user_name"] == $username and $row['password'] == $password_decrypt) {
            if($row["status"]==1) {
                header("Location:index.php");
                $num++;
                session_start();
                $_SESSION['username'] = $username;
            }
            $stat=1;
        }
    }
}

if ($num == 0 and $let==0) {
    header("Location:index.php?l=2");
}
if($stat==1){
    header("Location:index.php?l=3");
}



mysqli_close($conn);
