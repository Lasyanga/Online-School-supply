<?php
	ob_start();
	error_reporting(E_ALL);
	session_start();
	require('../class/autoload.php');

	$delId = $prod_id = $addstock ="";

	$user_id = $_SESSION['user_id'];
	$role = $_SESSION['role'];

	$getProdlist = new connectDB();

	if (isset($_GET['del'])) {
		$delId = $_GET['del'];

		$getDelete = new connectDb();
		$getDelete->getDelProduct($delId);
	}

	if(isset($_POST['add_stock'])){
		$prod_id  = test_input($_POST['prod_id']);
		$addstock = test_input($_POST['addstock']);

		$addUpdate = new connectDB();
		$addUpdate->updatingStock($prod_id, $addstock, $user_id);
	}

	function test_input($data){
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
		include('_css.php'); //adding css 
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
				<div class="col-xl-11 col-md-11 mx-auto">
					<div class="card border border-info rounded shadow h-100 pb-3 justify-content-center">
						<div class="card-header font-buxton mb-3 shadow-sm">
							<h5>All Products</h5>
						</div>
						<div class="card-body">
							
							<?php if(isset($_SESSION['message'])):?>
								<div class="alert alert-success alert-dismissible">
									<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
								 	<?php
								 		echo $_SESSION['message'];
								 		unset($_SESSION['message']);
								 	  ?>
								</div>
							<?php endif;?>

							<div style="overflow-x: auto;">
								<table class="table table-striped table-bordered mt-4 myDataTable" style="width:100%;">
									<thead>
										<tr class="text-center font-buxton">
											<th>#</th>
											<th>Product ID</th>
											<th>Product Name</th>
											<th>Price</th>
											<th colspan="2">Stock</th>
											<th>Description</th>
											<th>Image</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>

										<?php
											$getProdlist -> getProducts();
										?>
										
									</tbody>
									<tfoot>
										<tr class="text-center font-buxton">
											<th>#</th>
											<th>Product ID</th>
											<th>Product Name</th>
											<th>Price</th>
											<th colspan="2">Stock</th>
											<th>Decription</th>
											<th>Image</th>
											<th>Action</th>
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

		<!-- Modal for adding stock -->
		<div class="modal" id="stock">
		  <div class="modal-dialog">
		    <div class="modal-content">

		      <!-- Modal Header -->
		      <div class="modal-header">
		        <h4 class="modal-title">
		        	Add stock
		        </h4>
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		      </div>

		      <!-- Modal body -->
		      <div class="modal-body">
		      	<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
		      		 <input type="hidden" name="prod_id" value=""/>
		      		 <div class="form-group">
		      		 	<input type="number" name="addstock" min="1" class="form-control" placeholder="Input stock" required/>
		      		 </div>
		      		 <div class="form-group">
		      		 	<input type="submit" name="add_stock" value="Add" title="Add stock" class="form-control btn btn-primary" />
		      		 </div>
		      	</form>
		      
		      </div>

		      <!-- Modal footer -->
		      <div class="modal-footer">
		        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
		      </div>

		    </div>
		  </div>
		</div>
		<!-- Modal for adding stock -->
		<?php include('_admin_footer.php'); ?>



	</div>
	<!-- ./ main -->


	<script type="text/javascript">
		  $('#stock').on('show.bs.modal', function(e) {
        		var prod_id = $(e.relatedTarget).data('prod_id');
       		 $(e.currentTarget).find('input[name="prod_id"]').val(prod_id);
    		});

	</script>

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



    <!--     $("#submit").click(function () {
            var name = $("#name").val();
            var marks = $("#marks").val();
            var str = "You Have Entered " 
                + "Name: " + name 
                + " and Marks: " + marks;
            $("#modal_body").html(str);
        }); -->