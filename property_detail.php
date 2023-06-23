<!DOCTYPE html>
<html lang="en">
<?php include "db_connect.php"; ?>
<?php $selectedCity = $_GET['city'];
$propertyId = $_GET['propertyid'];
$propertyDetails = $conn->query("SELECT * FROM PROPERTIES WHERE ID = '$propertyId';");
while ($row = mysqli_fetch_assoc($propertyDetails)):
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
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>
            <?php echo $propertyName; ?> | PG Life
        </title>

        <link href="css/bootstrap.min.css" rel="stylesheet" />
        <link href="https://use.fontawesome.com/releases/v5.11.2/css/all.css" rel="stylesheet" />
        <link
            href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap"
            rel="stylesheet" />
        <link href="css/common_.css" rel="stylesheet" />
        <link href="css/property_details.css" rel="stylesheet" />
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
                <li class="breadcrumb-item">
                    <a href="./property_list.php?city=<?php echo $selectedCity ?>">
                        <?php echo $selectedCity; ?>
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <?php echo $propertyName; ?>
                </li>
            </ol>
        </nav>
    <?php endwhile; ?>

    <div id="property-images" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#property-images" data-slide-to="0" class="active"></li>
            <li data-target="#property-images" data-slide-to="1" class=""></li>
            <li data-target="#property-images" data-slide-to="2" class=""></li>
        </ol>
        <div class="carousel-inner">
            <?php
            $imageQuery = $conn->query("SELECT IMAGES FROM PROPERTIES WHERE ID = '$propertyId';");
            while ($row = mysqli_fetch_assoc($imageQuery)) {
                $propertyImages = explode("-", $propertyImages);
                foreach ($propertyImages as $imageIndex => $imagePath) {
                    if ($imageIndex == 0) {
                        echo '<div class="carousel-item active">';
                    } else {
                        echo '<div class="carousel-item">';
                    }
                    echo '<img class="d-block w-100" src="img/properties' . $imagePath . '" alt="slide">';
                    echo '</div>';
                }
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
            <div class="star-container" title="4.8">
                <?php $selectedCity = $_GET['city'];
                $propertyId = $_GET['propertyid'];
                $propertyDetails = $conn->query("SELECT * FROM PROPERTIES WHERE ID = '$propertyId';");
                while ($row = mysqli_fetch_assoc($propertyDetails)):
                    ?>
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
                        echo '<span class="interested-user-count">' . $interestedCount . '</span> interested';
                        ?>
                    </div>
                </div>
            </div>
            <div class="detail-container">
                <div class="property-name">
                    <?php
                    echo $propertyName; ?>
                </div>
                <div class="property-address">
                    <?php echo $propertyAddress; ?>
                </div>
                <div class="property-gender">
                    <?php
                    $gender = $row['GENDER'];
                    $maleImage = '<img src="./img/male.png" />';
                    $femaleImage = '<img src="./img/female.png" />';

                    if ($gender == 'female') {
                        echo $maleImage;
                    } elseif ($gender == 'male') {
                        echo $femaleImage;
                    } else {
                        echo "$maleImage|$femaleImage";
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
                    <a href="#" class="btn btn-primary" <?php if (isset($_SESSION['user_id'])) {
                        echo '';
                    } else {
                        echo 'data-toggle="modal" data-target="#login-modal"';
                    } ?>>Book Now</a>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
    <div class="property-amenities">

        <div class="page-container">
            <h1>Amenities</h1>
            <div class="row justify-content-between">
                <?php
                $amenityTypes = ['Building', 'Common Area', 'Bedroom', 'Washroom'];

                foreach ($amenityTypes as $type) {
                    $amenityId = $conn->query("SELECT AMENITY_ID FROM PROPERTIES_AMENITIES WHERE PROPERTY_ID = '$propertyId';");

                    echo '<div class="col-md-auto">';
                    echo "<h5>$type</h5>";

                    while ($row = mysqli_fetch_assoc($amenityId)) {
                        $amenity = $conn->query("SELECT * FROM AMENITIES WHERE ID = '$row[AMENITY_ID]' AND TYPE = '$type'; ");
                        while ($r = mysqli_fetch_assoc($amenity)) {
                            echo '<div class="amenity-container">';
                            echo "<img src='img/amenities/{$r['ICON']}.svg'>";
                            echo "<span>{$r['NAME']}</span>";
                            echo '</div>';
                        }
                    }
                    echo '</div>';
                }
                ?>
            </div>
        </div>
        <div class="property-about page-container">
            <h1>About the Property</h1>
            <p>
                <?php
                $about = $conn->query("SELECT * FROM PROPERTIES WHERE ID = '$propertyId';");
                while ($row = mysqli_fetch_assoc($about)) {
                    echo $propertyDescription;
                }
                ?>
            </p>
        </div>
        <?php
        function printStars($rating)
        {
            if (strpos($rating, '.0') !== false) {
                for ($i = 1; $i <= intval($rating); $i++) {
                    echo ' <i class="fas fa-star"></i> ';
                }
                for ($j = 1; $j <= 5 - intval($rating); $j++) {
                    echo ' <i class="far fa-star"></i> ';
                }
            } else {
                for ($i = 1; $i <= intval($rating); $i++) {
                    echo ' <i class="fas fa-star"></i> ';
                }
                echo ' <i class="fas fa-star-half-alt"></i> ';
                for ($j = 2; $j <= 5 - intval($rating); $j++) {
                    echo ' <i class="far fa-star"></i> ';
                }
            }
        }
        ?>
        <div class="property-rating">
            <div class="page-container">
                <h1>Property Rating</h1>
                <div class="row align-items-center justify-content-between">
                    <div class="col-md-6">
                        <div class="rating-criteria row">
                            <div class="col-6">
                                <i class="rating-criteria-icon fas fa-broom"></i>
                                <span class="rating-criteria-text">Cleanliness</span>
                            </div>
                            <div class="rating-criteria-star-container col-6">
                                <?php
                                $ratingQuery = $conn->query("SELECT * FROM PROPERTIES WHERE ID = '$propertyId';");
                                while ($row = mysqli_fetch_assoc($ratingQuery)) {
                                    $rating = $propertyRatingClean;
                                    printStars($rating);
                                }
                                ?>
                            </div>
                        </div>

                        <div class="rating-criteria row">
                            <div class="col-6">
                                <i class="rating-criteria-icon fas fa-utensils"></i>
                                <span class="rating-criteria-text">Food Quality</span>
                            </div>
                            <div class="rating-criteria-star-container col-6" title="3.4">
                                <?php
                                $ratingQuery = $conn->query("SELECT * FROM PROPERTIES WHERE ID = '$propertyId';");
                                while ($row = mysqli_fetch_assoc($ratingQuery)) {
                                    $rating = $row['RATING_FOOD'];
                                    printStars($rating);
                                }
                                ?>
                            </div>
                        </div>

                        <div class="rating-criteria row">
                            <div class="col-6">
                                <i class="rating-criteria-icon fa fa-lock"></i>
                                <span class="rating-criteria-text">Safety</span>
                            </div>
                            <div class="rating-criteria-star-container col-6" title="4.8">
                                <?php
                                $ratingQuery = $conn->query("SELECT * FROM PROPERTIES WHERE ID = '$propertyId';");
                                while ($row = mysqli_fetch_assoc($ratingQuery)) {
                                    $rating = $row['RATING_SAFETY'];
                                    printStars($rating);
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="rating-circle">
                            <?php
                            $ratingQuery = $conn->query("SELECT * FROM PROPERTIES WHERE ID = '$propertyId';");
                            while ($row = mysqli_fetch_assoc($ratingQuery)) {
                                $avgRating = (floatval($row['RATING_CLEAN']) + floatval($row['RATING_FOOD']) + floatval($row['RATING_SAFETY'])) / 3;
                                $avgRating = sprintf("%.1f", $avgRating);
                            }
                            ?>
                            <div class="total-rating">
                                <?php echo $avgRating; ?>
                            </div>
                            <div class="rating-circle-star-container">
                                <?php printStars(($avgRating)); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="property-testimonials page-container">
            <h1>What people say</h1>
            <div class="testimonial-block">
                <div class="testimonial-image-container">
                    <img class="testimonial-img" src="img/man.png">
                </div>
                <div class="testimonial-text">
                    <i class="fa fa-quote-left" aria-hidden="true"></i>
                    <p>You just have to arrive at the place, it's fully furnished and stocked with all basic amenities
                        and
                        services and even your friends are welcome.</p>
                </div>
                <div class="testimonial-name">- Ashutosh Gowariker</div>
            </div>
            <div class="testimonial-block">
                <div class="testimonial-image-container">
                    <img class="testimonial-img" src="img/man.png">
                </div>
                <div class="testimonial-text">
                    <i class="fa fa-quote-left" aria-hidden="true"></i>
                    <p>You just have to arrive at the place, it's fully furnished and stocked with all basic amenities
                        and
                        services and even your friends are welcome.</p>
                </div>
                <div class="testimonial-name">- Karan Johar</div>
            </div>
        </div>
        <?php include "./common pages/footer.php" ?>
        <script type="text/javascript" src="js/jquery.js"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <script>
            $(document).ready(function () {
                $('.is-interested-image').click(function (e) {
                    e.preventDefault();
                    likedata = {
                        'propertyid': $('.is-interested-image').attr('propertyid')
                    }
                    $.ajax({
                        type: 'POST',
                        url: '../PGLife/common pages/heart.php',
                        data: likedata,
                        success: function (response) {
                            var is_interested_image = $(".is-interested-image");
                            var interested_user_count = $(".interested-user-count");
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