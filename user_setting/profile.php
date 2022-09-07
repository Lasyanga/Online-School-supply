<?php
	ob_start();
	error_reporting(0); // change this to error_reporting(E_ALL) to display error on the page
	session_start();
	require ('../class/autoload.php');

	$user_id = $_SESSION['user_id'];
	$role = $_SESSION['role'];

	$fname = $lname = $contact = $bdate = $adrs = $img = $email = $user = "";
	
	if(isset($_SESSION['user_id'])){
		$Profile = new connectDB();

		$Profile->getProfile($user_id);

		$fname = $_SESSION['fname'];
		$lname = $_SERVER['lname'];
		$contact = $_SESSION['contact'];
		$adrs = $_SESSION['address'];
		$img = $_SESSION['img'];
	}

	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		if(isset($_POST['updateProfile'])){

			$updateProfile = new connectDB();


			$fname = test_input($_POST['fname']);
			$lname = test_input($_POST['lname']);
			$contact = test_input($_POST['contact']);
			$adrs = test_input($_POST['address']);

			$file = $_FILES['Toupdate']['name'];

			$extension = pathinfo($file, PATHINFO_EXTENSION);
			$rename = rand(0, 100000).date('Ymd').rand(1, 1000);
			$newfilename = $rename.'.'.$extension; // change filename

			$ftemp = $_FILES['Toupdate']['tmp_name'];//current path of img

			if(!empty($file)){
				$updateProfile->setUpdateProfile_wImg($user_id, $fname, $lname, $contact, $adrs, $newfilename, $ftemp);
			}else{
				$updateProfile->setUpdateProfile_nImg($user_id, $fname, $lname, $contact, $adrs, $user);
			}
		}
	}


	function test_input($data){
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);

		return $data;
	}

	if(isset($_SESSION['user_id'])){

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
				<div class="col-xl-8 col-md-8 shadow mx-auto">
					<div class="card border-info shadow">
						<div class="card-header">
							<h3 class="font-buxton">Profile</h3>
						</div>
						<div class="card-body">
							<?php if(isset($_SESSION['success'])):?>
								<div class="alert alert-success">
									<button type="button" class="close" data-dismiss="alert">&times;</button>
								  <?php
								  	echo $_SESSION['success'];
								  	unset($_SESSION['success']);

								  ?>
								</div>
							<?php endif;?>
							<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
								<div class="row px-3">

									<div class="col-xl-4 col-md-12 mx-auto align-items-center">

										<?php if(isset($_SESSION['img'])):?>
											<img src="../uploads/user_profile/<?php echo $_SESSION['img'];?>" class="border border-primary img-fluid shadow img-thumbnail" id="prevImage" /><br>

											<span id="updImgbtn"></span>

											<button type="button" class="btn btn-primary btn-block my-2" onclick="updateImg();" id="btnUpImg" style="display:block;">Update Image</button>

										<?php else:?>
											<img src="../assets/imgplaceholder.png" class="border border-primary img-fluid shadow" id="prevImage" onclick="triger();" /><br>
											<input type="file" name="fileToupload" accept="image/*" class="form-control my-2" id="profileImg" onchange="displayImage(this);">
										<?php endif;?>

									</div>

									<div class="col-xl-8 col-md-12">
										<div class="row">
											<div class="col-lg-6 col-md-6 py-0 my-0">
                                        		<div class="form-group">
                                            		<input type="text" name="fname" value="<?php echo $fname;?>" placeholder="First Name" class="form-control" required/>
                                        		</div>
                                        	</div>
		                                    <div class="col-lg-6 col-md-6 py-0 my-0">
		                                        <div class="form-group">
		                                            <input type="text" name="lname" value="<?php echo $lname;?>" placeholder="Last Name" class="form-control" required/>
		                                        </div>
		                                    </div>
		                                </div>

										<div class="form-group">
		                                    <input type="number" name="contact" value="<?php echo $contact;?>" placeholder="Contact Number" class="form-control" required/>
		                                </div>

		                                <div class="form-group">
		                                    <input type="text" name="address" value="<?php echo $adrs;?>" placeholder="Address" class="form-control" required/>
		                                </div>

		         						<div class="form-group">
											<button type="submit" name="updateProfile" class="btn btn-primary btn-block">Update Profile</button>
										</div> 

									</div>
								</div>								
							</form>
						</div>
					</div>
				</div>				
			</div>
		</div>

	<?php

		include('../customer/_cust_footer.php');

	}else{
		header('location: ../index.php');
	}

	?>

	<script type="text/javascript">

			//show update btn for img
			function updateImg(){
				var file ='<input type="file" name="Toupdate" class="form-control" accept="image/*" onchange="displayImage(this)" required/>';
				document.querySelector('#updImgbtn').innerHTML = file;
				document.querySelector('#btnUpImg').style.display = 'none';
			}


			//placeholder click
			function triger(){
				document.querySelector('#prodfileImg').click();
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

</body>
</html>