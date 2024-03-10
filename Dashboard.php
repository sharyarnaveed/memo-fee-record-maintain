<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] != true) {
  header("location: sign_in.php");
  exit;
} else {
  include "partials/_dbconn.php";

  $user_id = $_SESSION['id'];

  $receive_dashboard = "SELECT memo_id, memo, memo_title FROM `memo` WHERE user_id='$user_id' ORDER BY time DESC LIMIT 5"; //Added space before WHERE
  $result = mysqli_query($conn, $receive_dashboard);

  $receive_fee = "SELECT fee_id, fee_title FROM `fee_record` WHERE user_id='$user_id' ORDER BY server_save_time DESC LIMIT 5"; //Added space before WHERE
  $result2 = mysqli_query($conn, $receive_fee);

  $memos = array();
  $fee_array = array();

  if (mysqli_num_rows($result) > 0) {
    while ($row = $result->fetch_assoc()) {
      $memo_id = $row["memo_id"];
      $memos[$memo_id] = array(
        'memo' => $row["memo"],
        'memo_title' => $row["memo_title"],
        'memo_id' => $memo_id
      );
    }
  }

  if (mysqli_num_rows($result2) > 0) {
    while ($row2 = $result2->fetch_assoc()) {
      $fee_id_data = $row2["fee_id"]; //Changed $row to $row2
      $fee_array[$fee_id_data] = array(
        'fee_title' => $row2["fee_title"], //Changed $row to $row2
        'fee_id' => $fee_id_data
      );
    }
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
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap" rel="stylesheet" />

  <title id="title">Dashboard</title>
  <style>
    @font-face {
      font-family: "logofont";
      src: url("font/Aquire-BW0ox.otf") format('opentype');
    }
  </style>
</head>

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
          <div class="top_nav">
            <div class="rightpart">
              <div class="welcome_user">
                <h2>Welcome, <?php echo $_SESSION["username"]; ?></h2>
              </div>
            </div>
          </div>
          <div class="bottom_content">
            <div class="content">
              <h2>Memo</h2>
              <?php
              foreach ($memos as $memo_id => $memo) {
                echo '<a href="update_memo.php?memo_id=' . $memo_id . '" class="the_content">';
                echo '<h3>Title: ' . $memo['memo_title'] . '</h3>';
                echo '</a>';
              }
              ?>
            </div>
            <div class="content">
              <h2>Fee</h2>
              <?php
              foreach ($fee_array as $fee_id_data => $fee) {
                echo '<a target="_blank" href="Download_record.php?fee_id=' . $fee_id_data . '" class="the_content">'; //Changed memo_id to fee_id
                echo '<h3>Title: ' . $fee['fee_title'] . '</h3>';
                echo '</a>';
              }
              ?>
            </div>
          </div>
        </section>
      </section>
    </main>
  </section>
</body>

</html>