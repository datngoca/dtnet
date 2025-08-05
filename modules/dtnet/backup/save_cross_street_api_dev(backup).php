<?php
/*validate*/
if (!isset($array_param['area_cross']) || ($array_param['area_cross'] == ""))  exit(json_encode(array("result" => "false", "msg" => "no_area")));
if (!isset($array_param['street']) || ($array_param['street'] == ""))  exit(json_encode(array("result" => "false", "msg" => "no_street")));
if (!isset($array_param['edit']))  exit(json_encode(array("result" => "false", "msg" => "no_edit_number")));

$area_str_code = $array_param['area_cross'];
$uid_user_street = $array_param['street'];
$edit_num = $array_param['edit'];

/*lấy thông tin street */
$this->loadModel("StreetUser");
$array_street_check = $this->StreetUser->read($uid_user_street);
if ($array_street_check == null) exit(json_encode(array("result" => "false", "msg" => "no_street")));

/*lấy id street */
$id_user_street = $array_street_check['id'];
if ($id_user_street == '') exit(json_encode(array("result" => "false", "msg" => "no_id_street")));

/* lấy array cross của street */
$str_cross_existing = $array_street_check['str_cross'];

/*convert to array*/
$array_cross = json_decode($str_cross_existing, true);


$num_cross = 0;
if ($array_cross != null) $num_cross  = count($array_cross);

/*append */
$array_cross[] = $area_str_code;

/**Lưu dữ liệu vào bảng user_streets */
$array_street['id'] = $id_user_street;
$array_street['str_cross'] = json_encode($array_cross);
$array_street['approved'] = 0;

$this->StreetUser->save($array_street);

echo json_encode(array("result" => "ok", "msg" => "save_ok", "data" => json_encode($array_cross)));
