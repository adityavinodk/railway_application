<?php
    require '../dbconfig.php';

    session_start();
    $dbh = new PDO($dsn);
    if($dbh){
        echo "Connected to $db database successfully";
        if($_POST){
            $email = $_POST["email"];
            $password = $_POST["password"];
            $stmt = $dbh->prepare("SELECT * FROM person WHERE email=:email AND password=:password");
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
            $stmt->execute();
            if($row = $stmt->fetch()){
                $_SESSION['name'] = $row['user_name'];
                $_SESSION['email'] = $row['email'];
                header("Location: ../pages/home.php");
                die();
            }else{
                echo "No such user found";
            }
        }
    }else{
        echo 'Connection not established, try again';
    }
?>