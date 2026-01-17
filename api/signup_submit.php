<?php
require("../includes/database_connect.php");

header('Content-Type: application/json');

$full_name = $_POST['full_name'];
$email = $_POST['email'];
$password = $_POST['password'];
$college = $_POST['college_name'];
$gender = $_POST['gender'];
$phone = $_POST['phone'];

if (strlen($full_name) < 3 || strlen($full_name) > 20) {
    echo json_encode(array("success" => false, "message" => "Name must be between 3 and 20 characters!"));
    return;
}
if (!preg_match('/^[a-zA-Z_ ]+$/', $full_name)) {
    echo json_encode(array("success" => false, "message" => "Name can only contain letters, spaces, and underscores. No numbers!"));
    return;
}

if (strlen($password) <= 6) {
    echo json_encode(array("success" => false, "message" => "Password must be greater than 6 characters!"));
    return;
}
$has_uppercase = preg_match('/[A-Z]/', $password);
$has_number    = preg_match('/[0-9]/', $password);
$has_special   = preg_match('/[^a-zA-Z0-9]/', $password); 

if (!$has_uppercase || !$has_number || !$has_special) {
    echo json_encode(array("success" => false, "message" => "Password must contain at least 1 Uppercase letter, 1 Number, and 1 Special Character!"));
    return;
}

$sql = "SELECT * FROM users WHERE email='$email'";
$result = mysqli_query($conn, $sql);
if (!$result) {
    echo json_encode(array("success" => false, "message" => "Something went wrong!"));
    return;
}
$row_count = mysqli_num_rows($result);
if ($row_count != 0) {
    echo json_encode(array("success" => false, "message" => "This email id is already registered with us!"));
    return;
}

$sql = "INSERT INTO users (full_name, email, password, phone, gender, college) VALUES ('$full_name', '$email', '$password', '$phone', '$gender', '$college')";

$result = mysqli_query($conn, $sql);
if (!$result) {
    echo json_encode(array("success" => false, "message" => "Something went wrong!"));
    return;
}

echo json_encode(array("success" => true, "message" => "Your account has been created successfully!"));
mysqli_close($conn);
?>