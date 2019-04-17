<?php
    session_start();
    if(isset($_SESSION['name']) && isset($_SESSION['email'])){
        $name = $_SESSION['name'];
        print("Welcome $name\n");
    }else{
        header("Location: ../pages/login.html");
        die();
    }
?>
<a href="logout.php"><button>Logout</button></a>