<?php
	ob_start();
	error_reporting(E_ALL);
	session_start();
	require('../class/autoload.php');

	$getLog = new connectDB();

	$user_id = $_SESSION['user_id'];
	$role = $_SESSION['role'];

	if(!isset($_SESSION['user_id'])){
		header('location: ../index.php');
	}	

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<title>Profile | Setting</title>
	<?php include('_css.php');?>
</head>
<body>

	<?php
		if($role == 1){
			include('../admin/_admin_sidenav.php');
		}else if($role == 2){
			include('../customer/_cust_sidenav.php');//side nav
		}
		
	?>

	<div id="main">
		<?php 
			if($role == 1){
				include('../admin/_admin_topnav.php');
			}else if($role == 2){
				include('../customer/_cust_nav.php'); //topnav
			}
			
		?>
		<div class="container-fluid my-5">
			<div class="row">
				<div class="col-xl-11 col-md-11 shadow mx-auto">
					<div class="card border-info shadow">
						<div class="card-header">
							<h3 class="font-buxton">Activity log</h3>
						</div>
						<div class="card-body">

							<div style="overflow-x: auto;">
								<table class="table table-striped table-bordered mt-4 myDataTable" style="width:100%;">
									<thead>
										<tr class="text-center font-buxton">
											<th>#</th>
											<th>Activity Log</th>
											<th>Date</th>
											
										</tr>
									</thead>
									<tbody>

										<?php
											$getLog-> getDisplayActivtylog($user_id);
										?>
										
									</tbody>
									<tfoot>
										<tr class="text-center font-buxton">
											<th>#</th>
											<th>Activity Log</th>
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
	</div>

	<?php

		include('../customer/_cust_footer.php');
		ob_flush();

	?>