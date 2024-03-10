<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"]!=true)

{
  header("location:sign_in.php");
  exit;
}
include "partials/_dbconn.php"; 

if (isset($_GET['fee_id']) && !empty($_GET['fee_id'])) {
    $fee_id = $_GET['fee_id'];




$recieve_data = "SELECT *  FROM `fee_record` WHERE `fee_id`='$fee_id' ";
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

}
    
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap"
      rel="stylesheet"
    />
    <title>Download Record</title>
</head>
<style>
    *
    {
        font-family: 'Roboto', sans-serif;
    }
    main
    {
        /* border: 2px solid red; */
        width: 100%;
        height: 600px;

    }
    .images
    {
        /* border:2px solid green; */
        height: 100%;
        display: flex;
        justify-content: space-around;
        align-items: center;
        width: 70%;
    }
    .images_pic
    {
        /* border: 2px solid brown; */
width: 48%;
height: 95%;
    }
     .images_pic img
    {
        width: 100%;
        height: 100%;
    }
    .written_content
    {
        /* border:2px solid blue; */
        height: 100%;
        width: 30%;
        padding: 20px 20px;
        display: flex;
        justify-content: space-around;
        align-items: center;
        flex-direction: column;
    }
    button
    {
        width: 180px;
        height: 80px;
        font-size: 18px;
        /* border: 2px solid pink; */
        background-color:  #0e45fc5b;
        border: 2px solid #0e45fc5b;;
    }
</style>
<body>
    <main>
    <?php
        foreach ($feess as $key) {
            echo '<section class="images">';
            echo '<div class="images_pic"><img src="' . $key["fee_image1"] . '" ></div>';
            echo '<div class="images_pic"><img src="' . $key["fee_image2"] . '" ></div>';
            echo '</section>';
            
            echo '<section class="written_content">';
            echo '<h1 id="fileTitle">Title: ' . $key['fee_title'] . '</h1>';
            echo '<a href="' . $key["fee_image1"] . '" download="image1.jpg"><button>Download Image 1</button></a>';
            echo '<a href="' . $key["fee_image2"] . '" download="image2.jpg"><button>Download Image 2</button></a>';
            echo '</section>';
        }
        ?>

    </main>
</body>
</html>
