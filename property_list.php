<?php
session_start();
require "includes/database_connect.php";

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : NULL;
$city_name = $_GET["city"];

if (!$city_name) {
    echo "No city specified!";
    exit;
}

$sql = "SELECT p.*, c.name as city_name 
        FROM properties p
        INNER JOIN cities c ON p.city_id = c.id
        WHERE c.name = '$city_name'";

$result = mysqli_query($conn, $sql);
if (!$result) {
    echo "Something went wrong!";
    return;
}
$properties = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Best PG's in <?php echo $city_name ?> | PG Life</title>
    <?php include "includes/head_links.php"; ?>
    <link href="css/property_list.css" rel="stylesheet" />
</head>
<body>
    <?php include "includes/header.php"; ?>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb py-2">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo $city_name; ?></li>
        </ol>
    </nav>

    <div class="page-container">
        <div class="filter-bar row justify-content-around">
            <div class="col-auto" data-toggle="modal" data-target="#filter-modal">
                <img src="img/filter.png" alt="filter" />
                <span>Filter</span>
            </div>
            <div class="col-auto">
                <img src="img/desc.png" alt="sort-desc" />
                <span>Highest rent first</span>
            </div>
            <div class="col-auto">
                <img src="img/asc.png" alt="sort-asc" />
                <span>Lowest rent first</span>
            </div>
        </div>

        <?php
        if (count($properties) == 0) {
        ?>
            <div class="no-property-container">
                <p>No PGs found in <?php echo $city_name; ?>.</p>
            </div>
        <?php
        } else {
            foreach ($properties as $property) {
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
                                <a href="property_detail.php?id=<?php echo $property['id']; ?>" class="btn btn-primary">View</a>
                            </div>
                        </div>
                    </div>
                </div>
        <?php
            }
        }
        ?>
    </div>

    <?php include "includes/signup_modal.php"; ?>
    <?php include "includes/login_modal.php"; ?>
    <?php include "includes/footer.php"; ?>

    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/common.js"></script> 
</body>
</html>