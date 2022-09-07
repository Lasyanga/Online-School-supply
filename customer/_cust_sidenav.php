
 <?php 

 	if(isset($_GET['cust'])){
 		$_SESSION['inProfile'] = 1;
 	}

 	if(isset($_SESSION['inProfile']) == 1){
 ?>


	<div id="mySidenav" class="sidenav text-decoration-none font-buxton">
			<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
			
			<div class="text-justify text-center pb-3">
				 <img src="../uploads/user_profile/<?php echo $_SESSION['img']?>" class="img-fluid rounded-circle" alt="profile" title="Profile picture" width="200px" height="200px"> 
			</div>
			<a class="btn btn-block btn-dark-50 py-1 text-center" href="../customer/cust_index.php">Home</a>		
			<a class="btn btn-block btn-dark-50" href="../customer/cart.php">
				View Cart 

				<span class="badge badge-pill badge-danger">
					&nbsp;<i class="fas fa-shopping-cart"></i>
					<span class="badge badge-pill badge-primary">
					<?php

						$countItems = new connectDB();
						$countItems->getcountCart($user_id);
						?>
						
					</span>
				</span>

				
			</a>
			<a class="btn btn-block btn-dark-50" href="#"><span class="fas fa-shipping-fast"></span>&nbsp;Manage Delivery</a>
		</div> 
		

	<?php } else{?>
		<div id="mySidenav" class="sidenav text-decoration-none font-buxton">
			<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
			
			<div class="text-justify text-center pb-3">
				  <img src="../uploads/user_profile/<?php echo $_SESSION['img']?>" class="img-fluid rounded-circle" alt="profile" title="Profile picture" width="200px" height="200px">
			</div>
			<a class="btn btn-block btn-dark-50 py-1 text-center" href="cust_index.php">Home</a>		
			<a class="btn btn-block btn-dark-50" href="cart.php">
				View Cart 

				<span class="badge badge-pill badge-danger">
					&nbsp;<i class="fas fa-shopping-cart"></i>
					<span class="badge badge-pill badge-primary">
					<?php

						$countItems = new connectDB();
						$countItems->getcountCart($user_id);
						?>
						
					</span>
				</span>

				
			</a>
			<a class="btn btn-block btn-dark-50" href="#"><span class="fas fa-shipping-fast"></span>&nbsp;Manage Delivery</a>
		</div> 
	<?php } ?>