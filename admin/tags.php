<?php 
require 'config.inc.php';

$tag = '';
$tag_name = '';

function Delete_tag($id) 
{
    global $conn;
    $delete_sql = "DELETE FROM `tags` WHERE `id` = '$id'";
    if ($conn -> query($delete_sql) == true) {
        header('location: tags.php');
        die();
    }
}

function Get_tag($id) 
{
    global $tag_name, $conn ;
    $select_sql = "SELECT * FROM `tags` WHERE `id` = '$id'";
    $result = $conn -> query($select_sql) or die("Tag Selection Query Failed !!!.");
    if ($result -> num_rows > 0) {
        $data = $result -> fetch_assoc();
        $tag_name = $data['tags'];
    }
}

function Set_tag_values() 
{
    global $tag, $conn;
    $tag = get_safe_value($conn, $_REQUEST['tags']);
}

function Check_Duplicate_tag($tag) 
{
    global $conn;
    $tag_sql = "SELECT * FROM `tags` WHERE `tags` = '$tag'";
    $result = $conn -> query($tag_sql) or die("Query Failed !!!.");
    if ($result -> num_rows > 0) {
        $_SESSION['STATUS'] = 0;
        return true;
    } else {
        $_SESSION['STATUS'] = '';
        return false;
    }
}

function Update_tag($id) 
{
    global $tag, $conn ;
    Set_Tag_values($id);
    $update_sql = "UPDATE `tags` SET `tags` = '$tag' WHERE `id` = '$id'";
    if ($conn -> query($update_sql) == true) {
        $_SESSION['STATUS'] = 2;
        header('location: tags.php');
        die();
    } else {
        die("tag not updated !!!.");
    }
    
}

function Add_New_tag() 
{
    global $tag, $conn ;
    if (Check_Duplicate_tag($_REQUEST['tags'])) {
        $_SESSION['STATUS'] = 0;
    } else {
        Set_Tag_values();
        $insert_sql = "INSERT INTO `tags`(`tags`) VALUES('$tag')" ;
        if ($conn -> query($insert_sql) == true) {
            $_SESSION['STATUS'] = 1;
            header('location: tags.php');
            die();
        }    
    }
}

function Get_All_tags() 
{
    global $conn,$tags;
    $select_all_tags_sql = "SELECT * FROM `tags` ORDER BY `tags` ASC";
    $tags = $conn -> query($select_all_tags_sql) or die("All Tags Selection Query Failed !!!.");
}

if ((isset($_REQUEST['operation']) && isset($_REQUEST['id'])) && ($_REQUEST['operation'] != '' && $_REQUEST['id'] != '')) {
    if ($_REQUEST['operation'] == 'edit') {
        Get_tag($_REQUEST['id']);
    } else if ($_REQUEST['operation'] == 'delete') {
        Delete_tag($_REQUEST['id']);
    } else {
        die("OOPs something went wrong !!!.");
    }
}
if (isset($_REQUEST['submit']) && $_REQUEST['submit'] != '') {
    if ((isset($_REQUEST['operation']) && isset($_REQUEST['id'])) && ($_REQUEST['operation'] != '' && $_REQUEST['id'] != '')) {
        Update_tag($_REQUEST['id']);
    } else {
        Add_New_tag();
    }
} else {
    // Comment.
}

Get_All_tags();
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

                    <h3>Tags</h3>

                    <ul class="content-box-tabs">
                        <li><a href="#tab1" class="<?php if (!isset($_REQUEST['id'])) { echo 'default-tab'; }  ?>">Manage Tags</a></li>
                        <!-- href must be unique and match the id of target div -->
                        <li><a href="#tab2" class="<?php if (isset($_REQUEST['id'])) { echo 'default-tab'; }  ?>">Add Tag</a></li>
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
                                Tag Details Updated Successfully !!!.
                            </div>
                        </div>
                        <?php unset($_SESSION['STATUS']);  } ?>
                        <?php if (isset($_SESSION['STATUS']) && $_SESSION['STATUS'] == 1) { ?>
                        <div class="notification success png_bg">
                            <a href="#" class="close"><img src="resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
                            <div>
                                New Tag Added Successfully !!!;
                            </div>
                        </div>
                        <?php unset($_SESSION['STATUS']);  } ?>
                        <?php if (isset($_SESSION['STATUS']) && $_SESSION['STATUS'] == 0) {  ?>
                        <div class="notification error png_bg">
                            <a href="#" class="close"><img src="resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
                            <div>
                                Tag Already Exists !!!.
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
                                    <th>Tag</th>
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
                                    while ($tag = $tags -> fetch_assoc()) {

                                ?>
                                <tr>
                                    <td><input type="checkbox" value="<?php echo $tag['id']; ?>"/></td>
                                    <td><?php echo $sr; ?></td>
                                    <td><?php echo $tag['id']; ?></td>
                                    <td><?php echo $tag['tags']; ?></td>
                                    <td>
                                        <!-- Icons -->
                                        <a href="?operation=edit&id=<?php echo $tag['id']; ?>" title="Edit"><img src="resources/images/icons/pencil.png" alt="Edit" /></a>
                                        <a href="?operation=delete&id=<?php echo $tag['id']; ?>" title="Delete"><img src="resources/images/icons/cross.png" alt="Delete" /></a>
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
                                    <label>Tag Name</label>
                                    <input class="text-input medium-input datepicker" type="text" id="add-tag" name="tags" value="<?php echo $tag_name; ?>" required /> 
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