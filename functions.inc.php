<?php 
function pr($arr) 
{
    echo "<pre>";
    print_r($arr);
}

function prx($arr)
{
    echo "<pre>";
    print_r($arr);
    die();
}
function get_safe_value($conn, $str) 
{
    if ($str != '') {
        $str = trim($str);
        return $conn -> real_escape_string($str);
    }
}

function get_product($conn, $prod_id='', $cat_id='', $tag_id='', $page_num='', $color='')
{
    $sql = "SELECT `products`.*,`categories`.`category` FROM `products`,`categories` WHERE `products`.`cat_id`=`categories`.`id`";
    if ($prod_id != '') {
        $sql .= " AND `products`.`id`='$prod_id'";
    } 
    if($cat_id != '') {
        $sql .= " AND `products`.`cat_id`='$cat_id'";
    } 
    if ($color != '') {
        $sql .= " AND `products`.`color`='$color'";
    }
    if ($tag_id != '') {
        $sql .= " AND `products`.`tags` LIKE '%$tag_id%'";
    }
    $sql .= " ORDER BY `products`.`id` DESC";
    if ($page_num == '') {
        $page_num = 1;
    }
    $limit = 12;
    $offset = ($page_num - 1) * $limit;
    $sql .= " LIMIT {$offset}, {$limit}";
    $result = $conn -> query($sql) or die("Product Selection Query Failed !!!.");
    $products = array();
    if ($result -> num_rows > 0) {
    while ($row = $result -> fetch_assoc()) {
        $products[] = $row;
    }
    }
    return $products;
}


class cart {
    function addProduct($id, $qty) {
        $_SESSION['CART'][$id]['qty'] = $qty;
    }
    function updateProduct($id, $qty) {
        if (isset($_SESSION['CART'][$id])) {
            $_SESSION['CART'][$id]['qty'] = $qty;
        }
    }
    function removeProduct($id) {
        if (isset($_SESSION['CART'][$id])) {
            unset($_SESSION['CART'][$id]);
        }
    }
    function emptyCart(){
        if (isset($_SESSION['CART'])) {
            unset($_SESSION['CART']);
        }
    }
    function totalProduct() {
        if (isset($_SESSION['CART'])) {
            return count($_SESSION['CART']);
        } else {
            return 0;
        }
    }

}

class user{
    function register($conn, $name, $email, $mobile, $password) {
        $added_on = date('Y-m-d h:i:s');
        
        $sql = "SELECT * FROM `users` WHERE `email`='$email'";
        $result = $conn -> query($sql) or die("Selection query failed !!!.");
        if ($result -> num_rows > 0) {
            return "Email Already Registered !!!.";
        } else {
            $sql = "INSERT INTO `users`(`name`, `email`, `mobile`, `password`, `address`, `added_on`) VALUES('$name', '$email', '$mobile', '$password', '', '$added_on')";
            if ($conn -> query($sql) == true) {
                return 1;
            } else {
                return "OOPs Something Went Wrong !!!.";
            }
        }

    }
    function login($conn, $email, $password) {
        $sql = "SELECT * FROM `users` WHERE `email` = '$email' AND `password` = '$password' ";
        $result = $conn -> query($sql) or die("Login Detail Selection Query Failed !!!.");
        if ($result -> num_rows > 0) {
            $row = $result -> fetch_assoc();
            $_SESSION['USER_ID'] = $row['id'];
            $_SESSION['USER_NAME'] = $row['name'];
            return true;
        } else {
            return false;
        }
    }
    function logout() {
        session_start();
        unset($_SESSION['USER_ID']);
        unset($_SESSION['USER_NAME']);
        header('location: account.php');
    }
}

class order {
    private $user_id;
    function __construct($user_id = '') {
        $this -> user_id = $user_id;
    }
    function placeOrder($conn, $payment_type = '', $payment_status = '', $total_amount = '', $shipping_status = ''){
        $user_id = $this -> user_id;
        $added_on = date('Y-m-d h:i:s');
        $sql = "INSERT INTO `orders`(`user_id`, `payment_type`, `payment_status`, `total_amount`, `shipping_status`, `added_on`) VALUES ('$user_id','$payment_type','$payment_status','$total_amount','$shipping_status','$added_on')";
        if ($conn -> query($sql) == true) {
            return true;
        } else {
            return false;
        }
    }
    function orderDetails($conn, $order_id = '', $product_id = '', $qty = '', $price = '') {
        $user_id = $this -> user_id;
        $sql = "INSERT INTO `order_details`(`user_id`, `order_id`, `product_id`, `qty`, `price`) VALUES ('$user_id', '$order_id', '$product_id', '$qty', '$price')";
        if ($conn -> query($sql) == true) {
            return true;
        } else {
            return false;
        }
    }
    function billingDetails($conn, $order_id='', $name='', $last_name='', $company_name='', $email='', $mobile='', $address='', $country='', $appartment='', $city='', $district='', $pincode=''){
        $user_id = $this -> user_id;
        $added_on = date('Y-m-d h:i:s');
        $sql = "INSERT INTO `billing_details`(`user_id`, `order_id`, `name`, `last_name`, `company_name`, `email`, `mobile`, `address`, `country`, `appartment`, `city`, `district`, `pincode`, `added_on`) VALUES ('$user_id','$order_id','$name','$last_name','$company_name','$email','$mobile','$address','$country','$appartment','$city','$district','$pincode','$added_on')";
        if ($conn -> query($sql) == true) {
            return true;
        } else {
            return false;
        }
    }
    function shippingDetails($conn, $order_id='', $name='',$last_name='',$company_name='',$email='',$mobile='',$address='',$country='',$appartment='',$city='',$district='',$pincode='',$comment = ''){
        $user_id = $this -> user_id;
        $added_on = date('Y-m-d h:i:s');
        $sql = "INSERT INTO `shipping_details`(`user_id`, `order_id`, `name`, `last_name`, `company_name`, `email`, `mobile`, `address`, `country`, `appartment`, `city`, `district`, `pincode`, `comment`,`added_on`) VALUES ('$user_id','$order_id','$name','$last_name','$company_name','$email','$mobile','$address','$country','$appartment','$city','$district','$pincode','$comment','$added_on')";
        if ($conn -> query($sql) == true) {
            return true;
        } else {
            return false;
        }
    }
}

?>