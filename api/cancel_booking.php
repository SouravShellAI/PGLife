<?php
session_start();
require "../includes/database_connect.php";

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(array("success" => false, "message" => "Please login first."));
    return;
}

$booking_id = $_POST['booking_id'];
$reason = $_POST['reason'];
$comments = isset($_POST['comments']) ? $_POST['comments'] : ""; 
$user_id = $_SESSION['user_id'];

$sql_fetch = "SELECT property_id FROM bookings WHERE id='$booking_id' AND user_id='$user_id'";
$result_fetch = mysqli_query($conn, $sql_fetch);

if (mysqli_num_rows($result_fetch) == 0) {
    echo json_encode(array("success" => false, "message" => "Booking not found or access denied."));
    return;
}

$row = mysqli_fetch_assoc($result_fetch);
$property_id = $row['property_id'];

$sql_insert = "INSERT INTO booking_cancellations (user_id, property_id, reason, comments) VALUES ('$user_id', '$property_id', '$reason', '$comments')";
$result_insert = mysqli_query($conn, $sql_insert);

if (!$result_insert) {
    echo json_encode(array("success" => false, "message" => "Could not save cancellation reason."));
    return;
}

$sql_delete = "DELETE FROM bookings WHERE id='$booking_id'";
if (mysqli_query($conn, $sql_delete)) {
    echo json_encode(array("success" => true, "message" => "Booking cancelled successfully."));
} else {
    echo json_encode(array("success" => false, "message" => "Something went wrong deleting the booking."));
}
?>