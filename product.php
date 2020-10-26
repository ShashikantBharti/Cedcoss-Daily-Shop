<?php 
    require 'config.inc.php';
    $cat_id = '';
    $tag_id = '';
    $page_num = '';
    $color = '';
    $limit = 12;
    $products = array();
    if (isset($_REQUEST['cat_id']) && $_REQUEST['cat_id'] != '') {
        $cat_id = $_REQUEST['cat_id'];
        $products = get_product($conn, '', $cat_id);
    } else if (isset($_REQUEST['tag_id']) && $_REQUEST['tag_id'] != '') {
        $tag_id = $_REQUEST['tag_id'];
        $products = get_product($conn, '', '', $tag_id);
    } else if (isset($_REQUEST['color']) && $_REQUEST['color'] != '') {
        $color = $_REQUEST['color'];
        $products = get_product($conn, '', '', '', '', $color);
    } else {
        $products = get_product($conn);
    }
    if (isset($_REQUEST['page_num']) && $_REQUEST['page_num'] != '') {
        $page_num = $_REQUEST['page_num'];
        $products = get_product($conn, '', '', '', $page_num);
    } else {
        $page_num = 1;
    }
    $select_categories = "SELECT * FROM `categories` ORDER BY `category`";
    $select_tags = "SELECT * FROM `tags` ORDER BY `tags`";
    $get_category = $conn -> query($select_categories) or die("Category Selection Failed !!!.");
    $get_tags = $conn -> query($select_tags) or die("tag Selection Failed !!!.");
    $categories = array();
    $tags = array();
    if ($get_category -> num_rows > 0) {
        while ($row = $get_category -> fetch_assoc()) {
            $categories[] = $row;
        }
    }
    if ($get_tags -> num_rows > 0) {
        while ($row = $get_tags -> fetch_assoc()) {
            $tags[] = $row;
        }
    } 
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daily Shop | Product</title>

    <!-- Font awesome -->
    <link href="css/font-awesome.css" rel="stylesheet">
    <!-- Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <!-- SmartMenus jQuery Bootstrap Addon CSS -->
    <link href="css/jquery.smartmenus.bootstrap.css" rel="stylesheet">
    <!-- Product view slider -->
    <link rel="stylesheet" type="text/css" href="css/jquery.simpleLens.css">
    <!-- slick slider -->
    <link rel="stylesheet" type="text/css" href="css/slick.css">
    <!-- price picker slider -->
    <link rel="stylesheet" type="text/css" href="css/nouislider.css">
    <!-- Theme color -->
    <link id="switcher" href="css/theme-color/default-theme.css" rel="stylesheet">
    <!-- Top Slider CSS -->
    <link href="css/sequence-theme.modern-slide-in.css" rel="stylesheet" media="all">

    <!-- Main style sheet -->
    <link href="css/style.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

    <!-- Google Font -->
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<!-- !Important notice -->
<!-- Only for product page body tag have to added .productPage class -->

