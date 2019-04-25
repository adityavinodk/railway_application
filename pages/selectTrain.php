<?php
    session_start();
    if(!isset($_SESSION['name']) || !isset($_SESSION['user_id'])){
        header("Location: ../pages/login.html");
        die();
    }
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="generator" content="Jekyll v3.8.5">
    <title>Select Trains</title>



    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>



    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }
        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
        html,
        body {
            height: 100%;
        }
        body {
            align-items: center;
            background-color: #f5f5f5;
        }
    </style>
    </head>
    <body>
        <h1>Select Origin and Destination</h1>
        <form action = "../pages/viewTrains.php" method="POST">
            Enter Origin:<br>
            <input type = "text" name = "origin"><br><br>
            Enter Destination:<br>
            <input type = "text" name = "destination"><br><br>
            <input type = "submit" value="Enter trains">
        </form><br>
        <a href="../pages/viewBookings.php"><button>View Bookings</button></a><br><br>
        <a href="../server/logout.php"><button>Logout</button></a>
    </body>
</html>
