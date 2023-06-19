<!DOCTYPE html>
<html lang="en">
<?php include "db_connect.php" ?>
<?php $selectedCity = $_GET['city'];

?>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Best PG's in
        <?php echo $selectedCity; ?> | PG Life
    </title>

    <link href="css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://use.fontawesome.com/releases/v5.11.2/css/all.css" rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap"
        rel="stylesheet" />
    <link href="css/common.css" rel="stylesheet" />
    <link href="css/property_list_.css" rel="stylesheet" />
</head>

<body>
    <?php include "./common pages/header.php" ?>
    <div id="loading">
    </div>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb py-2">
            <li class="breadcrumb-item">
                <a href="index.php
">Home</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                <?php echo $selectedCity; ?>
            </li>
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
        $cityQuery = $conn->query("SELECT * FROM CITIES WHERE NAME = '$selectedCity';");
        if ($cityQuery) {
            while ($row = mysqli_fetch_assoc($cityQuery)) {
                $cityId = $row['ID'];
            }
        }
        $propertyListQuery = $conn->query("SELECT * FROM PROPERTIES WHERE CITY_ID = '$cityId';");
        while ($row = mysqli_fetch_assoc($propertyListQuery)):
            $propertyId = $row['ID'];
            ?>

            <div class="property-card row">
                <div class="image-container col-md-4">
                    <img src="./img/properties<?php
                    $imageQuery = $conn->query("SELECT IMAGES FROM PROPERTIES WHERE ID = '$propertyId';");
                    ($r = mysqli_fetch_assoc($imageQuery));
                    $propertyImage = explode("-", $r['IMAGES']);
                    echo $propertyImage[0] ?>">
                </div>

                <div class="content-container col-md-8">
                    <div class="row no-gutters justify-content-between">

                        <div class="star-container" title="4.5">
                            <?php
                            $avgRating = (floatval($row['RATING_CLEAN']) + floatval($row['RATING_FOOD']) + floatval($row['RATING_SAFETY'])) / 3;
                            $avgRating = sprintf("%.1f", $avgRating);
                            if (strpos($avgRating, '.0') !== false) {
                                for ($i = 1; $i <= intval($avgRating); $i++) {
                                    echo ' <i class="fas fa-star"></i> ';

                                }
                                for ($j = 1; $j <= 5 - intval($avgRating); $j++) {
                                    echo ' <i class="far fa-star"></i> ';
                                }
                            } else {
                                for ($i = 1; $i <= intval($avgRating); $i++) {
                                    echo ' <i class="fas fa-star"></i> ';

                                }
                                echo ' <i class="fas fa-star-half-alt"></i> ';
                                for ($j = 2; $j <= 5 - intval($avgRating); $j++) {
                                    echo ' <i class="far fa-star"></i> ';
                                }
                            }
                            ?>
                        </div>
                        <div class="interested-container">
                            <button href="#" data-toggle="modal" data-target="#login-modal">
                                <i class="far fa-heart"></i>
                                <div class="interested-text">3 interested</div>
                            </button>
                        </div>
                    </div>
                    <div class="detail-container">
                        <div class="property-name">
                            <?php echo $row['NAME']; ?>
                        </div>
                        <div class="property-address">
                            <?php echo $row['ADDRESS']; ?>
                        </div>
                        <div class="property-gender">
                            <?php
                            if ($row['GENDER'] == 'female') {
                                echo ' <img src="./img/male.png" />';
                            } elseif ($row['GENDER'] == 'male') {
                                echo ' <img src="./img/female.png" />';
                            } else {
                                echo '<img src="./img/male.png" />|<img src="./img/female.png" />';
                            }
                            ?>
                        </div>
                    </div>
                    <div class="row no-gutters">
                        <div class="rent-container col-6">
                            <div class="rent">Rs.
                                <?php echo $row['RENT']; ?>/-
                            </div>
                            <div class="rent-unit">per month</div>
                        </div>
                        <div class="button-container col-6">
                            <a href="property_detail.php?city=<?php echo $selectedCity ?>&propertyid=<?php echo $row['ID']; ?>
        " class="btn btn-primary">View</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

    <?php include "./common pages/footer.php" ?>

    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>

</html>