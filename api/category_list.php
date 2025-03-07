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

$sql = "SELECT * FROM category";
$db->sql($sql);
$res = $db->getResult();
$num = $db->numRows($res);

if ($num >= 1) {
    $rows = [];
    foreach ($res as $row) {
        $temp['id'] = $row['id'];
        $temp['name'] = $row['name'];
        $temp['image'] = DOMAIN_URL . $row['image'];
        $rows[] = $temp;
    }
    $response['success'] = true;
    $response['message'] = "Category listed Successfully";
    $response['data'] = $rows;
    echo json_encode($response);
} else {
    $response['success'] = false;
    $response['message'] = "No Category Found";
    echo json_encode($response);
}
?>  