<?php
session_start();
require "../includes/database_connect.php";

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(array("success" => false, "is_logged_in" => false, "message" => "Please login first."));
    return;
}

$user_id = $_SESSION['user_id'];
$property_id = $_POST['property_id']; 

$sql = "INSERT INTO bookings (user_id, property_id) VALUES ('$user_id', '$property_id')";
$result = mysqli_query($conn, $sql);

if ($result) {
    echo json_encode(array("success" => true, "message" => "Booking request sent successfully! We will contact you shortly."));
} else {
    echo json_encode(array("success" => false, "message" => "Something went wrong!"));
}
?>