<?php require '../includes/header.php'; ?>
<?php require '../config/config.php'; ?>

<?php 
$products = $conn->query("SELECT * FROM cart WHERE user_id='$_SESSION[user_id]'");
$products->execute();
$allProducts = $products->fetchAll(PDO::FETCH_OBJ);

// Calculate the total cart amount
$total = 0;
foreach ($allProducts as $product) {
    $total += $product->pro_price * $product->pro_qty;
}

if(isset($_POST["submit"])) { 
    $inp_price = filter_input(INPUT_POST, "inp_price", FILTER_SANITIZE_NUMBER_FLOAT);
    
    if ($inp_price !== false) {
        $_SESSION['price'] = $inp_price;
        
        // Close the session to ensure changes are saved
        session_write_close();
        
        // echo "<script>window.location.href='" . APPURL . "/products/checkout.php'; </script>";
        echo "<script>window.location.href='".APPURL."/products/checkout.php';</script>";
    } else {
        // Handle invalid input
        echo "<script>alert('Invalid input for price');</script>";
    }
}     
?>

<div id="page-content" class="page-content">
    <div class="banner">
        <div class="jumbotron jumbotron-bg text-center rounded-0" style="background-image: url('<?php echo APPURL; ?>/assets/img/bg-header.jpg');">
            <div class="container">
                <h1 class="pt-5">Your Cart</h1>
                <p class="lead">Save time and leave the groceries to us.</p>
            </div>
        </div>
    </div>

    <section id="cart">
        <div class="container"> 
            <div class="row">
                <div class="col-md-12"> 
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th width="10%"></th>
                                    <th>Products</th>
                                    <th>Price</th>
                                    <th width="15%">Quantity</th>
                                    <th width="15%">Update</th>
                                    <th>Subtotal</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($allProducts) > 0) : ?>
                                    <?php foreach ($allProducts as $product) : ?>
                                        <tr>
                                            <td>
                                                <img src="<?php echo APPURL; ?>/assets/img/<?php echo $product->pro_image; ?>" width="60">
                                            </td>
                                            <td> 
                                                <?php echo $product->pro_title; ?><br>
                                                <small>1000g</small>
                                            </td>
                                            <td class="pro_price">
                                                <?php echo $product->pro_price; ?>
                                            </td>
                                            <td>
                                                <input class="pro_qty form-control" type="number" min="1" value="<?php echo $product->pro_qty; ?>" name="vertical-spin">
                                            </td>
                                            <td>
                                                <button value="<?php echo $product->id; ?>" class="btn-update btn btn-primary update-btn">UPDATE</button>
                                            </td>
                                            <td class="subtotal">
                                                <?php echo $product->pro_price * $product->pro_qty; ?>
                                            </td>
                                            <td>
                                                <button value="<?php echo $product->id; ?>" class="btn-delete btn btn-primary">Delete</button>
                                            </td>
                                        </tr>  
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <div class='alert alert-success bg-success text-white text-center'>
                                        No products in cart
                                    </div>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col">
                    <a href="<?php echo APPURL; ?>/shop.php" class="btn btn-default">Continue Shopping</a>
                </div>

                <div class="col text-right">

                    <h6 class="mt-3">Total: <span id="total-amount"><?php echo number_format($total, 2); ?></span></h6>
                    <form action="POST" class="cart.php">
                    <input class=" mb-3 inp_price form-control" type="text" value="" name="inp_price">                     
                    <button type="submit" name="submit" class="btn btn-lg btn-primary">Checkout <i class="fa fa-long-arrow-right"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<?php require '../includes/footer.php'; ?>

<script>
$(document).ready(function() {
    // Event listener for when quantity is changed
    $(".pro_qty").on("change keyup", function() {
        var $el = $(this).closest('tr');
        var pro_qty = parseFloat($(this).val()) || 0;
        var pro_price = parseFloat($el.find(".pro_price").text()) || 0;
        var subtotal = pro_qty * pro_price;

        // Update the subtotal display for the row
        $el.find(".subtotal").text(subtotal.toFixed(2));

        // Update the total sum
        $("#total-amount").text(calculateSum());
    });

    // Event listener for update button
    $(".btn-update").on('click', function(e) {
        var id = $(this).val();
        var $el = $(this).closest('tr');
        var pro_qty = parseFloat($el.find(".pro_qty").val()) || 0;
        var subtotal = parseFloat($el.find(".subtotal").text()) || 0;

        // Send updated data via AJAX to update the cart in the backend
        $.ajax({
            type: "POST",
            url: "update-product.php",
            data: {
                update: "update",
                id: id,
                pro_qty: pro_qty,
                subtotal: subtotal
            },
            success: function(response) {
                alert("Update Successful");
                location.reload();
            }
        });
    });

    // Event listener for delete button
    $(".btn-delete").on('click', function(e) {
        var id = $(this).val();

        // Send delete request via AJAX to remove product from the cart
        $.ajax({
            type: "POST", 
            url: "delete-product.php",
            data: {
                delete: "delete",
                id: id,
            },
            success: function(response) {
                alert("Product deleted successfully");
                location.reload();
            }
        });
    });

    // Function to calculate the total sum
    function calculateSum() {
        var sum = 0;
        $('.subtotal').each(function () {
            sum += parseFloat($(this).text());
        });
        return sum.toFixed(2);
    }

    // Initial calculation of total sum
    $("#total-amount").text(calculateSum());

    // Function to update inp_price input
    function updateTotalPrice() {
        var totalPrice = parseFloat($("#total-amount").text());
        $(".inp_price").val(totalPrice);
    }

    // Call this function whenever the cart changes
    updateTotalPrice();

    // Add event listener to inp_price input
    $(".inp_price").on("change", function() {
        var newTotal = parseFloat($(this).val()) || 0;
        $("#total-amount").text(newTotal.toFixed(2));
    });
});
</script>
