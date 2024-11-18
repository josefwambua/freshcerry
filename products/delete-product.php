<?php require '../includes/header.php'; ?>
<?php require '../config/config.php'; ?>

<?php
// Check if the request is POST and has required data
if (isset($_POST['delete']) && isset($_POST['id'])) {
    $id = $_POST['id'];

    try {
        // Prepare the DELETE query using parameterized query to prevent SQL injection
        $delete = $conn->prepare("DELETE FROM cart WHERE id = :id");

        // Bind the 'id' parameter
        $delete->bindParam(':id', $id, PDO::PARAM_INT);

        // Execute the query
        $delete->execute();

        // Check if the delete query affected any rows
        if ($delete->rowCount() > 0) {
            echo "success"; // Return success if at least one row was deleted
        } else {
            echo "No such product found."; // Handle case where no rows were deleted
        }

    } catch (PDOException $e) {
        // Handle any errors
        echo "Error: " . $e->getMessage();
    }
} else {
    // If not a valid request or missing ID
    echo "Invalid request or missing ID";
}
?>
