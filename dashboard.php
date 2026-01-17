<?php
session_start();
require "includes/database_connect.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$sql_user = "SELECT * FROM users WHERE id = '$user_id'";
$result_user = mysqli_query($conn, $sql_user);
$user = mysqli_fetch_assoc($result_user);

if (!$user) {
    echo "User not found!";
    exit;
}

$sql_interests = "SELECT p.* FROM favourites f
                  INNER JOIN properties p ON f.property_id = p.id
                  WHERE f.user_id = '$user_id'";
$result_interests = mysqli_query($conn, $sql_interests);
$interested_properties = mysqli_fetch_all($result_interests, MYSQLI_ASSOC);

$sql_bookings = "SELECT p.*, b.id as booking_id, b.booking_date FROM bookings b
                 INNER JOIN properties p ON b.property_id = p.id
                 WHERE b.user_id = '$user_id'";
$result_bookings = mysqli_query($conn, $sql_bookings);
$booked_properties = mysqli_fetch_all($result_bookings, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard | PG Life</title>

    <?php include "includes/head_links.php"; ?>
    <link href="css/dashboard.css" rel="stylesheet" />
</head>

<body>
    <?php include "includes/header.php"; ?>

    <div class="page-container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb py-2">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
        </nav>

        <div class="my-profile page-container">
            <h1>My Profile</h1>
            <div class="row">
                <div class="col-md-3 profile-img-container">
                    <i class="fas fa-user profile-img"></i>
                </div>
                <div class="col-md-9">
                    <div class="row no-gutters justify-content-between align-items-end">
                        <div class="profile-details">
                            <div class="profile-name"><?php echo $user['full_name']; ?></div>
                            <div class="profile-email"><?php echo $user['email']; ?></div>
                            <div class="profile-phone"><?php echo $user['phone']; ?></div>
                            <div class="profile-college"><?php echo $user['college']; ?></div>
                        </div>
                        <div class="edit-profile">Edit Profile</div>
                    </div>
                </div>
            </div>
        </div>

        <?php
        if (count($booked_properties) > 0) {
        ?>
            <div class="my-bookings">
                <div class="page-container">
                    <h1>My Bookings</h1>
                    <?php
                    foreach ($booked_properties as $property) {
                        $property_images = glob("img/properties/" . $property['id'] . "/*.jpg");
                    ?>
                        <div class="property-card row">
                            <div class="image-container col-md-4">
                                <img src="<?php echo count($property_images) > 0 ? $property_images[0] : 'img/properties/1/1d4f0757fdb86d5f.jpg'; ?>" />
                            </div>
                            <div class="content-container col-md-8">
                                <div class="row no-gutters justify-content-between">
                                    <div class="star-container" title="<?php echo $property['rating_clean']; ?>">
                                        <?php
                                        $rating = $property['rating_clean'];
                                        for ($i = 0; $i < 5; $i++) {
                                            if ($rating >= $i + 0.8) { echo '<i class="fas fa-star"></i>'; }
                                            elseif ($rating >= $i + 0.3) { echo '<i class="fas fa-star-half-alt"></i>'; }
                                            else { echo '<i class="far fa-star"></i>'; }
                                        }
                                        ?>
                                    </div>
                                    <div class="interested-container">
                                        <div class="btn btn-success btn-sm"><i class="fas fa-check-circle"></i> Booked</div>
                                    </div>
                                </div>
                                <div class="detail-container">
                                    <div class="property-name"><?php echo $property['name']; ?></div>
                                    <div class="property-address"><?php echo $property['address']; ?></div>
                                    <div class="property-gender">
                                        <?php
                                        if ($property['gender_allowed'] == "Male") {
                                            echo '<img src="img/male.png" />';
                                        } elseif ($property['gender_allowed'] == "Female") {
                                            echo '<img src="img/female.png" />';
                                        } else {
                                            echo '<img src="img/unisex.png" />';
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="row no-gutters">
                                    <div class="rent-container col-6">
                                        <div class="rent">Rs <?php echo number_format($property['rent']); ?>/-</div>
                                        <div class="rent-unit">per month</div>
                                    </div>
                                    <div class="button-container col-6">
                                        <a href="property_detail.php?id=<?php echo $property['id']; ?>" class="btn btn-primary">View</a>
                                        <button onclick="open_cancel_modal(<?php echo $property['booking_id']; ?>)" class="btn btn-danger" style="margin-left: 5px;">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        <?php
        }
        ?>

        <?php
        if (count($interested_properties) > 0) {
        ?>
            <div class="my-interested-properties">
                <div class="page-container">
                    <h1>My Interested Properties</h1>
                    <?php
                    foreach ($interested_properties as $property) {
                        $property_images = glob("img/properties/" . $property['id'] . "/*.jpg");
                    ?>
                        <div class="property-card row">
                            <div class="image-container col-md-4">
                                <img src="<?php echo count($property_images) > 0 ? $property_images[0] : 'img/properties/1/1d4f0757fdb86d5f.jpg'; ?>" />
                            </div>
                            <div class="content-container col-md-8">
                                <div class="row no-gutters justify-content-between">
                                    <div class="star-container" title="<?php echo $property['rating_clean']; ?>">
                                        <?php
                                        $rating = $property['rating_clean'];
                                        for ($i = 0; $i < 5; $i++) {
                                            if ($rating >= $i + 0.8) { echo '<i class="fas fa-star"></i>'; }
                                            elseif ($rating >= $i + 0.3) { echo '<i class="fas fa-star-half-alt"></i>'; }
                                            else { echo '<i class="far fa-star"></i>'; }
                                        }
                                        ?>
                                    </div>
                                    <div class="interested-container">
                                        <i class="fas fa-heart"></i>
                                        <div class="interested-text">Interested</div>
                                    </div>
                                </div>
                                <div class="detail-container">
                                    <div class="property-name"><?php echo $property['name']; ?></div>
                                    <div class="property-address"><?php echo $property['address']; ?></div>
                                    <div class="property-gender">
                                        <?php
                                        if ($property['gender_allowed'] == "Male") {
                                            echo '<img src="img/male.png" />';
                                        } elseif ($property['gender_allowed'] == "Female") {
                                            echo '<img src="img/female.png" />';
                                        } else {
                                            echo '<img src="img/unisex.png" />';
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="row no-gutters">
                                    <div class="rent-container col-6">
                                        <div class="rent">Rs <?php echo number_format($property['rent']); ?>/-</div>
                                        <div class="rent-unit">per month</div>
                                    </div>
                                    <div class="button-container col-6">
                                        <a href="property_detail.php?id=<?php echo $property['id']; ?>" class="btn btn-primary">View</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        <?php
        }
        ?>
    </div>

    <?php include "includes/footer.php"; ?>

    <div class="modal fade" id="cancel-modal" tabindex="-1" role="dialog" aria-labelledby="cancel-heading" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cancel-heading">Cancel Booking</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="cancel-form" class="form" role="form">
                        <div class="form-group">
                            <label for="cancellation-reason">Why do you want to cancel?</label>
                            <select class="form-control" id="cancellation-reason" required>
                                <option value="" selected disabled>Select a reason...</option>
                                <option value="Booked by mistake">Booked by mistake</option>
                                <option value="Found a better place">Found a better place</option>
                                <option value="Change of plans">Change of plans</option>
                                <option value="Price is too high">Price is too high</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="cancellation-comment">Additional Comments (Optional)</label>
                            <textarea class="form-control" id="cancellation-comment" rows="3"></textarea>
                        </div>
                        <input type="hidden" id="cancel-booking-id" name="booking_id">
                        <div class="form-group">
                            <button type="submit" class="btn btn-block btn-danger">Confirm Cancellation</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/common.js"></script> 
    
    <script>
        function open_cancel_modal(booking_id) {
            document.getElementById('cancel-booking-id').value = booking_id;
            $('#cancel-modal').modal('show');
        }

        var cancel_form = document.getElementById("cancel-form");
        if(cancel_form) {
            cancel_form.addEventListener("submit", function (event) {
                event.preventDefault();

                var booking_id = document.getElementById('cancel-booking-id').value;
                var reason = document.getElementById('cancellation-reason').value;
                var comments = document.getElementById('cancellation-comment').value; 

                var form_data = new FormData();
                form_data.append("booking_id", booking_id);
                form_data.append("reason", reason);
                form_data.append("comments", comments); 

                var XHR = new XMLHttpRequest();
                XHR.addEventListener("load", function(event) {
                    try {
                        var response = JSON.parse(event.target.responseText);
                        if (response.success) {
                            alert(response.message);
                            window.location.reload(); 
                        } else {
                            alert(response.message);
                        }
                    } catch (e) {
                        console.error(e);
                        alert("Error processing response");
                    }
                });

                XHR.addEventListener("error", function(event) {
                    alert("Something went wrong");
                });

                XHR.open("POST", "api/cancel_booking.php");
                XHR.send(form_data);
            });
        }
    </script>
</body>
</html>