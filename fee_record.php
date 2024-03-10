<?php

session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"]!=true)

{
  header("location:sign_in.php");
  exit;
}

include "partials/_dbconn.php"; 



$user_name = $_SESSION["username"];

// Get user ID
$id_query = "SELECT id FROM `users` WHERE `username`='$user_name' ";
$check = mysqli_query($conn, $id_query);

$numrows = mysqli_num_rows($check);

if ($numrows > 0) {
    $row = $check->fetch_assoc();
    $user_id = $row["id"];


    $recieve_data = "SELECT *  FROM `fee_record` WHERE `user_id`='$user_id' ";
    $result = mysqli_query($conn, $recieve_data);
$feess=array();

    if (mysqli_num_rows($result) > 0) {
        // Fetch all rows in a loop
        while ($row = $result->fetch_assoc()) {
          $fee_id = $row["fee_id"];
            $feess[$fee_id] = array(
              'fee_id'=>$row["fee_id"],
                'fee_title' => $row["fee_title"],
                'fee_image1' => $row["fee_image1"],
                'fee_image2'=> $row["fee_image2"],
                'server_save_time'=>$row["server_save_time"]
            );
        }

        // Print or process memo data as needed
        
    }




}


?>




<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/index.css" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap"
      rel="stylesheet"
    />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <title id="title">Dashboard</title>
  </head>
  <body>
    <style>
    
    </style>
    <section class="whole_content">
      <main>
        <!-- aside menu  -->
       <?php include "components/nav.php" ?>

        <!-- the grey color in the center -->
        <div class="color"></div>

        <!-- main dashboard part -->
        <section class="main-section">
         




<section id="main_dashboard" class="main_dashboard">
<div class="heading_section">
  
<style>
    @font-face {
        font-family: "logofont";
        src: url("font/Aquire-BW0ox.otf") format('opentype');
    }
</style>


    <h2>Fee Record</h2>

    <a href="write_fee.php" id="add_file_record" class="add_memo">
      <img src="resources/icons/plus.png" alt="" />
    </a>
  </div>

  <div class="content_section">




<?php
            // Display memo data
            foreach ($feess as $fee) {
                echo '<div class="memo_container">';
                echo '<h3>Title: ' . $fee['fee_title'] . '</h3>';
                echo '<div style="width:20%;  display:flex; height:100%; justify-content:space-between; ">';
                echo '<form method="post">';
           
                echo '<input class="delete_fee" type="button" data-id="' . $fee['fee_id']  . '" value="DELETE" />';
                

                echo '</form>';
                echo '<a class="edit_memo" target="_blank" href="download_record.php?fee_id=' . $fee['fee_id'] . '">Download</a>';
                echo '</div>';
                // Add an edit link that leads to an edit page
         
                echo '</div>';
            }
            ?>
  </div>
    
  </section>





        </section>
        
      </main>
    </section>

  </body>
  <script>
    $(document).ready(function() {
    $(document).on("click", ".delete_fee", function() {
let confiramtion=confirm('Are you sure to delete this item ?');

if (confiramtion){



      var feeId = $(this).data("id");
      var $memoContainer = $(this).closest(".memo_container");

      $.ajax({
        url: "delete_fee.php",
        type: "POST",
        data: { fee_id: feeId },
        success: function(data) {
          if (data === "true") {
            $memoContainer.remove();
          } else {
            console.log("Error deleting memo");
          }
        },
      
      });
    }
else
{
  console.log("ok");
}

    });
  });
  </script>
</html>

