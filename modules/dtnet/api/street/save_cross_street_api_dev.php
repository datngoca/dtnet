<?php
/*validate*/
if (!isset($array_param['area_cross']) || ($array_param['area_cross'] == ""))  exit(json_encode(array("result" => "false", "msg" => "missing_area")));
if (!isset($array_param['street']) || ($array_param['street'] == ""))  exit(json_encode(array("result" => "false", "msg" => "missing_street")));
if (!isset($array_param['edit']))  exit(json_encode(array("result" => "false", "msg" => "no_edit_number")));

$area_str_code = $array_param['area_cross'];
$uid_user_street = $array_param['street'];
$edit_num = $array_param['edit'];

/*lấy thông tin street */
$this->loadModel("StreetUser");
$array_street_check = $this->StreetUser->read($uid_user_street);
if ($array_street_check == null) exit(json_encode(array("result" => "false", "msg" => "missing_street")));

/*lấy id street */
$id_user_street = $array_street_check['id'];
if ($id_user_street == '') exit(json_encode(array("result" => "false", "msg" => "no_id_street")));

/* lấy array cross của street */
$str_cross_existing = $array_street_check['str_cross'];

/*convert to array*/
$array_cross = json_decode($str_cross_existing, true);

$num_cross = 0;
if ($array_cross != null) $num_cross  = count($array_cross);

/*check if edit_num is not empty and is a valid index*/
if ($edit_num !== '' && $edit_num !== null) {
    $edit_index = intval($edit_num);

    // Validate edit_index
    if ($edit_index < 0 || ($array_cross != null && $edit_index >= count($array_cross))) {
        exit(json_encode(array("result" => "false", "msg" => "invalid_edit_index")));
    }

    // Update existing element
    if ($array_cross == null) {
        $array_cross = array();
    }
    $array_cross[$edit_index] = $area_str_code;
} else {
    /*append new element*/
    $array_cross[] = $area_str_code;
}

/**Lưu dữ liệu vào bảng user_streets */
$array_street['id'] = $id_user_street;
$array_street['str_cross'] = json_encode($array_cross);
$array_street['approved'] = "0";

$this->StreetUser->save($array_street);

echo json_encode(array("result" => "ok", "msg" => "created", "data" => json_encode($array_cross)));
