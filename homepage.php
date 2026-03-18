<?php
session_start();
include_once("connection.php");
?>

<!DOCTYPE html>
<html>

<head>
	<title>Home</title>
	<link rel="stylesheet" href="styles.css">
	<style>
		#navbar-left button img,
		#navbar-right a img {
			filter: invert(1);
		}


		body.sidebar-open #navbar-left button img {
			filter: invert(0);
		}

		#navbar a,
		#navbar a:link,
		#navbar a:visited,
		#navbar a:hover,
		#navbar a:active {
			color: #fff;
		}

		#homepage-banner {
			width: calc(100% + 40px);
			height: 95vh;
			margin: -70px -20px 0;
			background-image: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url("images/content/home-banner.png");
			background-size: cover;
			background-position: center;
			background-repeat: no-repeat;
			display: flex;
			align-items: center;
			justify-content: center;
			position: relative;
		}

		.homepage-banner-content {
			display: flex;
			flex-direction: column;
			align-items: center;
			gap: 12px;
			z-index: 10;
		}

		#homepage-banner h1 {
			text-align: center;
			font-size: 60px;
			font-weight: 300;
			margin: 0;
			color: #fff;
		}

		.homepage-banner-divider {
			width: 60%;
			height: 2px;
			background-color: #fff;
			margin-top: -16px;
		}

		#homepage-banner-arrow {
			position: absolute;
			left: 50%;
			bottom: 18px;
			transform: translateX(-50%);
			width: 20px;
			height: auto;
			opacity: 0.65;
			filter: invert(1);
		}


		#homepage-products-feature {
			display: flex;
			align-items: center;
			gap: 48px;
			padding: 48px 40px 0;
			box-sizing: border-box;
		}

		#homepage-products-image {
			width: 50%;
			border-radius: 8px;
			display: block;
		}

		#homepage-products-copy {
			flex: 1;
		}

		#homepage-products-copy h1 {
			margin: 0 0 10px 0;
		}

		.homepage-products-divider {
			width: 90px;
			height: 1px;
			background-color: #7e7e7e;
			margin: 0 0 14px 0;
		}

		#homepage-products-copy p {
			margin: 0 0 18px 0;
		}

		#homepage-products-copy form {
			margin: 0;
		}

		#homepage-products-copy form button {
			margin-left: 0;
		}

		@media (max-width: 900px) {
			#homepage-products-feature {
				flex-direction: column;
				align-items: flex-start;
			}

			#homepage-products-image {
				width: 100%;
			}
		}
	</style>
</head>
<body>


<?php
include_once("navbar.php");
?>

<div id="main-content">
	<div id="homepage-banner">
		<div class="homepage-banner-content">
			<h1>Jazze's Shop</h1>
			<div class="homepage-banner-divider"></div>
		</div>
		<img id="homepage-banner-arrow" src="images/content/dropdown-arrow.png" alt="Scroll down">
	</div>

	<div id="homepage-products-feature">
		<img id="homepage-products-image" src="images/content/products-banner.png" alt="Products">

		<div id="homepage-products-copy">
			<h1>Products</h1>
			<div class="homepage-products-divider"></div>
			<p>Shop Artwork & Clothing</p>
			<form method="get" action="displayproducts.php">
				<button type="submit">Shop Now</button>
			</form>
		</div>
	</div>
</div>


</body>
</html>



