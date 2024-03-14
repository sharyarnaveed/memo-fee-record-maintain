<?php
$login = false;
$showerror = false;
$dataexist = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") //send the request by post method
{
    include "partials/_dbconn.php";
    $username = $_POST["username"];
    $password = md5($_POST["password"]);

    $sql = "SELECT * FROM `users` WHERE  `username`='$username'AND `password`='$password'";

    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);

    if ($num == 1) {
        $login = true;
        session_start();
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        $row = $result->fetch_assoc();
        $user_id = $row["id"];

        $_SESSION['id'] = $user_id;

        // $_SESSION['id']=$num["id"];
        header("location:Dashboard.php");
    } else {
        $showerror = true;
    }
} ?>








<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="css/sign_in.css">
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> -->
    <title>Sign In</title>
</head>
<style>
    @font-face {
        font-family: "logofont";
        src: url("font/Aquire-BW0ox.otf") format('opentype');
    }
</style>

<body>
    <section class="signin_section">


        <div class="signin_form">
            <?php
            if ($login) {
                echo '
        
    <div class="login_sucess" style=" height: 15%;
  background-color: #0e45fc5b;
  display: flex;
  justify-content: center;
  align-items: center;"  >
          <h2 style="font-family: Roboto;
  font-weight: 200;" ><strong>Success!</strong> taking you to Home Page</h2>
        </div>
     ';
            }

            if ($showerror) {
                echo '
        
    <div class="login_sucess" style=" height: 15%;
    background-color: #ff4545;
  display: flex;
  justify-content: center;
  align-items: center;"  >
          <h2 style="font-family: Roboto;
  font-weight: 200;" ><strong>Error!</strong> No User Found. <a href="sign_up.php" style=";color:black;">Sign Up</a></h2>
        </div>
     ';
            }
            ?>
            <div class="welcome_text">
                <h1>Welcome!</h1>
                <p>Please sign in to your account.</p>
            </div>
            <div class="login_form">
                <form class="sign_in_form" action="" method="post">


                    <input class="input_sign_in" type="text" placeholder="User Name" name="username">
                    <input class="input_sign_in" type="password" name="password" placeholder="Password" id="">
                    <div class="remeber_fogot">
                       


                        <div class="forgot">
                            <a class="forgot_button" href="forgot_password.php"> Forgot Password?</a>
                                
                          
                        </div>


                    </div>

                    <input class="input_sign_in" type="submit" id="signin_submit" value="Sign In">

                    <p class="text_sign_up">Don't have an account? <a class="sign_up_shift" href="sign_up.php">Sign Up</a></p>
                </form>
            </div>



        </div>
        <div class="sign_image">
            <img src="resources/images/windows-v94mlgvsza4-unsplash.jpg" alt="">
        </div>
    </section>

    <script src="js/sign.js"></script>
</body>










</html>