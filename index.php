<?php
$title = "Home";
include_once "layouts/header.php";
include_once "layouts/nav.php";
include_once "app/models/Product.php";
include_once "app/models/Review.php";
include_once "app/models/OrderProduct.php";

$productObject = new Product;
$reccentProductsResult = $productObject->getRecentProducts();
$recentProducts = $reccentProductsResult->fetch_all(MYSQLI_ASSOC);

$reviewObject = new Review;
$reviewProductsResult = $reviewObject->read();
$reviewProducts = $reviewProductsResult->fetch_all(MYSQLI_ASSOC);

$orderObject = new OrderProduct;
$orderProductsResult = $orderObject->read();
$orderProducts = $orderProductsResult->fetch_all(MYSQLI_ASSOC);
?>


<div class="slider-area">
    <div class="slider-active owl-dot-style owl-carousel">
        <div class="single-slider ptb-240 bg-img" style="background-image:url(assets/img/slider/slider-1.jpg);">
            <div class="container">
                <div class="slider-content slider-animated-1">
                    <h1 class="animated">Want to stay <span class="theme-color">healthy</span></h1>
                    <h1 class="animated">drink matcha.</h1>
                    <p>Lorem ipsum dolor sit amet, consectetu adipisicing elit sedeiu tempor inci ut labore et dolore magna aliqua.</p>
                </div>
            </div>
        </div>
        <div class="single-slider ptb-240 bg-img" style="background-image:url(assets/img/slider/slider-1-1.jpg);">
            <div class="container">
                <div class="slider-content slider-animated-1">
                    <h1 class="animated">Want to stay <span class="theme-color">healthy</span></h1>
                    <h1 class="animated">drink matcha.</h1>
                    <p>Lorem ipsum dolor sit amet, consectetu adipisicing elit sedeiu tempor inci ut labore et dolore magna aliqua.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="product-area bg-image-1 pt-100 pb-95">
    <div class="container">
        <div class="section-title-wrap text-center mb-3">
            <h3 class="section-title">Most Recents</h3>
        </div>
        <div class="featured-product-active hot-flower owl-carousel product-nav">
            <?php foreach ($recentProducts as $recentProduct) { ?>
                <div class="product-wrapper">
                    <div class="product-img">
                        <a href="product-details.php">
                            <img alt="" src="assets/img/product/<?= $recentProduct['image'] ?>">
                        </a>
                        <div class="product-action">
                            <a class="action-wishlist" href="#" title="Wishlist">
                                <i class="ion-android-favorite-outline"></i>
                            </a>
                            <a class="action-cart" href="#" title="Add To Cart">
                                <i class="ion-ios-shuffle-strong"></i>
                            </a>
                            <a class="action-compare" href="#" data-target="#exampleModal" data-toggle="modal" title="Quick View">
                                <i class="ion-ios-search-strong"></i>
                            </a>
                        </div>
                    </div>
                    <div class="product-content text-left">
                        <div class="product-hover-style">
                            <div class="product-title">
                                <h4>
                                    <a href="product-details.php"><?= $recentProduct['name_en'] ?></a>
                                </h4>
                            </div>
                            <div class="cart-hover">
                                <h4><a href="product-details.php"><?= $recentProduct['created_at'] ?></a></h4>
                            </div>
                        </div>
                        <div class="product-price-wrapper">
                            <span class="product-price"><?= $recentProduct['price'] ?> EGP</span>
                        </div>
                    </div>
                </div>
            <?php } ?>

        </div>
    </div>
</div>

<div class="product-area bg-image-1 pt-100 pb-95">
    <div class="container">
        <div class="section-title-wrap text-center mb-3">
            <h3 class="section-title">Most Rated</h3>
        </div>
        <div class="featured-product-active hot-flower owl-carousel product-nav">
            <?php foreach ($reviewProducts as $reviewProduct) { ?>
                <div class="product-wrapper">
                    <div class="product-img">
                        <a href="product-details.php">
                            <img alt="" src="assets/img/product/<?= $reviewProduct['image'] ?>">
                        </a>
                        <div class="product-action">
                            <a class="action-wishlist" href="#" title="Wishlist">
                                <i class="ion-android-favorite-outline"></i>
                            </a>
                            <a class="action-cart" href="#" title="Add To Cart">
                                <i class="ion-ios-shuffle-strong"></i>
                            </a>
                            <a class="action-compare" href="#" data-target="#exampleModal" data-toggle="modal" title="Quick View">
                                <i class="ion-ios-search-strong"></i>
                            </a>
                        </div>
                    </div>
                    <div class="product-content text-left">
                        <div class="product-hover-style">
                            <div class="product-title">
                                <h4>
                                    <a href="product-details.php"><?= $reviewProduct['name_en'] ?></a>
                                </h4>
                            </div>
                            <div class="cart-hover">
                                <h4><a href="#"></i> <?= $reviewProduct['count_reviews'] ?> Reviews <?= $reviewProduct['average_rate']?>/5 <i class='ion-android-star-outline'></i></a></h4>
                            </div>
                        </div>
                        <div class="product-price-wrapper">
                            <span class="product-price"><?= $reviewProduct['price'] ?> EGP</span>
                        </div>
                    </div>
                </div>
            <?php } ?>

        </div>
    </div>
</div>

<div class="product-area bg-image-1 pt-100 pb-95">
    <div class="container">
        <div class="section-title-wrap text-center mb-3">
            <h3 class="section-title">Most Ordered</h3>
        </div>
        <div class="featured-product-active hot-flower owl-carousel product-nav">
            <?php foreach ($orderProducts as $orderProduct) { ?>
                <div class="product-wrapper">
                    <div class="product-img">
                        <a href="product-details.php">
                            <img alt="" src="assets/img/product/<?= $orderProduct['image'] ?>">
                        </a>
                        <div class="product-action">
                            <a class="action-wishlist" href="#" title="Wishlist">
                                <i class="ion-android-favorite-outline"></i>
                            </a>
                            <a class="action-cart" href="#" title="Add To Cart">
                                <i class="ion-ios-shuffle-strong"></i>
                            </a>
                            <a class="action-compare" href="#" data-target="#exampleModal" data-toggle="modal" title="Quick View">
                                <i class="ion-ios-search-strong"></i>
                            </a>
                        </div>
                    </div>
                    <div class="product-content text-left">
                        <div class="product-hover-style">
                            <div class="product-title">
                                <h4>
                                    <a href="product-details.php"><?= $orderProduct['name_en'] ?></a>
                                </h4>
                            </div>
                            <div class="cart-hover">
                                <h4><a href="product-details.php"><?= $orderProduct['count_products'] ?></a> Orders</h4>
                            </div>
                        </div>
                        <div class="product-price-wrapper">
                            <span class="product-price"><?= $orderProduct['price'] ?> EGP</span>
                        </div>
                    </div>
                </div>
            <?php } ?>

        </div>
    </div>
</div>
<?php
include_once "layouts/footer.php";
include_once "layouts/footer-scripts.php";
?>