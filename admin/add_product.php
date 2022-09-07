<?php
	ob_start();
	error_reporting(E_ALL);
	session_start();
	require('../class/autoload.php');
	$role = $_SESSION['role'];
	$user_id = $_SESSION['user_id'];

	$prod_img = $name = $price = $stock = $desc="";
	$btnUpdate = false;

	if(isset($_POST['up_prod'])){//updating product
		$updateProduct = new connectDB();

		$file = $_FILES['Toupdate']['name'];
		$extension = pathinfo($file, PATHINFO_EXTENSION);
		$rename = rand(0, 100000).date('Ymd').rand(1, 1000);
		$newfilename = $rename.'.'.$extension; // change filename


		$ftemp = $_FILES['Toupdate']['tmp_name'];//current time path

		$prod_name = test_input($_POST['prod_name']);
		$prod_desc = test_input($_POST['prod_desc']);
		$prod_price = test_input($_POST['prod_price']);
		$prod_stock = test_input($_POST['prod_stock']);
		$prod_id = $_SESSION['prod_id'];		

		if(!empty($file)){
			$updateProduct->updateProductwImg($prod_id, $prod_name, $prod_price, $prod_desc, $prod_stock, $newfilename, $ftemp, $user_id);
		}else{
			$updateProduct->updateProduct($prod_id, $prod_name, $prod_price, $prod_desc, $prod_stock,$user_id);
		}		
	}//updating product

	if(isset($_GET['edit'])){// preparing for edit
		$prod_id = $_GET['edit'];
		$btnUpdate = true;

		$setToEdit = new connectDB();

		$setToEdit->setEditProduct($prod_id);

		$id = $_SESSION['prod_id'];
		$name = $_SESSION['prod_name'];
		$price = $_SESSION['prod_price'];
		$desc = $_SESSION['prod_desc'];
		$stock = $_SESSION['prod_stock'];
		$prod_img = $_SESSION['prod_img'];

	}// preparing for edit

	if (isset($_POST['add_prod'])){ //adding product
		$prod_id = 'prod-'.date('Ymd').rand(1, 1000);
		$addProduct = new connectDB();	

		$file = $_FILES['fileToupload']['name'];
		$extension = pathinfo($file, PATHINFO_EXTENSION);
		$rename = rand(0, 100000).date('Ymd').rand(1, 1000);
		$newfilename = $rename.'.'.$extension; // change filename


		$ftemp = $_FILES['fileToupload']['tmp_name'];

		$prod_name = test_input($_POST['prod_name']);
		$prod_desc = test_input($_POST['prod_desc']);
		$prod_price = test_input($_POST['prod_price']);
		$prod_stock = test_input($_POST['prod_stock']);


		$addProduct->addNewProduct($prod_id, $prod_name, $prod_price, $prod_desc, $prod_stock, $newfilename, $ftemp, $user_id);

	} // adding product	


	function test_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}

	if($_SESSION['user_id']){
		if($role == 1){

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<title>TBLph | Manage Products</title>

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
							<h5>Add New Product</h5>
						</div>
						<div class="card-body">

							<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
								<div class="row px-3">

									<div class="col-xl-4 col-md-12 mx-auto">

										<?php if(isset($_GET['edit'])):?>
											<img src="../uploads/products/<?php echo $_SESSION['prod_img'];?>" class="border border-primary img-fluid shadow" id="prevImage" /><br>

											<span id="updImgbtn"></span>

											<button type="button" class="btn btn-primary my-2" onclick="updateImg();" id="btnUpImg" style="display:block;">Update Image</button>

										<?php else:?>
											<img src="../assets/imgplaceholder.png" 
												class="border border-primary img-fluid shadow" 
												id="prevImage"
												onclick="triger();" /><br>
											<input type="file" name="fileToupload" accept="image/*" class="form-control my-2" id="prodImg" onchange="displayImage(this);">
										<?php endif;?>

									</div>

									<div class="col-xl-8 col-md-12">
										<div class="form-group">
											<input type="text" name="prod_name" value="<?php echo $name;?>" class="form-control" placeholder="Product name" required>
										</div>
										<div class="form-group">
											<input type="number" name="prod_price" value="<?php echo $price;?>" class="form-control" placeholder="Price" min="1" required>
										</div>
										<div class="form-group">
											<input type="number" name="prod_stock" value="<?php echo $stock;?>"  class="form-control" placeholder="Stock" min="1" required>
										</div>
										<div class="form-group">
										 	<label for="desc">Product Description:</label>
										  <textarea class="form-control" rows="4" id="desc" name="prod_desc" required><?php echo $desc;?></textarea>
										</div> 

										<div class="form-group">
											<?php if(isset($_GET['edit'])):?>
										 		<button type="submit" name="up_prod" class="btn btn-primary btn-block">Update Product</button>
										 	<?php else:?>
										 		<input type="submit" name="add_prod" value="Add New Product" class="btn btn-primary btn-block">
										 	<?php endif;?>
										</div> 

									</div>
								</div>								
							</form>

						</div>						
					</div>
				</div>
			</div>

		</div>
		<!-- Content -->

		<?php include('_admin_footer.php'); ?>
    </script>

		<script type="text/javascript">

			//show update btn for img
			function updateImg(){
				var file ='<input type="file" name="Toupdate" class="form-control" accept="image/*" onchange="displayImage(this)" required/>';
				document.querySelector('#updImgbtn').innerHTML = file;
				document.querySelector('#btnUpImg').style.display = 'none';
			}


			//placeholder click
			function triger(){
				document.querySelector('#prodImg').click();
			}

			/*preview product*/
			function displayImage(e){
			    if(e.files[0]){
			        var reader = new FileReader();

			        reader.onload = function(e){
			            document.querySelector('#prevImage').setAttribute('src', e.target.result);
			        }

			        reader.readAsDataURL(e.files[0]);
			    }
			}
		</script>

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
