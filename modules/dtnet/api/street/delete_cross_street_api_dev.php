<?php

/*validate*/
if (!isset($array_param['street']) || ($array_param['street'] == ""))  exit(json_encode(array("result" => "false", "msg" => "missing_street")));
if (!isset($array_param['num']))  exit(json_encode(array("result" => "false", "msg" => "missing_num")));

$uid_street_user = $array_param['street'];
$num = $array_param['num'];
if (!is_numeric($num)) $num = 0;

/*lấy thông tin street */
$this->loadModel("StreetUser");
$array_street_check = $this->StreetUser->read($uid_street_user);
if ($array_street_check == null) exit(json_encode(array("result" => "false", "msg" => "missing_street")));

/*lấy id street */
$id_street_user = $array_street_check['id'];
if ($id_street_user == '') exit(json_encode(array("result" => "false", "msg" => "no_id_street")));

/* lấy array cross của street */
$str_cross_existing = $array_street_check['str_cross'];

/*convert to array*/
$array_cross = json_decode($str_cross_existing, true);

/*remove item*/
if ($array_cross != null) unset($array_cross[$num]);


$array_street['id'] = $id_street_user;
$array_street['str_cross'] = json_encode($array_cross);
$array_street['approved'] = 0;

/**Lưu dữ liệu vào bảng user_streets */
$this->StreetUser->save($array_street);

echo json_encode(array("result" => "ok", "msg" => "deleted"));
