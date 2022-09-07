<?php
	ob_start();
	error_reporting(E_ALL);
	session_start();
	require('../class/autoload.php');
	$user_id = $_SESSION['user_id'];
	$role = $_SESSION['role'];

	$getInventory = new connectDB();

	if($_SESSION['user_id']){
		if($role == 1){
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<title>TBLph | Inventory</title>

	<?php
		include('_css.php'); //adding the css file.
	?>

</head>
<body>
	<?php
		include('_admin_sidenav.php');//adding side nav
	?>

	<!-- main-->
	<div id="main">

		<?php 
			include('_admin_topnav.php'); //adding top nav
		?> 

		<!-- Content -->
		<div class="container-fluid my-5">
			
			<div class="row">
				<div class="col-xl-10 col-md-8 mx-auto">
					<div class="card border border-info rounded shadow h-100 pb-3 justify-content-center">
						<div class="card-header font-buxton mb-3 shadow-sm">
							<h5>Product Inventory</h5>
						</div>
						<div class="card-body">	

							<div style="overflow-x: auto;">
								<table class="table table-striped table-bordered mt-4 myDataTable" style="width:100%;">
									<thead>
										<tr class="text-center font-buxton">
											<th>#</th>
											<th>Product ID</th>
											<th>Product Name</th>
											<th>Added Product</th>
											<th>Sold Productk</th>
											<th>Current Stock</th>
											<th>Date</th>
										</tr>
									</thead>
									<tbody>

										<?php
											$getInventory -> getInventory();
										?>
										
									</tbody>
									<tfoot>
										<tr class="text-center font-buxton">
											<th>#</th>
											<th>Product ID</th>
											<th>Product Name</th>
											<th>Added Product</th>
											<th>Sold Productk</th>
											<th>Current Stock</th>
											<th>Date</th>
										</tr>
									</tfoot>
								</table>
							</div>											

						</div>						
					</div>
				</div>
			</div>

		</div>
		<!-- Content -->

		<?php include('_admin_footer.php'); ?>

	</div>
	<!-- ./ main -->

	<?php
		}else{
			header('location: ../customer/cust_index.php');
			ob_flush();
		}
	}else{
		header('location: ../index.php');
		ob_flush();
	}
	?>

</body>
</html>