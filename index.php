<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="robots" content="index,follow" >
    <meta name="googlebot" content="index,follow" >
    <meta name="author" content="Katona Balazs and Toth Zalan">
    <meta name="keywords" content="nutritional supplement">
    <meta http-equiv="content-language" content="hu">
    <meta name="description" content="This is a website for nutritional supplement.">


    <title>Be fit with B&Z</title>

    <link rel="stylesheet" href="css/master.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,user-scalable=no">
</head>
<body>

<div id="header"><h1 style="color: white; text-align: center;line-height: 220px">BE FIT WITH B&Z</h1></div>
<div id="content">
    <div id="nav">
        <label for="show-menu" class="show-menu"><i class="fa fa-bars"></i>&nbsp;Menu</label>
        <input type="checkbox" id="show-menu">
        <ul class="list">
            <li class="list"><a class="link" href="index.php" title="Home"><i class="fa fa-home"></i>Home</a></li>

            <li class="list"><a class="link" href="info.php" title="Information"><i class="fa fa-history"></i>Information</a></li>

            <li class="list"><a class="link" href="shop.php" title="Shop"><i class="fa fa-map-signs"></i>Shop</a></li>

            <li class="list"><a class="link" href="products.php" title="Products"><i class="fa fa-folder"></i>Products</a></li>

            <li class="list"><a class="link" href="contacts.php" title="Contacts"><i class="fa fa-id-badge"></i>Contacts </a></li>
            <?php
            //logged out
            session_start();
            if(isset($_POST['logout'])){
                unset($username);
                unset($_SESSION['username']);
                session_destroy();
                //header("Location:index.php");
            }
            //logged in
            if (!empty($_SESSION['username'])) {
                echo <<<EOT
            <li class="list"><a class="link" href="order.php" title="Order"><i class="fa fa-folder"></i>Order!</a></li>
EOT;

            }
            ?>
        </ul>
        <?php
        // logged out
        if (!empty($_SESSION['username'])) {
            include "db_config.php";
            $username = $_SESSION['username'];
            $sql = "SELECT user_id,first_name, last_name, user_name, password,email,phone, address,city,status FROM users";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // output data of each row
                while ($row = $result->fetch_assoc()) {
                    if ($row["user_name"] == $username) {
                        $firstname = $row["first_name"];
                        echo <<< EOT
                      <div id="profilediv">
                      Welcome $firstname<br>
                               <span style='font-size: 10px; color: green'>You are logged in</span>
                               <br>
                                 <form action="index.php" method="post">
                <input type="submit" id="regbutton" name="myprofile" value="My Profile">
            </form>
                               <form action="index.php" method="post">
                <input type="submit" id="regbutton" name="myorders" value="My Orders">
            </form>
                               <hr>
                                <form action="index.php" method="post">
                <input type="submit" id="regbutton" name="logout" value="Logout">
            </form>
                               </div>
                               
EOT;


                    }
                }
            }

        }
        else {
            //logged in
            ?>
            <div id="logindiv">
                <h3>Login</h3>
                <?php
                //received errors from login
                if (isset($_GET['l']))
                    $l = $_GET['l'];
                else
                    $l = "";

                if ($l == "1")
                    echo "<span style='color: crimson; font-size: 12px'>One of fields are not filled!</span>";
                if ($l == "2")
                    echo "<span style='color: crimson; font-size: 12px'>Wrong username or password!</span>";
                if ($l == "3")
                    echo "<span style='color: crimson; font-size: 12px'>Activate your account!</span>";
                ?>
                <form action="login.php" method="post">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" maxlength="30" size="25" placeholder="username" autofocus>
                    <br><br>
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password" maxlength="15" size="25" placeholder="password" autofocus>
                    <br><br>
                    <input type="submit" name="sb" value="Send">
                    <input type="reset" name="rg" value="Cancle">
                    <br>
                    <br>
                </form>
                <form action="index.php" method="post">
                    <input type="submit" id="regbutton" name="reg" value="Registration">
                </form>
            </div>

            <?php
        }
        ?>

    </div>
    <div id="main">
        <?php
        // registration part
        $firstname_reg = "";
        $lastname_reg = "";
        $username_reg = "";
        $email_reg = "";
        $phone_reg = "";
        $address_reg = "";
        $city_reg = "";

        $num=0;
        if(isset($_POST['reg']) or isset($_GET['p'])){
            if(!empty($_SESSION['firstname_reg'])) {
                $firstname_reg = $_SESSION['firstname_reg'];
            }
            if(!empty($_SESSION['lastname_reg'])) {
                $lastname_reg = $_SESSION['lastname_reg'];
            }
        if(!empty($_SESSION['username_reg'])) {
            $username_reg = $_SESSION['username_reg'];
        }
        if(!empty($_SESSION['email_reg'])) {
            $email_reg = $_SESSION['email_reg'];
        }
        if(!empty($_SESSION['phone_reg'])) {
            $phone_reg = $_SESSION['phone_reg'];
        }
        if(!empty($_SESSION['address_reg'])) {
            $address_reg = $_SESSION['address_reg'];
        }
        if(!empty($_SESSION['city_reg'])) {
            $city_reg = $_SESSION['city_reg'];
        }

            session_destroy();
            $num++;
            echo "<div id=\"regdiv\">
            <div class=\"reg_error\">";
            // received error from registration
            if (isset($_GET['p']))
                $p = $_GET['p'];
            else
                $p = "";

            if ($p == "1")
                echo "Firstname required!";
            if ($p == "2")
                echo "Lastname required!";
            if ($p == "3")
                echo "Username required!";
            if ($p == "4")
                echo "Password required!";
            if ($p == "5")
                echo "Verification password required!";
            if ($p == "6")
                echo "Email required!";
            if ($p == "7")
                echo "Phone required!";
            if ($p == "8")
                echo "Address required!";
            if ($p == "9")
                echo "City required!";
            if ($p == "10")
                echo "Error in firstname field!";
            if ($p == "11")
                echo "Error in Lastname field!";
            if ($p == "12")
                echo "Error in username field!";
            if ($p == "13")
                echo "Error in password field!";
            if ($p == "14")
                echo "Error in phone field!";
            if ($p == "15")
                echo "Error in city field!";
            if ($p == "16")
                echo "This email or username already exist! ";
            if ($p == "17")
                echo "<span style='color: green'>You are registered! Verify your account via email link.</span> ";
            if ($p == "18")
                echo "Something went wrong! Please try again! ";
            echo <<< EOT

    </div>
      <form method="post" action="registration.php">
	    <h2>Registration:</h2>
		<label for="fn">First name:</label>
		<input type="text" name="fn" value="$firstname_reg" id="fn" maxlength="30" size="15" placeholder="First Name" autofocus>
		<b>Allowed:Only letters</b>
		<br><br>
		<label for="ln">Last name:</label>
		<input type="text" name="ln" value="$lastname_reg" id="ln" maxlength="30" size="15" placeholder="Last Name" autofocus>
		<b>Allowed:Only letters</b>
		<br><br>
		<label for="username">Username:</label>
		<input type="text" name="username" value="$username_reg" id="username" maxlength="30" size="15" placeholder="Username" autofocus>
		<b>Allowed:Only letters and numbers</b>
		<br><br>
		<label for="password">Password:</label>
		<input type="password" name="password" id="password" minlength="8" maxlength="15" size="15" placeholder="Password" autofocus>
		<b>Allowed:Letters, numbers, characters</b>
		<br><br>
		<label for="password2">Confirm Password:</label>
		<input type="password" name="password2" id="password2" maxlength="15" size="15" placeholder="Confirm Password" autofocus>
		<b>Retype password</b>
		<br><br>
		<label for="email">Email:</label>
		<input type="email" name="email" value="$email_reg" id="email" maxlength="40" size="15" placeholder="Email" autofocus>
		<br><br>
		<label for="phone">Phone:</label>
		<input type="text" name="phone" value="$phone_reg" id="phone" maxlength="15" size="15" placeholder="Phone" autofocus>
		<b>Allowed:only numbers</b>
		<br><br>
		<label for="address">Address:</label>
		<input type="text" name="address" value="$address_reg" id="address" maxlength="40" size="15" placeholder="Address" autofocus>
	    <b>Street name and house number</b>
	    <br><br>
		<label for="city">City:</label>
		<input type="text" name="city" value="$city_reg" id="city" maxlength="30" size="15" placeholder="City" autofocus>
		<br><br>
		<input type="submit" name="sb" value="Send">
		<input type="reset"  name="rg" value="Cancel">
       </form>
    </div>
EOT;

        }


        //MYPROFILE PART
        if(isset($_POST['myprofile']) or isset($_GET['k'])){
            $num++;
            $username = $_SESSION['username'];
            $sql = "SELECT user_id,first_name, last_name, user_name, password,email,phone, address,city FROM users";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // output data of each row
                while ($row = $result->fetch_assoc()) {
                    if ($row["user_name"] == $username) {
                        $firstname = $row["first_name"];
                        $lastname = $row["last_name"];
                        $email=$row["email"];
                        $phone=$row["phone"];
                        $address=$row["address"];
                        $city=$row["city"];
                    }
                }
            }
            echo <<< EOT
            <div id="myprofile">
            <fieldset id="myprofile_field">
            <legend>My Profile</legend>
