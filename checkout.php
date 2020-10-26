<?php 
  require 'header.inc.php'; 
  if (!isset($_SESSION['CART'])) {
    ?> <script> window.location.href = 'index.php'; </script> <?php
  }
  $order_msg = '';
if (isset($_REQUEST['submit']) && $_REQUEST['submit'] != '') {
    $user_id = $_SESSION['USER_ID'];
    
    // Billing Details
    $bill_name = get_safe_value($conn, $_REQUEST['bill_name']);
    $bill_last_name = get_safe_value($conn, $_REQUEST['bill_last_name']);
    $bill_company_name = get_safe_value($conn, $_REQUEST['bill_company_name']);
    $bill_email = get_safe_value($conn, $_REQUEST['bill_email']);
    $bill_mobile = get_safe_value($conn, $_REQUEST['bill_mobile']);
    $bill_address = get_safe_value($conn, $_REQUEST['bill_address']);
    $bill_country = get_safe_value($conn, $_REQUEST['bill_country']);
    $bill_appartment = get_safe_value($conn, $_REQUEST['bill_appartment']);
    $bill_city = get_safe_value($conn, $_REQUEST['bill_city']);
    $bill_district = get_safe_value($conn, $_REQUEST['bill_district']);
    $bill_pincode = get_safe_value($conn, $_REQUEST['bill_pincode']);
    // Shipping Details
    $ship_name = get_safe_value($conn, $_REQUEST['ship_name']);
    $ship_last_name = get_safe_value($conn, $_REQUEST['ship_last_name']);
    $ship_company_name = get_safe_value($conn, $_REQUEST['ship_company_name']);
    $ship_email = get_safe_value($conn, $_REQUEST['ship_email']);
    $ship_mobile = get_safe_value($conn, $_REQUEST['ship_mobile']);
    $ship_address = get_safe_value($conn, $_REQUEST['ship_address']);
    $ship_country = get_safe_value($conn, $_REQUEST['ship_country']);
    $ship_appartment = get_safe_value($conn, $_REQUEST['ship_appartment']);
    $ship_city = get_safe_value($conn, $_REQUEST['ship_city']);
    $ship_district = get_safe_value($conn, $_REQUEST['ship_district']);
    $ship_pincode = get_safe_value($conn, $_REQUEST['ship_pincode']);
    $ship_comment = get_safe_value($conn, $_REQUEST['ship_comment']);

    $payment_type = $_REQUEST['payment_method'];
    $payment_status = 'success';
    if ($payment_type == 'COD') {
        $payment_status = 'pending';
    }
    $sub_total = 0;
    $total_amount = 0;
    $tax = 9;
    if(isset($_SESSION['CART'])) {
        foreach ($_SESSION['CART'] as $key => $value) {
            $product = get_product($conn, $key);
            $price = $product[0]['price'];
            $qty = $value['qty'];
            $sub_total += $price * $qty;
        }
        $total_amount = $sub_total + (($sub_total * $tax) / 100);
    } else {
        $order_msg = "No Product Added !!!.";
    }
    $order = new order($user_id);
    if ($order -> placeOrder($conn, $payment_type, $payment_status, $total_amount, 'pending')) {
        $order_id = $conn -> insert_id;
        if ($order -> billingDetails($conn, $order_id, $bill_name,$bill_last_name,$bill_company_name,$bill_email,$bill_mobile,$bill_address,$bill_country,$bill_appartment,$bill_city,$bill_district,$bill_pincode)) {
            if ($order -> shippingDetails($conn, $order_id, $ship_name,$ship_last_name,$ship_company_name,$ship_email,$ship_mobile,$ship_address,$ship_country,$ship_appartment,$ship_city,$ship_district,$ship_pincode,$ship_comment)) {
                if(isset($_SESSION['CART'])) {
                    foreach ($_SESSION['CART'] as $key => $value) {
                        $product = get_product($conn, $key);
                        $price = $product[0]['price'];
                        $qty = $value['qty'];
                        $product_id = $key;
                        if ($order -> orderDetails($conn, $order_id, $product_id, $qty, $price)) {
                            $order_msg = 1;
                            unset($_SESSION['CART']);
                        } else {
                            $order_msg = "Order Details Insertion Failed !!!.";
                        }
                    }
                } else {
                    $order_msg = "No Product Added !!!.";
                }
            } else {
                $order_msg = "Shipping Details Insertion Failed !!!.";
            }
        } else {
            $order_msg = "Billing Details Insertion Failed !!!.";
        }
    } else {
        $order_msg = "Placing Order is Failed !!!.";
    }
} else {
  $order_msg = "OOPs Something Went Wrong !!!";
}

