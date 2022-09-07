<?php
	ob_start();
	error_reporting(E_ALL);
	session_start();
	require('../class/autoload.php');

	$cart = new connectDB();

	$user_id = $_SESSION['user_id'];

	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		if(isset($_POST['delete-cart-submit'])){
			$prod_id = $_POST['item_id'];
			$cart->delCart($user_id, $prod_id);
		}

		if(isset($_POST['edit-cart-submit'])){
			$prod_id = $_POST['item_id'];
			header('location: addcart.php?prod_id='.$prod_id);
		}
	}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<title>TBLph | Cart</title>

	<?php include('_css.php');?>

</head>
<body>

	<div id="main">
		<?php
			include('_cust_sidenav.php');
		 	include('_cust_nav.php');
		 ?>

		<div class="container-fluid">
			<!-- Row Content-->
			<div class="row">

				<!-- main Column content-->
				<div class="col-xl-11 col-md-11 my-2 py-4 mx-auto">
					<div class="card shadow h-100">
						<div class="card-header shadow">
							<h3 class="font-buxton">Shopping cart</h3>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="container">
									<div class="row">

										<div class="col-xl-8 col-md-8 py-2">
											<div class="card py-2">
												<div class="card-body">
													<div class="row">
													<?php
														$Cart = new connectDB();

														if($Cart->checkCart($user_id)){
															$Cart->getCart($user_id);
														}else{
													?>
													
														<div class="col-xl-10 col-md-10 align-items-center justifiy-align-center">
															<img src="../assets/empty_cart.png" class="img-fluid" width="500" height="400">
														</div>
														<?php 
															} //closing of contition
														?>
													</div>
												</div>
											</div>
										</div>

										<div class="col-xl-4 col-md-4 mx-auto py-2">
											<h4 class="font-rubik font-size-14">
												Total items: 
												<?php

												$countItems = new connectDB();

												$countItems->getcountCart($user_id);

												?>
											</h4>
											<h3 class="font-rubik font-size-20">
												Subtotal:
												<?php

												$getTotal = new connectDB();

												$getTotal->getTotalCart($user_id);

												?>
											</h3>
										</div>
										
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- main Column content-->

			</div>
			<!-- Row Content-->
		</div>

		 <?php include('_cust_footer.php');?>
	</div>

</body>
</html>

