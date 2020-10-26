<?php 
require 'config.inc.php';

$cat_id = '';
$category = '';
$name = '';
$mrp = '';
$price = '';
$quantity = '';
$tags = array();
$color = '';
$image = '';
$short_desc = '';
$description = '';

function Delete_product($id) 
{
    global $conn;
    $select_image = "SELECT * FROM `products` WHERE `id` = '$id'";
    $result = $conn -> query($select_image) or die("Query Failed !!!.");
    $row = $result -> fetch_assoc() or die("Now Data Found !!!.");
    $image = $row['image'];
    $delete_sql = "DELETE FROM `products` WHERE `id` = '$id'";
    if ($conn -> query($delete_sql) == true) {
        unlink(PRODUCT_IMAGE_SERVER_PATH.$image);
        header('location: products.php');
        die();
    }
}

function Get_product($id) 
{
    global $cat_id, $name, $mrp, $price, $quantity, $tags, $image, $color, $short_desc, $description, $conn ;
    $select_sql = "SELECT * FROM `products` WHERE `id` = '$id'";
    $result = $conn -> query($select_sql) or die("Product Selection Query Failed !!!.");
    if ($result -> num_rows > 0) {

        $data = $result -> fetch_assoc();

        $cat_id = $data['cat_id'];
        $name = $data['name'];
        $mrp = $data['mrp'];
        $price = $data['price'];
        $quantity = $data['quantity'];
        $tags = $data['tags'];
        $tags = explode(',', $tags);
        $image = $data['image'];
        $color = $data['color'];
        $short_desc = $data['short_desc'];
        $description = $data['description'];
    }
}

function Set_Product_values() 
{
    global $cat_id, $name, $mrp, $price, $quantity, $tags, $color, $image, $short_desc, $description, $conn ;
    $cat_id = get_safe_value($conn, $_REQUEST['category']);
    $name = get_safe_value($conn, $_REQUEST['name']);
    $mrp = get_safe_value($conn, $_REQUEST['mrp']);
    $price = get_safe_value($conn, $_REQUEST['price']);
    $quantity = get_safe_value($conn, $_REQUEST['quantity']);
    $tags = $_REQUEST['tags'];
    $tags = implode(',', $tags);
    $color = get_safe_value($conn, $_REQUEST['color']);
    $image = rand(111111111, 99999999).$_FILES['image']['name'];
    $short_desc = $_REQUEST['short_desc'];
    $description = $_REQUEST['description'];
}

function Check_Duplicate_product($name) 
{
    global $conn;
    $product_sql = "SELECT * FROM `products` WHERE `name` = '$name'";
    $result = $conn -> query($product_sql) or die("Query Failed !!!.");
    if ($result -> num_rows > 0) {
        $_SESSION['STATUS'] = 0;
        return true;
    } else {
        $_SESSION['STATUS'] = '';
        return false;
    }
}

function Validate_image() 
{
    if ($_FILES['image']['type'] != '' && ($_FILES['image']['type'] != 'image/png' && $_FILES['image']['type'] != 'image/jpg' && $_FILES['image']['type'] != 'image/jpeg')) {
        return false;
    } else {
        return true;
    } 
}

function Update_product($id) 
{
    global $cat_id, $name, $mrp, $price, $quantity, $tags, $color, $image, $short_desc, $description, $conn ;
    Get_product($id);
    $old_image = $image;
    Set_Product_values($id);
    if ($_FILES['image']['name'] != '') {
        if ($_FILES['image']['type'] != '' && ($_FILES['image']['type'] != 'image/png' && $_FILES['image']['type'] != 'image/jpg' && $_FILES['image']['type'] != 'image/jpeg')) {
            $_SESSION['STATUS'] = 3;
        } else {
            // Update if Image IS selected.
            unlink(PRODUCT_IMAGE_SERVER_PATH.$old_image);
            move_uploaded_file($_FILES['image']['tmp_name'], PRODUCT_IMAGE_SERVER_PATH.$image);
            $update_sql = "UPDATE `products` SET `cat_id` = '$cat_id', `name` = '$name', `mrp` = '$mrp', `price` = '$price', `quantity` = '$quantity', `tags` = '$tags', `color` = '$color', `image` = '$image', `short_desc` = '$short_desc', `description` = '$description' WHERE `id` = '$id'" ;
            if ($conn -> query($update_sql) == true) {
                $_SESSION['STATUS'] = 2;
                header('location: products.php');
                die();
            } else {
                die("Product Without Image Not updated !!!.");
            }
        }
    } else {
        // update if Image IS NOT selected.
        $update_sql = "UPDATE `products` SET `cat_id` = '$cat_id', `name` = '$name', `mrp` = '$mrp', `price` = '$price', `quantity` = '$quantity', `tags` = '$tags', `color` = '$color', `short_desc` = '$short_desc', `description` = '$description' WHERE `id` = '$id'" ;
        if ($conn -> query($update_sql) == true) {
            $_SESSION['STATUS'] = 2;
            header('location: products.php');
            die();
        } else {
            die("Product with image not updated !!!.");
        }
    }
}

