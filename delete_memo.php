<?php
include "partials/_dbconn.php";

// Retrieve memo_id from POST data
$memodele_id = $_POST["memo_id"];

// Prepare and execute the delete query
$delete_query = "DELETE FROM `memo` WHERE `memo_id`='$memodele_id'";
if (mysqli_query($conn, $delete_query)) {
    echo "true"; // Echo "true" if deletion was successful
} else {
    echo "false"; // Echo "false" if there was an error
}
?>
