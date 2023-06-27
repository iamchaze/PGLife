<!DOCTYPE html>
<html lang="en">
<?php
include "db_connect.php";
if (isset($_GET['city'])) {
    $selectedCity = $_GET['city'];
}
if (isset($_GET['search-query'])) {
    $searchQuery = $_GET['search-query'];
}
?>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Best PG's in
        <?php
        if (isset($_GET['city'])) {
            echo $selectedCity;
        }
        ?> | PG Life
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
                <?php if (isset($_GET['city'])) {
                    echo $selectedCity; 
                } else {
                    echo 'Search Results for "'.$searchQuery.'"';
                } ?>
            </li>
        </ol>
    </nav>

    <div class="page-container">
        <?php include "./common pages/filter.php"; ?>
        <?php
        if (isset($_GET['city'])){
            $cityQuery = $conn->query("SELECT * FROM CITIES WHERE NAME = '$selectedCity';");
            $cityId = mysqli_fetch_assoc($cityQuery)['ID'] ?? null;
        }
        ?>
        <?php include "./property_cards.php"; ?>
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