<body class="productPage">
    <!-- wpf loader Two -->
    <div id="wpf-loader-two">
        <div class="wpf-loader-two-inner">
            <span>Loading</span>
        </div>
    </div>
    <!-- / wpf loader Two -->
    <!-- SCROLL TOP BUTTON -->
    <a class="scrollToTop" href="#"><i class="fa fa-chevron-up"></i></a>
    <!-- END SCROLL TOP BUTTON -->


    <!-- Start header section -->
    <header id="aa-header">
        <!-- start header top  -->
        <div class="aa-header-top">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="aa-header-top-area">
                            <!-- start header top left -->
                            <div class="aa-header-top-left">
                                <!-- start language -->
                                <div class="aa-language">
                                    <div class="dropdown">
                                        <a class="btn dropdown-toggle" href="#" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                            <img src="img/flag/english.jpg" alt="english flag">ENGLISH
                                            <span class="caret"></span>
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                            <li>
                                                <a href="#"><img src="img/flag/french.jpg" alt="">FRENCH</a>
                                            </li>
                                            <li>
                                                <a href="#"><img src="img/flag/english.jpg" alt="">ENGLISH</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- / language -->

                                <!-- start currency -->
                                <div class="aa-currency">
                                    <div class="dropdown">
                                        <a class="btn dropdown-toggle" href="#" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                            <i class="fa fa-usd"></i>USD
                                            <span class="caret"></span>
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                            <li><a href="#"><i class="fa fa-euro"></i>EURO</a></li>
                                            <li><a href="#"><i class="fa fa-jpy"></i>YEN</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- / currency -->
                                <!-- start cellphone -->
                                <div class="cellphone hidden-xs">
                                    <p><span class="fa fa-phone"></span>00-62-658-658</p>
                                </div>
                                <!-- / cellphone -->
                            </div>
                            <!-- / header top left -->
                            <div class="aa-header-top-right">
                                <ul class="aa-head-top-nav-right">
                                    <li><a href="account.html">My Account</a></li>
                                    <li class="hidden-xs"><a href="wishlist.html">Wishlist</a></li>
                                    <li class="hidden-xs"><a href="cart.html">My Cart</a></li>
                                    <li class="hidden-xs"><a href="checkout.html">Checkout</a></li>
                                    <li>
                                    <?php  
                                        if(isset($_SESSION['USER_ID']) && isset($_SESSION['USER_NAME'])) {
                                            echo '<a href="logout.php">logout</a>';
                                        } else {
                                            echo '<a href="" data-toggle="modal" data-target="#login-modal">Login</a>';
                                        }   
                                    ?>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- / header top  -->

        <!-- start header bottom  -->
        <div class="aa-header-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="aa-header-bottom-area">
                            <!-- logo  -->
                            <div class="aa-logo">
                                <!-- Text based logo -->
                                <a href="index.html">
                                    <span class="fa fa-shopping-cart"></span>
                                    <p>daily<strong>Shop</strong> <span>Your Shopping Partner</span></p>
                                </a>
                                <!-- img based logo -->
                                <!-- <a href="index.html"><img src="img/logo.jpg" alt="logo img"></a> -->
                            </div>
                            <!-- / logo  -->
                            <div class="aa-cartbox">
                <a class="aa-cart-link" href="cart.php">
                  <span class="fa fa-shopping-basket"></span>
                  <span class="aa-cart-title">SHOPPING CART</span>
                  <span class="aa-cart-notify">
                    <?php 
                        if(isset($_SESSION['CART'])) {
                            echo count($_SESSION['CART']);
                        } else {
                            echo 0;
                        }  
                    ?>
                  </span>
                </a>
                <div class="aa-cartbox-summary">
                  <ul>
                    <?php  
                        $total = 0;
                        if (isset($_SESSION['CART'])) {
                            foreach($_SESSION['CART'] as $key => $value) {
                            $product = get_product($conn, $key);
                            $pname = $product[0]['name'];
                            $image = $product[0]['image'];
                            $price = $product[0]['price'];
                            $qty = $value['qty'];
                            $total += $qty * $price;

                    ?>
                    <li>
                      <a class="aa-cartbox-img" href="#"><img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$image; ?>" alt="img"></a>
                      <div class="aa-cartbox-info">
                        <h4><a href="#"><?php echo $pname; ?></a></h4>
                        <p><?php echo $qty.' X $'.$price;  ?></p>
                      </div>
                      <a class="aa-remove-product" href="javascript:void(0)" onclick="manage_cart(<?php echo $key; ?>,'remove')"><span class="fa fa-times"></span></a>
                    </li>
                      <?php 
                        }
                      }
                      ?>
                    <li>
                      <span class="aa-cartbox-total-title">
                        Total
                      </span>
                      <span class="aa-cartbox-total-price">
                      <?php echo '$'.$total;  ?>
                      </span>
                    </li>
                  </ul>
                  <a class="aa-cartbox-checkout aa-primary-btn" href="checkout.php">Checkout</a>
                </div>
              </div>
              <!-- / cart box -->
                            <!-- search box -->
                            <div class="aa-search-box">
                                <form action="">
                                    <input type="text" name="" id="" placeholder="Search here ex. 'man' ">
                                    <button type="submit"><span class="fa fa-search"></span></button>
                                </form>
                            </div>
                            <!-- / search box -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- / header bottom  -->
    </header>
    <!-- / header section -->
    <!-- menu -->
    <section id="menu">
        <div class="container">
            <div class="menu-area">
                <!-- Navbar -->
                <div class="navbar navbar-default" role="navigation">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <div class="navbar-collapse collapse">
                        <!-- Left nav -->
                        <ul class="nav navbar-nav">
                            <li><a href="index.php">Home</a></li>
                            <li><a href="#">Men <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Casual</a></li>
                                    <li><a href="#">Sports</a></li>
                                    <li><a href="#">Formal</a></li>
                                    <li><a href="#">Standard</a></li>
                                    <li><a href="#">T-Shirts</a></li>
                                    <li><a href="#">Shirts</a></li>
                                    <li><a href="#">Jeans</a></li>
                                    <li><a href="#">Trousers</a></li>
                                    <li><a href="#">And more.. <span class="caret"></span></a>
                                        <ul class="dropdown-menu">
                                            <li><a href="#">Sleep Wear</a></li>
                                            <li><a href="#">Sandals</a></li>
                                            <li><a href="#">Loafers</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li><a href="#">Women <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Kurta & Kurti</a></li>
                                    <li><a href="#">Trousers</a></li>
                                    <li><a href="#">Casual</a></li>
                                    <li><a href="#">Sports</a></li>
                                    <li><a href="#">Formal</a></li>
                                    <li><a href="#">Sarees</a></li>
                                    <li><a href="#">Shoes</a></li>
                                    <li><a href="#">And more.. <span class="caret"></span></a>
                                        <ul class="dropdown-menu">
                                            <li><a href="#">Sleep Wear</a></li>
                                            <li><a href="#">Sandals</a></li>
                                            <li><a href="#">Loafers</a></li>
                                            <li><a href="#">And more.. <span class="caret"></span></a>
                                                <ul class="dropdown-menu">
                                                    <li><a href="#">Rings</a></li>
                                                    <li><a href="#">Earrings</a></li>
                                                    <li><a href="#">Jewellery Sets</a></li>
                                                    <li><a href="#">Lockets</a></li>
                                                    <li class="disabled"><a class="disabled" href="#">Disabled item</a></li>
                                                    <li><a href="#">Jeans</a></li>
                                                    <li><a href="#">Polo T-Shirts</a></li>
                                                    <li><a href="#">SKirts</a></li>
                                                    <li><a href="#">Jackets</a></li>
                                                    <li><a href="#">Tops</a></li>
                                                    <li><a href="#">Make Up</a></li>
                                                    <li><a href="#">Hair Care</a></li>
                                                    <li><a href="#">Perfumes</a></li>
                                                    <li><a href="#">Skin Care</a></li>
                                                    <li><a href="#">Hand Bags</a></li>
                                                    <li><a href="#">Single Bags</a></li>
                                                    <li><a href="#">Travel Bags</a></li>
                                                    <li><a href="#">Wallets & Belts</a></li>
                                                    <li><a href="#">Sunglases</a></li>
                                                    <li><a href="#">Nail</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li><a href="#">Kids <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Casual</a></li>
                                    <li><a href="#">Sports</a></li>
                                    <li><a href="#">Formal</a></li>
                                    <li><a href="#">Standard</a></li>
                                    <li><a href="#">T-Shirts</a></li>
                                    <li><a href="#">Shirts</a></li>
                                    <li><a href="#">Jeans</a></li>
                                    <li><a href="#">Trousers</a></li>
                                    <li><a href="#">And more.. <span class="caret"></span></a>
                                        <ul class="dropdown-menu">
                                            <li><a href="#">Sleep Wear</a></li>
                                            <li><a href="#">Sandals</a></li>
                                            <li><a href="#">Loafers</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li><a href="#">Sports</a></li>
                            <li><a href="#">Digital <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Camera</a></li>
                                    <li><a href="#">Mobile</a></li>
                                    <li><a href="#">Tablet</a></li>
                                    <li><a href="#">Laptop</a></li>
                                    <li><a href="#">Accesories</a></li>
                                </ul>
                            </li>
                            <li><a href="#">Furniture</a></li>
                            <li><a href="blog-archive.html">Blog <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="blog-archive.html">Blog Style 1</a></li>
                                    <li><a href="blog-archive-2.html">Blog Style 2</a></li>
                                    <li><a href="blog-single.html">Blog Single</a></li>
                                </ul>
                            </li>
                            <li><a href="contact.html">Contact</a></li>
                            <li><a href="#">Pages <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="product.html">Shop Page</a></li>
                                    <li><a href="product-detail.html">Shop Single</a></li>
                                    <li><a href="404.html">404 Page</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <!--/.nav-collapse -->
                </div>
            </div>
        </div>
        </div>
    </section>
    <!-- / menu -->

    <!-- catg header banner section -->
    <section id="aa-catg-head-banner">
        <img src="img/fashion/fashion-header-bg-8.jpg" alt="fashion img">
        <div class="aa-catg-head-banner-area">
            <div class="container">
                <div class="aa-catg-head-banner-content">
                    <h2>Fashion</h2>
                    <ol class="breadcrumb">
                        <li><a href="index.php">Home</a></li>
                        <li class="active">Products</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <!-- / catg header banner section -->

    <!-- product category -->
    <section id="aa-product-category">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 col-md-9 col-sm-8 col-md-push-3">
                    <div class="aa-product-catg-content">
                        <div class="aa-product-catg-head">
                            <div class="aa-product-catg-head-left">
                                <form action="" class="aa-sort-form">
                                    <label for="">Sort by</label>
                                    <select name="">
                                        <option value="1" selected="Default">Default</option>
                                        <option value="2">Name</option>
                                        <option value="3">Price</option>
                                        <option value="4">Date</option>
                                    </select>
                                </form>
                                <form action="" class="aa-show-form">
                                    <label for="">Show</label>
                                    <select name="">
                                        <option value="1" selected="12">12</option>
                                        <option value="2">24</option>
                                        <option value="3">36</option>
                                    </select>
                                </form>
                            </div>
                            <div class="aa-product-catg-head-right">
                                <a id="grid-catg" href="#"><span class="fa fa-th"></span></a>
                                <a id="list-catg" href="#"><span class="fa fa-list"></span></a>
                            </div>
                        </div>
                        <div class="aa-product-catg-body">
                            <ul class="aa-product-catg">
                                <!-- start single product item -->
                                <?php 
                                    foreach ($products as $product) {
                                ?>
                                <li>
                                    <figure>
                                        <a class="aa-product-img" href="product-detail.php?id=<?php echo $product['id']; ?>"><img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$product['image']; ?>" alt="polo shirt img"></a>
                                        <a class="aa-add-card-btn" href="javascript:void(0)" onclick="manage_cart(<?php echo $product['id']; ?>,'add');"><span class="fa fa-shopping-cart"></span>
                                        <?php 
                                            if (isset($_SESSION['CART'])) {
                                                $flag = 0;
                                                foreach ($_SESSION['CART'] as $key => $value) {
                                                if ($product['id'] == $key) {
                                                    $flag = 1;
                                                } else {
                                                    $flag = 0;
                                                }
                                                }
                                                if ($flag) {
                                                echo 'Added';
                                                } else {
                                                echo 'Add To Cart';
                                                }
                                            } else {
                                                echo 'Add To Cart';
                                            }
                                        ?>
                                        </a>    
                                        <figcaption>
                                            <h4 class="aa-product-title"><a href="product-detail.php?id=<?php echo $product['id']; ?>"><?php echo $product['name']; ?></a></h4>
                                            <span class="aa-product-price"> <?php echo '$'.$product['price']; ?> </span><span class="aa-product-price"><del> <?php echo '$'.$product['mrp']; ?> </del></span>
                                            <p class="aa-product-descrip"> <?php echo $product['short_desc']; ?> </p>
                                            <p class="aa-product-descrip"> <?php echo $product['description']; ?> </p>
                                        </figcaption>
                                    </figure>
                                    <div class="aa-product-hvr-content">
                                        <a href="#" data-toggle="tooltip" data-placement="top" title="Add to Wishlist"><span class="fa fa-heart-o"></span></a>
                                        <a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><span class="fa fa-exchange"></span></a>
                                        <a href="#" data-toggle2="tooltip" data-placement="top" title="Quick View" data-toggle="modal" data-target="#quick-view-modal"><span class="fa fa-search"></span></a>
                                    </div>
                                    <!-- product badge -->
                                    <span class="aa-badge aa-sale" href="#">SALE!</span>
                                </li>
                                <?php 
                                    }
                                ?>
                            </ul>
                            <!-- quick view modal -->
                            <div class="modal fade" id="quick-view-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <div class="row">
                                                <!-- Modal view slider -->
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <div class="aa-product-view-slider">
                                                        <div class="simpleLens-gallery-container" id="demo-1">
                                                            <div class="simpleLens-container">
                                                                <div class="simpleLens-big-image-container">
                                                                    <a class="simpleLens-lens-image" data-lens-image="img/view-slider/large/polo-shirt-1.png">
                                                                        <img src="img/view-slider/medium/polo-shirt-1.png" class="simpleLens-big-image">
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="simpleLens-thumbnails-container">
                                                                <a href="#" class="simpleLens-thumbnail-wrapper" data-lens-image="img/view-slider/large/polo-shirt-1.png" data-big-image="img/view-slider/medium/polo-shirt-1.png">
                                                                    <img src="img/view-slider/thumbnail/polo-shirt-1.png">
                                                                </a>
                                                                <a href="#" class="simpleLens-thumbnail-wrapper" data-lens-image="img/view-slider/large/polo-shirt-3.png" data-big-image="img/view-slider/medium/polo-shirt-3.png">
                                                                    <img src="img/view-slider/thumbnail/polo-shirt-3.png">
                                                                </a>

                                                                <a href="#" class="simpleLens-thumbnail-wrapper" data-lens-image="img/view-slider/large/polo-shirt-4.png" data-big-image="img/view-slider/medium/polo-shirt-4.png">
                                                                    <img src="img/view-slider/thumbnail/polo-shirt-4.png">
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Modal view content -->
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <div class="aa-product-view-content">
                                                        <h3>T-Shirt</h3>
                                                        <div class="aa-price-block">
                                                            <span class="aa-product-view-price">$34.99</span>
                                                            <p class="aa-product-avilability">Avilability: <span>In stock</span></p>
                                                        </div>
                                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officiis animi, veritatis quae repudiandae quod nulla porro quidem, itaque quis quaerat!</p>
                                                        <h4>Size</h4>
                                                        <div class="aa-prod-view-size">
                                                            <a href="#">S</a>
                                                            <a href="#">M</a>
                                                            <a href="#">L</a>
                                                            <a href="#">XL</a>
                                                        </div>
                                                        <div class="aa-prod-quantity">
                                                            <form action="">
                                                                <select name="" id="">
                                                                    <option value="0" selected="1">1</option>
                                                                    <option value="1">2</option>
                                                                    <option value="2">3</option>
                                                                    <option value="3">4</option>
                                                                    <option value="4">5</option>
                                                                    <option value="5">6</option>
                                                                </select>
                                                            </form>
                                                            <p class="aa-prod-category">
                                                                Category: <a href="#">Polo T-Shirt</a>
                                                            </p>
                                                        </div>
                                                        <div class="aa-prod-view-bottom">
                                                            <a href="#" class="aa-add-to-cart-btn"><span class="fa fa-shopping-cart"></span>Add To Cart</a>
                                                            <a href="#" class="aa-add-to-cart-btn">View Details</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- / quick view modal -->
                        </div>
                        <div class="aa-product-catg-pagination">
                            <nav>
                                <ul class="pagination">
                                    <?php 
                                        if ($page_num > 1) {
                                    ?>
                                    <li>
                                        <a href="?page_num=<?php echo ($page_num - 1); ?>" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                    <?php } ?>
                                    <?php 
                                        $all_products = "SELECT * FROM `products`";
                                        $result = $conn -> query($all_products) or die(" Product Selection Query Failed !!!.");
                                        if ($result -> num_rows > 0) {
                                            $total_records = $result -> num_rows;
                                            
                                            $total_pages = ceil($total_records/$limit);
                                            for($i = 1;$i <= $total_pages; $i++) {
                                                echo '<li><a href="?page_num='.$i.'">'.$i.'</a></li>';
                                            }
                                        }
                                    ?>
                                    <?php 
                                        if ($page_num < $total_pages) {
                                    ?>
                                    <li>
                                        <a href="?page_num=<?php echo ($page_num + 1); ?>" aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-4 col-md-pull-9">
                    <aside class="aa-sidebar">
                        <!-- single sidebar -->
                        <div class="aa-sidebar-widget">
                            <h3>Category</h3>
                            <ul class="aa-catg-nav">
                            <li><a href="product.php">All</a></li>
                                <?php 
                                    foreach ($categories as $category) {
                                        echo '<li><a href="?cat_id='.$category['id'].'">'.$category['category'].'</a></li>';
                                    }
                                ?>
                            </ul>
                        </div>
                        <!-- single sidebar -->
                        <div class="aa-sidebar-widget">
                            <h3>Tags</h3>
                            <div class="tag-cloud">
                            <a href="product.php">All</a>
                                <?php
                                    foreach ($tags as $tag) {
                                        echo '<a href="?tag_id='.$tag['id'].'">'.$tag['tags'].'</a>';
                                    }
                                ?>
                            </div>
                        </div>
                        <!-- single sidebar -->
                        <div class="aa-sidebar-widget">
                            <h3>Shop By Price</h3>
                            <!-- price range -->
                            <div class="aa-sidebar-price-range">
                                <form action="">
                                    <div id="skipstep" class="noUi-target noUi-ltr noUi-horizontal noUi-background"></div>
                                    <span id="skip-value-lower" class="example-val">30.00</span>
                                    <span id="skip-value-upper" class="example-val">100.00</span>
                                    <button class="aa-filter-btn" type="submit">Filter</button>
                                </form>
                            </div>

                        </div>
                        <!-- single sidebar -->
                        <div class="aa-sidebar-widget">
                            <h3>Shop By Color</h3>
                            <div class="aa-color-tag">
                                <a class="aa-color-green" href="?color=Green" title="Green"></a>
                                <a class="aa-color-yellow" href="?color=Yellow" title="Yellow"></a>
                                <a class="aa-color-pink" href="?color=Pink" title="Pink"></a>
                                <a class="aa-color-purple" href="?color=Purple" title="Purple"></a>
                                <a class="aa-color-blue" href="?color=Blue" title="Blue"></a>
                                <a class="aa-color-orange" href="?color=Orange" title="Orange"></a>
                                <a class="aa-color-gray" href="?color=Grey" title="Grey"></a>
                                <a class="aa-color-black" href="?color=Black" title="Black"></a>
                                <a class="aa-color-white" href="?color=White" title="White"></a>
                                <a class="aa-color-cyan" href="?color=Cyan" title="Cyan"></a>
                                <a class="aa-color-olive" href="?color=Olive" title="Olive"></a>
                                <a class="aa-color-orchid" href="?color=Orchid" title="Orchid"></a>
                            </div>
                        </div>
                        <!-- single sidebar -->
                        <div class="aa-sidebar-widget">
                            <h3>Recently Views</h3>
                            <div class="aa-recently-views">
                                <ul>
                                    <li>
                                        <a href="#" class="aa-cartbox-img"><img alt="img" src="img/woman-small-2.jpg"></a>
                                        <div class="aa-cartbox-info">
                                            <h4><a href="#">Product Name</a></h4>
                                            <p>1 x $250</p>
                                        </div>
                                    </li>
                                    <li>
                                        <a href="#" class="aa-cartbox-img"><img alt="img" src="img/woman-small-1.jpg"></a>
                                        <div class="aa-cartbox-info">
                                            <h4><a href="#">Product Name</a></h4>
                                            <p>1 x $250</p>
                                        </div>
                                    </li>
                                    <li>
                                        <a href="#" class="aa-cartbox-img"><img alt="img" src="img/woman-small-2.jpg"></a>
                                        <div class="aa-cartbox-info">
                                            <h4><a href="#">Product Name</a></h4>
                                            <p>1 x $250</p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- single sidebar -->
                        <div class="aa-sidebar-widget">
                            <h3>Top Rated Products</h3>
                            <div class="aa-recently-views">
                                <ul>
                                    <li>
                                        <a href="#" class="aa-cartbox-img"><img alt="img" src="img/woman-small-2.jpg"></a>
                                        <div class="aa-cartbox-info">
                                            <h4><a href="#">Product Name</a></h4>
                                            <p>1 x $250</p>
                                        </div>
                                    </li>
                                    <li>
                                        <a href="#" class="aa-cartbox-img"><img alt="img" src="img/woman-small-1.jpg"></a>
                                        <div class="aa-cartbox-info">
                                            <h4><a href="#">Product Name</a></h4>
                                            <p>1 x $250</p>
                                        </div>
                                    </li>
                                    <li>
                                        <a href="#" class="aa-cartbox-img"><img alt="img" src="img/woman-small-2.jpg"></a>
                                        <div class="aa-cartbox-info">
                                            <h4><a href="#">Product Name</a></h4>
                                            <p>1 x $250</p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </aside>
                </div>

            </div>
        </div>
    </section>
    <!-- / product category -->
<?php require 'footer.inc.php'; ?>