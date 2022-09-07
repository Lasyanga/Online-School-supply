<?php
	ob_start();
	error_reporting(E_ALL);
	session_start();
	require('class/autoload.php');

	if($_SERVER["REQUEST_METHOD"] == "POST") {
		if(isset($_POST['addCart'])){
			$prod_id = $_POST['prod_to_cart'];
			$qty = $_POST['qty'];

			$_SESSION['prod_id'] = $prod_id;

			header('location: login.php');

	}	}

	if(isset($_GET['prod_id'])){
		$prod_id = $_GET['prod_id'];
		$cart = new connectDB();

		$cart->prepareAddToCart($prod_id);

		$name = $_SESSION['name'];
		$desc = $_SESSION['description'];
		$price = $_SESSION['price'];
		$img = $_SESSION['prod_img'];
	}

	if(isset($_SESSION['user_id'])){
		if($_SESSION['role']==1){
			header('location: admin/admin_index.php');
		}
		header('location: customer/cust_index.php');
	}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Cart | TBLph</title>
	<?php include('template/_css.php'); ?>
</head>
<body>

	<?php
		include('template/_nav.php');
	?>

	<div class="container-fluid">
			<div class="row">
				<div class="col-xl-8 col-md-8 mx-auto py-5">
					<div class="card shadow h-100">
						<div class="card-header font-buxton font-size-20 shadow">
							Add to Cart
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-xl-4 col-md-4 align-items-center mh-100 mx-auto">
									 <?php if (isset($_GET['prod_id'])): ?>
									 	<img src="uploads/products/<?php echo $img;?>" class="img-fluid thumbnail" />
									<?php endif; ?>
									
								</div>
								<div class="col-xl-8 col-md-8 my-3">
									<h3 class="font-buxton font-size-20"><?php echo $name; ?></h3>
									<p class="font-baloo font-size-14"><?php echo $desc; ?></p>
									<h2 class="font-rubik font-size-20 text-danger"><?php echo $price;?> &nbsp;pesos only</h2>
									<h4 for="sel1" class="font-baloo font-size-14">Qty:</h4>
									
									<form method="post">
										<div class="row">
											 	<div class="form-group">
													<select class="form-control" id="sel1" name="qty">
											    		<option value="1" selected>1</option>
											    		<option value="2">2</option>
											    		<option value="3">3</option>
											    		<option value="4">4</option>
											    		<option value="5">5</option>
											    		<option value="6">6</option>
											    		<option value="7">7</option>
											    		<option value="8">8</option>
											    		<option value="9">9</option>
											    		<option value="10">10</option>
													</select>
												</div> 
											<div class="col-xl-4 col-md-4 ml-auto mt-2">											
												<input type="hidden" name="prod_to_cart" value="<?php echo $prod_id;?>">
												<button type="submit" name="addCart" class="btn btn-warning btn-block">Add to Cart&nbsp;<i class="fas fa-shopping-cart"></i></button>
											</div>
										</div>
									</form>									
								</div>
							</div>
						</div>
					</div>
				</div>				
			</div>
		</div>

	<?php 

		include('template/_footer.php'); // adding footer including the js file

	?>

</body>
</html>