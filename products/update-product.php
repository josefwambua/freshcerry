<?php require '../includes/header.php' ?>
<?php require '../config/config.php' ?>
 
<?php
// Check if the request is POST and has required data
if(isset($_POST['update'])) {
    $id = $_POST['id'];
    $pro_qty = $_POST['pro_qty'];
    $subtotal = $_POST['subtotal'];

    try {
        // Use prepared statement to prevent SQL injection
        $update = $conn->prepare("UPDATE cart SET pro_qty = :pro_qty, pro_subtotal = :subtotal WHERE id = :id");
        
        // Bind parameters
        $update->bindParam(':pro_qty', $pro_qty, PDO::PARAM_INT);
        $update->bindParam(':subtotal', $subtotal, PDO::PARAM_STR);
        $update->bindParam(':id', $id, PDO::PARAM_INT);
        
        // Execute the query
        $update->execute();
        
        // Send success response
        echo "success";
        
    } catch(PDOException $e) {
        // Handle errors
        echo "Error: " . $e->getMessage();
    }
} else {
    // If not a valid request
    echo "Invalid request";
}
?>