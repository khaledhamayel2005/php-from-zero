<?php 

    $username = 'root';
    $password = '';
    $dbname = 'login';
    $host='localhost';
    $dsn ="mysql:host=$host;dbname=$dbname;charset=utf8mb4";


    try{
        $pdo = new PDO($dsn,$username,$password);
        $pdo-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo-> setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    }catch(PDOException $e){
        die("Connection Faield". $e->getMessage());

    }

?>