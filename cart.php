<?php require 'header.inc.php'; ?>
  <!-- catg header banner section -->
  <section id="aa-catg-head-banner">
   <img src="img/fashion/fashion-header-bg-8.jpg" alt="fashion img">
   <div class="aa-catg-head-banner-area">
     <div class="container">
      <div class="aa-catg-head-banner-content">
        <h2>Cart Page</h2>
        <ol class="breadcrumb">
          <li><a href="index.html">Home</a></li>                   
          <li class="active">Cart</li>
        </ol>
      </div>
     </div>
   </div>
  </section>
  <!-- / catg header banner section -->

 <!-- Cart view section -->
 <section id="cart-view">
   <div class="container">
     <div class="row">
       <div class="col-md-12">
         <div class="cart-view-area">
           <div class="cart-view-table">
             <form action="">
               <div class="table-responsive">
                  <table class="table">
                    <thead>
                      <tr>
                        <th></th>
                        <th></th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                          $total = 0;
                          $product_ids = array();
                          if (isset($_SESSION['CART'])) {
                            foreach ($_SESSION['CART'] as $key => $value) {
                              $product = get_product($conn, $key);
                              $pname = $product[0]['name'];
                              $image = $product[0]['image'];
                              $price = $product[0]['price'];
                              $qty = $value['qty'];
                              $total += $qty * $price;
                              $product_ids[] = $key;
                      ?>
                      <tr>
                        <td><a class="remove" href="javascript:void(0)" onclick="manage_cart(<?php echo $key; ?>,'remove')"><fa class="fa fa-close"></fa></a></td>
                        <td><a href="#"><img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$image; ?>" alt="img"></a></td>
                        <td><a class="aa-cart-title" href="#"><?php echo $pname; ?></a></td>
                        <td><?php echo '$'.$price; ?></td>
                        <td>
                          <input class="aa-cart-quantity" type="number" id="<?php echo $key.'qty'; ?>" value="<?php echo $qty; ?>">
                        </td>
                        <td><?php echo '$'.$qty*$price;  ?></td>
                      </tr>
                      <?php
                            }
                        }
                      ?>
                      <tr>
                        <td colspan="6" class="aa-cart-view-bottom">
                          <div class="aa-cart-coupon">
                            <input class="aa-coupon-code" type="text" placeholder="Coupon">
                            <input class="aa-cart-view-btn" type="submit" value="Apply Coupon">
                          </div>
                          <a class="aa-cart-view-btn" href="javascript:void(0)" onclick="update_cart(<?php echo json_encode($product_ids); ?>)">Update Cart</a>
                        </td>
                      </tr>
                      </tbody>
                  </table>
                </div>
             </form>
             <!-- Cart Total view -->
             <div class="cart-view-total">
               <h4>Cart Totals</h4>
               <table class="aa-totals-table">
                 <tbody>
                   <tr>
                     <th>Sub-Total</th>
                     <td><?php echo '$'.$total; ?></td>
                   </tr>
                   <tr>
                     <th>Total</th>
                     <td><?php echo '$'.$total; ?></td>
                   </tr>
                 </tbody>
               </table>
               <a href="checkout.php" class="aa-cart-view-btn">Proced to Checkout</a>
             </div>
           </div>
         </div>
       </div>
     </div>
   </div>
 </section>
 <!-- / Cart view section -->

<?php require 'footer.inc.php'; ?>