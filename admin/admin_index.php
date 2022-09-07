<?php
	ob_start();
	error_reporting(E_ALL);
	session_start();
	require('../class/autoload.php');

	$user_id = $_SESSION['user_id'];
	$role = $_SESSION['role'];
	
	$getProdCount = new connectDB();

	if(isset($_SESSION['user_id'])){
		if($role == 1){

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<title>TBlph | Admin</title>

	<?php
		include('_css.php'); //adding the css file.
	?>

</head>
<body>
	
	<?php
		include('_admin_sidenav.php');//adding side nav
	?>	

	<div id="main">
		<?php 
			include('_admin_topnav.php'); //adding top nav
		?> 

		<!-- Content -->
		<div class="container-fluid">
			
			<div class="d-sm-flex align-items-center justify-content-between mb-4">
				<h1 class="mb-0 text-dark-50 font-buxton"></h1>				
			</div>

			<!-- Content Row -->
			<div class="row">

				<div class="col-xl-6 col-md-6">
					<div class="col-xl-12 col-md-12 mb-4">
						<div class="card border border-primary border-top-0 border-right-0 shadow h-100 py-2">
							<div class="card-body">
								<div class="row align-items-center">
									<div class="col mr-2">
										<div class="text-xs font-weight-bold text-primary text-uppercase mb-1 font-buxton">
											Products
										</div>
										<div class="h-25 mb-0 font-weight-bold text-black-50">
											<?php
												$getProdCount->getCountProduct();
											?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-12 col-md-12 mb-4">
						<div class="card border border-secondary border-top-0 border-right-0 shadow h-100 py-2">
							<div class="card-body">
								<div class="row align-items-center">
									<div class="col mr-2">
										<div class="text-xs font-weight-bold text-secondary text-uppercase mb-1 font-buxton">
											Inventory
										</div>
										<div class="h-25 mb-0 font-weight-bold text-black-50">20</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					
				</div>


				<div class="col-xl-6 col-md-6">

					<div class="col-xl-12 col-md-12 mb-4">
						<div class="card border border-success border-top-0 border-right-0 shadow h-100 py-2">
							<div class="card-body">
								<div class="row align-items-center">
									<div class="col mr-2">
										<div class="text-xs font-weight-bold text- text-uppercase mb-1 font-buxton text-success-50">
											Delivery
										</div>
										<div class="h-25 mb-0 font-weight-bold text-black-50">20</div>
									</div>
									<div class="col-auto">
	                                    <span class="fas fa-shipping-fast text-black-50"></span>
	                                </div>
								</div>
							</div>
						</div>
					</div>

				<div class="col-xl-12 col-md-12 mb-4">
					<div class="card border border-success border-top-0 border-right-0 shadow h-100 py-2">
						<div class="card-body">
							<div class="row align-items-center">
								<div class="col mr-2">
									<div class="text-xs font-weight-bold text- text-uppercase mb-1 font-buxton">
										Client
									</div>
									<div class="h-25 mb-0 font-weight-bold text-black-50">20</div>
								</div>
								<div class="col-auto">
                                    <span class="fas fa-shipping-fast text-black-50"></span>
                                </div>
							</div>
						</div>
					</div>
				</div>
					
				</div>
				
				

			</div>
			<!-- ./Content Row -->

		</div>
		<!-- /Content-->
		
		<?php 
		include('_admin_footer.php');
	}else{
		header('location: ../customer/cust_index.php');
	}
	}else{
		header('location: ../index.php');
	}
	ob_flush();
	?>
	</div>
 

</body>
</html>

