<!DOCTYPE html>
<html lang="en">
<?php include "db_connect.php"; ?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://use.fontawesome.com/releases/v5.11.2/css/all.css" rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap"
        rel="stylesheet" />
    <link href="css/common.css" rel="stylesheet" />
    <link href="css/property_detail.css" rel="stylesheet" />
    <link href="css/home.css" rel="stylesheet" />
    <link href="css/dashboard_.css" rel="stylesheet" />
    <link href="css/property_list.css" rel="stylesheet" />
</head>

<body>
    <?php include "./common pages/header.php"; ?>
    <?php $currentUser = $_SESSION['user_id'];
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../../index.php");
    }
    ?>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb py-2">
            <li class="breadcrumb-item">
                <a href="index.php">Home</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Dashboard
            </li>
        </ol>
    </nav>
    <div id="user-container">
        <?php
        $userDetalis = $conn->query("SELECT * FROM USERS WHERE ID = $currentUser");
        while ($row = mysqli_fetch_assoc($userDetalis)):
            $email = $row['EMAIL'];
            $fullName = $row['FULL_NAME'];
            $phone = $row['PHONE'];
            $gender = $row['GENDER'];
            $collegeName = $row['COLLEGE_NAME'];

            ?>
            <h1>Profile</h1>
            <div class="row profile-details">
                <div class="col-lg-6">
                    <div id="user-img">
                        <i class="fa fa-user" aria-hidden="true"></i>
                    </div>
                </div>
                <div class="col-lg-4 justify-content-between" id="user-info">
                    <div>
                        <p>
                            <?php echo $fullName . ' (' . $gender . ')'; ?>
                        </p>
                        <p>
                            <?php echo $email; ?>
                        </p>
                        <p>
                            <?php echo $phone; ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div id="about-img">
            <img src="./img/about.jpg" alt="">
        </div>
    <?php endwhile; ?>

    <div id="interested-properties">
        <h1>My Interested Properties</h1>
    </div>
    <div class="page-container">
        <?php include "./common pages/filter.php" ?>

        <?php include "./property_cards.php" ?>
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