<?php
include "partials/_dbconn.php";

// Retrieve memo_id from POST data
$feedele_id = $_POST["fee_id"];

// Prepare and execute the delete query
$delete_query = "DELETE FROM `fee_record` WHERE `fee_id`='$feedele_id'";
if (mysqli_query($conn, $delete_query)) {
    echo "true"; // Echo "true" if deletion was successful
} else {
    echo "false"; // Echo "false" if there was an error
}
?>
