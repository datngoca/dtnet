<?php
$this->loadModel('PlaceUser');

/* kiểm tra khu vực có hợp lệ? */
$uid_place_user = '';
if (isset($_GET['place'])) $uid_place_user = $_GET['place'];
if ($uid_place_user  == '') exit(json_encode(array("result" => "false", "msg" => "invalid")));

$array_place_user_check = $this->PlaceUser->read($uid_place_user);
if ($array_place_user_check == null) exit(json_encode(array("result" => "false", "msg" => "no_place")));
if (!isset($array_place_user_check['id']) || $array_place_user_check['id'] == '') exit(json_encode(array("result" => "false", "msg" => "invalid_place")));



$str_approve = $this->request_api("place", "approve_user", $array_place_user_check, false);

$array_approve = json_decode($str_approve, true);

/* kiểm tra đã duyệt thành công hay chưa? */
$approve_result = '';
$approve_msg = '';

if (isset($array_approve['result']))  $approve_result = $array_approve['result'];
if (isset($array_approve['msg']))  $approve_msg = $array_approve['msg'];

if ($approve_result != 'ok') exit(json_encode(array("result" => "false", "msg" => $approve_msg, "info" => $str_approve)));

$id_place = '';
$uid_place = '';
if (isset($array_approve['last_id']))  $id_place = $array_approve['last_id'];
if (isset($array_approve['last_uid']))  $uid_place = $array_approve['last_uid'];
if ($id_place == '' || $uid_place == '') exit(json_encode(array("result" => "false", "msg" => "no_id_return")));

$approved = $array_place_user_check['approved'];
if ($approved == '1') $approve_value = 0;
else $approve_value = '1';

/* update approved */
$array_place_user = null;
$array_place_user['id'] = $array_place_user_check['id'];
$array_place_user['id_place'] = $id_place;
$array_place_user['uid_place'] = $uid_place;
$array_place_user['approved'] = "1";
$this->PlaceUser->save($array_place_user);

echo json_encode($array_approve);
