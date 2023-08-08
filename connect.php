<?php
    // Local Server information
    $server = "127.0.0.1";
    // $port = "3306";
    $username = "root";
    $password = "Brandy2253!";
    $db = "BionicBuys";

    try {
        $handle = new PDO("mysql:host=$server;dbname=$db", "$username", "$password");
        // error handling and reporting
        $handle->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        // there is a issue connecting to the database!
        $em = $e->getMessage();
        die("Oops, Something went wrong connecting to the database. $em");
    }
    // Check if connection was successful
?>