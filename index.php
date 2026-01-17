<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome | PG Life</title>

    <?php include "includes/head_links.php"; ?>
</head>
<body>
    <?php
        include "includes/header.php";       
        include "includes/signup_modal.php"; 
        include "includes/login_modal.php";  
    ?>

    <div id="loading"></div>

    <div class="banner-container">
        <h2 class="white pb-3">Happiness per Square Foot</h2>

        <form id="search-form" class="city-search" method="get" action="property_list.php">
            <input type="text" name="city" class="form-control input-city" placeholder="Enter your city to search for PGs" required>
            <div class="input-group-append">
                <button type="submit" class="btn btn-secondary">
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </form>
    </div>

    <div class="page-container">
        <h1 class="city-heading">Major Cities</h1>
        <div class="row">
            <div class="city-card-container col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a href="property_list.php?city=Delhi">
                    <div class="city-card rounded-circle">
                        <img src="img/delhi.png" class="city-img"/>
                    </div>
                </a>
            </div>

            <div class="city-card-container col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a href="property_list.php?city=Mumbai">
                    <div class="city-card rounded-circle">
                        <img src="img/mumbai.png" class="city-img"/>
                    </div>
                </a>
            </div>

            <div class="city-card-container col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a href="property_list.php?city=Bangalore">
                    <div class="city-card rounded-circle">
                        <img src="img/bangalore.png" class="city-img"/>
                    </div>
                </a>
            </div>

            <div class="city-card-container col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a href="property_list.php?city=Hyderabad">
                    <div class="city-card rounded-circle">
                        <img src="img/hyderabad.png" class="city-img"/>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div class="footer">
        
        <div class="page-container footer-container">
            <div class="footer-cities">
                <div class="footer-city">
                    <a href="property_list.php?city=Delhi">PG in Delhi</a>
                </div>
                <div class="footer-city">
                    <a href="property_list.php?city=Mumbai">PG in Mumbai</a>
                </div>
                <div class="footer-city">
                    <a href="property_list.php?city=Bangalore">PG in Bangalore</a>
                </div>
                <div class="footer-city">
                    <a href="property_list.php?city=Hyderabad">PG in Hyderabad</a>
                </div>
            </div>
            <div class="footer-copyright">© 2020 Copyright PG Life</div>
        </div>
    </div>

    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/common.js"></script> 
</body>
</html>
