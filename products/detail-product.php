<?php require '../includes/header.php' ?>
<?php require '../config/config.php' ?>

<?php
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $select = $conn->query("SELECT * FROM products WHERE status  = 1 AND id=$id");
    $select->execute();

    $product = $select->fetch(PDO::FETCH_OBJ);


    // related products

    $relatedProducts  = $conn -> query("SELECT * FROM products WHERE status= 1 AND category_id = '$product->category_id' AND id != '$id'");

    $relatedProducts->execute();

    $allRelatedProducts = $relatedProducts->fetchAll(PDO::FETCH_OBJ);
    // var_dump($allRelatedProducts);


    // Cart Logic
    if(isset($POST['submit'])){
        $pro_id= $_POST['pro_id'];
        $pro_title = $_POST['pro_title'];
        $pro_image= $_POST['pro_image'];
        $pro_price= $_POST['pro_price'];
        $pro_qty= $_POST['pro_qty'];
        $user_id= $_POST['user_id'];

        $insert = $conn->prepare("INSERT INTO cart (pro_id, pro_title,pro_image,pro_price,pro_qty,user_id) 
        VALUES (:pro_id, :pro_title, :pro_image, :pro_price, :pro_qty, :user_id) ");
        $insert->execute([

        ':pro_id' => $pro_id,
        ':pro_title' => $pro_title,

        ':pro_image' => $pro_image,

        ':pro_price' => $pro_price,
        ':pro_qty' => $pro_qty,
        ':user_id' => $user_id,
        ]);
    }
}else{

}


?>
<div id="page-content" class="page-content">
        <div class="banner">
            <div class="jumbotron jumbotron-bg text-center rounded-0" style="background-image: url('<?php echo APPURL; ?>/assets/img/bg-header.jpg');">
                <div class="container">
                    <h1 class="pt-5">
                        The Meat Product Title
                    </h1>
                    <p class="lead">
                        Save time and leave the groceries to us.
                    </p>
                </div>
            </div>
        </div>
        <div class="product-detail">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="slider-zoom">
                            <a href="<?php echo APPURL; ?>/assets/img/<?php echo $product->image; ?>" class="cloud-zoom" rel="transparentImage: 'data:image/gif;base64,R0lGODlhAQABAID/AMDAwAAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==', useWrapper: false, showTitle: false, zoomWidth:'500', zoomHeight:'500', adjustY:0, adjustX:10" id="cloudZoom">
                                <img alt="Detail Zoom thumbs image" src="<?php echo APPURL; ?>/assets/img/<?php echo $product->image; ?>" style="width: 100%;">
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <p>
                            <strong>Overview</strong><br>
                            <?php echo $product->Description ?>
                        </p>
                        <div class="row">
                            <div class="col-sm-6">
                                <p>
                                    <strong>Price</strong> (/Pack)<br>
                                    <span class="price"> $ <?php echo $product->Price ?></span>
                                    <!-- <span class="old-price"> <?php echo $product->price ?></span> -->
                                </p>
                            </div>
                           
                        </div>
                        <p class="mb-1">
                            <strong>Quantity</strong>
                        </p>
                        <form method="POST" id="form-data">
                        <div class="row">
                            <div class="col-sm-5">
                                <input class="form-control" type="text" name="pro_title"  value="<?php echo $product->Title ?> "">
                            </div>
                        
                        </div>
                        <div class="row">
                            <div class="col-sm-5">
                                <input class="form-control" type="text" name="pro_id"  value="<?php echo $product->id ?> "">
                            </div>
                        
                        </div>
                        <div class="row">
                            <div class="col-sm-5">
                                <input class="form-control" type="text"name="pro_image"  value="<?php echo $product->image ?> "">
                            </div>
                        
                        </div>

                        <div class="row">
                            <div class="col-sm-5">
                                <input class="form-control" type="text" name="pro_price" value="<?php echo $product->Price ?> "">
                            </div>
                        
                        </div>

                        <div class="row">
                            <div class="col-sm-5">
                                <input class="form-control" type="text" name="user_id" value="<?php echo $_SESSION['user_id'] ?>" >
                            </div>
                        
                        </div> 

                        
                        <div class="row">
                            <div class="col-sm-5">
                                <input class="form-control" type="number" min="1" data-bts-button-down-class="btn btn-primary" data-bts-button-up-class="btn btn-primary" value="<?php echo $product->quantity ?> " name="pro_qty">
                            </div>
                            <div class="col-sm-6"><span class="pt-1 d-inline-block">Pack  (1000 grams)</span></div>
                        </div>
                        <button name="submit" type="submit" class="btn-insert mt-3 btn btn-primary btn-lg">
                            <i class="fa fa-shopping-basket"></i> Add to Cart
                        </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <section id="related-product">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="title">Related Products</h2>
                        <div class="product-carousel owl-carousel">
                            <?php foreach($allRelatedProducts as $prodcts ):  ?>
                            <div class="item">
                                <div class="card card-product">
                                    <div class="card-ribbon">
                                        <div class="card-ribbon-container right">
                                            <span class="ribbon ribbon-primary">SPECIAL</span>
                                        </div>
                                    </div>
                                    <div class="card-badge">
                                        <div class="card-badge-container left">
                                            <span class="badge badge-default">
                                                Until <?php echo $prodcts-> exp_date ?>
                                            </span>
                                            <span class="badge badge-primary">
                                                20% OFF
                                            </span>
                                        </div>
                                        <img src="../assets/img/<?php echo $prodcts->image ?>" alt="Card image 2" class="card-img-top">
                                    </div>
                                    <div class="card-body">
                                        <h4 class="card-title">
                                            <a href="detail-product.php"><?php echo $prodcts->Title ?></a>
                                        </h4>
                                        <div class="card-price">
                                            <!-- <span class="discount">Rp. 300.000</span> -->
                                            <span class="reguler">$ <?php echo  $prodcts -> Price ?></span>
                                        </div>
                                        <a href="<?php echo APPURL;?>/products/detail-product.php?id=<?php echo $prodcts->id;?> " class=" btn-insert btn btn-block btn-primary">
                                            Add to Cart
                                        </a>

                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                            
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
    
    <?php require '../includes/footer.php' ?>


    <!-- <script>
        $(document).ready(function(){
            $(".form-control").keyup(function(){
                var value = $(this).val();
                value = value.replace(/^(0*)/,"");
                $(this).val(1);
            });
            $(".btn-insert").on("click", function(e){
                e.preventDefault();

                var  form_data =  $("#form-data").serialize()+ '&submit=submit';

                $.ajax({
                    url: "detail-product.php?id<?php echo $id ?>",
                    method:"POST",
                    data: form_data,
                    success: function(){
                        alert('Product added succesfully');
                    }
                })
            })

        })
    </script> -->


    <script>
$(document).ready(function(){
    $(".form-control").keyup(function(){
        var value = $(this).val();
        value = value.replace(/^(0*)/, ""); // Remove leading zeros
        $(this).val(value ? value : 1); // Set to 1 if empty
    });
    
    $(".btn-insert").on("click", function(e){
        e.preventDefault();

        var form_data = $("#form-data").serialize() + '&submit=submit';

        $.ajax({
            url: "detail-product.php?id=<?php echo $id; ?>",
            method: "POST",
            data: form_data,
            success: function(){
                console.log('Product added successfully'); // Debug log
                alert('Product added successfully');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('AJAX Error:', textStatus, errorThrown); // Debug error
            }
        });
    });
});
</script>
