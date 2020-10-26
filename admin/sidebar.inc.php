 <?php 
 $current = '';
 $filename = basename($_SERVER['REQUEST_URI']);
 $productmenu = array('products.php','categories.php','tags.php');
 $ordermenu = array('orders.php','order_details.php','billing_address.php','shipping_address.php');
 if (in_array($filename, $productmenu)) {
     $current = 'current';
 } else {
     $current = '';
}
if(in_array($filename, $ordermenu)) {
    $order_class = 'current';
} else {
    $order_class = '';
}


?>
 <!-- Wrapper for the radial gradient background -->
 <div id="sidebar">
            <div id="sidebar-wrapper">
                <!-- Sidebar with logo and menu -->
                <h1 id="sidebar-title"><a href="#">Simpla Admin</a></h1>

                <!-- Logo (221px wide) -->
                <a href="#"><img id="logo" src="resources/images/logo.png" alt="Simpla Admin logo" /></a>

                <!-- Sidebar Profile links -->
                <div id="profile-links">
                    Hello, <a href="#" title="Edit your profile">John Doe</a>, you have <a href="#messages" rel="modal" title="3 Messages">3 Messages</a><br />
                    <br />
                    <a href="#" title="View the Site">View the Site</a> | <a href="logout.php" title="Sign Out">Sign Out</a>
                </div>

                <ul id="main-nav">
                    <!-- Accordion Menu -->

                    <li>
                        <a href="http://www.google.com/" class="nav-top-item no-submenu">
                            <!-- Add the class "no-submenu" to menu items with no sub menu -->
                            Dashboard
                        </a>
                    </li>

                    <li>
                        <a href="#" class="nav-top-item <?php echo $current; ?>">
                            <!-- Add the class "current" to current menu item -->
                            Products
                        </a>
                        <ul>
                            <li><a class="<?php if($filename == 'products.php') echo $current; ?>" href="products.php">Manage Products</a></li>
                            <!-- Add class "current" to sub menu items also -->
                            <li><a class="<?php if($filename == 'categories.php') echo $current; ?>" href="categories.php">Manage Categories</a></li>
                            <li><a class="<?php if($filename == 'tags.php') echo $current; ?>" href="tags.php">Manage Tags</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="#" class="nav-top-item <?php echo $order_class; ?>">
						Orders
					</a>
                        <ul>
                            <li><a class="<?php if($filename == 'orders.php') echo $order_class; ?>" href="orders.php">Orders</a></li>
                            <li><a class="<?php if($filename == 'order_details.php') echo $order_class; ?>"  href="order_details.php">Order Details</a></li>
                            <li><a class="<?php if($filename == 'billing_address.php') echo $order_class; ?>"  href="billing_address.php">Billing Address</a></li>
                            <li><a class="<?php if($filename == 'shipping_address.php') echo $order_class; ?>"  href="shipping_address.php">Shipping Address</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#" class="nav-top-item <?php if($filename == 'users.php') echo 'current'; ?> ">
						Users
					</a>
                        <ul>
                            <li><a href="users.php" class=" <?php if($filename == 'users.php') echo 'current'; ?> ">Manage Users</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#" class="nav-top-item">
						Settings
					</a>
                        <ul>
                            <li><a href="#">General</a></li>
                            <li><a href="#">Design</a></li>
                            <li><a href="#">Your Profile</a></li>
                            <li><a href="#">Users and Permissions</a></li>
                        </ul>
                    </li>

                </ul>
                <!-- End #main-nav -->

                <div id="messages" style="display: none">
                    <!-- Messages are shown when a link with these attributes are clicked: href="#messages" rel="modal"  -->

                    <h3>3 Messages</h3>

                    <p>
                        <strong>17th May 2009</strong> by Admin<br /> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus magna. Cras in mi at felis aliquet congue.
                        <small><a href="#" class="remove-link" title="Remove message">Remove</a></small>
                    </p>

                    <p>
                        <strong>2nd May 2009</strong> by Jane Doe<br /> Ut a est eget ligula molestie gravida. Curabitur massa. Donec eleifend, libero at sagittis mollis, tellus est malesuada tellus, at luctus turpis elit sit amet quam. Vivamus pretium
                        ornare est.
                        <small><a href="#" class="remove-link" title="Remove message">Remove</a></small>
                    </p>

                    <p>
                        <strong>25th April 2009</strong> by Admin<br /> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus magna. Cras in mi at felis aliquet congue.
                        <small><a href="#" class="remove-link" title="Remove message">Remove</a></small>
                    </p>

                    <form action="#" method="post">

                        <h4>New Message</h4>

                        <fieldset>
                            <textarea class="textarea" name="textfield" cols="79" rows="5"></textarea>
                        </fieldset>

                        <fieldset>

                            <select name="dropdown" class="small-input">
							<option value="option1">Send to...</option>
							<option value="option2">Everyone</option>
							<option value="option3">Admin</option>
							<option value="option4">Jane Doe</option>
						</select>

                            <input class="button" type="submit" value="Send" />

                        </fieldset>

                    </form>

                </div>
                <!-- End #messages -->

            </div>
        </div>
        <!-- End #sidebar -->