function Add_New_product() 
{
    global $cat_id, $name, $mrp, $price, $quantity, $tags, $color, $image, $short_desc, $description, $conn ;
    if (Check_Duplicate_product($_REQUEST['name'])) {
        $_SESSION['STATUS'] = 0;
    } else {
        Set_Product_values();
        $insert_sql = "INSERT INTO `products`(`cat_id`, `name`, `mrp`, `price`, `quantity`, `tags`, `color`, `image`, `short_desc`, `description`) VALUES('$cat_id', '$name', '$mrp', '$price', '$quantity', '$tags', '$color', '$image', '$short_desc', '$description')" ;
        if ($conn -> query($insert_sql) == true) {
            move_uploaded_file($_FILES['image']['tmp_name'], PRODUCT_IMAGE_SERVER_PATH.$image);
            $_SESSION['STATUS'] = 1;
            header('location: products.php');
            die();
        }    
    }
}

function Get_All_products() 
{
    global $conn,$products;
    $select_all_product_sql = "SELECT `products`.*,`categories`.`category` FROM `products`,`categories` WHERE `products`.`cat_id` = `categories`.`id` ORDER BY `products`.`id` DESC";
    $products = $conn -> query($select_all_product_sql) or die("All Product Selection Query Failed !!!.");
}

if ((isset($_REQUEST['operation']) && isset($_REQUEST['id'])) && ($_REQUEST['operation'] != '' && $_REQUEST['id'] != '')) {
    if ($_REQUEST['operation'] == 'edit') {
        Get_product($_REQUEST['id']);
    } else if ($_REQUEST['operation'] == 'delete') {
        Delete_product($_REQUEST['id']);
    } else {
        die("OOPs something went wrong !!!.");
    }
}
if (isset($_REQUEST['submit']) && $_REQUEST['submit'] != '') {
    if ((isset($_REQUEST['operation']) && isset($_REQUEST['id'])) && ($_REQUEST['operation'] != '' && $_REQUEST['id'] != '')) {
        Update_product($_REQUEST['id']);
    } else {
        Add_New_product();
    }
} else {
    // Comment.
}

Get_All_products();
?>

