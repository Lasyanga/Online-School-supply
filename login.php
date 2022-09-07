<?php
    ob_start();
    error_reporting(E_ALL);
    session_start();
    require('class/autoload.php');
    $login = new connectDB();

    $user = $pass = "";

    if(isset($_POST['login'])){
        $user = test_input($_POST['user']);
        $pass = test_input($_POST['pass']);            

        $login->getLogin($user, $pass);
    }

    function test_input($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);

        return $data;
    }    

    if(isset($_SESSION['user_id'])){
        if($_SESSION['role'] == 1){
            header('Location: admin/admin_index.php');
        }
        header('Location: customer/cust_index.php');
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
            <div class="row h-100 align-items-center justify-content-center text-center">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-8">
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
                        <div class="col-lg-4">
                            <h4 class="text-white">Login Now</h4>

                            <?php if(isset($_SESSION['error'])):?>
                                <div class="alert alert-danger">
                                  <?php 
                                    echo $_SESSION['error'];
                                    unset($_SESSION['error']);
                                  ?>
                                </div>
                            <?php endif;?>

                            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
                                <div class="form-group">
                                    <input type="text" name="user" placeholder="Username / Email" class="form-control" required/>
                                </div>
                                <div class="form-group">
                                    <input type="password" name="pass" placeholder="Password" class="form-control" required/>
                                </div>
                                <div class="align-items-center">
                                    <button type="submit" name="login" class="btn btn-primary btn-block">Login</button>
                                    <p class="text-success"><a href="frgot.html">Forgot password?</a></p>
                                </div>
                                <p class="text-dark-50">Create Account? Sign-up <a href="sign-up.php">here</a>.</p>
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

</body>
</html>