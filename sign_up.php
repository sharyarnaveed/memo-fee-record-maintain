<?php
  $Alert=false;
  $showerror=false;
  $incomplete_form=false;
  $img_size_error=false;
  $imgae_formate=false;
  $dataexist=false;
if($_SERVER["REQUEST_METHOD"]=="POST") //send the request by post method
{

  include "partials/_dbconn.php"; // include the data base connection file

//delacring variables

  $firstname=$_POST["fname"];
  $lastname=$_POST["lname"];
  $email=$_POST["email"];
  $username=$_POST["username"];
  $password=$_POST["password"];
  $repeatpassword=$_POST["rpassword"];


if(empty($firstname) || empty($lastname) || empty($username) || empty($password) || empty($repeatpassword))

{
 $incomplete_form=true;
}
else
{


if (($password==$repeatpassword)) { // check if repeat pass is equal to password or not
  

  $query  = "SELECT * FROM `users` WHERE  `username`='$username'"; // to select username from table

  $check = mysqli_query($conn, $query);

if($check->num_rows>0)// checks if user name already exists or not
{
$dataexist=true;

}
else{
  $mdpass=md5($password); // to make password secure
$target_dir="profile_images/";
$target_file=$target_dir.rand(1,800000).basename($_FILES["profile_img"]["name"]);

$img_size=getimagesize($_FILES["profile_img"]["tmp_name"]);
$imagefiletype=strtolower(pathinfo($target_file,PATHINFO_EXTENSION));




if( $imagefiletype != "jpg" && $imagefiletype != "png" && $imagefiletype != "jpeg")
{
  $imgae_formate=true;
}
else if($_FILES["profile_img"]["size"] > 10000000)
{
$img_size_error=true;
}
else
{
move_uploaded_file($_FILES["profile_img"]["tmp_name"], $target_file);
$current_timestamp = time();
  $insert=$conn->prepare("INSERT INTO `users` (`fname`, `lname`, `email`, `username`, `password`, `dt`,`profile_img` ) VALUES(?,?,?,?,?,?,? )"); // to insert data into table 
$insert->bind_param("sssssss",$firstname,$lastname,$email,$username,$mdpass,$current_timestamp,$target_file);

if ($insert->execute()) {
  $Alert=true;
    } else {
        echo $conn->error;
    }

    $insert->close();
    $conn->close();



}


}






}
else
{
  $showerror=true;
}


}

}




?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap"
      rel="stylesheet"
    /> -->
    <link rel="stylesheet" href="css/sign_in.css" />
    <title>Sign Up</title>
  </head>
  <body>
    <main class="signup_main">
      <section class="image_sign">
        <img
          src="resources/images/nathan-dumlao-5tNBKg_cXkw-unsplash.jpg"
          alt=""
        />
      </section>


      <section class="sign_up_form">

     <?php
      if($Alert)
      {

      echo '
        <div class="login_sucess" style=" height: 15%;
  background-color: #0e45fc5b;
  display: flex;
  justify-content: center;
  align-items: center;"  >
          <h2 style="font-family: Roboto;
  font-weight: 200;" ><strong>Success!</strong> Your Account has Been Created.</h2>
        </div>
      
      ';

      header("refresh:3,url=sign_in.php");

      }
      else{
        echo '';
      }


      if($dataexist)
      {
        echo '
        <div class="login_sucess" style=" height: 15%;
  background-color: #ff4545;
  display: flex;
  justify-content: center;
  align-items: center;"  >
          <h2 style="font-family: Roboto;
  font-weight: 200;" ><strong>Alert!</strong> User Name Already Exists</h2>
        </div>
      
      ';
      }
else
{
  echo '';
}

if($incomplete_form)
{
  echo '
  <div class="login_sucess" style=" height: 15%;
background-color: #ff4545;
display: flex;
justify-content: center;
align-items: center;"  >
    <h2 style="font-family: Roboto;
font-weight: 200;" ><strong>Alert!</strong> Fill The Complete Form</h2>
  </div>

';
}
else
{
  echo '';
}

if($img_size_error)
{
  echo '
  <div class="login_sucess" style=" height: 15%;
background-color: #ff4545;
display: flex;
justify-content: center;
align-items: center;"  >
    <h2 style="font-family: Roboto;
font-weight: 200;" ><strong>Alert!</strong> Image Size is Greater Than 500kb</h2>
  </div>

';
}
else
{
echo '';
}



if($imgae_formate)
{
  echo '
  <div class="login_sucess" style=" height: 15%;
background-color: #ff4545;
display: flex;
justify-content: center;
align-items: center;"  >
    <h2 style="font-family: Roboto;
font-weight: 200;" ><strong>Alert!</strong>wrong Image Formate</h2>
  </div>

';
}
else
{
echo '';
}

?>

        <div class="welcome_text" >
          <h1>Create Account</h1>
          <p>Fill In The Below Form</p>
        </div>
        <div class="the_form">
          <form class="sign_up" action="" method="post" enctype="multipart/form-data" >
            <input
              class="sign_up_input"
              type="text"
              name="fname"
              pattern="[A-Za-z]+" title="Only Aplhabets are allowed"
              placeholder="First Name"
            />
            <input
              class="sign_up_input"
              type="text"
              name="lname"
              placeholder="Last Name"
              pattern="[A-Za-z]+" title="Only Aplhabets are allowed"
            />
            <input
              class="sign_up_input"
              type="text"
              name="email"
              placeholder="Email"
         
            />
            <input
              class="sign_up_input"
              type="text"
              name="username"
              placeholder="User Name"
       
            />
            <?php
if($showerror)
{

echo '
            <h4>Password Doesnot Match </h4>';
}        else
{
  echo'';
}    ?>
            <input
              class="sign_up_input"
              type="password"
              name="password"
              placeholder="Password"
            
            />

            <input
              class="sign_up_input"
              type="password"
              name="rpassword"
              placeholder="Repeat Password"
            />
<input type="file" name="profile_img" id="profile_img">

<h5 style=" font-family: 'Roboto', sans-serif;font-size: 18px; margin: 18px 5px; " >Already have a Account <a style="color: #0e46fce5;" href="sign_in.php">Sign In</a></h5>

            <div class="sign_up_button">
              <input
                type="submit"
                class="sign_up_submit_button"
                value="Sign Up"
                name="submit"
              />
            </div>
          </form>
        </div>
      </section>
    </main>
  </body>
</html>
