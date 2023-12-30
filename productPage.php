<?php
session_start();
require("classes/DAOcategories.php");
require("classes/DAOpanier.php");
require("classes/DAOproduct.php");

$DAOproduct = new DAOproduct();
$DAOcategorie = new DAOcategorie();
$DAOpanier = new DAOpanier();

$ref = $_GET['ref'];

$product = $DAOproduct->get_product_by_reference($ref);

$reference = (int)$product->getReference();

$catg = $product->getCatg();
$products = $DAOproduct->get_product_by_catg($catg);
$categories = $DAOcategorie->get_all_categories();

if (isset($_SESSION['client'])) {
	$client = $_SESSION['client'];
	$nbrOfPanier = count($DAOpanier->get_panier($client));

	// $qnt = $DAOpanier->get_panier($client, $ref)[0]->getQnt();
	if (empty($DAOpanier->get_panier($client, $ref))) {
		$result = 1;
	} else {
		$result = $DAOpanier->get_panier($client, $ref)[0]->getQnt();
	}
}




?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

	<title><?php echo $product->getEtiquette()?></title>

	<!-- Google font -->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">

	<!-- Bootstrap -->
	<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css" />

	<!-- Slick -->
	<link type="text/css" rel="stylesheet" href="css/slick.css" />
	<link type="text/css" rel="stylesheet" href="css/slick-theme.css" />

	<!-- nouislider -->
	<link type="text/css" rel="stylesheet" href="css/nouislider.min.css" />

	<!-- Font Awesome Icon -->
	<link rel="stylesheet" href="css/font-awesome.min.css">

	<!-- Custom stlylesheet -->
	<link type="text/css" rel="stylesheet" href="css/style.css" />


</head>

