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
    <link href="./css/common_.css" type="text/css" rel="stylesheet" />

    <link href="./css/home.css" type="text/css" rel="stylesheet" />
</head>

<!-- -------------------------------------------------------------Header Content(Not Logged In)------------------------------------------ -->
<?php session_start(); ?>
<div class="header sticky-top">
    <nav class="navbar navbar-expand-md navbar-light">
        <a class="navbar-brand" href="./index.php">
            <img src="./img/logo.png" />
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#my-navbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="my-navbar">
            <ul class="navbar-nav">
                <?php
                if (isset($_SESSION['user_id'])) {
                    echo '<li class="nav-item">
                    <b class="nav-link ">Hi, ' . $_SESSION['username'] . '</b>
                    </li>';
                    echo '<li class="nav-item ">
                    <a id="dashboard-btn" class="nav-link text-info" href="../../PGLife/dashboard.php"">
                        <i class="fas fa-user"></i><b>Dashboard</b>
                    </a>
                </li>';
                } else {
                    echo '<li class="nav-item">
                    <a class="nav-link" href="#" data-toggle="modal" data-target="#signup-modal">
                        <i class="fas fa-user"></i><b>Signup</b>
                    </a>
                </li>';
                }

                ?>
                <div class="nav-vl"></div>
                <?php
                if (isset($_SESSION['user_id'])) {
                    echo '
                    <li class="nav-item">
                        <a id="logout-btn" class="nav-link text-danger" href="../../PGLife/common pages/logout.php">
                            <i class="fas fa-sign-in-alt"></i><b>Logout</b>
                        </a>
                    </li>';
                } else {
                    echo
                        '<li class="nav-item">
                    <a class="nav-link" href="#" data-toggle="modal" data-target="#login-modal">
                        <i class="fas fa-sign-in-alt"></i><b>Login</b>
                    </a>
                </li>';
                }
                ?>
            </ul>
        </div>
    </nav>
</div>






<!-- -------------------------------------------------------Signup Modal---------------------------------------------- -->

<div class="modal fade" id="signup-modal" tabindex="-1" role="dialog" aria-labelledby="signup-heading"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="signup-heading">Signup with PGLife</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="signup-form" class="form" role="form" method="POST">
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-user"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control" name="full_name" placeholder="Full Name" maxlength="30"
                            required>
                    </div>

                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-phone-alt"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control" name="phone" placeholder="Phone Number" maxlength="10"
                            minlength="10" required>
                    </div>

                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-envelope"></i>
                            </span>
                        </div>
                        <input type="email" class="form-control" name="email" placeholder="Email" required>
                    </div>

                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-lock"></i>
                            </span>
                        </div>
                        <input type="password" class="form-control" name="password" placeholder="Password" minlength="6"
                            required>
                    </div>

                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-university"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control" name="college_name" placeholder="College Name"
                            maxlength="150" required>
                    </div>

                    <div class="form-group">
                        <span>I'm a</span>
                        <input type="radio" class="ml-3" id="gender-male" name="gender" value="male" /> Male
                        <label for="gender-male">
                        </label>
                        <input type="radio" class="ml-3" id="gender-female" name="gender" value="female" />
                        <label for="gender-female">
                            Female
                        </label>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-block btn-primary">Create Account</button>
                    </div>
                </form>
            </div>
            <div id="signup-result">
            </div>
            <div class="modal-footer">
                <span>Already have an account?
                    <a href="#" data-dismiss="modal" data-toggle="modal" data-target="#login-modal">Login</a>
                </span>
            </div>
        </div>
    </div>
</div>

<!-- -----------------------------------------------Login Modal---------------------------------------------- -->

<div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="login-heading" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="login-heading">Login with PGLife</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form id="login-form" class="form" role="form" method="POST">
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-user"></i>
                            </span>
                        </div>
                        <input type="email" class="form-control" name="email" placeholder="Email" required>
                    </div>

                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-lock"></i>
                            </span>
                        </div>
                        <input type="password" class="form-control" name="password" placeholder="Password" minlength="6"
                            required>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-block btn-primary">Login</button>
                    </div>
                </form>
            </div>
            <div id="login-result"></div>
            <div class="modal-footer">
                <span>
                    <a href="#" data-dismiss="modal" data-toggle="modal" data-target="#signup-modal">Click here</a>
                    to register a new account
                </span>
            </div>
        </div>
    </div>
</div>

<!--         -----------------------------------------Loader------------------------------------------------------------       -->
<div id="loading">
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('#signup-form').submit(function (e) {
            $('#loading').css({ 'display': 'block' })
            e.preventDefault(); // Prevent the form from submitting normally

            // Perform an AJAX request to the signup_submit.php file
            $.ajax({
                type: 'POST',
                url: '../../PGLife/common pages/signup_submit.php',
                data: $(this).serialize(),// Serialize the form data
                success: function (response) {
                    // Display the signup result in the signup-result container
                    if (response == 'Sign up Complete!') {
                        $('#signup-result').html(response).addClass('success').removeClass('failure');
                    } else {
                        $('#signup-result').html(response).addClass('failure').removeClass('success');
                    }
                },
                error: function () {
                    // Handle the AJAX request error
                    $('#signup-result').html('<div class="alert alert-danger">Something went wrong.</div>');
                }
            });
            $('#loading').css({ 'display': 'none' })
        });

        $('#login-form').submit(function (event) {
            $('#loading').css({ 'display': 'block' })
            event.preventDefault();

            $.ajax({
                type: 'POST',
                url: '../../PGLife/common pages/login_submit.php',
                data: $(this).serialize(),
                success: function (response) {
                    if (response == 'Login Successful!') {
                        window.location.href = window.location.href;
                    } else {
                        $("#login-result").html(response).addClass('failure');
                    }
                },
                error: function () {
                    // Handle the AJAX request error
                    $('#signup-result').html('<div class="alert alert-danger">Something went wrong.</div>');

                }
            })

        });
        $('#logout-btn').click(function (e) {
            $('#loading').css({ 'display': 'block' })
            e.preventDefault();

            $.ajax({
                type: 'POST',
                url: '../../PGLife/common pages/logout.php',
                data: $(this).serialize(),
                success: function (response) {
                    window.location.href = '../../PGLife/index.php';
                }
            })
        });
    });
</script>