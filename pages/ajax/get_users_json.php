<?php
include_once('../func/config.php');

$user_data = array();
$users = $db->query("select * from users");

foreach($users as $key => $val)
{
    $user_data[$key]['id'] = $val['ID'];
    $user_data[$key]['name'] = $val['Username'];
    $user_data[$key]['avatar'] = "https://cdn.w3lessons.info/logo.png";
    $user_data[$key]['type'] = 'user';
}
header('Content-Type: application/json');
echo json_encode($user_data);