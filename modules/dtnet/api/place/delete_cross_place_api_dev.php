<?php

/*validate*/
if (!isset($array_param['place']) || ($array_param['place'] == ""))  exit(json_encode(array("result" => "false", "msg" => "missing_place")));
if (!isset($array_param['num']))  exit(json_encode(array("result" => "false", "msg" => "missing_num")));

$uid_place_user = $array_param['place'];
$num = $array_param['num'];
if (!is_numeric($num)) $num = 0;

/*lấy thông tin place */
$this->loadModel("PlaceUser");
$array_place_check = $this->PlaceUser->read($uid_place_user);
if ($array_place_check == null) exit(json_encode(array("result" => "false", "msg" => "missing_place")));

/*lấy id place */
$id_place_user = $array_place_check['id'];
if ($id_place_user == '') exit(json_encode(array("result" => "false", "msg" => "missing_id_place")));

/* lấy array cross của place */
$str_cross_existing = $array_place_check['str_cross'];

/*convert to array*/
$array_cross = json_decode($str_cross_existing, true);

/*remove item*/
if ($array_cross != null) unset($array_cross[$num]);


$array_place['id'] = $id_place_user;
$array_place['str_cross'] = json_encode($array_cross);
$array_place['approved'] = 0;

/**Lưu dữ liệu vào bảng user_places */
$this->PlaceUser->save($array_place);

echo json_encode(array("result" => "ok", "msg" => "deleted"));
