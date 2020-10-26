<?php 
require 'header.inc.php'; 
$reg_msg = ''; 
$login_msg = '';
if (isset($_REQUEST['register']) && $_REQUEST['register'] != '') {
    $name = get_safe_value($conn, $_REQUEST['reg-name']);
    $email = get_safe_value($conn, $_REQUEST['reg-email']);
    $mobile = get_safe_value($conn, $_REQUEST['reg-mobile']);
    $password = get_safe_value($conn, $_REQUEST['reg-password']);
    $user = new user;
    $reg_msg = $user -> register($conn, $name, $email, $mobile, $password);
    
}
if (isset($_REQUEST['login']) && $_REQUEST['login'] != '') {
    $user_id = get_safe_value($conn, $_REQUEST['userid']);
    $user_password = get_safe_value($conn, $_REQUEST['userpassword']);
    $user = new user;
    if ($user -> login($conn, $user_id, $user_password) == true) {
      ?> <script> window.location.href = window.location.href; </script> <?php
      $login_msg = "You are now Logged In !!!.";
    } else {
        $login_msg = "User Id or Password is Incorrect !!!.";
    }
}
?> 
  <!-- catg header banner section -->
  <section id="aa-catg-head-banner">
    <img src="img/fashion/fashion-header-bg-8.jpg" alt="fashion img">
    <div class="aa-catg-head-banner-area">
     <div class="container">
      <div class="aa-catg-head-banner-content">
        <h2>Account Page</h2>
        <ol class="breadcrumb">
          <li><a href="index.php">Home</a></li>                   
          <li class="active">Account</li>
        </ol>
      </div>
     </div>
   </div>
  </section>
  <!-- / catg header banner section -->

 <!-- Cart view section -->
 <section id="aa-myaccount">
   <div class="container">
     <div class="row">
       <div class="col-md-12">
        <div class="aa-myaccount-area">         
            <div class="row">
              <div class="col-md-6">
                <div class="aa-myaccount-login">
                <h4>Login</h4>
                 <form action="" class="aa-login-form" method="POST">
                  <label for="">Email address<span>*</span></label>
                   <input type="text" placeholder="Email Address" name="userid">
                   <label for="">Password<span>*</span></label>
                    <input type="password" placeholder="Password" autocomplete="false" name="userpassword">
                    <input type="submit" name="login" value="Login" class="aa-browse-btn">
                    <label class="rememberme" for="remember-me"><input type="checkbox" id="remember-me"> Remember me </label>
                    <p class="aa-lost-password"><a href="#">Lost your password?</a></p>
                    <p class="error-message"><?php echo $login_msg; ?></p>
                  </form>
                </div>
              </div>
              <div class="col-md-6">
                <div class="aa-myaccount-register">                 
                 <h4>Register</h4>
                 <form id="reg-form" action="" method="POST" class="aa-login-form">
                    <label for="">Name<span>*</span></label>
                    <input type="text" placeholder="Your Name" name="reg-name" id="reg-name" class="has-error">
                    <p class="error-message" ></p>
                    <label for="">Email<span>*</span></label>
                    <input type="text" placeholder="Your email" name="reg-email" id="reg-email" class="has-error">
                    <p class="error-message" ></p>
                    <label for="">Mobile Number<span>*</span></label>
                    <input type="text" placeholder="Your Mobile Number" name="reg-mobile" id="reg-mobile" class="has-error">
                    <p class="error-message" ></p>
                    <label for="">Password<span>*</span></label>
                    <input type="password" placeholder="Password" autocomplete="false" name="reg-password" id="reg-password" class="has-error">
                    <p class="error-message" ></p>
                    <input type="submit" class="aa-browse-btn" id="reg-btn" name="register" value="Register">  
                    <p class="<?php 
                      if ($reg_msg == 1) {
                        echo 'success-message';
                      } else {
                        echo 'error-message';
                      }
                    ?>" id="reg-message"> <?php 
                      if ($reg_msg == 1) {
                        echo 'Registration Successfull !!!.';
                      } else {
                        echo $reg_msg;
                      }
                    ?> <span></span> </p>                  
                  </form>
                </div>
              </div>
            </div>          
         </div>
       </div>
     </div>
   </div>
 </section>
 <!-- / Cart view section -->

  <?php require 'footer.inc.php'; ?>