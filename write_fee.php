<?php
$done=false;
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: sign_in.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "partials/_dbconn.php";

    $fee_title = $_POST["fee_title"];
    $user_name = $_SESSION["username"];

    $target_dir = "uploads/";

    $target_file = $target_dir . rand(1, 800000) . basename($_FILES["image_1"]["name"]);
    $imagefiletype = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $check = getimagesize($_FILES["image_1"]["tmp_name"]);

    $target_file_2 = $target_dir . rand(1, 80000) . basename($_FILES["image_2"]["name"]);
    $imagefiletype_2 = strtolower(pathinfo($target_file_2, PATHINFO_EXTENSION));
    $check2 = getimagesize($_FILES["image_2"]["tmp_name"]);

    // Check for empty fields
    if ($fee_title == "" || empty($_FILES["image_1"]["name"]) || empty($_FILES["image_2"]["name"])) {
        $empty_fee = true;
    } else {
        // Get user ID
        $id_query = "SELECT id FROM `users` WHERE `username`='$user_name'";
        $result = mysqli_query($conn, $id_query);

        $numrows = mysqli_num_rows($result);

        if ($numrows > 0) {
            $row = $result->fetch_assoc();
            $user_id = $row["id"];

            if ($check !== false || $check2 !== false) {
               
            } else {
                
            }

            if (file_exists($target_file) || file_exists($target_file_2)) {
               
            }

            if ($_FILES["image_1"]["size"] > 3000000 || $_FILES["image_2"]["size"] > 3000000 ) {
               
            }

            if (
                $imagefiletype != "jpg" && $imagefiletype != "png" && $imagefiletype != "jpeg"
                || $imagefiletype_2 != "jpg" && $imagefiletype_2 != "png" && $imagefiletype_2 != "jpeg"
            ) {
                // $wrong_format = true;
            }

           
                if (move_uploaded_file($_FILES["image_1"]["tmp_name"], $target_file) && move_uploaded_file($_FILES["image_2"]["tmp_name"], $target_file_2)) {
                    $stmt = $conn->prepare("INSERT INTO fee_record (`user_id`, `fee_title`, `fee_image1`, `fee_image2`) VALUES (?, ?, ?, ?)");
                    $stmt->bind_param("ssss", $user_id, $fee_title, $target_file, $target_file_2);

                    if ($stmt->execute()) {
                  $done=true;
                    } else {
                        echo $conn->error;
                    }

                    $stmt->close();
                    $conn->close();
                } else {
                    
                }
            
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
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/index.css">
    <title>Write the Record</title>
</head>

<body>
<form method="post" class="write_a_fee_record" enctype="multipart/form-data">
<?php
    if($done)
    {
echo '
        <div class="login_sucess" style=" height: 15%;
  background-color: #0e45fc5b;
  display: flex;
  justify-content: center;
  align-items: center;"  >
          <h2 style="font-family: Roboto;
  font-weight: 200;" ><strong>Success! </strong>Record Saved.</h2>
        </div>
      
      ';
    }

      ?>
    <h2>Fill the Below Info</h2>
    <div class="fill_the_info">
        <input type="text" name="fee_title" placeholder="Title" id="file_record_title" />
        <label for="" style="height:47px;"> Upload Pic: 
          <input type="file" name="image_1" id="file_pic_upload1" />
        </label>
        <label for="">Upload Pic 2 :
           <input type="file" name="image_2" id="file_pic_upload2" /> 
          </label>
        <div class="submit_back_buttons">
            <input type="submit" id="submit_file" name="submit" value="Submit" />
            <a href="fee_record.php" id="back_fee_file" > Back</a>
        </div>
    </div>
</form>
</body>
</html>