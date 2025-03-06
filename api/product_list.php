<?php
header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");
header("Expires: 0");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");


include_once('../includes/crud.php');

$db = new Database();
$db->connect();
date_default_timezone_set('Asia/Kolkata');

if (empty($_POST['category_id'])) {
    $response['success'] = false;
    $response['message'] = "Category Id is Empty";
    print_r(json_encode($response));
    return false;
}
$category_id = $db->escapeString($_POST['category_id']);

$sql = "SELECT * FROM product WHERE category_id = '$category_id'";
$db->sql($sql);
$res = $db->getResult();
$num = $db->numRows($res);
if ($num >= 1) {
    foreach ($res as $row) {
        $temp['id'] = $row['id'];
        $temp['category_id'] = $row['category_id'];
        $temp['name'] = $row['name'];
        $temp['unit'] = $row['unit'];
        $temp['measurement'] = $row['measurement'];
        $temp['price'] = $row['price'];
        $temp['description'] = $row['description'];
        $temp['ratings'] = $row['ratings'];
        $temp['discount_percentage'] = $row['discount_percentage'];
        $temp['mrp'] = $row['mrp'];
        $temp['image'] = DOMAIN_URL . $row['image'];
        $rows[] = $temp;
    }
    $response['success'] = true;
    $response['message'] = "Products listed Successfully";
    $response['data'] = $rows;
    print_r(json_encode($response));

}else{
    $response['success'] = false;
    $response['message'] = "No Results Found";
    print_r(json_encode($response));

}




?>