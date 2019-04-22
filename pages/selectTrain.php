<?php
    session_start();
    if(!isset($_SESSION['name']) || !isset($_SESSION['email'])){
        header("Location: ../pages/login.html");
        die();
    }

    function getTrains() {
		$es = $_POST["destination"]; 
		$ss = $_POST["origin"]; 
		$sql = "SELECT Train_id, Train_name FROM Train WHERE End_station = $es AND Start_station=";
		// $sql = "SELECT train_id, train_name, Total_time FROM Train INNER JOIN Route ON Train.Route = Route.Route_number WHERE Train.Start_station=$ss AND Train.End_station=$es"
		$queryRecords = pg_query($this->conn, $sql) or die("error to fetch train data");
		$data = pg_fetch_all($queryRecords);
		echo $data;
		return $data;
	}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="generator" content="Jekyll v3.8.5">
    <title>Homepage</title>



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
        <h1>Select Date and Destination</h1>
        <form action = "../pages/viewTrains.php" method="POST">
            Enter Origin:<br>
            <input type = "text" name = "origin"><br><br>
            Enter Destination:<br>
            <input type = "text" name = "destination"><br><br>
            <input type = "submit" value="Enter trains">
        </form><br>
        <a href="../server/logout.php"><button>Logout</button></a>
    </body>
</html>
