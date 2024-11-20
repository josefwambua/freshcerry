<?php require '../includes/header.php'; ?>
<?php require '../config/config.php'; ?>

<?php 
$products = $conn->query("SELECT * FROM cart WHERE user_id='$_SESSION[user_id]'");
$products->execute();
$allProducts = $products->fetchAll(PDO::FETCH_OBJ);
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
                    <!-- <div class="clearfix"></div>
                    <h6 class="full price mt-3">Total: <span id="total-amount"></span></h6> -->
                    <button class="intaSendPayButton" data-amount="10" data-currency="KES">Pay Now</button>
                    <!-- <a href="" class="btn btn-lg btn-primary">Checkout <i class="fa fa-long-arrow-right"></i></a> -->
                </div>
            </div>
        </div>
    </section>
</div>

<?php require '../includes/footer.php'; ?>

<script>


$(document).ready(function() {
    $(".pro_qty").on("change keyup", function() {
        var $el = $(this).closest('tr');
        var pro_qty = parseFloat($(this).val()) || 0; // Use 0 if the value is NaN
        var pro_price = parseFloat($el.find(".pro_price").text()) || 0; // Use 0 if the value is NaN
        var subtotal = pro_qty * pro_price;

        $el.find(".subtotal").text(subtotal.toFixed(2)); // Update the subtotal cell

        // Update the total amount
        updateTotal();
    });

    function updateTotal() {
        var tot//intasend
al = 0;
        $(".subtotal").each(function() {
            total += parseFloat($(this).text()) || 0; // Use 0 if the value is NaN
        });
        $("#total-amount").text("$ " + total.toFixed(2)); // Update the total display
    }

    $(".btn-update").on('click', function(e) {
    // Get the product ID from the button's value
    var id = $(this).val();
    
    // Get the updated quantity and subtotal
    var $el = $(this).closest('tr'); // Find the closest row (tr)
    var pro_qty = parseFloat($el.find(".pro_qty").val()) || 0; // Get the updated quantity from the input
    var subtotal = parseFloat($el.find(".subtotal").text()) || 0; // Get the updated subtotal from the text

    // Send the updated data via AJAX
    $.ajax({
        type: "POST", // Corrected syntax error: type should be ':', not '='
        url: "update-product.php",
        data: {
            update: "update",
            id: id,
            pro_qty: pro_qty,
            subtotal: subtotal
        },
        success: function(response) {
            alert("Update Successful");
            // Optionally, reload the page
            location.reload(); // Use this to reload the page after the update
            // Alternatively, you can fetch the updated data or update the DOM without reloading
        }
    });
});

$(".btn-delete").on('click', function(e) {
    // Get the product ID from the button's value
    var id = $(this).val();

    // Send the deleted data via AJAX
    $.ajax({
        type: "POST", 
        url: "delete-product.php",
        data: {
            delete: "delete",
            id: id,
        },
        success: function(response) {
            alert("Product deleted Successful");
            location.reload(); 
        }
    });
});


function reload() {
    $("body").load("cart.php");
}

});


</script>

