<?php 

//     if(!isset($_SERVER['HTTP_REFERER'])){
//     //     // redirect to the cart

//          header('location:127.0.0.1/freshcerry/index.php');
//          exit;
//     }

    try{
    // host 
    if(!defined("HOST"))define("HOST", "localhost");

    // dbname
    if(!defined("DBNAME"))define("DBNAME", "freshcerry");

    // user 
    if(!defined("USER"))define("USER", "root");

    // password
    if(!defined("PASS"))define("PASS", "");


    $conn = new PDO("mysql:host=".HOST."; dbname=".DBNAME.";",USER,PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    }catch(Exception $e){
            echo $e->getMessage();
    }
