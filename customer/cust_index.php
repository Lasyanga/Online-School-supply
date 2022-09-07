<?php
	ob_start();
	error_reporting(E_ALL);
	session_start();
	require ('../class/autoload.php');
	$getDisplayCust = new connectDB();

	$user_id = $_SESSION['user_id'];
	$role = $_SESSION['role'];

	if(isset($_GET['logout'])==1){
		session_unset();
		session_destroy();
	}	
	 
	if(isset($_SESSION['user_id'])){
	 	if($role == 2){
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<title>TBLph | Home</title>
	<?php include('_css.php'); //adding the css?>
</head>
<body>

	<?php include('_cust_sidenav.php');//side nav?>

	<div id="main">
		<?php include('_cust_nav.php'); //topnav?>

		<div class="container-fluid">
			<!-- Row Content-->
			<div class="row">

				<div class="col-xl-11 col-md-8 my-4 mx-auto shadow"><!-- main Column content-->

					<div class="row">
						<div class="col-xl-11 col-md-10 mx-auto">
							<h3 class="font-buxton">Top Selling Products</h3>
							<div class="owl-carousel owl-theme mx-auto">

							<?php
								$getDisplayCust->topSelling();
							?>						

							</div>
						</div>	

					</div>

									
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
							<div class="col-xl-10">
								<div class="grid col-xl-12 col-md-8 mx-auto">
									<!-- Populate products-->
									<?php
										$getDisplayCust ->getDisplayCust();
									?>
									<!-- Populate products-->	
								</div>
							</div>
						</div>
					</div>	

				</div><!-- main Column content-->


			</div>
			<!-- Row Content-->				
		</div>

		<?php include('_cust_footer.php'); //footer contain js file
			}else{
				header('location: ../admin/admin_index.php');
				ob_flush();
			}
		}else{
			header('location: ../index.php');
			ob_flush();
		}
		?>	
	</div>

	

</body>
</html>