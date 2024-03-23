<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;

$notfound=false;
$mail_send=false;
if($_SERVER["REQUEST_METHOD"]=="POST")
{

function sendmail($remail,$rtoken)
{
require('mailer/Exception.php');
require('mailer/SMTP.php');
require('mailer/PHPMailer.php');

$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = '';                     //SMTP username
    $mail->Password   = '';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('sharyarmalik943751@gmail.com', 'Management');
    $mail->addAddress($remail);     //Add a recipient
  

 

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Password Reset Link';
    $mail->Body    = "Reset Your Password <br>
    Click The Link  <a href='http://localhost/incomplete%20projects/DsaProjectphp/updatepassword.php?email=$email' & reset_token=$rtoken>Reset Password</a>";


    $mail->send();
    echo true;
} 
catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}


}


$email_reset = $_POST["email_reset"];

if (!empty($email_reset)) {
    include "partials/_dbconn.php";
    $reset_query = "SELECT * FROM `users` WHERE  `email`='$email_reset' ";

    $result = mysqli_query($conn, $reset_query);
    $num = mysqli_num_rows($result);
    if ($num > 0) {
        $reset_token = bin2hex(random_bytes(16));
        date_default_timezone_set('Asia/Karachi');
        $date = date("Y-m-d");
        $query = "UPDATE `users` SET `resettoken`='$reset_token',`tokenexpire`='$date' WHERE `email`='$email_reset'";

        $query_result = mysqli_query($conn, $query);

        if ($query_result && sendmail($email_reset, $reset_token)) {
            $mail_send = true;
        }
    } else {
        $notfound = true;
    }
}
}
?>







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
    <title>Forgot Password</title>
</head>
<body>
    <section class="forgot_container">
        <?php
        if($notfound)
        {
                      echo '
        
                      <div class="login_sucess" style=" height: 15%;
                      background-color: #ff4545;
                    display: flex;
                    justify-content: center;
                    align-items: center;"  >
                            <h2 style="font-family: Roboto;
                    font-weight: 200;" ><strong>Error!</strong> No User Found. <a href="sign_up.php" style=";color:black;">Sign Up</a></h2>
                          </div>
                       '; }

                       
        ?>
             <?php
        if($mail_send)
        {
                      echo '
        
                      <div class="login_sucess" style=" height: 15%;
                      background-color: #0e45fc5b;
                    display: flex;
                    justify-content: center;
                    align-items: center;"  >
                            <h2 style="font-family: Roboto;
                    font-weight: 200;" ><strong>Done!</strong> Mail Sent </h2>
                          </div>
                       '; }

                       
        ?>
        <section class="forgot_mini">
        <div class="forgot_logo"><img src="resources/images/forgot.png" alt=""></div>
        <div class="forgot_email">
            <h3>Password Reset</h3>
            <form method="POST" class="email_form">
                <input type="email"class="input_email_forgot" name="email_reset" placeholder="Email.." id="">
                <input type="submit" class="forgot_submit" value="Reset">
            </form>
        </div>
        </section>
    </section>
</body>
</html>