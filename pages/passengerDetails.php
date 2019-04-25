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
    <title>Select Passenger Details</title>



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

            $dbh = new PDO($dsn);
            if($_POST['train_id']){
                $_SESSION['train_id']=$_POST['train_id'];
                $stmt = $dbh->prepare("SELECT Ticket_number, Type, Berth, Availability, Price FROM Ticket WHERE Train=:t_id AND Availability=TRUE");
                $stmt->bindParam(':t_id', $_SESSION['train_id']);
                $stmt->execute();
                $result = $stmt->fetchAll();
            }else{
                header("Location: ../pages/viewTrains.php");
                die();
            }
        ?>
        <?php if($result): ?>
            <h1>Available Tickets for Train <?php echo $_POST['train_id']; ?></h1>
            <table id="Ticket" class="table" border = "3" frame = "all" rule = "groups">
                <thead>
                    <tr>
                        <th>Ticket Number</th>
                        <th>Type</th>
                        <th>Berth</th>
                        <th>Availability</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($result as $key=>$ticket) :?>
                        <tr>
                            <td><?php echo $ticket['ticket_number'] ?></td>
                            <td><?php echo $ticket['type'] ?></td>
                            <td><?php echo $ticket['berth'] ?></td>
                            <td><?php if($ticket['availability']){echo "Available";} else{echo "Not Available";} ?></td>
                            <td><?php echo $ticket['price'] ?></td>
                        </tr>
                    <?php endforeach;?>
                </tbody>
            </table><br><br>
            <h3>Enter Passenger Details</h3>
            <form action = "../server/addPassenger.php" method="POST">
                Enter Ticket Number<br>
                <input type = "number" name = "ticket_number" required><br><br>
                Enter Passenger Name<br>
                <input type = "text" name = "pass_name" required><br><br>
                Enter Passenger Age<br>
                <input type = "number" name = "pass_age" required><br><br>
                Enter Passenger Gender<br>
                <select name='gender'> 
                    <option value="M" default>Male</option>
                    <option value="F">Female</option>
                </select><br><br>
                <input type = "submit" value="Book Ticket">
            </form><br>
        <?php else: ?>
            <h1>No Tickets available</h1>
        <?php endif ?>
        <a href="../pages/viewBookings.php"><button>View Bookings</button></a><br><br>
        <a href="../server/logout.php"><button>Logout</button></a>
    </body>
</html>
