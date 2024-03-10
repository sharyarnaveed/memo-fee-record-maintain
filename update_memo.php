<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"]!=true)

{
  header("location:sign_in.php");
  exit;
}

include "partials/_dbconn.php"; 

$alert_saved = false;
$empty_memo = false;

// Check if ID is provided in the URL
if (isset($_GET['memo_id']) && !empty($_GET['memo_id'])) {
    $encrypted_memo_id = $_GET['memo_id'];


    $decrypted_memo_id_p = base64_decode(urldecode($encrypted_memo_id));
    $decrypted_memo_id1= (($decrypted_memo_id_p*9876)/123456/9876) ;
            $memo_id=$decrypted_memo_id1;
    // Fetch memo data based on ID
    $fetch_memo_query = "SELECT * FROM `memo` WHERE `memo_id`='$memo_id'";
    $fetch_result = mysqli_query($conn, $fetch_memo_query);

    $num_rows = mysqli_num_rows($fetch_result);

    if ($num_rows > 0) {
        $memo_data = mysqli_fetch_assoc($fetch_result);
        $memo_title = $memo_data['memo_title'];
        $memo_text = $memo_data['memo'];
    } else {
        // Handle the case where memo with the provided ID is not found
        echo "Memo not found";
        exit();
    }
} else {
    $memo_id = ''; // For new memo
    $memo_title = ''; // Initialize variables for new memo
    $memo_text = '';
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_name = $_SESSION["username"];

    $memo_title = $_POST["memo_title"];
    $memo_text = $_POST["memo_text"];

    if (empty($memo_text) && empty($memo_title)) {
        $empty_memo = true;
    } else {
        $id_query = "SELECT id FROM `users` WHERE `username`='$user_name'";
        $check = mysqli_query($conn, $id_query);

        $num_rows = mysqli_num_rows($check);

        if ($num_rows > 0) {
            $row = $check->fetch_assoc();
            $user_id = $row["id"];

          
                // Update existing memo
                $update_data = "UPDATE `memo` SET `memo`='$memo_text', `memo_title`='$memo_title' WHERE `memo_id`='$memo_id' AND `user_id`='$user_id'";
                $result = mysqli_query($conn, $update_data);

                if ($result) {
                    $alert_saved = true;
                } else {
                    echo "Error updating memo: " . mysqli_error($conn);
                    exit();
                }
            

           

            if ($result) {
                $alert_saved = true;
            } else {
                echo "Error saving memo: " . mysqli_error($conn);
            }

            $conn->close();
        } else {
            echo "User Not Found ";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <link rel="stylesheet" href="css/index.css">
<head>
    <!-- Add your head content here -->
</head>
<body>

    <?php
    if ($alert_saved) {
        echo '<div class="login_sucess" style="height: 15%; background-color: #0e45fc5b; display: flex; justify-content: center; align-items: center;">
                  <h2 style="font-family: Roboto; font-weight: 200;"><strong>Success! </strong> Memo Saved.</h2>
              </div>';
    }
    if ($empty_memo) {
        echo '<div class="login_sucess" style="height: 15%; background-color: #ff4545; display: flex; justify-content: center; align-items: center;">
                  <h2 style="font-family: Roboto; font-weight: 200;"><strong>Not Saved!</strong> Please write something to get it saved.</h2>
              </div>';
    }
    ?>

    <form id="write_a_memo_container" method="post" class="write_a_memo_container">
        <div class="memo_write">
            <input type="text" name="memo_title" placeholder="Title" id="title" value="<?php echo htmlspecialchars($memo_title); ?>">
            <textarea name="memo_text" placeholder="Write a memo" id="memo_write" cols="100" rows="30"><?php echo htmlspecialchars($memo_text); ?></textarea>
        </div>  

        <div class="memo_buttons">
            <div id="go_back_memo" onclick="previous()">Back</div>
            <input type="submit" id="submit_memo" name="submit" value="Update">
        </div>
        <input type="hidden" name="memo_id" value="<?php echo $memo_id; ?>">
    </form>

    <script>
        // for going back
        function previous() {
            console.log("in button");
            window.location = "memo.php";
        }

        // to submit memo
        let submit_memo = document.getElementById("submit_memo");
        submit_memo.addEventListener("click", () => {
            console.log("done");
        });
    </script>
</body>
</html>