<?php require 'header.inc.php' ; ?>
<?php require 'sidebar.inc.php' ; ?>
<div id="main-content">
            <!-- Main Content Section with everything -->

            <noscript> <!-- Show a notification if the user has disabled javascript -->
				<div class="notification error png_bg">
					<div>
						Javascript is disabled or is not supported by your browser. Please <a href="http://browsehappy.com/" title="Upgrade to a better browser">upgrade</a> your browser or <a href="http://www.google.com/support/bin/answer.py?answer=23852" title="Enable Javascript in your browser">enable</a> Javascript to navigate the interface properly.
					</div>
				</div>
			</noscript>

            <!-- Page Head -->
            <h2>Welcome John</h2>
            <p id="page-intro">What would you like to do?</p>

            <!-- End .shortcut-buttons-set -->

            <div class="clear"></div>
            <!-- End .clear -->

            <div class="content-box">
                <!-- Start Content Box -->

                <div class="content-box-header">

                    <h3>Products</h3>

                    <ul class="content-box-tabs">
                        <li><a href="#tab1" class="<?php if (!isset($_REQUEST['id'])) { echo 'default-tab'; }  ?>">Manage Products</a></li>
                        <!-- href must be unique and match the id of target div -->
                        <li><a href="#tab2" class="<?php if (isset($_REQUEST['id'])) { echo 'default-tab'; }  ?>">Add Product</a></li>
                    </ul>

                    <div class="clear"></div>

                </div>
                <!-- End .content-box-header -->

                <div class="content-box-content">

                    <div class="tab-content <?php if (!isset($_REQUEST['id'])) { echo 'default-tab'; }  ?>" id="tab1">
                        <!-- This is the target div. id must match the href of this div's tab -->
                        <!-- Start Notification -->
                        <!--
                        <div class="notification attention png_bg">
                            <a href="#" class="close"><img src="resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
                            <div>
                                Warning notification. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin vulputate, sapien quis fermentum luctus, libero.
                            </div>
                        </div>
                        -->
                        <?php if (isset($_SESSION['STATUS']) && $_SESSION['STATUS'] == 2) { ?>
                        <div class="notification information png_bg">
                            <a href="#" class="close"><img src="resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
                            <div>
                                Product Details Updated Successfully !!!.
                            </div>
                        </div>
                        <?php unset($_SESSION['STATUS']);  } ?>
                        <?php if (isset($_SESSION['STATUS']) && $_SESSION['STATUS'] == 1) { ?>
                        <div class="notification success png_bg">
                            <a href="#" class="close"><img src="resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
                            <div>
                                New Product Added Successfully !!!;
                            </div>
                        </div>
                        <?php unset($_SESSION['STATUS']);  } ?>
                        <?php if (isset($_SESSION['STATUS']) && $_SESSION['STATUS'] == 0) {  ?>
                        <div class="notification error png_bg">
                            <a href="#" class="close"><img src="resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
                            <div>
                                Product Already Exists !!!.
                            </div>
                        </div>
                        <?php unset($_SESSION['STATUS']);  }  ?>
                        <!-- End. Notifications -->
                        <table>
                            <thead>
                                <tr>
                                    <th><input class="check-all" type="checkbox" /></th>
                                    <th>#</th>
                                    <th>ID</th>
                                    <th>Category</th>
                                    <th>Name</th>
                                    <th>Image</th>
                                    <th>MRP</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Tags</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>

                            <tfoot>
                                <tr>
                                    <td colspan="11">
                                        <div class="bulk-actions align-left">
                                            <select name="dropdown">
												<option value="option1">Choose an action...</option>
												<option value="option2">Edit</option>
												<option value="option3">Delete</option>
											</select>
                                            <a class="button" href="#">Apply to selected</a>
                                        </div>

                                        <div class="pagination">
                                            <a href="#" title="First Page">&laquo; First</a><a href="#" title="Previous Page">&laquo; Previous</a>
                                            <a href="#" class="number" title="1">1</a>
                                            <a href="#" class="number" title="2">2</a>
                                            <a href="#" class="number current" title="3">3</a>
                                            <a href="#" class="number" title="4">4</a>
                                            <a href="#" title="Next Page">Next &raquo;</a><a href="#" title="Last Page">Last &raquo;</a>
                                        </div>
                                        <!-- End .pagination -->
                                        <div class="clear"></div>
                                    </td>
                                </tr>
                            </tfoot>

                            <tbody>
                                <?php 
                                    $sr = 1;
                                    while ($product = $products -> fetch_assoc()) {

                                ?>
                                <tr>
                                    <td><input type="checkbox" value="<?php echo $product['id']; ?>"/></td>
                                    <td><?php echo $sr; ?></td>
                                    <td><?php echo $product['id']; ?></td>
                                    <td><?php echo $product['category']; ?></td>
                                    <td><?php echo $product['name']; ?></td>
                                    <td><img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$product['image']; ?>" alt="" height="40px"></td>
                                    <td><?php echo $product['mrp']; ?></td>
                                    <td><?php echo $product['price']; ?></td>
                                    <td><?php echo $product['quantity']; ?></td>
                                    <td>
                                    <?php
                                        $tag_id = explode(',', $product['tags']);
                                        foreach ($tag_id as $id) {
                                            $select_tag = "SELECT * FROM `tags` WHERE `id` = '$id'";
                                            $result = $conn -> query($select_tag) or die("Tag Selection Query Failed !!!.");
                                            if ($result -> num_rows > 0) {
                                                while ($row = $result -> fetch_assoc()) {
                                                    echo $row['tags'].', ';
                                                }
                                            }
                                        }
                                     ?>
                                    </td>
                                    <td>
                                        <!-- Icons -->
                                        <a href="?operation=edit&id=<?php echo $product['id']; ?>" title="Edit"><img src="resources/images/icons/pencil.png" alt="Edit" /></a>
                                        <a href="?operation=delete&id=<?php echo $product['id']; ?>" title="Delete"><img src="resources/images/icons/cross.png" alt="Delete" /></a>
                                        <a href="#" title="Edit Meta"><img src="resources/images/icons/hammer_screwdriver.png" alt="Edit Meta" /></a>
                                    </td>
                                </tr>
                                <?php 
                                        $sr++;
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- End #tab1 -->

                    <div class="tab-content <?php if (isset($_REQUEST['id'])) { echo 'default-tab'; }  ?>" id="tab2">

                        <form action="" method="post" enctype="multipart/form-data">

                            <fieldset>
                                <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->

                                <p>
                                    <label>Category</label>
                                    <select name="category" id="category" class="small-input" required>
                                    <option value="">--Select Category--</option>
                                        <?php 
                                        $category = "SELECT * FROM `categories`";
                                        $result = $conn -> query($category) or die("Category not selected !!!.");
                                        if ($result -> num_rows > 0) {
                                           while ($row = $result -> fetch_assoc()) {
                                               if ($row['id'] == $cat_id) { 
                                                    $selected = 'selected'; 
                                                } else { 
                                                    $selected = ''; 
                                                }
                                               echo '<option '.$selected.' value="'.$row['id'].'">'.$row['category'].'</option>';
                                           }
                                        }
                                        ?>
                                    </select>
                                    <span class="input-notification success png_bg"></span>
                                    <span class="input-notification error png_bg"></span>
                                </p>

                                <p>
                                    <label>Product Name</label>
                                    <input class="text-input medium-input datepicker" type="text" id="name" name="name" value="<?php echo $name; ?>" required /> 
                                    <span class="input-notification success png_bg"></span>
                                    <span class="input-notification error png_bg"></span>
                                </p>
                                <p>
                                    <label>Product MRP</label>
                                    <input class="text-input small-input" type="text" id="mrp" name="mrp" value="<?php echo $mrp; ?>" required /> 
                                    <span class="input-notification success png_bg"></span>
                                    <span class="input-notification error png_bg"></span>
                                </p>
                                <p>
                                    <label>Product Price</label>
                                    <input class="text-input small-input" type="text" id="price" name="price" value="<?php echo $price; ?>" required /> 
                                    <span class="input-notification success png_bg"></span>
                                    <span class="input-notification error png_bg"></span>
                                </p>
                                <p>
                                    <label>Product Quantity</label>
                                    <input class="text-input small-input" type="text" id="quantity" name="quantity" value="<?php echo $quantity; ?>" required /> 
                                    <span class="input-notification success png_bg"></span>
                                    <span class="input-notification error png_bg"></span>
                                </p>
                                
                                <p>
                                    <label>Tags</label>
                                    <?php 
                                    $tag_sql = "SELECT * FROM `tags`";
                                    $tag_result = $conn -> query($tag_sql) or die("Tags Query Failed !!!.");
                                    if ($tag_result -> num_rows > 0) {
                                        while ($row = $tag_result -> fetch_assoc()) {
                                            $tag = $row['id'];
                                            if (in_array($tag, $tags)) {
                                                $checkbox = 'checked';
                                            } else {
                                                $checkbox = '';
                                            }
                                            echo '<input '.$checkbox.' type="checkbox" name="tags[]" value="'.$tag.'" /> '.$row['tags'];
                                        }
                                    }

                                    ?>
                                </p>
                                <p>
                                    <label>Product Color</label>
                                    <input class="text-input small-input" type="text" id="color" name="color" value="<?php echo $color; ?>" required/> 
                                    <span class="input-notification success png_bg"></span>
                                    <span class="input-notification error png_bg"></span>
                                </p>

                                <p>
                                    <label>Product Image</label>
                                    <input class="text-input small-input" type="file" id="image" name="image" <?php if(!isset($_REQUEST['id'])) { echo 'required'; } ?> /> 
                                    <span class="input-notification success png_bg"></span>
                                    <span class="input-notification error png_bg"></span>
                                    <br /><small>Image format must be png/jpg/jpeg.</small>
                                </p>

                                <p>
                                    <label>Short Description</label>
                                    <input class="text-input large-input" type="text" id="short_desc" name="short_desc" value="<?php echo $short_desc; ?>" required />
                                    <span class="input-notification success png_bg"></span>
                                    <span class="input-notification error png_bg"></span>
                                </p>

                                <p>
                                    <label>Description</label>
                                    <textarea class="text-input textarea wysiwyg" id="description" name="description" cols="79" rows="15" required ><?php echo $description; ?></textarea>
                                    <span class="input-notification success png_bg"></span>
                                    <span class="input-notification error png_bg"></span>
                                </p>

                                <p>
                                    <input class="button" type="submit" name="submit" value="Submit" />
                                </p>

                            </fieldset>

                            <div class="clear"></div>
                            <!-- End .clear -->
                           
                        </form>
                    </div>
                    <!-- End #tab2 -->

                </div>
                <!-- End .content-box-content -->

            </div>
            <!-- End .content-box -->

            <div class="clear"></div>

<?php require 'footer.inc.php'; ?>