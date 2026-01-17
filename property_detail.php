<?php
session_start();
require "includes/database_connect.php";

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : NULL;
$property_id = $_GET["id"];

$sql = "SELECT * FROM properties WHERE id = '$property_id'";
$result = mysqli_query($conn, $sql);
$property = mysqli_fetch_assoc($result);

if (!$property) {
    echo "Property not found.";
    exit;
}

$sql_amenities = "SELECT a.* FROM amenities a
                  INNER JOIN property_amenities pa ON a.id = pa.amenity_id
                  WHERE pa.property_id = '$property_id'";
$result_amenities = mysqli_query($conn, $sql_amenities);
$amenities = mysqli_fetch_all($result_amenities, MYSQLI_ASSOC);

$amenities_by_type = [];
foreach ($amenities as $amenity) {
    $amenities_by_type[$amenity['type']][] = $amenity;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $property['name']; ?> | PG Life</title>
    <?php include "includes/head_links.php"; ?>
    <link href="css/property_detail.css" rel="stylesheet" />
</head>
<body>
    <?php include "includes/header.php"; ?>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb py-2">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item"><a href="property_list.php?city=Mumbai">Properties</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo $property['name']; ?></li>
        </ol>
    </nav>

    <div id="property-images" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <?php
            $property_images = glob("img/properties/" . $property['id'] . "/*.jpg");
            if(count($property_images) == 0) {
                 echo '<div class="carousel-item active"><img class="d-block w-100" src="img/properties/1/1d4f0757fdb86d5f.jpg" alt="slide"></div>';
            }
            foreach ($property_images as $index => $image) {
            ?>
                <div class="carousel-item <?php echo $index == 0 ? 'active' : ''; ?>">
                    <img class="d-block w-100" src="<?php echo $image; ?>" alt="slide">
                </div>
            <?php
            }
            ?>
        </div>
        <a class="carousel-control-prev" href="#property-images" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#property-images" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <div class="property-summary page-container">
        <div class="row no-gutters justify-content-between">
            <div class="star-container" title="<?php echo $property['rating_clean']; ?>">
                <?php
                $rating = $property['rating_clean'];
                for ($i = 0; $i < 5; $i++) {
                    if ($rating >= $i + 0.8) {
                        echo '<i class="fas fa-star"></i>';
                    } elseif ($rating >= $i + 0.3) {
                        echo '<i class="fas fa-star-half-alt"></i>';
                    } else {
                        echo '<i class="far fa-star"></i>';
                    }
                }
                ?>
            </div>
            <div class="interested-container">
                <?php
                $interested_users_count = 0;
                $is_interested = false;

                if($user_id) {
                    $sql_check = "SELECT * FROM favourites WHERE property_id = '" . $property['id'] . "' AND user_id = '$user_id'";
                    $result_check = mysqli_query($conn, $sql_check);
                    if(mysqli_num_rows($result_check) > 0) {
                        $is_interested = true;
                    }
                }

                $sql_total = "SELECT COUNT(*) as total FROM favourites WHERE property_id = '" . $property['id'] . "'";
                $result_total = mysqli_query($conn, $sql_total);
                $row_total = mysqli_fetch_assoc($result_total);
                $interested_users_count = $row_total['total'];
                ?>
                
                <i class="is-interested-image-<?php echo $property['id']; ?> <?php echo $is_interested ? 'fas' : 'far'; ?> fa-heart" onclick="toggle_interest(<?php echo $property['id']; ?>)"></i>
                <div class="interested-text">
                    <span class="interested-user-count-<?php echo $property['id']; ?>"><?php echo $interested_users_count; ?></span> interested
                </div>
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
                <button onclick="book_property(<?php echo $property_id; ?>)" class="btn btn-primary">Book Now</button>
            </div>

            <script>
                function book_property(property_id) {
                    <?php if (!isset($_SESSION['user_id'])) { ?>
                        $('#login-modal').modal('show');
                    <?php } else { ?>
                        var XHR = new XMLHttpRequest();
                        var form_data = new FormData();
                        form_data.append("property_id", property_id);

                        XHR.addEventListener("load", function(event) {
                            try {
                                var response = JSON.parse(event.target.responseText);
                                if (response.success) {
                                    alert(response.message);
                                    window.location.href = "dashboard.php";
                                } else {
                                    alert(response.message);
                                }
                            } catch (e) {
                                alert("Error processing response");
                            }
                        });

                        XHR.addEventListener("error", function(event) {
                            alert("Something went wrong");
                        });

                        XHR.open("POST", "api/book_property.php");
                        XHR.send(form_data);
                    <?php } ?>
                }
            </script>
        </div>
    </div>

    <div class="property-amenities">
        <div class="page-container">
            <h1>Amenities</h1>
            <div class="row justify-content-between">
                <?php 
                foreach ($amenities_by_type as $type => $list) { 
                ?>
                    <div class="col-md-auto">
                        <h5><?php echo $type; ?></h5>
                        <?php foreach ($list as $a) { ?>
                            <div class="amenity-container">
                                <img src="img/amenities/<?php echo $a['icon']; ?>.svg">
                                <span><?php echo $a['name']; ?></span>
                            </div>
                        <?php } ?>
                    </div>
                <?php 
                } 
                ?>
            </div>
        </div>
    </div>

    <div class="property-about page-container">
        <h1>About the Property</h1>
        <p><?php echo $property['description']; ?></p>
    </div>

    <div class="property-rating page-container">
        <h1>Property Rating</h1>
        <div class="row align-items-center justify-content-between">
            <div class="col-md-6">
                <div class="rating-criteria row">
                    <div class="col-6">
                        <i class="rating-criteria-icon fas fa-broom"></i>
                        <span class="rating-criteria-text">Cleanliness</span>
                    </div>
                    <div class="rating-criteria-star-container col-6" title="<?php echo $property['rating_clean']; ?>">
                        <?php
                        $rating = $property['rating_clean'];
                        for ($i = 0; $i < 5; $i++) {
                            if ($rating >= $i + 0.8) { echo '<i class="fas fa-star"></i>'; }
                            elseif ($rating >= $i + 0.3) { echo '<i class="fas fa-star-half-alt"></i>'; }
                            else { echo '<i class="far fa-star"></i>'; }
                        }
                        ?>
                    </div>
                </div>

                <div class="rating-criteria row">
                    <div class="col-6">
                        <i class="rating-criteria-icon fas fa-utensils"></i>
                        <span class="rating-criteria-text">Food Quality</span>
                    </div>
                    <div class="rating-criteria-star-container col-6" title="<?php echo $property['rating_food']; ?>">
                        <?php
                        $rating = $property['rating_food'];
                        for ($i = 0; $i < 5; $i++) {
                            if ($rating >= $i + 0.8) { echo '<i class="fas fa-star"></i>'; }
                            elseif ($rating >= $i + 0.3) { echo '<i class="fas fa-star-half-alt"></i>'; }
                            else { echo '<i class="far fa-star"></i>'; }
                        }
                        ?>
                    </div>
                </div>

                <div class="rating-criteria row">
                    <div class="col-6">
                        <i class="rating-criteria-icon fa fa-lock"></i>
                        <span class="rating-criteria-text">Safety</span>
                    </div>
                    <div class="rating-criteria-star-container col-6" title="<?php echo $property['rating_safety']; ?>">
                         <?php
                        $rating = $property['rating_safety'];
                        for ($i = 0; $i < 5; $i++) {
                            if ($rating >= $i + 0.8) { echo '<i class="fas fa-star"></i>'; }
                            elseif ($rating >= $i + 0.3) { echo '<i class="fas fa-star-half-alt"></i>'; }
                            else { echo '<i class="far fa-star"></i>'; }
                        }
                        ?>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="rating-circle">
                    <?php 
                    $total_rating = ($property['rating_clean'] + $property['rating_food'] + $property['rating_safety']) / 3;
                    ?>
                    <div class="total-rating"><?php echo number_format($total_rating, 1); ?></div>
                    <div class="rating-circle-star-container">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include "includes/signup_modal.php"; ?>
    <?php include "includes/login_modal.php"; ?>
    <?php include "includes/footer.php"; ?>

    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/common.js"></script> 
</body>
</html>