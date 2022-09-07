<?php
    ob_start();
    error_reporting(E_ALL);
    session_start();
    require('class/autoload.php');

    if(isset($_SESSION['user_id'])){
        if($_SESSION['role'] == 1){
            header('Location: admin/admin_index.php');
        }
        header('Location: customer/cust_index.php');
    }

    $lname = $fname = $email = $contact = $address = $repass = $pass = $user = $bdate ="";

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST['signup'])){
            $hasError = 0;

            $fname = test_input($_POST['fname']);
            $lname = test_input($_POST['lname']);
            $email = test_input($_POST['email']);
            $address = test_input($_POST['address']);
            $contact = test_input($_POST['contact']);
            $date = date('Y-m-d',strtotime($_POST['bdate']));
            $bday = test_input($date);
            $user = test_input($_POST['user']);
            $repass = test_input($_POST['rpass']);
            $pass = test_input($_POST['pass']);


            if(isstring($fname)){
                if(isstring($lname)){
                    if(isemail($email)){
                        if(isnumber($contact)){
                            if(len($contact)){
                                if(isAddress($address)){
                                    if(passlen($pass)){

                                        $pass = md5($pass);
                                        $create = new connectDB();
                                        $create->createAccount($fname, $lname, $email, $contact, $bday, $address, $user, $pass);

                                    }else{
                                        $_SESSION['error'] = 'Password: Atleast 8 characters';
                                    }

                                }else{
                                    $_SESSION['error'] = 'Please check your address';
                                }

                            }else{
                                $_SESSION['error'] = 'Contact number must 10 digits';
                            }

                        }else{
                           $_SESSION['error'] = 'Contact number must contain numeric only';
                        }

                    }else{
                        $_SESSION['error'] = 'Please check your Email';
                    }
                 }else{
                   $_SESSION['error'] = 'Please check your Last name';
                 }
            }else{
                $_SESSION['error'] = 'Please check your First name.';
            }
        }
    }

    function passlen($pass){
        if (strlen ($pass) < 8) {
            return false;
        }
        return true;
    }

    function len($length){
         if (strlen ($length) != 10) {
            return false;
        }
        return true;
    }

    function isnumber($number){
        if (!preg_match ("/^[0-9]*$/", $number)) {
            return false;
        }
        return true;
    }

    function isemail($email){
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        return true;
    }

    function isAddress($input){
        if (!preg_match("/^[a-zA-Z0-9 .]*$/",$input)) {
            return false;
        }
        return true;
    }

    function isstring($input){
        if (!preg_match("/^[a-zA-Z ]*$/",$input)) {
            return false;
        }
        return true;
    }

    function test_input($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);

        return $data;
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TBLph</title>

    <?php
        include('template/_css.php');
    ?>
</head>
<body>
   <?php
        include('template/_nav.php');
    ?>

    <!-- Header -->
    <header class="masthead">
        <div class="container px-4 px-lg-5 h-100">
            <div class="row h-100 align-items-center justify-content-center ">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-7  text-center">
                            <div class="col-lg-12 align-self-end">
                                <h1 class="text-white font-weight-bold">
                                   The Local Bookstore ph
                                </h1>
                                <hr class="divider" />
                            </div>
                            <div class="col-lg-10 align-self-baseline">
                                <p class="text-white-50 mb-5">
                                   Start your shopping now we offer different products from school supply to
                                   your office supplies.
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <h4 class="text-white">Sign up</h4>

                            <?php if(isset($_SESSION['error'])):?>
                                <div class="alert alert-danger">
                                    <?php
                                        echo $_SESSION['error'];
                                        unset( $_SESSION['error']);
                                      ?>
                                </div>
                            <?php endif;?>

                            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 py-0 my-0">
                                        <div class="form-group">
                                            <input type="text" name="fname" placeholder="First Name" class="form-control" 
                                                value="<?php echo $fname;?>" title="Please input your first name" required/>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 py-0 my-0">
                                        <div class="form-group">
                                            <input type="text" name="lname" placeholder="Last Name" class="form-control" 
                                                value="<?php echo $lname;?>" title="Please input your last name" required/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="email" name="email" placeholder="Email Address" class="form-control"  
                                        value="<?php echo $email;?>" title="Input your email" required/>
                                </div>
                                 <div class="form-group">
                                    <input type="number" name="contact" placeholder="9XXXXXXXXX" class="form-control" 
                                        value="<?php echo $contact;?>" title="Input your Contact Number" required/>
                                </div>
                                <div class="row">
                                    <div class="col-lg-2 col-md-2 ">
                                        <label class="text-white">Birthday:</label>
                                    </div>
                                    <div class="col-lg-10 col-md-10">
                                         <div class="form-group">
                                            <input type="date" name="bdate" id="bdate" class="form-control" required/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="text" name="address" placeholder="Your home Addrress" class="form-control" 
                                        value="<?php echo $address;?>" title="Please input your Address" required/>
                                </div>
                                  <div class="form-group">
                                    <input type="text" name="user" placeholder="Username" class="form-control" 
                                        value="<?php echo $user;?>" title="Please input your Username" required/>
                                </div>
                                 <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <input type="password" id="pass" name="pass" placeholder="Password" class="form-control" required/>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <input type="password" id="rpass" name="rpass" placeholder="Confirm Password" class="form-control" required/>
                                        </div>
                                    </div>
                                    <span classs="text-white" id="matched" style="";></span>
                                </div>
                                <div class="align-items-center">
                                    <button type="submit" name="signup" id="btnpass" class="btn btn-primary btn-block">Register Now</button>
                                </div>
                                <p class="text-dark-50">Already have Account? Login <a href="login.php">here</a>.</p>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </header>
    <!-- #Header -->


    <?php
        include('template/_footer.php'); // adding footer including the js file
    ?>

    <script type="text/javascript">
    var check = document.getElementById('rpass');

    check.onkeyup = function() {
        if (document.getElementById('pass').value ==
            document.getElementById('rpass').value) {
            document.getElementById('matched').style.color = 'green';
            document.getElementById('matched').innerHTML = 'Confirm Password: matched';
            document.getElementById('btnpass').disabled = false;
        } else {
            document.getElementById('matched').style.color = 'red';
            document.getElementById('matched').innerHTML = 'Confirm Password: not matched';
            document.getElementById('btnpass').disabled=true;
        }
    }
</script>

</body>
</html>
