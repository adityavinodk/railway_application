<?php
    require '../dbconfig.php';

    session_start();
    $dbh = new PDO($dsn);
    if($dbh){
        if($_POST){
            $email = $_POST["email"];
            $password = $_POST["password"];
            $name = $_POST["name"];
            $age = $_POST["age"];
            $data = [
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'age' => $age
            ];
            $stmt = $dbh->prepare("INSERT INTO person(user_name, age, email, password) VALUES (:name, :age, :email, :password)");
            if($stmt->execute($data)){
                $_SESSION['name'] = $name;
                $_SESSION['email'] = $email;
                header("Location: ../pages/home.php");
                die();
            }else{
                echo "Insert didn't work";
            }
        }
    }else{
        echo 'Connection not established, try again';
    }
?>