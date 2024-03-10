<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"]!=true)

{
  header("location:sign_in.php");
  exit;
}

$alert_saved=false;
$empty_memo=false;
if($_SERVER["REQUEST_METHOD"]=="POST")
{
    include "partials/_dbconn.php"; 

    $user_name=$_SESSION["username"];

$memo_title=$_POST["memo_title"];
$memo_text=$_POST["memo_text"];

if($memo_text==""&&$memo_title=="")
{
   $empty_memo=true;
}
else{

    $id_query="SELECT id FROM `users` WHERE `username`='$user_name' ";

    $check= mysqli_query($conn,$id_query);

    $numrows=mysqli_num_rows($check);

    if($numrows> 0)
    {
        $row=$check->fetch_assoc();

        $user_id=$row["id"];


$insert_data="INSERT INTO `memo` (`user_id`, `memo`, `memo_title`,`time`) VALUES ( '$user_id', '$memo_text', '$memo_title', current_timestamp() )";

$result=mysqli_query($conn,$insert_data);

if($result)
{
   $alert_saved=true;
}
else
{
    echo "error";
}

$conn->close();



    }
    else
    {
        echo "User Not Found ";
    }



}

}


?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Write a Memo</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap"
      rel="stylesheet"
    />
</head>
<body>
    <?php
    if($alert_saved)
    {
echo '
        <div class="login_sucess" style=" height: 15%;
  background-color: #0e45fc5b;
  display: flex;
  justify-content: center;
  align-items: center;"  >
          <h2 style="font-family: Roboto;
  font-weight: 200;" ><strong>Success! </strong>Memo Saved.</h2>
        </div>
      
      ';
    }
    if($empty_memo)
    {
echo '
        <div class="login_sucess" style=" height: 15%;
  background-color: #ff4545;
  display: flex;
  justify-content: center;
  align-items: center;"  >
          <h2 style="font-family: Roboto;
  font-weight: 200;" ><strong>Not Saved!</strong> Plese Write Somthing to get i Saved.</h2>
        </div>
      
      ';
    }
      ?>
    <form id="write_a_memo_container" method="post" class="write_a_memo_container">
        <div class="memo_write">
<input type="text" name="memo_title" placeholder="Title" id="title">
<textarea name="memo_text" placeholder="Write a memo" id="memo_write" cols="100" rows="30"></textarea>
</div>  

<div class="memo_buttons">
<a id="go_back_memo" onclick="previous()">Back</a>
<input type="submit" id="submit_memo" name="submit" value="Submit">
</div>
</form>

<script>
    console.log("hello");
  // for going back
 function previous()
 {
    console.log("in button");
    window.location.href="memo.php"
 }
    
  

  // to submit memo
  let submit_memo = document.getElementById("submit_memo");
  submit_memo.addEventListener("click", () => {
    console.log("done");
    
});
</script>
</body>
</html>