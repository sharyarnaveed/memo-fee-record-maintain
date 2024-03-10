<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] != true) {
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

  // Retrieve memo data
  $recieve_data = "SELECT memo_id, memo, memo_title  FROM `memo` WHERE `user_id`='$user_id' ";
  $result = mysqli_query($conn, $recieve_data);
  $memos = array();

  if (mysqli_num_rows($result) > 0) {
    // Fetch all rows in a loop
    while ($row = $result->fetch_assoc()) {
      $memo_id = $row["memo_id"];
      $memos[$memo_id] = array(
        'memo' => $row["memo"],
        'memo_title' => $row["memo_title"],
        'memo_id' => $row["memo_id"]
      );
    }

    // Print or process memo data as needed

  }
}
?>















<!-- Notes -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Memo</title>
  <link rel="stylesheet" href="css/index.css">
</head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<style>
  @font-face {
    font-family: "logofont";
    src: url("font/Aquire-BW0ox.otf") format('opentype');
  }
</style>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap" rel="stylesheet" />














<body>
  <section class="whole_content">
    <main>
      <!-- aside menu  -->
      <?php include "components/nav.php" ?>

      <!-- the grey color in the center -->
      <div class="color"></div>

      <!-- main dashboard part -->
      <section class="main-section">

        <section id="main_dashboard" class="main_dashboard">

          <section id="memo_section" class="memo_section">
            <div class="heading_section">

              <h2>Memo</h2>


              <a href="write_memo.php" id="addmemo" class="add_memo ">
                <img src="resources/icons/plus.png" alt="">
              </a>
            </div>
            <div class="content_section">


   


              <?php



              // Display memo data
              foreach ($memos as $memo_id => $memo) {
                echo '<div class="memo_container">';
                echo '<h3>Title: ' . $memo['memo_title'] . '</h3>';
                echo '<div style="width:20%;  display:flex; height:100%; justify-content:space-between; ">';
                echo '<form method="post">';
           
                echo '<input class="delete_memo" type="button" data-id="' . $memo_id . '" value="DELETE" />';
                $data=$memo_id;

          $encrypted_memo_id = base64_encode((($data*123456*9876)/9876));

                echo '</form>';
                echo '<a class="edit_memo" href="update_memo.php?memo_id=' . urlencode($encrypted_memo_id) . '">EDIT</a>';
                echo '</div>';
                echo '</div>';
              }

            

              ?>


            </div>

          </section>
        </section>

      </section>
    </main>
  </section>
</body>



<script>
  $(document).ready(function() {
    $(document).on("click", ".delete_memo", function() {
let confiramtion=confirm('Are you sure to delete this item ?');

if (confiramtion){



      var memoId = $(this).data("id");
      var $memoContainer = $(this).closest(".memo_container");

      $.ajax({
        url: "delete_memo.php",
        type: "POST",
        data: { memo_id: memoId },
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