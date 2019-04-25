<!-- Bootstrap core CSS -->
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="generator" content="Jekyll v3.8.5">
    <title>View Trains</title>



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
        <?php
            require '../dbconfig.php';
            
            session_start();
            if(!isset($_SESSION['name']) || !isset($_SESSION['user_id'])){
                header("Location: ../pages/login.html");
                die();
            }
            if(!isset($_POST['origin']) || !isset($_POST['destination'])){
                header("Location: selectTrain.php");
                die();
            }

            $dbh = new PDO($dsn);
            if($_POST['origin'] && $_POST['destination']){
                $es = $_POST["destination"]; 
                $ss = $_POST["origin"]; 
                $stmt = $dbh->prepare("SELECT station_id from Station WHERE Station_name=:ss");
                $stmt->bindParam(':ss', $ss);
                $stmt->execute();
                $result = $stmt->fetchAll();
                if($result){
                    foreach ($result as $key => $station) {
                        $origin = $station['station_id'];
                    }
                    $stmt2 = $dbh->prepare("SELECT station_id from Station WHERE Station_name=:es");
                    $stmt2->bindParam(':es', $es);
                    $stmt2->execute();
                    $result2 = $stmt2->fetchAll();
                    if($result2){
                        foreach ($result2 as $key => $station) {
                            $destination = $station['station_id'];
                        }
                        $stmt = $dbh->prepare("SELECT Train_id, Train_name FROM Train WHERE End_station = :es AND Start_station=:ss");
                        $stmt->bindParam(':es', $destination);
                        $stmt->bindParam(':ss', $origin);
                        $stmt->execute();
                        $result = $stmt->fetchAll();
                    }
                }

                
            }
        ?>
        <h2>Select your train from <?php echo $_POST['origin'] ?> to <?php echo $_POST['destination'] ?></h2>
        <?php if($result): ?>
            <table id="Train" class="table" border = "3" frame = "all" rule = "groups">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>`
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($result as $key=>$train) :?>
                        <tr>
                            <td><?php echo $train['train_id'] ?></td>
                            <td><?php echo $train['train_name'] ?></td>
                        </tr>
                    <?php endforeach;?>
                </tbody>
            </table><br>
            <form method="POST" action="../pages/passengerDetails.php">
                Book By Train ID - <input type="number" name="train_id"/><br><br>
                <input type = "submit" value="Book train">
            </form><br>
        <?php else: ?>
            <h2> No Trains Found </h2><br><br>
        <?php endif ?>
        <a href="../pages/viewBookings.php"><button>View Bookings</button></a><br><br>
        <a href="../server/logout.php"><button>Logout</button></a>

</body>
</html>
    