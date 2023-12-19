<?php

try {
	$conn = new PDO('mysql:host=localhost;dbname=brief8', 'root', '');
	$stmt = $conn->prepare("SELECT * FROM products WHERE isHide = 0");
	$stmt->execute();
	$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$stmt1 = $conn->prepare("SELECT * FROM categories WHERE isHide = 0");
	$stmt1->execute();
	$catgs = $stmt1->fetchAll(PDO::FETCH_ASSOC);

	
	if (isset($_SESSION['client'])) {
		$client = $_SESSION['client'];
		$stmt1 = $conn->prepare("SELECT * FROM panier WHERE client_username = '$client'");
		$stmt1->execute();
		$nbrOfPanier = $stmt1->rowCount();
	}
} catch (Exception $e) {
	echo "" . $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

	<title>Menu</title>

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


	<style>
		#search-input {
			border-radius: 20px;
		}

		#pagination {
			cursor: pointer;
			margin: 10vh 40%;
		}

		#panier {
			cursor: pointer;
		}
	</style>

</head>

<body>
	<!-- HEADER -->
	<header>
		<div id="top-header">
			<div class="container">
				<ul class="header-links pull-left">
					<li><a href="#"><i class="fa fa-phone"></i> +212642653021</a></li>
					<li><a href="#"><i class="fa fa-envelope-o"></i> class404@electro.com</a></li>
					<li><a href="#"><i class="fa fa-map-marker"></i> Youcode Safi</a></li>
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

		<!-- MAIN HEADER -->
		<div id="header">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<!-- LOGO -->
					<div class="col-md-3">
						<div class="header-logo">
							<a href="index.php" class="logo">
								<img src="./img/logo.png" alt="">
							</a>
						</div>
					</div>
					<!-- /LOGO -->

					<!-- SEARCH BAR -->
					<div class="col-md-6">
						<div class="header-search">
							<form>
								<input class="input" id="search-input" style="width: 35vw;" placeholder="Search here">
							</form>
						</div>
					</div>
					<!-- /SEARCH BAR -->

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
					<li class="li-padding">All Products</li>
					<?php foreach ($catgs as $catg) { ?>
						<li class="li-padding"><?php echo $catg['name']; ?></li>
					<?php } ?>
				</ul>
				<!-- /NAV -->
			</div>
			<!-- /responsive-nav -->
		</div>
		<!-- /container -->
	</nav>
	<!-- /NAVIGATION -->


	<!-- SECTION -->

	<!-- /SECTION -->

	<!-- Section -->
	<div class="section">
		<!-- container -->
		<div class="container">
			<!-- row -->
			<div class="row" id="menu-product">


				<div class="col-md-12">
					<div class="section-title text-center">
						<h3 class="title" id="title-catg">All Product</h3>
					</div>
				</div>

				<?php foreach ($products as $pro) : ?>
					<div class="col-md-4 col-xs-6">
						<div class="product">
							<div class="product-img">
								<img src="./img/product04.png" alt="">
								<div class="product-label">
									<span class="sale">-30%</span>
									<span class="new">NEW</span>
								</div>
							</div>
							<div class="product-body">
								<p class="product-category">Category</p>
								<h3 class="product-name"><a href="#"><?php echo $pro['etiquette'] ?></a></h3>
								<h4 class="product-price">$980.00 <del class="product-old-price">$990.00</del></h4>
								<div class="product-rating">
									<i class="fa fa-star"></i>
									<i class="fa fa-star"></i>
									<i class="fa fa-star"></i>
									<i class="fa fa-star"></i>
									<i class="fa fa-star"></i>
								</div>
								<div class="my-add-to-cart">
									<button class="add-to-cart-btn">ADD TO CART</button>
								</div>

							</div>
						</div>
					</div>
				<?php endforeach; ?>

			</div>
			<!-- /row -->
		</div>
		<!-- /container -->
	</div>
	<!-- /Section -->

	<ul class="pagination mx-auto" id="pagination">

	</ul>

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
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
								incididunt ut.</p>
							<ul class="footer-links">
								<li><a href="#"><i class="fa fa-map-marker"></i>1734 Stonecoal Road</a></li>
								<li><a href="#"><i class="fa fa-phone"></i>+021-95-51-84</a></li>
								<li><a href="#"><i class="fa fa-envelope-o"></i>email@email.com</a></li>
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

				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /top footer -->



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
		let listCatg = document.querySelectorAll('.li-padding');
		listCatg[0].style.color = '#D10024';

		function getData(tableName) {
			var result;
			let myRequest = new XMLHttpRequest();
			myRequest.open("GET", "admin/ajaxConn.php?table=" + tableName, false);
			myRequest.onreadystatechange = function() {
				if (this.readyState === 4 && this.status === 200) {
					result = JSON.parse(this.responseText);
				}
			}
			myRequest.send();
			return result;
		}

		// let products = getData("products");

		// let menu = document.getElementById('menu-product');

		// function displayProducts(object) {
		// 	let firstDiv = document.createElement('div');
		// 	firstDiv.className = 'col-md-3 col-xs-6';
		// 	firstDiv.innerHTML = `
		// 		<div class="product">
		// 			<div class="product-img">
		// 				<img src="admin/${object['img']}" alt="">
		// 				<div class="product-label">
		// 							<span class="sale">-${(object['prixFinal'] - object['prixOffre']) / object['prixFinal'] * 100}%</span>
		// 				</div>
		// 			</div>

		// 			<div class="product-body">
		// 				<p class="product-category">${object['catg']}</p>
		// 				<h3 class="product-name"><a href="">${object['etiquette']}</a></h3>
		// 				<h4 class="product-price">${object['prixOffre']}DH <del class="product-old-price">${object['prixFinal']}DH</del></h4>
		// 				<div class="product-rating">
		// 					<i class="fa fa-star"></i>
		// 					<i class="fa fa-star"></i>
		// 					<i class="fa fa-star"></i>
		// 					<i class="fa fa-star"></i>
		// 					<i class="fa fa-star-o"></i>
		// 				</div>
		// 			</div>
		// 			<div class="add-to-cart">
		// 				<button class="add-to-cart-btn" onclick="addToCart(${object['reference']})"><i class="fa fa-shopping-cart" ></i>add to cart</button>
		// 			</div>
		// 		</div>
		// 	`;
		// 	menu.appendChild(firstDiv);
		// }

		// products.forEach(function(pro) {
		// 	displayProducts(pro);
		// });

		// listCatg.forEach(function(catg) {

		// 	catg.addEventListener('click', function() {
		// 		listCatg.forEach(function(c) {
		// 			c.style.color = 'black';
		// 		});
		// 		document.getElementById('title-catg').innerText = catg.textContent;
		// 		catg.style.color = '#D10024';
		// 		menu.innerHTML = `
		// 			<div class="col-md-12">
		// 				<div class="section-title text-center">
		// 					<h3 class="title" id="title-catg">${catg.textContent}</h3>
		// 				</div>
		// 			</div>
		// 		`;
		// 		if (catg.textContent === 'All Products') {
		// 			products.forEach(function(pro) {
		// 				displayProducts(pro);
		// 			});
		// 		} else {
		// 			products.forEach(function(pro) {
		// 				// console.log(catg.textContent);
		// 				// console.log();
		// 				if (pro['catg'] === catg.textContent) displayProducts(pro);
		// 			});
		// 		}
		// 	});
		// });
		/* Search of Products */
		let search = document.getElementById('search-input');
		search.addEventListener('keyup', function() {

			let myRequest = new XMLHttpRequest();
			myRequest.open("GET", "admin/ajaxConn.php?liveSearch=" + search.value, true);
			myRequest.onreadystatechange = function() {
				if (this.readyState === 4 && this.status === 200) {
					// result = JSON.parse(this.responseText);
					if (this.responseText != "") {
						menu.innerHTML = '';
						JSON.parse(this.responseText).forEach(function(pro) {
							displayProducts(pro);
						});
					} else {
						menu.innerHTML = `
							<div class="col-md-12">
								<div class="section-title text-center">
									<h3 class="title" id="title-catg">ALl Products</h3>
								</div>
							</div>
				`;
						products.forEach(function(pro) {
							displayProducts(pro);
						});
					}

				}
			}
			myRequest.send();
		});

		function addToCart(ref) {
			let myRequest = new XMLHttpRequest();
			myRequest.open("GET", "ajax.php?ref=" + ref, true);
			myRequest.onreadystatechange = function() {
				if (this.readyState === 4 && this.status === 200) {
					console.log(this.responseText);
				}
			}
			myRequest.send();
		}

		/* Pagination */
		let itemsPerPage = 4;
		let nbrOfPages = Math.ceil(products.length / itemsPerPage);
		let pagination = document.getElementById('pagination');
		for (let i = 0; i < nbrOfPages; i++) {
			let liNbr = document.createElement('li');
			liNbr.className = 'list-group-item list';
			liNbr.textContent = i + 1;
			pagination.appendChild(liNbr);
		}

		let allList = document.querySelectorAll('.list');
		allList.forEach(function(oneList) {
			oneList.addEventListener('click', function() {
				menu.innerHTML = `
							<div class="col-md-12">
								<div class="section-title text-center">
									<h3 class="title" id="title-catg">ALl Products</h3>
								</div>
							</div>
				`;
				for (let i = itemsPerPage * (Number(oneList.textContent) - 1); i < itemsPerPage * (Number(oneList.textContent)); i++) {
					displayProducts(products[i]);
				}
			});
		});


		/* End Of Pagination */
	</script>


</body>

</html>