<?php require '../includes/header.php' ?>
<?php require '../config/config.php' ?>
 
<?php

// on clicking submit button

if(isset($_POST['update'])){

    $id = $_POST['id'];
    $pro_qty = $_POST['pro_qty'];
    $pro_subtotal = $_POST['pro_subtotal'];

    $update = $conn->prepare("UPDATE cart SET pro_qty = '$pro_qty', pro_subtotal = 'pro_subtotal' WHERE id='$id'");
    $update->execute();


}






















?>







<?php require "../includes/footer.php" ?>