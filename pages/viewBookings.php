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
        <h1>View Tickets booked by <?php echo $_SESSION['name'] ?></h1>
        <?php
            require '../dbconfig.php';

            $dbh = new PDO($dsn);
            $stmt = $dbh->prepare("SELECT Ticket_number, Type, Berth, Price FROM Ticket WHERE Ticket_number IN (SELECT Ticket FROM Passenger WHERE Booked_by=:u_id)");
            $stmt->bindParam(':u_id', $_SESSION['user_id']);
            $stmt->execute();
            $result = $stmt->fetchAll();

            $stmt2 = $dbh->prepare("SELECT Ticket, Name, Age, Gender FROM Passenger WHERE Booked_by=:u_id");
            $stmt2->bindParam(':u_id', $_SESSION['user_id']);
            $stmt2->execute();
            $result2 = $stmt2->fetchAll();
        ?>
        <?php if($result): ?>
            <h2> Tickets Booked </h2>
            <table id="Ticket" class="table" border = "3" frame = "all" rule = "groups">
                <thead>
                    <tr>
                        <th>Ticket Number</th>
                        <th>Type</th>
                        <th>Berth</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($result as $key=>$ticket) :?>
                        <tr>
                            <td><?php echo $ticket['ticket_number'] ?></td>
                            <td><?php echo $ticket['type'] ?></td>
                            <td><?php echo $ticket['berth'] ?></td>
                            <td><?php echo $ticket['price'] ?></td>
                        </tr>
                    <?php endforeach;?>
                </tbody>
            </table><br>
            <h2> Passenger Details </h2>
            <table id="Passenger" class="table" border = "3" frame = "all" rule = "groups">
                <thead>
                    <tr>
                        <th>Ticket Number</th>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Gender</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($result2 as $key=>$passenger) :?>
                        <tr>
                            <td><?php echo $passenger['ticket'] ?></td>
                            <td><?php echo $passenger['name'] ?></td>
                            <td><?php echo $passenger['age'] ?></td>
                            <td><?php echo $passenger['gender'] ?></td>
                        </tr>
                    <?php endforeach;?>
                </tbody>
            </table><br>
            <h3>Delete Ticket</h3>
            <form method="POST" action="../server/deleteTicket.php">
                <input type="number" name="ticket_number" required><br><br>
                <input type = "submit" value="Delete Ticket">
            </form><br><br>
            <h3>Update Passenger Details</h3>
            <form method="POST" action="../server/updateTicket.php">
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
                <input type = "submit" value="Update Ticket">
            </form><br><br>
        <?php else: ?>
        <h2> No Tickets Booked </h2><br><br>
        <?php endif; ?>
        <h3>Book More Tickets</h3>
        <form method="POST" action="passengerDetails.php">
            <input type="hidden" name="train_id" value="<?php echo $_SESSION['train_id'] ?>">
            <input type = "submit" value="Book More Tickets">
        </form><br><br>
        <a href="../server/logout.php"><button>Logout</button></a>
    </body>
</html>
