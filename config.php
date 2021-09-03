<?php
    $host = "localhost";
    $name = "root";
    $password = "";
    $database = "misc";
    $pdo = new PDO("mysql:host=".$host.";port=3306;dbname=".$database,$name,$password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