<body>
	<!-- HEADER -->
	<header>
		<!-- TOP HEADER -->
		<div id="top-header">
			<div class="container">
				<ul class="header-links pull-left">
					<li><a href="#"><i class="fa fa-phone"></i> +212642653021</a></li>
					<li><a href="#"><i class="fa fa-envelope-o"></i>class404@electro.com</a></li>
					<li><a href="#"><i class="fa fa-map-marker"></i>Youcode Safi</a></li>
				</ul>
				<ul class="header-links pull-right">
					<?php if (isset($_SESSION['client'])) { ?>
						<li><a href="#"><i class="fa fa-user-o"></i>
								<?php echo $_SESSION['client'] ?>
							</a></li>
						<li><a href="logoutClient.php"><i class="fa fa-user-o"></i> Logout</a></li>
					<?php } else { ?>
						<li><a href="loginClient.php"><i class="fa fa-user-o"></i> Login</a></li>

					<?php } ?>
				</ul>
			</div>
		</div>
		<!-- /TOP HEADER -->

		<!-- MAIN HEADER -->
		<div id="header">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<!-- LOGO -->
					<div class="col-md-9">
						<div class="header-logo">
							<a href="index.php" class="logo">
								<img src="./img/logo.png" alt="">
							</a>
						</div>
					</div>
					<!-- /LOGO -->



					<!-- ACCOUNT -->
					<div class="col-md-3 clearfix">
						<div class="header-ctn">
							<?php if (isset($_SESSION['client'])) { ?>
								<div>
									<a href="cart.php" id="panier">
										<i class="fa fa-shopping-cart"></i>
										<span>Your Cart</span>
										<div class="qty"><?php echo $nbrOfPanier ?></div>
									</a>
								</div>
							<?php } ?>
							<!-- Menu Toogle -->
							<div class="menu-toggle">
								<a href="#">
									<i class="fa fa-bars"></i>
									<span>Menu</span>
								</a>
							</div>
							<!-- /Menu Toogle -->
						</div>
					</div>
					<!-- /ACCOUNT -->
				</div>
				<!-- row -->
			</div>
			<!-- container -->
		</div>
		<!-- /MAIN HEADER -->
	</header>
	<!-- /HEADER -->

	<!-- NAVIGATION -->
	<nav id="navigation">
		<!-- container -->
		<div class="container">
			<!-- responsive-nav -->
			<div id="responsive-nav">
				<!-- NAV -->
				<ul class="main-nav nav navbar-nav">
					<li><a href="productPage.php">All Products</a></li>
					<?php foreach ($categories as $category) : ?>
						<li><a href="product.php?catg=<?php echo $category->getName(); ?>"><?php echo $category->getName() ?></a></li>
					<?php endforeach; ?>
				</ul>
				<!-- /NAV -->
			</div>
			<!-- /responsive-nav -->
		</div>
		<!-- /container -->
	</nav>
	<!-- /NAVIGATION -->


	<!-- SECTION -->
	<div class="section">
		<!-- container -->
		<div class="container">
			<!-- row -->
			<div class="row">
				<!-- Product main img -->
				<div class="col-md-6">
					<div id="product-main-img">
						<div class="product-preview">
							<img src="<?php echo "admin/" . $product->getImg(); ?>" alt="">
						</div>
					</div>
				</div>
				<!-- /Product main img -->

				<!-- Product details -->
				<div class="col-md-6">
					<div class="product-details">
						<h2 class="product-name"><?php echo $product->getEtiquette(); ?></h2>
						<div>
							<div class="product-rating">
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star-o"></i>
							</div>
						</div>
						<div>
							<h3 class="product-price"><?php echo $product->getPrixOffre() . "DH"; ?> <del class="product-old-price"><?php echo $product->getPrixFinal() . "DH"; ?></del></h3>
							<span class="product-available">In Stock</span>
						</div>
						<p><?php echo $product->getDescpt(); ?></p>

						<div class="add-to-cart">
							
							<button class="add-to-cart-btn" onclick="addToCart(<?php echo $reference; ?>)"><i class="fa fa-shopping-cart"></i> add to cart</button>
						</div>
						<ul class="product-links">
							<li>Category:</li>
							<li><a href="#"><?php echo $product->getCatg(); ?></a></li>
						</ul>



					</div>
				</div>
				<!-- /Product details -->

				<!-- Product tab -->
				<div class="col-md-12">
					<div id="product-tab">
						<!-- product tab nav -->
						<ul class="tab-nav">
							<li class="active"><a data-toggle="tab" href="#tab1">Description</a></li>
						</ul>
						<!-- /product tab nav -->

						<!-- product tab content -->
						<div class="tab-content">
							<!-- tab1  -->
							<div id="tab1" class="tab-pane fade in active">
								<div class="row">
									<div class="col-md-12">
										<p><?php echo $product->getDescpt(); ?></p>
									</div>
								</div>
							</div>
							<!-- /tab1  -->


						</div>
						<!-- /product tab content  -->
					</div>
				</div>
				<!-- /product tab -->
			</div>
			<!-- /row -->
		</div>
		<!-- /container -->
	</div>
	<!-- /SECTION -->

	<!-- Section -->
	<div class="section">
		<!-- container -->
		<div class="container">
			<!-- row -->
			<div class="row">

				<div class="col-md-12">
					<div class="section-title text-center">
						<h3 class="title">Related Products</h3>
					</div>
				</div>

				<!-- product -->
				<?php foreach ($products as $item) : ?>
					<div class="col-md-3 col-xs-6">
						<div class="product">
							<div class="product-img">
								<img src="<?php echo "admin/" . $item->getImg() ?>" alt="">
								<div class="product-label">
									<span class="sale">-30%</span>
								</div>
							</div>
							<div class="product-body">
								<p class="product-category"><?php echo $item->getCatg() ?></p>
								<h3 class="product-name"><a href="productPage.php?ref=<?= $item->getReference() ?>"><?php echo $item->getEtiquette() ?></a></h3>
								<h4 class="product-price"><?php echo $item->getPrixOffre() . "DH" ?> <del class="product-old-price"><?php echo $item->getPrixFinal() . "DH" ?></del></h4>
								<div class="product-rating">
								</div>
							</div>
							<div class="add-to-cart">
								<button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i> add to cart</button>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
				<!-- /product -->



			</div>
			<!-- /row -->
		</div>
		<!-- /container -->
	</div>
	<!-- /Section -->


	<!-- /NEWSLETTER -->

	<!-- FOOTER -->
	<footer id="footer">
		<!-- top footer -->
		<div class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<div class="col-md-3 col-xs-6">
						<div class="footer">
							<h3 class="footer-title">About Us</h3>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut.</p>
							<ul class="footer-links">
								<li><a href="#"><i class="fa fa-map-marker"></i>1734 Stonecoal Road</a></li>
								<li><a href="#"><i class="fa fa-phone"></i>+021-95-51-84</a></li>
								<li><a href="#"><i class="fa fa-envelope-o"></i>email@email.com</a></li>
							</ul>
						</div>
					</div>

					<div class="col-md-3 col-xs-6">
						<div class="footer">
							<h3 class="footer-title">Categories</h3>
							<ul class="footer-links">
								<li><a href="#">Hot deals</a></li>
								<li><a href="#">Laptops</a></li>
								<li><a href="#">Smartphones</a></li>
								<li><a href="#">Cameras</a></li>
								<li><a href="#">Accessories</a></li>
							</ul>
						</div>
					</div>

					<div class="clearfix visible-xs"></div>

					<div class="col-md-3 col-xs-6">
						<div class="footer">
							<h3 class="footer-title">Information</h3>
							<ul class="footer-links">
								<li><a href="#">About Us</a></li>
								<li><a href="#">Contact Us</a></li>
								<li><a href="#">Privacy Policy</a></li>
								<li><a href="#">Orders and Returns</a></li>
								<li><a href="#">Terms & Conditions</a></li>
							</ul>
						</div>
					</div>

					<div class="col-md-3 col-xs-6">
						<div class="footer">
							<h3 class="footer-title">Service</h3>
							<ul class="footer-links">
								<li><a href="#">My Account</a></li>
								<li><a href="#">View Cart</a></li>
								<li><a href="#">Wishlist</a></li>
								<li><a href="#">Track My Order</a></li>
								<li><a href="#">Help</a></li>
							</ul>
						</div>
					</div>
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /top footer -->

		<!-- bottom footer -->
		<div id="bottom-footer" class="section">
			<div class="container">
				<!-- row -->
				<div class="row">
					<div class="col-md-12 text-center">
						<ul class="footer-payments">
							<li><a href="#"><i class="fa fa-cc-visa"></i></a></li>
							<li><a href="#"><i class="fa fa-credit-card"></i></a></li>
							<li><a href="#"><i class="fa fa-cc-paypal"></i></a></li>
							<li><a href="#"><i class="fa fa-cc-mastercard"></i></a></li>
							<li><a href="#"><i class="fa fa-cc-discover"></i></a></li>
							<li><a href="#"><i class="fa fa-cc-amex"></i></a></li>
						</ul>
						<span class="copyright">
							<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
							Copyright &copy;<script>
								document.write(new Date().getFullYear());
							</script> All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
							<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
						</span>
					</div>
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /bottom footer -->
	</footer>
	<!-- /FOOTER -->

	<!-- jQuery Plugins -->
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/slick.min.js"></script>
	<script src="js/nouislider.min.js"></script>
	<script src="js/jquery.zoom.min.js"></script>
	<script src="js/main.js"></script>

	<script>
		function addToCart(ref) {
			console.log(ref);
			let myRequest = new XMLHttpRequest();
			myRequest.open("GET", "ajax.php?ref=" + ref, true);
			myRequest.onreadystatechange = function() {
				if (this.readyState === 4 && this.status === 200) {
					console.log(this.responseText);
				}
			}
			myRequest.send();
		}

		let plus = document.querySelector('.qty-up');
		let minus = document.querySelector('.qty-down');
		let qty = document.querySelector('.qtyNumber');

		qty.addEventListener('input', function() {
			let ref = this.getAttribute('data-ref');
			let myRequest = new XMLHttpRequest();
			myRequest.open("GET", "ajax.php?ref=" + ref + "&qty=" + this.value, true);
			myRequest.onreadystatechange = function() {
				if (this.readyState === 4 && this.status === 200) {
					console.log(this.responseText);
				}
			}
			myRequest.send();
		});

		plus.addEventListener('click', function() {
			let ref = this.getAttribute('data-ref');
			console.log(qty.value);
			qty.value++;
			console.log(qty.value);

			addToCart(ref);
		});
		minus.addEventListener('click', function() {
			let ref = this.getAttribute('data-ref');
			let myRequest = new XMLHttpRequest();
			myRequest.open("GET", "ajax.php?minus=" + ref, true);
			myRequest.onreadystatechange = function() {
				if (this.readyState === 4 && this.status === 200) {
					console.log(this.responseText);
				}
			}
			myRequest.send();
		});
	</script>

</body>

</html>