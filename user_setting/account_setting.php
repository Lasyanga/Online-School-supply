<?php
	ob_start();
	error_reporting(E_ALL);
	session_start();
	require('../class/autoload.php');
	$account = new connectDB();

	$user_id = $_SESSION['user_id'];
	$role = $_SESSION['role'];

	$user = $pass = $rpass = $email ="";

	if(isset($_SESSION['user_id'])){
		$account->getAccount($user_id);

		$user = $_SESSION['username'];
		$email = $_SESSION['email'];
	}

	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		if(isset($_POST['update'])){
			$user = test_input($_POST['user']);
			$pass = test_input($_POST['pass']);
			$email = test_input($_POST['email']);
			$rpass = test_input($_POST['rpass']);

			if(!empty($pass) && !empty($rpass)){
				if(strcmp($pass, $rpass) == 0){
					$pass = md5($pass);
					$account->setUpdateAccount_wpass($user_id, $email, $user, $pass);
				}else{
					$_SESSION['message'] = 'Password and confirm password not match';
					$_SESSION['type'] = 'alert-danger';
				}	
			}else{
				$account->setUpdateAccount_npass($user_id, $email, $user);
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
				<div class="col-xl-5 col-md-5 shadow mx-auto">
					<div class="card border-info shadow">
						<div class="card-header">
							<h3 class="font-buxton">Account Setting</h3>
						</div>
						<div class="card-body">
							
							<?php if(isset($_SESSION['message'])):?>
								<div class="alert <?php echo $_SESSION['type']?>">
									<button type="button" class="close" data-dismiss="alert">&times;</button>
									<?php
										echo $_SESSION['message'];
										unset($_SESSION['success']);
										unset($_SESSION['type']);
										?>
								</div>
							<?php endif;?>
							
							<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
								<div class="col-xl-12 col-md-12">
									<div class="form-group">
	                                    <input type="text" name="user" value="<?php echo $user;?>" placeholder="Username" class="form-control" required/>
	                                </div>
	                                <div class="form-group">
	                                    <input type="email" name="email" value="<?php echo $email;?>" placeholder="Email Address" class="form-control" required/>
	                                </div>

	                                <div class="form-group">
	                                    <input type="password" name="pass"  placeholder="New Password" class="form-control"/>
	                                </div>
	                                 <div class="form-group">
	                                    <input type="password" name="rpass"  placeholder="Confrim Password" class="form-control"/>
	                                </div>

									<div class="form-group">
										<button type="submit" name="update" class="btn btn-primary btn-block">Apply Changes</button>
									</div>
								</div>
							</form>

						</div>
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

		ob_flush();

	?>