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
            $stmt = $dbh->prepare("UPDATE passenger SET name=:name, age=:age, gender=:gender WHERE train=:train AND booked_by=:booked_by AND ticket=:ticket");
            if($stmt->execute($data)){
                header("Location: ../pages/viewBookings.php");
                die();
            }else{
                echo "Insert didn't work";
            }
        }
    }else{
        echo 'Connection not established, try again';
    }
?>