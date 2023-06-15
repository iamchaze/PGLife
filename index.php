<!DOCTYPE html>
<html lang="en">
<?php include "./db_connect.php" ?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://use.fontawesome.com/releases/v5.11.2/css/all.css" rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap"
        rel="stylesheet" />
    <link href="./css/common.css" type="text/css" rel="stylesheet" />
    <link href="./css/property_detail.css" type="text/css" rel="stylesheet" />
    <link href="./css/index.css" type="text/css" rel="stylesheet" />
</head>

<body>
    <?php include "./common pages/header.php" ?>
    <div id="background">
        <div id="header-content">
            <h1>Happiness per Square Foot</h1>
            <div id="searchbar">
                <input id="search" name="city-search" type="text" placeholder="Enter your city to search for PGs">
                <button class="d-inline"> <i class="fa fa-search" aria-hidden="true"></i> </button>
            </div>
        </div>
    </div>
    <div id="major-cities">
        <?php
        $delhi = "SELECT LOGO_IMAGE FROM CITIES WHERE NAME = 'Delhi'";
        ?>
        <h1>Major Cities</h1>
            <a href="./property_list.php?city=Delhi">
                <button type="submit" id="delhi"> <img src="./img/delhi.png"> </button>
            </a>
            <a href="./property_list.php?city=Mumbai">
                <button type="submit" id="mumbai"> <img src="./img/mumbai.png"> </button>
            </a>
            <a href="./property_list.php?city=Bengaluru">
                <button type="submit" id="bengaluru"> <img src="./img/bangalore.png"> </button>
            </a>
            <a href="./property_list.php?city=Hyderabad">
                <button type="submit" id="hyderabad"> <img src="./img/hyderabad.png"> </button>
            </a>

    </div>
    <?php include "./common pages/footer.php" ?>
    <script type="text/javascript" src="./js/jquery.js"></script>
    <script type="text/javascript" src="./js/bootstrap.min.js"></script>
</body>

</html>