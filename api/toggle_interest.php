<?php
session_start();
require "../includes/database_connect.php";

if (!isset($_SESSION['user_id'])) {
    echo json_encode(array("success" => false, "is_logged_in" => false));
    return;
}

$user_id = $_SESSION['user_id'];
$property_id = $_GET["property_id"];

$sql_check = "SELECT * FROM favourites WHERE user_id = '$user_id' AND property_id = '$property_id'";
$result_check = mysqli_query($conn, $sql_check);

if (mysqli_num_rows($result_check) > 0) {
    $sql_delete = "DELETE FROM favourites WHERE user_id = '$user_id' AND property_id = '$property_id'";
    mysqli_query($conn, $sql_delete);
    $is_interested = false;
} else {
    $sql_insert = "INSERT INTO favourites (user_id, property_id) VALUES ('$user_id', '$property_id')";
    mysqli_query($conn, $sql_insert);
    $is_interested = true;
}

$sql_count = "SELECT COUNT(*) as total FROM favourites WHERE property_id = '$property_id'";
$result_count = mysqli_query($conn, $sql_count);
$row_count = mysqli_fetch_assoc($result_count);

echo json_encode(array("success" => true, "is_logged_in" => true, "is_interested" => $is_interested, "property_id" => $property_id, "count" => $row_count['total']));
?>