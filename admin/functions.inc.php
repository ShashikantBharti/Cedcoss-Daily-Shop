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

?>