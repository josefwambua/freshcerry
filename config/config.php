<?php 

    if(!isset($_SERVER['HTTP_REFERER'])){
    //     // redirect to the cart

         header('location:127.0.0.1/freshcerry/index.php');
         exit;
    }

    try{
    // host 
    define("HOST", "localhost");

    // dbname
    define("DBNAME", "freshcerry");

    // user 
    define("USER", "root");

    // password
    define("PASS", "");


    $conn = new PDO("mysql:host=".HOST."; dbname=".DBNAME.";",USER,PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    }catch(Exception $e){
            echo $e->getMessage();
    }
