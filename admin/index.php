<?php 

include_once('config.inc.php');
$msg = '';
if (isset($_SESSION['USERNAME'])) {
    header('location:products.php');
    die();
}
if(isset($_REQUEST['login']) && $_REQUEST['username'] != '' && $_REQUEST['password'] != '') {
    $username = get_safe_value($conn, $_REQUEST['username']);
    $password = get_safe_value($conn, $_REQUEST['password']);
    $sql = "SELECT * FROM `admin_users` WHERE `username` = '$username' AND `password` = '$password'" ;
    $result = $conn -> query($sql) or die("Admin Not Exist !!!.");
    if ($result -> num_rows > 0) {
        $_SESSION['USERNAME'] = $username;
        header('location: products.php');
    } else {
        $msg = "Username or Password is Incorrect !!!.";
    }
} else {
    $msg = "Fill Login Details";
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Simpla Admin | Sign In</title>
    <link rel="stylesheet" href="resources/css/reset.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="resources/css/style.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="resources/css/invalid.css" type="text/css" media="screen" />
    <script type="text/javascript" src="resources/scripts/jquery-1.3.2.min.js"></script>
    <script type="text/javascript" src="resources/scripts/simpla.jquery.configuration.js"></script>
    <script type="text/javascript" src="resources/scripts/facebox.js"></script>
    <script type="text/javascript" src="resources/scripts/jquery.wysiwyg.js"></script>
</head>

<body id="login">

    <div id="login-wrapper" class="png_bg">
        <div id="login-top">
            <h1>Simpla Admin</h1>
            <!-- Logo (221px width) -->
            <img id="logo" src="resources/images/logo.png" alt="Simpla Admin logo" />
        </div>
        <!-- End #logn-top -->

        <div id="login-content">

            <form action="" method="POST">

                <div class="notification information png_bg">
                    <div> <?php echo $msg; ?> </div>
                </div>

                <p>
                    <label>Username</label>
                    <input class="text-input" type="text" name="username" />
                </p>
                <div class="clear"></div>
                <p>
                    <label>Password</label>
                    <input class="text-input" type="password" name="password" />
                </p>
                <div class="clear"></div>
                <p id="remember-password">
                    <input type="checkbox" />Remember me
                </p>
                <div class="clear"></div>
                <p>
                    <input class="button" type="submit" name="login" value="login" />
                </p>
                
            </form>
        </div>
        <!-- End #login-content -->

    </div>
    <!-- End #login-wrapper -->
</body>

</html>