EOT;
            // my profile editing errors
        if(isset($_POST['savechanges']) or isset($_GET['k'])) {
            echo "<div class=\"savechanges_error\">";
            if (isset($_GET['k']))
                $k = $_GET['k'];
            else
                $k = "";

            if ($k == "1")
                echo "Firstname required!";
            if ($k == "2")
                echo "Lastname required!";
            if ($k == "3")
                echo "Password required!";
            if ($k == "4")
                echo "Verification password required!";
            if ($k == "5")
                echo "Email required!";
            if ($k == "6")
                echo "Phone required!";
            if ($k == "7")
                echo "Address required!";
            if ($k == "8")
                echo "City required!";
            if ($k == "9")
                echo "Error in firstname field!";
            if ($k == "10")
                echo "Error in lastname field!";
            if ($k == "11")
                echo "Error in password field!";
            if ($k == "12")
                echo "Error in email field!";
            if ($k == "13"){
                echo "Error in phone field!";
            }
            if ($k == "14"){
                echo "Error in address field!";
            }
            if ($k == "15"){
                echo "Error in city field!";
            }
            echo "</div>";
        }

              echo "<form method='post' action='index.php'>
                  Your fistname:<input type='text' name='firstname' maxlength='30' size='15' value='$firstname' autofocus><br><br>
                  Your lastname:<input type='text' name='lastname' maxlength='30' size='15' value='$lastname' autofocus><br><br>
                  Your username:$username<br><br>
                  New Password:<input type='password' name='passw1'  minlength='8' maxlength='15' size='15' autofocus><br><br>
                  New Password again:<input type='password' name='passw2'  minlength='8' maxlength='15' size='15' autofocus><br><br>
                  Your email address:<input type='email' name='emailaddr' id='emailaddr' maxlength='40' size='30' value='$email' autofocus><br><br>
                  Your phone number:<input type='text' name='phonenum'  maxlength='15' size='15' value='$phone' autofocus><br><br>
                  Your address:<input type='text' name='address'  maxlength='40' size='30' value='$address' autofocus><br><br>
                  Your city:<input type='text' name='city' maxlength='30' size='20' value='$city' autofocus><br><br>
                  <input type='submit' name='savechanges' value='Save Changes'>
                  </form>";

            echo "</fieldset></div>";
        }
        // profile editing check
        if(isset($_POST['savechanges'])){
            $num++;
            echo <<< EOT
            <div id="savechanges">
EOT;
            $num = 0;
            if (empty($_POST['firstname'])){
                header("Location:index.php?k=1");
                $num++;
            }
            else if (empty($_POST['lastname'])){
                header("Location:index.php?k=2");
                $num++;
            }
            else if (empty($_POST['emailaddr'])){
                header("Location:index.php?k=5");
                $num++;
            }
            else if (empty($_POST['phonenum'])){
                header("Location:index.php?k=6");
                $num++;
            }
            else if (empty($_POST['address'])){
                header("Location:index.php?k=7");
                $num++;
            }
            else if (empty($_POST['city'])){
                header("Location:index.php?k=8");
                $num++;
            }
            $username = $_SESSION['username'];
            define("SALT1", "wtSHSU890381IC4");
            define("SALT2", "4CITAcywut46a");

            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $password = $_POST['passw1'];
            $password2 = $_POST['passw2'];
            $email = $_POST['emailaddr'];
            $phone = $_POST['phonenum'];
            $address = $_POST['address'];
            $city = $_POST['city'];
            $num = 0;

            if (!preg_match('/[0-9]/', $firstname) and !preg_match('/[\/^£$%&*()}{@#~?><>,|=_+¬-]/', $firstname) and preg_match('/[A-Za-z]/', $firstname)) {
                $firstname = strip_tags($firstname);
                $firstname = strtolower($firstname);
                $firstname = ucfirst($firstname);
            }
            else {
                header("Location:index.php?k=9");
                $num++;
            }
            if (!preg_match('/[0-9]/', $lastname) and !preg_match('/[\/^£$%&*()}{@#~?><>,|=_+¬-]/', $lastname) and preg_match('/[A-Za-z]/', $lastname)) {
                $lastname = strip_tags($lastname);
                $lastname = strtolower($lastname);
                $lastname = ucfirst($lastname);

            } else {
                header("Location:index.php?k=10");
                $num++;
            }
            if(!empty($_POST['passw1']) or !empty($_POST['passw2'])) {
              if ($password == $password2 and strlen($password) >= 8) {
                $password = strip_tags($password);
                $password_temp = SALT1 . "$password" . SALT2;
                $password_decrypt = md5($password_temp);

            }
              else {
                header("Location:index.php?k=11");
                $num++;
              }
            }
            if(!empty($email)) {
                $email = strip_tags($email);
            }
            else{
                header("Location:index.php?k=12");
                $num++;
            }

            if (preg_match('/[0-9]/', $phone) and !preg_match('/[A-Za-z]/', $phone) and !preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $phone) and strlen($phone) >= 6) {
                $phone = strip_tags($phone);

            }
            else {
                header("Location:index.php?k=13");
                $num++;
            }
            if(!empty($address)) {
                $address = strip_tags($address);
            }
            else{
                header("Location:index.php?k=14");
                $num++;
            }

            if (!preg_match('/[0-9]/', $city) and !preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $city) and preg_match('/[A-Za-z]/', $city)) {
                $city = strip_tags($city);
                $city = strtolower($city);
                $city = ucfirst($city);

            }
            else {
                header("Location:index.php?k=15");
                $num++;
            }
            // if not have error the profile is updating in db
            if($num==0) {
                if (empty($_POST['passw1']) and empty($_POST['passw2'])){
                    $sql = "UPDATE users SET first_name='$firstname',last_name='$lastname',email='$email',phone='$phone',address='$address',city='$city' WHERE user_name='$username'";
                    if (mysqli_query($conn, $sql)) {
                        echo "<span style='color: green;font-size:20px;margin-left: 35px;'>Profile is updated successfully</span>";
                    } else {
                        echo "<span style='color: red;font-size:20px;margin-left:35px'>Error updating profile</span>";
                    }

                    mysqli_close($conn);
                }
                else if(!empty($_POST['passw1']) and !empty($_POST['passw2'])){
                $sql = "UPDATE users SET first_name='$firstname',last_name='$lastname',password='$password_decrypt',email='$email',phone='$phone',address='$address',city='$city' WHERE user_name='$username'";
                if (mysqli_query($conn, $sql)) {
                    echo "<span style='color: green;font-size:20px;margin-left:35px'>Profile is updated successfully</span>";
                } else {
                    echo "<span style='color: red;font-size:20px;margin-left:35px'>Error updating profile</span>";
                }

                mysqli_close($conn);
                }
            }
            echo "</div>";
        }
        else if($num==0){
             echo <<< EOT
EOT;
        }
        ?>
    </div>


</div>
<div class="clear"></div>
<div>
    <div id="footer">
        <p>
           School project.<br>
            © <?php
            $date = date('Y.m.d');
            echo $date;
            ?>
            <br>Katona Balazs and Toth Zalan<br>All rights reserved.<br>
            <a href="admin_login.php" name="Admin login" target="_blank">Admin login</a>

    </div>
</div>
</body>
</html>