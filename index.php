<?php
	ob_start();
	error_reporting(E_ALL);
	session_start();
	require_once("class/autoload.php");

	$getDisplayIndex = new connectDB();

	if(isset($_SESSION['user_id'])){
		if($_SESSION['role'] == 1){
			header('Location: admin/admin_index.php');
		}
		header('Location: customer/cust_index.php');
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>TBLph</title>

	<?php include('template/_css.php'); ?>
</head>
<body>
	
	<?php
		include('template/_nav.php');
	?>

	<!-- Header -->
	<header class="masthead">
		<div class="container px-4 px-lg-5 h-100">
			<div class="row h-100 align-items-center justify-content-center text-center">
				<div class="col-lg-8 align-self-end">
					<h1 class="text-white font-weight-bold font-buxton font-size-24">
					   The Local Bookstore ph
					</h1>
					<hr class="divider" />
				</div>
				<div class="col-lg-8 align-self-baseline">
					<p class="text-white-50 mb-5">
					   Start your shopping now. We offer different products from school supplies to your office supplies.
					</p>
					<a class="btn btn-warning btn-lg badge-pill text-light" href="#products">
						<i class="fas fa-shopping-cart"></i> &nbsp;Shop now
					</a>
				</div>
			</div>
		</div>
	</header>
	<!-- #Header -->

	<!-- Products -->
	<span id="products"></span>
	<div class="container-fluid mt-5">
		<div class="row px-4 px-lg-5">
			<h3 class="font-buxton">Top Selling Products</h3>
			<div class="owl-carousel owl-theme">

				<!-- Populate products-->
				<?php
					$getDisplayIndex ->indextopSelling();
				?>
				<!-- Populate products-->

			</div>
		</div>
	</div>

	<!-- Products -->

	<!-- All products -->
	<div class="container-fluid py-5 mt-2" >
		<div class="row px-4 px-lg-5">
			<h3 class="font-buxton">All Products</h3>
			<div class="btn-group ml-auto" id="sort">
				<h5 class="font-buxton font-size-16">sort by:</h5>
				<button class="btn font-buxton font-size-24" data-sort-by="name">name</button>
				<button class="btn font-buxton font-size-24" data-sort-by="price">price</button>
			</div>
		</div>

		<div  class="row px-4 px-lg-5">
			<div class="col-lg-10">
				<div class="grid">

				<!-- Populate products-->
				<?php
					$getDisplayIndex ->getDisplayIndex();
				?>
				<!-- Populate products-->

				</div>
			</div>
		</div>
	</div>

	<!-- All products -->

	<?php 

		include('template/_footer.php'); // adding footer including the js file

	?>
</body>
</html>