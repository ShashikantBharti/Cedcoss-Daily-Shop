<?php 
require 'config.inc.php';

$category = '';
$category_name = '';

function Delete_category($id) 
{
    global $conn;
    $delete_sql = "DELETE FROM `categories` WHERE `id` = '$id'";
    if ($conn -> query($delete_sql) == true) {
        header('location: categories.php');
        die();
    }
}

function Get_category($id) 
{
    global $category_name, $conn ;
    $select_sql = "SELECT * FROM `categories` WHERE `id` = '$id'";
    $result = $conn -> query($select_sql) or die("Category Selection Query Failed !!!.");
    if ($result -> num_rows > 0) {

        $data = $result -> fetch_assoc();

        $category_name = $data['category'];
        
    }
}

function Set_Category_values() 
{
    global $category, $conn ;
    $category = get_safe_value($conn, $_REQUEST['category']);
}

function Check_Duplicate_category($category) 
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

function Update_category($id) 
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

function Add_New_category() 
{
    global $category, $conn ;
    if (Check_Duplicate_category($_REQUEST['category'])) {
        $_SESSION['STATUS'] = 0;
    } else {
        Set_Category_values();
        $insert_sql = "INSERT INTO `categories`(`category`) VALUES('$category')" ;
        if ($conn -> query($insert_sql) == true) {
            $_SESSION['STATUS'] = 1;
            header('location: categories.php');
            die();
        }    
    }
}

function Get_All_categories() 
{
    global $conn,$categories;
    $select_all_categories_sql = "SELECT * FROM `categories` ORDER BY `category` ASC";
    $categories = $conn -> query($select_all_categories_sql) or die("All Categories Selection Query Failed !!!.");
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

Get_All_categories();
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

                    <h3>Categories</h3>

                    <ul class="content-box-tabs">
                        <li><a href="#tab1" class="<?php if (!isset($_REQUEST['id'])) { echo 'default-tab'; }  ?>">Manage Categories</a></li>
                        <!-- href must be unique and match the id of target div -->
                        <li><a href="#tab2" class="<?php if (isset($_REQUEST['id'])) { echo 'default-tab'; }  ?>">Add Category</a></li>
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
                                Category Details Updated Successfully !!!.
                            </div>
                        </div>
                        <?php unset($_SESSION['STATUS']);  } ?>
                        <?php if (isset($_SESSION['STATUS']) && $_SESSION['STATUS'] == 1) { ?>
                        <div class="notification success png_bg">
                            <a href="#" class="close"><img src="resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
                            <div>
                                New Category Added Successfully !!!;
                            </div>
                        </div>
                        <?php unset($_SESSION['STATUS']);  } ?>
                        <?php if (isset($_SESSION['STATUS']) && $_SESSION['STATUS'] == 0) {  ?>
                        <div class="notification error png_bg">
                            <a href="#" class="close"><img src="resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
                            <div>
                                Category Already Exists !!!.
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
                                    <th>Actions</th>
                                </tr>
                            </thead>

                            <tfoot>
                                <tr>
                                    <td colspan="5">
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
                                    while ($category = $categories -> fetch_assoc()) {

                                ?>
                                <tr>
                                    <td><input type="checkbox" value="<?php echo $category['id']; ?>"/></td>
                                    <td><?php echo $sr; ?></td>
                                    <td><?php echo $category['id']; ?></td>
                                    <td><?php echo $category['category']; ?></td>
                                    <td>
                                        <!-- Icons -->
                                        <a href="?operation=edit&id=<?php echo $category['id']; ?>" title="Edit"><img src="resources/images/icons/pencil.png" alt="Edit" /></a>
                                        <a href="?operation=delete&id=<?php echo $category['id']; ?>" title="Delete"><img src="resources/images/icons/cross.png" alt="Delete" /></a>
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
                                    <label>Category Name</label>
                                    <input class="text-input medium-input datepicker" type="text" id="add-category" name="category" value="<?php echo $category_name; ?>" required /> 
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