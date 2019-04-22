<?php
    require '../dbconfig.php';

    session_start();
    $dbh = new PDO($dsn);
    if($dbh){
        if($_POST){
            $name = $_POST["pass_name"];
            $ticket = $_POST["ticket_number"];
            $age = $_POST["pass_age"];
            $gender = $_POST["gender"];
            $data = [
                'name' => $name,
                'age' => $age,
                'gender' => $gender,
                'train' => $_SESSION['train_id'],
                'booked_by' => $_SESSION['user_id'],
                'ticket' => $ticket
            ];
            $stmt = $dbh->prepare("INSERT INTO passenger(name, age, gender, train, booked_by, ticket) VALUES (:name, :age, :gender, :train, :booked_by, :ticket)");
            if($stmt->execute($data)){
                $stmt2 = $dbh->prepare("UPDATE Ticket SET Availability=FALSE WHERE ticket_number=:ticket");
                $stmt2->bindParam(':ticket', $ticket);
                if($stmt2->execute()){
                    header("Location: ../pages/viewBookings.php");
                    die();
                }else{
                    echo "Update didn't work";
                }
            }else{
                echo "Insert didn't work";
            }
        }
    }else{
        echo 'Connection not established, try again';
    }
?>