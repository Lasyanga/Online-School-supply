<?php 
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

	class connectDB{


		// // Database Connection Properties
	 //    protected $host = 'localhost';
	 //    protected $user = 'id17196229_cowboy';
	 //    protected $password = 'Ne43f9!rrxDrg3R^';
	 //    protected $database = 'id17196229_tbhl_ordering';


		// Database Connection Properties
	    protected $host = 'localhost';
	    protected $user = 'root';
	    protected $password = '';
	    protected $database = 'tblph_ordering';

	    // connection property
	    public $conn = null;

	    // call constructor
	    public function __construct(){
	        $this->conn = mysqli_connect($this->host, $this->user, $this->password, $this->database);
	        if ($this->conn->connect_error){
	            echo "Fail " . $this->conn->connect_error;
	        }
	    }

	    public function __destruct(){
	        $this->closeConnection();
	    }

	    // for mysqli closing connection
	    protected function closeConnection(){
	        if ($this->conn != null ){
	            $this->conn->close();
	            $this->conn = null;
	        }
	    }

	    public function getDelProduct($prod_id){// deleting the product
	    	$sql = "DELETE FROM products WHERE prod_id = '$prod_id'";

	    	if($result = $this->conn->query($sql)){
	    		echo '<script>alert("Product that has product ID: '.$prod_id.' was Successfully Deleled.")</script>';
	    		$this->actlog($user_id, 'You Delete the product '.$prod_name);
	    	}else{
	    	 die("Error: ". $this->conn->mysqli_error());
	    	}
	    }// deleting the product

	    public function setEditProduct($prod_id){// setting to EditProduct
	    	$toEdit = "SELECT 
	    					products.prod_id as id,
	    					products.prod_name as name,
	    					products.price as price,
	    					stk.prod_stock as stock,
	    					products.prod_desc as description,
	    					products.prod_img as imgname
	    				FROM
	    					products 
	    				LEFT JOIN
	    					stocks as stk
	    					ON
	    					products.prod_id = stk.prod_id
	    				WHERE products.prod_id = '$prod_id'";

	    	$result = $this->conn->query($toEdit) or die("Error: ". $this->conn->mysqli_error());
	    	$rows = $result->fetch_assoc();

	    	$_SESSION['prod_id'] = $rows['id'];
	    	$_SESSION['prod_name'] = $rows['name'];
	    	$_SESSION['prod_price'] = $rows['price'];
	    	$_SESSION['prod_desc'] = $rows['description'];
	    	$_SESSION['prod_stock'] = $rows['stock'];
	    	$_SESSION['prod_img'] = $rows['imgname'];


	    }// setting to EditProduct

	    public function updateProductwImg($prod_id, $prod_name, $price, $prod_desc, $prod_stock, $fileimg, $ftemp, $user_id){ // update product
			if(!empty($fileimg)  && !empty($ftemp)){
				$path = '../uploads/products/'.$fileimg;
				if (move_uploaded_file($ftemp, $path)){
					$sql = "UPDATE 
								products
							SET
								prod_name ='$prod_name',
								price = '$price',
								prod_desc = '$prod_desc',											
								prod_img = '$fileimg'
							WHERE
								prod_id = '$prod_id'";

					if($this->conn->query($sql) == TRUE){
						$this->updatingStock($prod_id, $prod_stock, $user_id);
						echo "<script>alert('The product ".$prod_name." successfully updated.');</script>";
						$this->actlog($user_id, 'You Upadte the product '.$prod_name);
					} else {
					    echo "Error: " . $sql . "<br>" . $this->conn->error;
					}
				}
			}

	    }// update product

	    public function updateProduct($prod_id, $prod_name, $price, $prod_desc, $prod_stock, $user_id){
	    	$sql = "UPDATE 
					products
				SET
					prod_name ='$prod_name',
					price = '$price',
					prod_desc = '$prod_desc'
				WHERE
					prod_id = '$prod_id'";

			if($this->conn->query($sql) == TRUE){
				$this->updatingStock($prod_id, $prod_stock, $user_id);
				echo "<script>alert('The product ".$prod_name." successfully updated.');</script>";
				$this->actlog($user_id, 'You Upadte the product '.$prod_name);
			} else {
			    echo "Error: " . $sql . "<br>" . $this->conn->error;
			}
	    }

	    public function getCountProduct(){// get product count
	    	$sql_count = "SELECT 
	    					count(id) as prod_count 
	    				FROM
	    					products";
	    	$result = $this->conn->query($sql_count) or die("Error: " . $this->conn->mysqli_error());
	    	$rows = $result->fetch_assoc();

	    	echo $rows['prod_count'];

	    }// get product count

		public function addNewProduct($prod_id, $prod_name, $price, $prod_desc, $prod_stock, $fileimg, $ftemp, $user_id){ // adding new product
			$path = '../uploads/products/'.$fileimg;
			if (move_uploaded_file($ftemp, $path)){
				
					$sql = "INSERT INTO products(
											prod_id,
											prod_name,
											price,
											prod_desc,											
											prod_img
										)
						VALUES(
								'$prod_id',
								'$prod_name',
								'$price',
								'$prod_desc',								
								'$fileimg'
							)";

					$this->conn->query($sql) or die("Error: " .$this->conn->mysqli_error());
					$this->setInventory($prod_id, $prod_stock);
					$this->actlog($user_id, 'You Add new the product '. $prod_id);
					header('Location:'. $_SERVER['PHP_SELF']);		

					//echo "<script>alert('The product ".$prod_name." successfully added.');</script>";
			}

		}//end of adding new product

		public function getProducts(){ //getting display the data veiw_product.php
			$getProd = "SELECT 
							product.id as i,
							product.prod_id as id,
							product.prod_name as name,
							product.price as price,
							stk.prod_stock as stock,
							product.prod_desc as description,								
							product.prod_img as img
						FROM
							products as product
						LEFT JOIN
							stocks as stk
						ON 
							product.prod_id = stk.prod_id
						ORDER BY i desc";
			$result = $this->conn->query($getProd) or die("Error: " .$this->conn->mysqli_error());

			if($result->num_rows > 0){
				$i = 1;
                while($rows = $result->fetch_assoc()){
                    echo '<tr>
                    		<td>'.$i.'</td>
                            <td>'.$rows['id'].'</td>
                            <td>'.$rows['name'].'</td>
                            <td>'.$rows['price'].'</td>
                            <td>                            	
                            	'.$rows['stock'].'
							</td>
							<td>
								<button type="sumbit" class="btn btn-primary py-0 ml-auto" data-toggle="modal" data-prod_id="'.$rows['id'].'" data-target="#stock">
									+
								</button>
							</td>
				            <td>'.$rows['description'].'</td>
                            <td> <img src="../uploads/products/'.$rows['img'].'" class=".img-thumbnail img-fluid" width="100" height="200"/></td>
                            <td>
                                <a href="add_product.php?edit='.$rows['id'].'" class="btn btn-success btn-block mt-2">
                                	<span class="fas fa-edit">&nbsp;Edit</span>
                                </a>
                                <a href="view_product.php?del='.$rows['id'].'" class="btn btn-warning btn-block mt-2">
                                	<span class="fas fa-trash">&nbsp;Delete</span>
                                </a>
                            </td>
                        </tr>';
                    $i++;
                }
            }

		}// end fetch product to be display at product view


		public function setInventory($prod_id, $prod_stock){// setting Invertory once user add new product
			$addDate = date('Y-m-d');
			
			$sqlInventory ="INSERT INTO stocks(
												prod_id,
												prod_add,
												prod_sold,
												prod_stock,
												stkdate
												)
											VALUES(
													'$prod_id',
													 $prod_stock,
													 0,
													 $prod_stock,
													'$addDate'
												)";
			$this->conn->query($sqlInventory) or die("Error: " .$this->conn->mysqli_error());

		}// setting Invertory once user add new product


		public function getInventory(){// fetching the Inventory
			$getInventory = "SELECT 
							stocks.id as i,
							stocks.prod_id as id,
							products.prod_name as name,
							stocks.prod_add as added,
							stocks.prod_sold as sold,
							stocks.prod_stock as stock,
							stocks.stkdate as stock_date 
						FROM
							stocks
						LEFT JOIN
							products
							ON
							products.prod_id = stocks.prod_id
						ORDER BY i desc";
			$result = $this->conn->query($getInventory) or die("Error: " .$this->conn->mysqli_error());

			if($result->num_rows > 0){
				$i = 1;
                while($rows = $result->fetch_assoc()){
                    echo '<tr>
                    		<td>'.$i.'</td>
                            <td>'.$rows['id'].'</td>
                            <td>'.$rows['name'].'</td>
                            <td>'.$rows['added'].'</td>
                            <td>'.$rows['sold'].'</td>                            
                            <td>'.$rows['stock'].'</td>
                            <td>'.$rows['stock_date'].'</td>
                        </tr>';
                    $i++;
                }
            }

		}// fetching the Inventory

		public function updatingStock($prod_id, $stock, $user_id){// updating the stock count

			$now = date('Y-m-d');

			$totalstock = $this->add($this->getCurrentStock($prod_id), $stock);
			$datestock = $this->getStockDate($prod_id);
			// $prod_name = $this->getProductName($prod_id);

			if(strcmp($datestock, $now) == 0){
				$add = "UPDATE 
						stocks
					SET 
						prod_add = $stock,
						prod_stock = $totalstock
					WHERE
						prod_id = '$prod_id'";

				$this->conn->query($add) or die("Error: ". $this->conn->mysqli_error());
			}else{
				

				$newStock = " INSERT INTO stocks(
												prod_id,
												prod_add,
												prod_sold,
												prod_stock,
												stkdate
												)
										VALUES(
												'$prod_id',
												'$stock',
												0,
												'$totalstock',
												'$now'
												)";

				$this->conn->query($newStock) or die("Error: ". $this->conn->mysqli_error());

			}
			$this->actlog($user_id, 'You update the stock of '. $prod_id );
			$_SESSION['message'] ='<strong>Stock is Successfully added</strong>';			

		}// updating the stock count

		function getStockDate($prod_id){
			$sql ="SELECT 
						stkdate
					FROM
						stocks
					WHERE
						prod_id = '$prod_id'";
			$result = $this->conn->query($sql) or die("Error: ".$this->conn->mysqli_error());
			$rows = $result->fetch_assoc();

			return $rows['stkdate'];
		}

		function getCurrentStock($prod_id){
			$sql ="SELECT 
						prod_stock
					FROM
						stocks
					WHERE
						prod_id = '$prod_id'";
			$result = $this->conn->query($sql) or die("Error: ".$this->conn->mysqli_error());
			$rows = $result->fetch_assoc();

			return $rows['prod_stock'];

		}

		function add($current, $added){
			return intval($current) + intval($added);
		}

		public function getDisplayIndex(){//populate the index.php
			$getDisplay = "SELECT 
								prod_id as id,
								prod_name as name,
								price as price,
								prod_img as imgname
							FROM
								products
							ORDER BY id desc";

			$result = $this->conn->query($getDisplay) or die("Error: " .$this->conn->mysqli_error());

			if($result->num_rows > 0){
				$i = 1;
                while($rows = $result->fetch_assoc()){
                    echo '
                    	<div class="grid-item">
							<div class="gallery">
								<a href="addcart.php?prod_id='.$rows['id'].'">
									<img src="uploads/products/'.$rows['imgname'].'" alt="'.$rows['imgname'].'" class="img-fluid">
								</a>
								<div class="desc">
									<h6 class="name">'.$rows['name'].'</h6>
									<p class="price">'.$rows['price'].' PHP</p>
								</div>
							</div>
						</div>
                    ';
                    $i++;
                }
            }

		}//populate the index.php

		public function indextopSelling(){// displaying the top selling  in index
			$getDisplay = "SELECT 
								prod_id as id,
								prod_name as name,
								price as price,
								prod_img as imgname
							FROM
								products
							ORDER BY id desc";

			$result = $this->conn->query($getDisplay) or die("Error: " .$this->conn->mysqli_error());

			if($result->num_rows > 0){
				$i = 1;
                while($rows = $result->fetch_assoc()){
                	if($i == 11){
                		break;
                	}else{
	                    echo '
	                    	<div class="item">
									<div class="gallery">
										<a href="addcart.php?prod_id='.$rows['id'].'">
											<img src="uploads/products/'.$rows['imgname'].'" width="200px" class="img-fluid">
										</a>
										<div class="desc">
											<h6 class="name">'.$rows['name'].'</h6>
											<p class="price">'.$rows['price'].' PHP</p>
										</div>									
									</div>
								</div>
							';
	                    $i++;
                	}
                }
            }
		}// displaying the top selling  in index

		public function topSelling(){// displaying the top selling  in custindex
			$getDisplay = "SELECT 
								prod_id as id,
								prod_name as name,
								price as price,
								prod_img as imgname
							FROM
								products
							ORDER BY id desc";

			$result = $this->conn->query($getDisplay) or die("Error: " .$this->conn->mysqli_error());

			if($result->num_rows > 0){
				$i = 1;
                while($rows = $result->fetch_assoc()){
                	if($i == 11){
                		break;
                	}else{
	                    echo '
	                    	<div class="item">
									<div class="gallery">
										<a href="addcart.php?prod_id='.$rows['id'].'">
											<img src="../uploads/products/'.$rows['imgname'].'" width="200px" class="img-fluid">
										</a>
										<div class="desc">
											<h6 class="name">'.$rows['name'].'</h6>
											<p class="price">'.$rows['price'].' PHP</p>
										</div>									
									</div>
								</div>
							';
	                    $i++;
                	}
                }
            }
		}// displaying the top selling  in custindex


		public function getDisplayCust(){//populate the populate cust dash
			$getDisplay = "SELECT 
								prod_id as id,
								prod_name as name,
								price as price,
								prod_img as imgname
							FROM
								products
							ORDER BY id desc";

			$result = $this->conn->query($getDisplay) or die("Error: " .$this->conn->mysqli_error());

			if($result->num_rows > 0){
                while($rows = $result->fetch_assoc()){
                    echo '
                    	<div class="grid-item">
							<div class="gallery">
								<a href="addcart.php?prod_id='.$rows['id'].'">
									<img src="../uploads/products/'.$rows['imgname'].'" alt="'.$rows['imgname'].'" class="img-fluid">
								</a>
								<div class="desc">
									<h6 class="name">'.$rows['name'].'</h6>
									<p class="price">'.$rows['price'].' PHP</p>
								</div>
							</div>
						</div>
                    ';
                }
            }

		}//populate the populate cust dash

		public function prepareAddToCart($prod_id){// preparing the data, for add cart
			$sql = "SELECT prod_name as name,
							prod_desc as description,
							price as price,
							prod_img as img
						FROM
							products
						wHERE 
							prod_id = '$prod_id'";
			$result = $this->conn->query($sql) or die("Error: ".$this->conn->mysqli_error());

			$rows = $result->fetch_assoc();


			$_SESSION['name'] = $rows['name'];
			$_SESSION['description'] = $rows['description'];
			$_SESSION['price'] = $rows['price'];
			$_SESSION['prod_img'] = $rows['img'];

		}// end of preparing the data, for add cart

		public function checkProductId($user_id, $prod_id){// checking if the product is alreardy added
			$checkItem ="SELECT * FROM cart WHERE user_id='$user_id' AND prod_id='$prod_id'";
			$result = $this->conn->query($checkItem) or die("Error: ".$this->conn->mysqli_error());

			if($result->num_rows == 1){
				return true;
			}

		}// end of checking if the product is alreardy added

		public function updateCart($user_id, $prod_id, $qty){// updating the qty of item if it's already added
			$updateCart = "UPDATE 
								cart 
							SET 
								qty = $qty 
							WHERE 
								user_id = '$user_id'
								AND
								prod_id= '$prod_id'";

			if($result = $this->conn->query($updateCart) == TRUE){
				header('location: cust_index.php');
			}else{
				die("Error: ".$this->conn->mysqli_error());
			}

		}// end of updating the qty of item if it's already added

		public function setAddCart($user_id, $prod_id, $qty){// inserting item to cart
			$addcart = "INSERT INTO cart(
										user_id,
										prod_id,
										qty,
										status
										)
								VALUES(
										'$user_id',
										'$prod_id',
										$qty,
										'add cart'
									)";

			if($result = $this->conn->query($addcart) == TRUE){
				header('location: cust_index.php');
			}else{
				die("Error: ".$this->conn->mysqli_error());
			}			
			
		}//end of inserting item to cart

		public function checkCart($user_id){//checking if user has already items in the cart
			$isCart = "SELECT * FROM cart wHERE user_id ='$user_id'";

			$result = $this->conn->query($isCart) or die("Error: ".$this->conn->mysqli_error());
			if($result->num_rows > 0){
				return true;
			}
		}//end of checking if user has already items in the cart

		public function getCart($user_id){// populate the cart view
			$getcart ="SELECT
						product.prod_id as prod_id,
					    product.prod_name as name,
					    product.prod_desc as description,
					    product.prod_img as imagename,
					    product.price as price,
					    crt.qty as qty
					   
					FROM
						products as product
					INNER JOIN
						cart as crt 
					ON product.prod_id = crt.prod_id
					wHERE
						crt.user_id = '$user_id'";

			$result = $this->conn->query($getcart) or die("Error: " .$this->conn->mysqli_error());

			if($result->num_rows >0){
				while($rows = $result->fetch_assoc()){
                    echo '
                    	<div class="col-xl-4 col-md-4 align-items-center justifiy-align-center">
							<img src="../uploads/products/'.$rows['imagename'].'" class="img-fluid ">
						</div>
						<div class="col-xl-8 col-md-8 my-2">
							<h3 class="font-baloo font-size-20">'.$rows['name'].'</h3>
							<h3 class="font-baloo font-size-20">Price: ₱ '.$rows['price'].'</h3>
							<h3 class="font-baloo font-size-14">Quantity: '.$rows['qty'].'</h3>												
							
							<div class="col-xl-8 col-md-8 ml-auto mt-5">
								<div class="row">
									<div class="col-xl-6 col-md-6">
										<form method="post">
							               	<input type="hidden" value="'.$rows['prod_id'].'" name="item_id">
							               	<button type="submit" name="edit-cart-submit" class="btn btn-block btn-info mt-2">Edit</button>
							            </form>
									</div>
									<div class="col-xl-6 col-md-6">
										<form method="post">
										   	<input type="hidden" value="'.$rows['prod_id'].'" name="item_id">
										   	<button type="submit" name="delete-cart-submit" class="btn btn-block btn-danger mt-2">Remove</button>
										</form>
									</div>
								</div>																
							</div>
						</div>
                    ';
                }
			}

		}// populate the cart view

		public function delCart($user_id, $prod_id){// removing the item in cart
			$delcart = "DELETE FROM cart wHERE user_id='$user_id' AND prod_id = '$prod_id'";

			$this->conn->query($delcart) or die('Error: '.$this->conn->mysqli_error());
		}// removing the item in cart


		public function getcountCart($user_id){//getting the count of cart
			$getcount = "SELECT count(prod_id) as items FROM cart WHERE user_id = '$user_id' AND status ='add cart'";

			$result = $this->conn->query($getcount) or die("Error: ". $this->conn->mysqli_error());

			$rows = $result->fetch_assoc();

			echo $rows['items'];

		}//getting the count of cart


		public function getTotalCart($user_id){//getting the total price of items
			$getTotal = "SELECT 
							product.price as price,
							crt.qty as qty,
							sum(price * qty) as total
						FROM
							products as product
						INNER JOIN
							cart as crt
							ON product.prod_id = crt.prod_id
						WHERE 
							crt.user_id = '$user_id'";
			$result = $this->conn->query($getTotal) or die("Error: ".$this->conn->mysqli_error());

			$rows = $result->fetch_assoc();

			echo '₱ '.$rows['total'];


		}//getting the total price of items


		//---------------------- User Account --------------------

		public function createAccount($fname, $lname, $email, $contact, $bday, $address, $user, $pass){// creating customer account
			$user_id =rand(0, 9).date('Ymd').rand(1, 1000);

			$createAcc = "INSERT INTO account(
											user_id,
											fname,
											lname,
											email,
											contact_no,
											bday,
											address,
											username,
											password,
											role
										)
									VALUES(
											'$user_id',
											'$fname',
											'$lname',
											'$email',
											'$contact',
											'$bday',
											'$address',
											'$user',
											'$pass',
											2
									)";
			$this->conn->query($createAcc) or die("Error: ".$this->conn->mysqli_error());

			$_SESSION['user_id'] = $user_id;
			$_SESSION['username'] = $user;
			$_SESSION['role'] = 2;

			if(isset($_SESSION['prod_id'])){
				header('Location: customer/addcart.php?prod_id='.$_SESSION['prod_id'].'');
			}else{
				header('Location: customer/cust_index.php');
			}

		}// creating customer account

		public function getLogin($user, $pass){// try to login.
			 $pass = md5($pass);

			$logUsername = "SELECT 
								user_id, 
								username, 
								password, 
								role,
								profile_img
							FROM 
								account 
							WHERE 
								username = '$user' 
								AND
								password = '$pass'";

			$result = $this->conn->query($logUsername) or die("Error: ". $this->conn->mysqli_error());#trying to login usint username

			if($result->num_rows == 1){
				$rows = $result->fetch_assoc();

				$user_id = $rows['user_id'];
				$role = $rows['role'];
				$username = $rows['username'];
				$img = $rows['profile_img'];

				if($role == 1){
					$_SESSION['user_id'] = $user_id;
					$_SESSION['username'] = $username;
					$_SESSION['role'] = $role;
					$_SESSION['img'] = $img;
					header('location: admin/admin_index.php');
				}else if($role == 2){
					$_SESSION['user_id'] = $user_id;
					$_SESSION['username'] = $username;
					$_SESSION['role'] = $role;
					$_SESSION['img'] = $img;

					if(isset($_SESSION['prod_id'])){
						header('Location: customer/addcart.php?prod_id='.$_SESSION['prod_id'].'');
					}else{
						header('Location: customer/cust_index.php');
					}					
				}

			}else{
				$logEmail = "SELECT 
								user_id, 
								username, 
								password, 
								role,
								profile_img
							FROM 
								account 
							WHERE 
								email = '$user' 
								AND
								password = '$pass'";

				$result = $this->conn->query($logEmail) or die("Error: ". $this->conn->mysqli_error());#trying to login usint username

				if($result->num_rows == 1){
					$rows = $result->fetch_assoc();

					$user_id = $rows['user_id'];
					$role = $rows['role'];
					$username = $rows['username'];
					$img = $rows['profile_img'];

					if($role == 1){						
						$_SESSION['user_id'] = $user_id;
						$_SESSION['username'] = $username;
						$_SESSION['role'] = $role;
						$_SESSION['img'] = $img;
						header('location: admin/admin_index.php');
						
					}else if($role == 2){
						
						$_SESSION['user_id'] = $user_id;
						$_SESSION['username'] = $username;
						$_SESSION['role'] = $role;
						$_SESSION['img'] = $img;
						
						if(isset($_SESSION['prod_id'])){
							header('Location: customer/addcart.php?prod_id='.$_SESSION['prod_id'].'');
						}else{
							header('Location: customer/cust_index.php');
						}
					}
				}else{
					$_SESSION['error'] = 'Wrong username or password.';
				}
			}			

		}// try to login.

		public function getProfile($user_id){// get profile to display
			$getProfile ="SELECT 
								fname,
								lname,
								contact_no,
								bday,
								email,
								address,
								profile_img
							FROM
								account
							WHERE
								user_id ='$user_id'";

			$result = $this->conn->query($getProfile) or die('Errr: '.$this->conn->mysqli_error());
			$rows = $result->fetch_assoc();

			$_SESSION['fname']	= $rows['fname'];
			$_SERVER['lname']  	= $rows['lname'];
			$_SESSION['contact']= $rows['contact_no'];
			$_SESSION['bdate']	= $rows['bday'];
			$_SESSION['address']= $rows['address'];
			$_SESSION['img']	= $rows['profile_img'];
			$_SESSION['email'] = $rows['email'];

		}// get profile to display

		public function setUpdateProfile_wImg($user_id, $fname, $lname, $contact, $adrs, $img_name, $ftemp_path){// updating the profile with img file
			$path = '../uploads/user_profile/'.$img_name;
			if (move_uploaded_file($ftemp_path, $path)){
				$updateProfile = "UPDATE
								account
							SET
								fname ='$fname',
								lname ='$lname',
								contact_no ='$contact',
								address = '$adrs',
								profile_img = '$img_name'
							WHERE 
								user_id = '$user_id'";
				$this->conn->query($updateProfile) or die("Error: ". $this->conn->mysqli_error());
				$this->actlog($user_id, 'You Upadte your credentials');

				$_SESSION['success'] = 'Your profile was <strong>Successfully Updated.</strong>';
			}

		}// updating the profile

		public function setUpdateProfile_nImg($user_id, $fname, $lname, $contact, $adrs){// updating profile without updating the img and the password
			$updateProfile = "UPDATE
								account
							SET
								fname ='$fname',
								lname ='$lname',
								contact_no ='$contact',
								address = '$adrs'
							WHERE 
								user_id = '$user_id'";
				$this->conn->query($updateProfile) or die("Error: ". $this->conn->mysqli_error());
				$this->actlog($user_id, 'You Upadte your credentials');

				$_SESSION['success'] = 'Your profile was <strong>Successfully Updated.</strong>';

		}// updating profile withoue updating the img

		public function getAccount($user_id){// get profile to display
			$getProfile ="SELECT 
								email,
								username
							FROM
								account
							WHERE
								user_id ='$user_id'";

			$result = $this->conn->query($getProfile) or die('Errr: '.$this->conn->mysqli_error());
			$rows = $result->fetch_assoc();

			$_SESSION['email']= $rows['email'];
			$_SESSION['username'] = $rows['username'];

		}// get profile to display

		public function setUpdateAccount_wpass($user_id, $email, $user, $pass){//update login credentials
			$updateAccount ="UPDATE
								account
							SET
								email = '$email',
								username = '$user',
								password = '$pass'
							WHERE 
								user_id = '$user_id'";
			$this->conn->query($updateAccount) or die("Error: ". $this->conn->mysqli_error());
			$this->actlog($user_id, 'You Upadte your credentials');

			$_SESSION['message'] = 'Successfully applied';
			$_SESSION['type'] = 'alert-success';
		}

		public function setUpdateAccount_npass($user_id, $email, $user){//update login credentials
			$updateAccount ="UPDATE
								account
							SET
								email = '$email',
								username = '$user'
							WHERE 
								user_id = '$user_id'";
			$this->conn->query($updateAccount) or die("Error: ". $this->conn->mysqli_error());
			$this->actlog($user_id, 'You Upadte your credentials');

			$_SESSION['message'] = 'Updating username and email was Successfully applied';
			$_SESSION['type'] = 'alert-success';
		}
		
		public function actlog($user_id, $log){
			$date = date('Y-m-d');
			$log ="INSERT INTO act_log(
										user_id,
										log,
										date_log
									)
								VALUES(
										'$user_id',
										'$log',
										'$date'
									)";
			$this->conn->query($log) or die("Error: ".$this->conn->mysqli_error());
		}

		public function getDisplayActivtylog($user_id){// display log
			$displaylog = "SELECT 
							log,
							date_log
						FROM
							act_log
						ORDER BY id desc";
			$result = $this->conn->query($displaylog) or die("Error: " .$this->conn->mysqli_error());

			if($result->num_rows > 0){
				$i = 1;
                while($rows = $result->fetch_assoc()){
                    echo '<tr class="text-center">
                    		<td>'.$i.'</td>
                            <td>'.$rows['log'].'</td>
                            <td>'.$rows['date_log'].'</td>                            
                        </tr>';
                    $i++;
                }
			}
		}


	}// end of class
	
?>