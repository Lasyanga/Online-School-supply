	<?php 
		if(isset($_GET['user'])){
			$_SESSION['inProfile'] = 1;
		}

		if(isset($_SESSION['inProfile']) == 1){
	?>
			<div id="mySidenav" class="sidenav text-decoration-none font-buxton">
				<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
				
				<div class="text-justify text-center pb-3">
					<span class="fas fa-user" style="font-size: 100px;"></span>
				</div>
				<a class="btn btn-block btn-dark-50 py-1 text-center" href="../admin/admin_index.php">DashBoard</a>
				
				<div class="dropdown">
					<a href="#" class="btn btn-dark-50 btn-block dropdown-toggle" data-toggle="dropdown">
					Manage Products
					</a>
					<div class="dropdown-menu dropdown-menu-right py-0">
						<a class="dropdown-item bg-dark btn btn-dark-50 py-0 mt-0 btn-block" href="../admin/add_product.php">Add New Product</a>
						<a class="dropdown-item bg-dark btn btn-dark-50 py-0 mt-0 btn-block" href="../admin/view_product.php">View Products</a>
					</div>
				</div> 	
				
				<a class="btn btn-block btn-dark-50" href="#">Manage Customer</a>
				<a class="btn btn-block btn-dark-50" href="../admin/view_inventory.php"><span class="fas fa-warehouse"></span>&nbsp;Manage Inventory</a>
				<a class="btn btn-block btn-dark-50" href="#"><span class="fas fa-shipping-fast"></span>&nbsp;Manage Delivery</a>
			</div>


	<?php 
		}else{ ?>
		
		<div id="mySidenav" class="sidenav text-decoration-none font-buxton">
			<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
			
			<div class="text-justify text-center pb-3">
				<span class="fas fa-user" style="font-size: 100px;"></span>
			</div>
			<a class="btn btn-block btn-dark-50 py-1 text-center" href="admin_index.php">DashBoard</a>
			
			<div class="dropdown">
				<a href="#" class="btn btn-dark-50 btn-block dropdown-toggle" data-toggle="dropdown">
				   Manage Products
				</a>
			  	<div class="dropdown-menu dropdown-menu-right py-0">
			    	<a class="dropdown-item bg-dark btn btn-dark-50 py-0 mt-0 btn-block" href="add_product.php">Add New Product</a>
			   		<a class="dropdown-item bg-dark btn btn-dark-50 py-0 mt-0 btn-block" href="view_product.php">View Products</a>
			  	</div>
			</div> 	
			
			<a class="btn btn-block btn-dark-50" href="#">Manage Customer</a>
			<a class="btn btn-block btn-dark-50" href="view_inventory.php"><span class="fas fa-warehouse"></span>&nbsp;Manage Inventory</a>
			<a class="btn btn-block btn-dark-50" href="#"><span class="fas fa-shipping-fast"></span>&nbsp;Manage Delivery</a>
		</div>
	<?php }?>


	