?>
  <!-- catg header banner section -->
  <section id="aa-catg-head-banner">
    <img src="img/fashion/fashion-header-bg-8.jpg" alt="fashion img">
    <div class="aa-catg-head-banner-area">
     <div class="container">
      <div class="aa-catg-head-banner-content">
        <h2>Checkout Page</h2>
        <ol class="breadcrumb">
          <li><a href="index.php">Home</a></li>                   
          <li class="active">Checkout</li>
        </ol>
      </div>
     </div>
   </div>
  </section>
  <!-- / catg header banner section -->

 <!-- Cart view section -->
 <section id="checkout">
   <div class="container">
     <div class="row">
       <div class="col-md-12">
        <div class="checkout-area">
          <form action="" method="POST">
            <div class="row">
              <div class="col-md-8">
                <div class="checkout-left">
                  <div class="panel-group" id="accordion">
                    <!-- Coupon section -->
                    <div class="panel panel-default aa-checkout-coupon">
                      <div class="panel-heading">
                        <h4 class="panel-title">
                          <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                            Have a Coupon?
                          </a>
                        </h4>
                      </div>
                      <div id="collapseOne" class="panel-collapse collapse in">
                        <div class="panel-body">
                          <input type="text" placeholder="Coupon Code" class="aa-coupon-code">
                          <a  href="javascipt:void(0);" class="aa-browse-btn"> Apply Coupan </a>
                        </div>
                      </div>
                    </div>
                    <!-- Login section -->
                    <?php 
                      if(!isset($_SESSION['USER_ID'])) {
                    ?>
                    <div class="panel panel-default aa-checkout-login">
                      <div class="panel-heading">
                        <h4 class="panel-title">
                          <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                            Client Login 
                          </a>
                        </h4>
                      </div>
                      <div id="collapseTwo" class="panel-collapse collapse">
                        <div class="panel-body">
                          <p id="checkout-login-msg"></p>
                            <input type="text" placeholder="User Email" name="email_id" id="email_id">
                            <input type="password" placeholder="Password" autocomplete="false" name="login_password" id="login_password">
                            <a href="javascript:void(0);" class="aa-browse-btn" id="checkout-login-btn"> Login </a>
                            <label for="rememberme"><input type="checkbox" id="rememberme"> Remember me </label>
                          <p class="aa-lost-password"><a href="#">Lost your password?</a></p>
                        </div>
                      </div>
                    </div>
                    <?php 
                      }
                    ?>
                    <!-- Billing Details -->
                    <div class="panel panel-default aa-checkout-billaddress">
                      <div class="panel-heading">
                        <h4 class="panel-title">
                          <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                            Billing Details
                          </a>
                        </h4>
                      </div>
                      <div id="collapseThree" class="panel-collapse collapse <?php if (isset($_SESSION['USER_ID'])) { echo 'in'; } ?>">
                        <div class="panel-body">
                          <div class="row">
                            <div class="col-md-6">
                              <div class="aa-checkout-single-bill">
                                <input type="text" placeholder="First Name*" name="bill_name">
                              </div>                             
                            </div>
                            <div class="col-md-6">
                              <div class="aa-checkout-single-bill">
                                <input type="text" placeholder="Last Name*" name="bill_last_name">
                              </div>
                            </div>
                          </div> 
                          <div class="row">
                            <div class="col-md-12">
                              <div class="aa-checkout-single-bill">
                                <input type="text" placeholder="Company name" name="bill_company_name">
                              </div>                             
                            </div>                            
                          </div>  
                          <div class="row">
                            <div class="col-md-6">
                              <div class="aa-checkout-single-bill">
                                <input type="email" placeholder="Email Address*" name="bill_email">
                              </div>                             
                            </div>
                            <div class="col-md-6">
                              <div class="aa-checkout-single-bill">
                                <input type="tel" placeholder="Phone*" name="bill_mobile">
                              </div>
                            </div>
                          </div> 
                          <div class="row">
                            <div class="col-md-12">
                              <div class="aa-checkout-single-bill">
                                <textarea cols="8" rows="3" placeholder="Address*" name="bill_address"></textarea>
                              </div>                             
                            </div>                            
                          </div>   
                          <div class="row">
                            <div class="col-md-12">
                              <div class="aa-checkout-single-bill">
                                <select name="bill_country">
                                  <option value="0">Select Your Country</option>
                                  <?php 
                                    $sql = "SELECT * FROM `country`";
                                    $result = $conn -> query($sql) or die("Country Selection Query Failed !!!.");
                                    if($result -> num_rows > 0) {
                                      while($row = $result -> fetch_assoc()) {
                                        echo '<option value="'.$row['id'].'">'.$row['country'].'</option>';
                                      }
                                    }
                                  ?>
                                </select>
                              </div>                             
                            </div>                            
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="aa-checkout-single-bill">
                                <input type="text" placeholder="Appartment, Suite etc." name="bill_appartment">
                              </div>                             
                            </div>
                            <div class="col-md-6">
                              <div class="aa-checkout-single-bill">
                                <input type="text" placeholder="City / Town*" name="bill_city">
                              </div>
                            </div>
                          </div>   
                          <div class="row">
                            <div class="col-md-6">
                              <div class="aa-checkout-single-bill">
                                <input type="text" placeholder="District*" name="bill_district">
                              </div>                             
                            </div>
                            <div class="col-md-6">
                              <div class="aa-checkout-single-bill">
                                <input type="text" placeholder="Postcode / ZIP*" name="bill_pincode">
                              </div>
                            </div>
                          </div>                                    
                        </div>
                      </div>
                    </div>
                    <!-- Shipping Address -->
                    <div class="panel panel-default aa-checkout-billaddress">
                      <div class="panel-heading">
                        <h4 class="panel-title">
                          <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour">
                            Shippping Address
                          </a>
                        </h4>
                      </div>
                      <div id="collapseFour" class="panel-collapse collapse">
                        <div class="panel-body">
                         <div class="row">
                            <div class="col-md-6">
                              <div class="aa-checkout-single-bill">
                                <input type="text" placeholder="First Name*" name="ship_name">
                              </div>                             
                            </div>
                            <div class="col-md-6">
                              <div class="aa-checkout-single-bill">
                                <input type="text" placeholder="Last Name*" name="ship_last_name">
                              </div>
                            </div>
                          </div> 
                          <div class="row">
                            <div class="col-md-12">
                              <div class="aa-checkout-single-bill">
                                <input type="text" placeholder="Company name" name="ship_company_name">
                              </div>                             
                            </div>                            
                          </div>  
                          <div class="row">
                            <div class="col-md-6">
                              <div class="aa-checkout-single-bill">
                                <input type="email" placeholder="Email Address*" name="ship_email">
                              </div>                             
                            </div>
                            <div class="col-md-6">
                              <div class="aa-checkout-single-bill">
                                <input type="tel" placeholder="Phone*" name="ship_mobile">
                              </div>
                            </div>
                          </div> 
                          <div class="row">
                            <div class="col-md-12">
                              <div class="aa-checkout-single-bill">
                                <textarea cols="8" rows="3" placeholder="Address*" name="ship_address"></textarea>
                              </div>                             
                            </div>                            
                          </div>   
                          <div class="row">
                            <div class="col-md-12">
                              <div class="aa-checkout-single-bill">
                                <select name="ship_country">
                                  <option value="0">Select Your Country</option>
                                  <?php 
                                    $sql = "SELECT * FROM `country` ORDER BY `country` ASC";
                                    $result = $conn -> query($sql) or die("Country Selection Query Failed !!!.");
                                    if($result -> num_rows > 0) {
                                      while($row = $result -> fetch_assoc()) {
                                        echo '<option value="'.$row['id'].'">'.$row['country'].'</option>';
                                      }
                                    }
                                  ?>
                                </select>
                              </div>                             
                            </div>                            
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="aa-checkout-single-bill">
                                <input type="text" placeholder="Appartment, Suite etc." name="ship_appartment">
                              </div>                             
                            </div>
                            <div class="col-md-6">
                              <div class="aa-checkout-single-bill">
                                <input type="text" placeholder="City / Town*" name="ship_city">
                              </div>
                            </div>
                          </div>   
                          <div class="row">
                            <div class="col-md-6">
                              <div class="aa-checkout-single-bill">
                                <input type="text" placeholder="District*" name="ship_district">
                              </div>                             
                            </div>
                            <div class="col-md-6">
                              <div class="aa-checkout-single-bill">
                                <input type="text" placeholder="Postcode / ZIP*" name="ship_pincode">
                              </div>
                            </div>
                          </div> 
                           <div class="row">
                            <div class="col-md-12">
                              <div class="aa-checkout-single-bill">
                                <textarea cols="8" rows="3" placeholder="Special Notes" name="ship_comment"></textarea>
                              </div>                             
                            </div>                            
                          </div>              
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="checkout-right">
                  <h4>Order Summary</h4>
                  <div class="aa-order-summary-area">
                    <table class="table table-responsive">
                      <thead>
                        <tr>
                          <th>Product</th>
                          <th>Total</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php 
                        $sub_total = 0;
                        $tax = 0;
                        $total = 0;
                        if (isset($_SESSION['CART'])) {
                          foreach ($_SESSION['CART'] as $key => $value) {
                            $product = get_product($conn, $key);
                            $pname = $product[0]['name'];
                            $price = $product[0]['price'];
                            $qty = $value['qty'];
                            $sub_total += $price*$qty;
                            $tax = 9;
                            
                      ?>
                        <tr>
                          <td><?php echo $pname; ?> <strong> x  <?php echo $qty; ?> </strong></td>
                          <td><?php echo '$'.$price*$qty; ?></td>
                        </tr>
                        <?php 
                          }
                          $total =$sub_total + ($sub_total * $tax) / 100;
                        }
                        ?>
                      </tbody>
                      <tfoot>
                        <tr>
                          <th>Subtotal</th>
                          <td><?php echo '$'.$sub_total; ?></td>
                        </tr>
                         <tr>
                          <th>Tax</th>
                          <td><?php echo $tax.'%'; ?></td>
                        </tr>
                         <tr>
                          <th>Total</th>
                          <td><?php echo '$'.$total; ?></td>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                  <h4>Payment Method</h4>
                  <div class="aa-payment-method">                    
                    <label for="cashdelivery"><input type="radio" id="cashdelivery" name="payment_method" value="COD"> Cash on Delivery </label>
                    <label for="paypal"><input type="radio" id="paypal" name="payment_method" value="paypal" checked> Via Paypal </label>
                    <img src="https://www.paypalobjects.com/webstatic/mktg/logo/AM_mc_vs_dc_ae.jpg" border="0" alt="PayPal Acceptance Mark">    
                    <input type="submit" name="submit" value="Place Order" class="aa-browse-btn">                
                  </div>
                  <?php if ($order_msg != ''){ ?>
                  <div class="<?php if($order_msg == 1) { echo 'order-success-msg'; } else { echo 'order-error-msg'; } ?>">
                    <p><?php if ($order_msg == 1) { echo 'Order Placed Successfully !!!.'; } else { echo $order_msg; } ?></p>
                  </div>
                  <?php } ?>
                </div>
              </div>
            </div>
          </form>
         </div>
       </div>
     </div>
   </div>
 </section>
 <!-- / Cart view section -->
<?php require 'footer.inc.php'; ?>