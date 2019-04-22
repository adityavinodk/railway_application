<?php
    require '../dbconfig.php';

    session_start();
    $dbh = new PDO($dsn);
    if($dbh){
        if($_POST){
            $ticket = $_POST["ticket_number"];
            $stmt = $dbh->prepare("DELETE from Passenger WHERE Ticket=:ticket and Booked_by=:booked_by");
            $stmt->bindParam(':ticket', $ticket);
            $stmt->bindParam(':booked_by', $_SESSION['user_id']);
            if($stmt->execute()){
                $stmt2 = $dbh->prepare("UPDATE Ticket SET Availability=TRUE WHERE ticket_number=:ticket");
                $stmt2->bindParam(':ticket', $ticket);
                if($stmt2->execute()){
                    header("Location: ../pages/viewBookings.php");
                    die();
                }else{
                    echo "Update didn't work";
                }
            }else{
                echo "Delete didn't work";
            }
        }
    }else{
        echo 'Connection not established, try again';
    }
?>