<!DOCTYPE html>
<html lang="en">
<?php
include "db_connect.php";
$selectedCity = $_GET['city'];
$filterGender = $_GET['gender'] ?? null;
$sortType = $_GET['sort'] ?? null;
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
    <link href="css/common_.css" rel="stylesheet" />
    <link href="css/property_list1.css" rel="stylesheet" />
</head>

<body>
    <?php include "./common pages/header.php" ?>
    <div id="loading">
    </div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb py-2">
            <li class="breadcrumb-item">
                <a href="index.php">Home</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                <?php echo $selectedCity; ?>
            </li>
        </ol>
    </nav>

    <div class="page-container">
        <?php include "./common pages/filter.php"; ?>
        <?php
        $cityQuery = $conn->query("SELECT * FROM CITIES WHERE NAME = '$selectedCity';");
        $cityId = mysqli_fetch_assoc($cityQuery)['ID'] ?? null;
        
        $sortClause = isset($_GET['sort']) ? " ORDER BY RENT $sortType" : "";
        $genderClause = isset($_GET['gender']) ? " AND GENDER = '$filterGender'" : "";
        $propertyListQuery = $conn->query("SELECT * FROM PROPERTIES WHERE CITY_ID = '$cityId' $genderClause $sortClause;");
        
        if (mysqli_num_rows($propertyListQuery) == 0) { echo 'No Search Results'; }
            
        while ($row = mysqli_fetch_assoc($propertyListQuery)):
            $propertyId = $row['ID'];
            $propertyName = $row['NAME'];
            $propertyAddress = $row['ADDRESS'];
            $propertyDescription = $row['DESCRIPTION'];
            $propertyForGender = $row['GENDER'];
            $propertyRent = $row['RENT'];
            $propertyRatingClean = $row['RATING_CLEAN'];
            $propertyRatingFood = $row['RATING_FOOD'];
            $propertyRatingSafety = $row['RATING_SAFETY'];
            $propertyRatingOverall = (floatval($row['RATING_CLEAN']) + floatval($row['RATING_FOOD']) + floatval($row['RATING_SAFETY'])) / 3;
            $propertyImages = $row['IMAGES'];
            ?>
            <div class="property-card row">
                <div class="image-container col-md-4">
                    <img src="./img/properties<?php
                    $imageQuery = $conn->query("SELECT IMAGES FROM PROPERTIES WHERE ID = '$propertyId';");
                    ($r = mysqli_fetch_assoc($imageQuery));
                    $propertyImage = explode("-", $propertyImages);
                    echo $propertyImage[0]; ?>">
                </div>

                <div class="content-container col-md-8">
                    <div class="row no-gutters justify-content-between">
                        <div class="star-container" title="4.5">
                            <?php
                            $avgRating = sprintf("%.1f", $propertyRatingOverall);
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
                            <?php
                            if (!isset($_SESSION["user_id"])) {
                                echo '<i class="interested-image far fa-heart"  id="interested-btn" data-toggle="modal" data-target="#login-modal" ></i>';
                            } else {
                                $user_id = $_SESSION["user_id"];
                                $isLiked_result = $conn->query("SELECT * FROM interested_users_properties WHERE USER_ID = $user_id AND PROPERTY_ID = $propertyId");
                                if (isset($_SESSION["user_id"]) && mysqli_num_rows($isLiked_result) == 1) {
                                    echo "<i class='is-interested-image fas fa-heart' propertyid = $propertyId ></i>";
                                } else {
                                    echo "<i class='is-interested-image far fa-heart' propertyid = $propertyId ></i>";
                                }
                            }
                            ?>
                            <div class="interested-text">
                                <?php
                                $likeCountQuery = $conn->query("SELECT * FROM interested_users_properties WHERE PROPERTY_ID = '$propertyId';");
                                if ($likeCountQuery) {
                                    $interestedCount = mysqli_num_rows($likeCountQuery);
                                }
                                echo "<span class='interested-user-count' propertyid='$propertyId'>" . $interestedCount . "</span> interested";
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="detail-container">
                        <div class="property-name">
                            <?php echo $propertyName; ?>
                        </div>
                        <div class="property-address">
                            <?php echo $propertyAddress; ?>
                        </div>
                        <div class="property-gender">
                            <?php
                            if ($propertyForGender == 'female') {
                                echo ' <img src="./img/female.png" />';
                            } elseif ($propertyForGender == 'male') {
                                echo ' <img src="./img/male.png" />';
                            } else {
                                echo '<img src="./img/male.png" />|<img src="./img/female.png" />';
                            }
                            ?>
                        </div>
                    </div>
                    <div class="row no-gutters">
                        <div class="rent-container col-6">
                            <div class="rent">Rs.
                                <?php echo $propertyRent; ?>/-
                            </div>
                            <div class="rent-unit">per month</div>
                        </div>
                        <div class="button-container col-6">
                            <a href="property_detail.php?city=<?php echo $selectedCity ?>&propertyid=<?php echo $row['ID']; ?>"
                                class="btn btn-primary">View</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

    <?php include "./common pages/footer.php" ?>

    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.is-interested-image').click(function (e) {
                e.preventDefault();
                propertyid = $(this).attr('propertyid');
                likedata = {
                    'propertyid': propertyid
                }
                console.log(propertyid)
                $.ajax({
                    type: 'POST',
                    url: '../PGLife/common pages/heart.php',
                    data: likedata,
                    success: function (response) {
                        var is_interested_image = $('.is-interested-image[propertyid="' + propertyid + '"]');
                        var interested_user_count = $('.interested-user-count[propertyid="' + propertyid + '"]');
                        if (response == 'Liked') {
                            is_interested_image.addClass("fas").removeClass("far");
                            interested_user_count.html(parseFloat(interested_user_count.html()) + 1);
                        } else {
                            is_interested_image.addClass("far").removeClass("fas");
                            interested_user_count.html(parseFloat(interested_user_count.html()) - 1);
                        }
                    }
                })
            })

    })
    </script>
</body>

</html>