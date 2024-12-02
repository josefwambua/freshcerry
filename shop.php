<?php require "includes/header.php"; ?>
<?php require "config/config.php"; ?>


<?php 
// fetching categories from the database
$categories = $conn->query("SELECT * FROM categories");
$categories->execute();
$allcategories=$categories->fetchAll(PDO::FETCH_OBJ);

// most wanted products
$mostProducts=$conn->prepare("SELECT * FROM products WHERE status=1");
$mostProducts->execute();
$mostWantedProducts=$mostProducts->fetchAll(PDO::FETCH_OBJ);


// All vegetables
$vegies=$conn->prepare("SELECT * FROM products WHERE status=1 AND category_id = 1");
$vegies->execute();
$AllVegies=$vegies->fetchAll(PDO::FETCH_OBJ);

//Meat
$meat=$conn->prepare("SELECT * FROM products WHERE status=1 AND category_id = 2");
$meat->execute();
$AllMeat=$meat->fetchAll(PDO::FETCH_OBJ);

// fish
$fishes=$conn->prepare("SELECT * FROM products WHERE status=1 AND category_id = 5");
$fishes->execute();
$AllFishes=$fishes->fetchAll(PDO::FETCH_OBJ);
 
// Fruits
$fruits=$conn->prepare("SELECT * FROM products WHERE status=1 AND category_id = 6");
$fruits->execute();
$AllFruits=$fruits->fetchAll(PDO::FETCH_OBJ);
?>
    <div id="page-content" class="page-content">
        <div class="banner">
            <div class="jumbotron jumbotron-bg text-center rounded-0" style="background-image: url('assets/img/bg-header.jpg');">
                <div class="container">
                    <h1 class="pt-5">
                        Shopping Page
                    </h1>
                    <p class="lead">
                        Save time and leave the groceries to us.
                    </p>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="shop-categories owl-carousel mt-5">
                        <?php foreach ($allcategories as $category): ?>
                        <div class="item">
                            <a href="shop.php">
                                <div class="media d-flex align-items-center justify-content-center">
                                    <span class="d-flex mr-2"><i class="sb-<?php echo $category->icon?>"></i></span>
                                    <div class="media-body">
                                        <h5><?php echo $category->name ?></h5>
                                        <p><?php echo substr($category->description, 0, 40) ?></p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>
        </div>

        <section id="most-wanted">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="title">Most Wanted</h2>
                        <div class="product-carousel owl-carousel">
                            <?php foreach($mostWantedProducts as $mostWantedProduct) : ?>
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
                                                Until <?php echo $mostWantedProduct->exp_date ?>
                                            </span>
                                            <span class="badge badge-primary">
                                                20% OFF
                                            </span>
                                        </div>
                                        <img src="assets/img/<?php echo $mostWantedProduct->image?>" alt="Card image 2" class="card-img-top">
                                    </div>
                                    <div class="card-body">
                                        <h4 class="card-title">
                                            <a href="detail-product.php"><?php echo $mostWantedProduct->Title ?></a>
                                        </h4>
                                        <div class="card-price">
                                            <!-- <span class="discount">Rp. 300.000</span> -->
                                            <span class="reguler">$ <?php echo $mostWantedProduct->Price;?></span>
                                        </div>
                                        <!-- <a href="detail-product.php" class="btn btn-block btn-primary"> -->
                                        <a href="<?php echo APPURL;?>/products/detail-product.php?id=<?php echo $mostWantedProduct->id ?>" class="btn btn-block btn-primary">

                                            Add to Cart
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach ?>

                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="vegetables" class="gray-bg">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="title">Vegetables</h2>
                        <div class="product-carousel owl-carousel">
                            <?php foreach($AllVegies as $vegie):?>
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
                                                Until <?php echo $vegie->exp_date ?>
                                            </span>
                                            <span class="badge badge-primary">
                                                20% OFF
                                            </span>
                                        </div>
                                        <img src="assets/img/<?php echo $vegie->image; ?>" alt="Card image 2" class="card-img-top">
                                    </div>
                                    <div class="card-body">
                                        <h4 class="card-title">
                                            <a href="detail-product.php"><?php echo $vegie->Title?></a>
                                        </h4>
                                        <div class="card-price">
                                            <!-- <span class="discount">Rp. 300.000</span> -->
                                            <span class="reguler">$ <?php echo $vegie->Price ?></span>
                                        </div>
                                        <a href="<?php echo APPURL;?>/products/detail-product.php?id=<?php echo $vegie->id ?>" class="btn btn-block btn-primary">
                                            Add to Cart
                                        </a>

                                    </div>
                                </div>
                            </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="meat">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="title">meat</h2>
                        <div class="product-carousel owl-carousel">
                            <?php foreach($AllMeat as $item): ?>
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
                                                Until <?php echo $item->exp_date ?>
                                            </span>
                                            <span class="badge badge-primary">
                                                20% OFF
                                            </span>
                                        </div>
                                        <img src="assets/img/<?php echo $item->image?>" alt="Card image 2" class="card-img-top">
                                    </div>
                                    <div class="card-body">
                                        <h4 class="card-title">
                                            <a href="detail-product.php"><?php echo $item->Title ?></a>
                                        </h4>
                                        <div class="card-price">
                                            <!-- <span class="discount">Rp. 300.000</span> -->
                                            <span class="reguler">$ <?php echo $item->Price ?></span>
                                        </div>
                                        <!-- <a href="detail-product.php" class="btn btn-block btn-primary"> -->
                                        <a href="<?php echo APPURL;?>/products/detail-product.php?id=<?php echo $item->id ?>" class="btn btn-block btn-primary">

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

        <section id="fishes" class="gray-bg">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="title">Fishes</h2>
                        <div class="product-carousel owl-carousel">
                            <?php foreach($AllFishes as $fish) : ?>
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
                                                Until <?php echo $fish->exp_date ?>
                                            </span>
                                            <span class="badge badge-primary">
                                                20% OFF
                                            </span>
                                        </div>
                                        <img src="assets/img/<?php echo $fish->image?>" alt="Card image 2" class="card-img-top">
                                    </div>
                                    <div class="card-body">
                                        <h4 class="card-title">
                                            <a href="detail-product.php"><?php echo $fish->Title ?></a>
                                        </h4>
                                        <div class="card-price">
                                            <!-- <span class="discount">Rp. 300.000</span> -->
                                            <span class="reguler">$ <?php echo $fish->Price ?></span>
                                        </div>
                                        <!-- <a href="detail-product.php" class="btn btn-block btn-primary"> -->
                                        <a href="<?php echo APPURL;?>/products/detail-product.php?id=<?php echo $fish->id ?>" class="btn btn-block btn-primary">

                                            Add to Cart
                                        </a>

                                    </div>
                                </div>
                            </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="fruits">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="title">Fruits</h2>
                        <div class="product-carousel owl-carousel">
                            <?php foreach($AllFruits as $fruit) : ?>
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
                                                Until <?php echo $fruit->exp_date ?>
                                            </span>
                                            <span class="badge badge-primary">
                                                20% OFF
                                            </span>
                                        </div>
                                        <img src="assets/img/<?php echo $fruit->image; ?>" alt="Card image 2" class="card-img-top">
                                    </div>
                                    <div class="card-body">
                                        <h4 class="card-title">
                                            <a href="detail-product.php"><?php echo $fruit->Title ?></a>
                                        </h4>
                                        <div class="card-price">
                                            <!-- <span class="discount">Rp. 300.000</span> -->
                                            <span class="reguler">$ <?php echo $fruit->Price ?></span>
                                        </div>
                                        <!-- <a href="detail-product.php" class="btn btn-block btn-primary"> -->
                                        <a href="<?php echo APPURL;?>/products/detail-product.php?id=<?php echo $fruit->id ?>" class="btn btn-block btn-primary">

                                            Add to Cart
                                        </a>

                                    </div>
                                </div>
                            </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
<?php require 'includes/footer.php'; ?>