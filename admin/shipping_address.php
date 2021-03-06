<?php 
require 'config.inc.php';

$username = '';

function Delete_user($id) 
{
    global $conn;
    $delete_sql = "DELETE FROM `users` WHERE `id` = '$id'";
    if ($conn -> query($delete_sql) == true) {
        header('location: users.php');
        die();
    }
}

function Get_user($id) 
{
    global $username, $conn ;
    $select_sql = "SELECT * FROM `users` WHERE `id` = '$id'";
    $result = $conn -> query($select_sql) or die("User Selection Query Failed !!!.");
    if ($result -> num_rows > 0) {

        $data = $result -> fetch_assoc();

        $category_name = $data['category'];
        
    }
}

function Set_User_values() 
{
    global $category, $conn ;
    $category = get_safe_value($conn, $_REQUEST['username']);
}

function Check_Duplicate_user($username) 
{
    global $conn;
    $category_sql = "SELECT * FROM `categories` WHERE `category` = '$category'";
    $result = $conn -> query($category_sql) or die("Query Failed !!!.");
    if ($result -> num_rows > 0) {
        $_SESSION['STATUS'] = 0;
        return true;
    } else {
        $_SESSION['STATUS'] = '';
        return false;
    }
}

function Update_user($id) 
{
    global $category, $conn ;
    Set_Category_values($id);
    $update_sql = "UPDATE `categories` SET `category` = '$category' WHERE `id` = '$id'" ;
    if ($conn -> query($update_sql) == true) {
        $_SESSION['STATUS'] = 2;
        header('location: categories.php');
        die();
    } else {
        die("Category not updated !!!.");
    }
    
}

function Get_All_addresses() 
{
    global $conn, $addresses;
    $sql = "SELECT * FROM `shipping_details` ORDER BY `id` DESC";
    $addresses = $conn -> query($sql) or die("All Users Selection Query Failed !!!.");
}

if ((isset($_REQUEST['operation']) && isset($_REQUEST['id'])) && ($_REQUEST['operation'] != '' && $_REQUEST['id'] != '')) {
    if ($_REQUEST['operation'] == 'edit') {
        Get_category($_REQUEST['id']);
    } else if ($_REQUEST['operation'] == 'delete') {
        Delete_category($_REQUEST['id']);
    } else {
        die("OOPs something went wrong !!!.");
    }
}
if (isset($_REQUEST['submit']) && $_REQUEST['submit'] != '') {
    if ((isset($_REQUEST['operation']) && isset($_REQUEST['id'])) && ($_REQUEST['operation'] != '' && $_REQUEST['id'] != '')) {
        Update_category($_REQUEST['id']);
    } else {
        Add_New_category();
    }
} else {
    // Comment.
}

Get_All_addresses();
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
                    <h3>Shipping Addresses</h3>
                    <ul class="content-box-tabs">
                        <li><a href="#tab1" class="<?php if (!isset($_REQUEST['id'])) { echo 'default-tab'; }  ?>">Shipping Addresses</a></li>
                    </ul>

                    <div class="clear"></div>

                </div>
                <!-- End .content-box-header -->

                <div class="content-box-content">

                    <div class="tab-content default-tab" id="tab1">
                       
                        <table>
                            <thead>
                                <tr>
                                    <th><input class="check-all" type="checkbox" /></th>
                                    <th>#</th>
                                    <th>ID</th>
                                    <th>User ID</th>
                                    <th>Order ID</th>
                                    <th>Name</th>
                                    <th>Company Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Address</th>
                                    <th>Country</th>
                                    <th>Appartment</th>
                                    <th>City</th>
                                    <th>District</th>
                                    <th>PIN Code</th>
                                    <th>Date Time</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>

                            <tfoot>
                                <tr>
                                    <td colspan="17">
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
                                    while ($address = $addresses -> fetch_assoc()) {

                                ?>
                                <tr>
                                <td><input type="checkbox" value="<?php echo $address['id']; ?>"/></td>
                                    <td><?php echo $sr; ?></td>
                                    <td><?php echo $address['id']; ?></td>
                                    <td><?php echo $address['user_id']; ?></td>
                                    <td><?php echo $address['order_id']; ?></td>
                                    <td><?php echo $address['name'].' '.$address['last_name']; ?></td>
                                    <td><?php echo $address['company_name']; ?></td>
                                    <td><?php echo $address['email']; ?></td>
                                    <td><?php echo $address['mobile']; ?></td>
                                    <td><?php echo $address['address']; ?></td>
                                    <td><?php echo $address['country']; ?></td>
                                    <td><?php echo $address['appartment']; ?></td>
                                    <td><?php echo $address['city']; ?></td>
                                    <td><?php echo $address['district']; ?></td>
                                    <td><?php echo $address['pincode']; ?></td>
                                    <td><?php echo $address['added_on']; ?></td>
                                    <td>
                                        <!-- Icons -->
                                        <a href="#" title="Edit"><img src="resources/images/icons/pencil.png" alt="Edit" /></a>
                                        <a href="#" title="Delete"><img src="resources/images/icons/cross.png" alt="Delete" /></a>
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

                </div>
                <!-- End .content-box-content -->

            </div>
            <!-- End .content-box -->

            <div class="clear"></div>

<?php require 'footer.inc.php'; ?>