<?php

$array_data = $array_param;

if (!isset($array_data["lang"])) exit(json_encode(array("result" => "false", "msg" => "missing_lang")));
if (!isset($array_data["area_str_code"])) exit(json_encode(array("result" => "false", "msg" => "missing_area_code")));
if (!isset($array_data["uid_street"])) exit(json_encode(array("result" => "false", "msg" => "missing_street")));
if (!isset($array_data["place_in"])) exit(json_encode(array("result" => "false", "msg" => "missing_place_in")));
if (!isset($array_data["place"])) exit(json_encode(array("result" => "false", "msg" => "missing_place")));

if (!isset($array_data["name"]) || $array_data["name"] == "") exit(json_encode(array("result" => "false", "msg" => "missing_name")));
if (!isset($array_data["code"])) exit(json_encode(array("result" => "false", "msg" => "missing_code")));

// Thêm các trường mới
$array_data["street_number"] = isset($array_data["street_number"]) ? $array_data["street_number"] : "";
$array_data["section"] = isset($array_data["section"]) ? $array_data["section"] : "";
$array_data["floor"] = isset($array_data["floor"]) ? $array_data["floor"] : "";
$array_data["room"] = isset($array_data["room"]) ? $array_data["room"] : "";
$array_data["des_short"] = isset($array_data["des_short"]) ? $array_data["des_short"] : "";
$array_data["des"] = isset($array_data["des"]) ? $array_data["des"] : "";
$array_data["content"] = isset($array_data["content"]) ? $array_data["content"] : "";
$array_data["sent"] = isset($array_data["sent"]) ? $array_data["sent"] : 0;

$lang = $array_data["lang"];
$code = $array_data["code"];

if ($code == "")    $code = $this->MyString->remove_special_char($array_data['name']);

$uid_place_user = $array_data['place'];

/*area, street, place_in*/
$area_str_code = $array_data['area_str_code'];
$uid_str_street = $array_data['uid_street'];
$uid_place_in = $array_data['place_in'];

/* Load models */
$this->loadModel('Area');
$this->loadModel('Street');
$this->loadModel('Place');

/* Get area info */
$this->Area->cond('str_code', $area_str_code);
$array_area_result = $this->Area->get();
if (!$array_area_result) exit(json_encode(array("result" => "false", "msg" => "missing_area_info")));

// Kiểm tra nếu kết quả là mảng số, lấy phần tử đầu tiên
if (isset($array_area_result[0]) && is_array($array_area_result[0])) {
    $array_area_result = $array_area_result[0];
}
$array_area = $array_area_result;
$array_data["id_area"] = $array_area["id"];
$array_data["uid_area"] = isset($array_area["uid"]) ? $array_area["uid"] : "";
$array_data['code'] = $code;
$array_data["area_name"] = $array_area["name"];
$array_data["area_code"] = isset($array_area["code"]) ? $array_area["code"] : "";
$array_data["area_str_code"] = isset($array_area["str_code"]) ? $array_area["str_code"] : "";
$array_data["area_str_name"] = isset($array_area["str_name"]) ? $array_area["str_name"] : "";
$array_data["area_str_name_reverse"] = isset($array_area["str_name_reverse"]) ? $array_area["str_name_reverse"] : "";

$array_data["country_code"] = isset($array_area["country_code"]) ? $array_area["country_code"] : "";
$array_data["country_name"] = isset($array_area["country_name"]) ? $array_area["country_name"] : "";

// Chỉ gán des_short = area name nếu des_short chưa có giá trị từ input
if (empty($array_data['des_short'])) {
    $array_data['des_short'] = $array_area['name'];
}

/*street info*/
$array_street_result = $this->Street->read($uid_str_street);
if (!$array_street_result) exit(json_encode(array("result" => "false", "msg" => "missing_street_info", "debug" => $uid_str_street)));

// Kiểm tra nếu kết quả là mảng số, lấy phần tử đầu tiên
if (isset($array_street_result[0]) && is_array($array_street_result[0])) {
    $array_street_result = $array_street_result[0];
}
$array_street = $array_street_result;
$array_data['id_street'] = $array_street['id'];
$array_data['uid_street'] = $array_street['uid'];
$array_data['street_name'] = $array_street['name'];
$array_data['street_code'] = $array_street['code'];
$street_code = $array_street['code'];

/*place_in info*/
$array_place_in = null;
if ($uid_place_in != "") {
    $array_place_in = $this->Place->read($uid_place_in);
    if ($array_place_in) {
        $array_data['id_place_in'] = $array_place_in['id'];
        $array_data['uid_place_in'] = $array_place_in['uid'];
        $array_data['place_name_in'] = $array_place_in['name'];
        $array_data['place_code_in'] = $array_place_in['code'];
    }
}

/*$area_str_code*/
$area_str_code = isset($array_area["str_code"]) ? trim($array_area["str_code"], "/") : "";
$area_str_code = str_replace("/", "-", $area_str_code);

$area_str_code_reverse = isset($array_area["str_code_reverse"]) ? trim($array_area["str_code_reverse"], "/") : "";
$area_str_code_reverse = str_replace("/", "-", $area_str_code_reverse);



/*str_code*/
if ($street_code == "") $street_code = "nostreet";
$str_code = $code;
if ($area_str_code != "") $str_code = $area_str_code . "-" . $street_code . "-" . $code;
$array_data["str_code"] = $str_code;

/*str_code_reverse*/
$str_code_reverse = $code;
if ($str_code_reverse != "") $str_code_reverse = $code . "-" . $street_code . "-" . $area_str_code_reverse;
$array_data['url_key'] = $str_code_reverse;


/* lấy thông tin người nhập hiện tại */
$array_data['id_user'] = $this->CurrentUser->id;
$array_data['uid_user'] = $this->CurrentUser->uid;
$array_data['user_fullname'] = $this->CurrentUser->fullname;
$array_data['username'] = $this->CurrentUser->username;
$array_data['user_email'] = $this->CurrentUser->email;

$array_data['created'] = date("Y-m-d H:i:s");
$array_data['status'] = 0;
$array_data['approved'] = 0;

/* load model user_places */
$this->loadModel('PlaceUser');


/*check update*/
$uid_place_user = isset($array_data["place"]) ? $array_data["place"] : "";
if ($uid_place_user != "") {
    $array_check = $this->PlaceUser->read($uid_place_user);
    if ($array_check) $array_data["id"] = $array_check["id"];
}

$this->PlaceUser->save($array_data);


$last_uid_place_user = $uid_place_user;
if ($this->PlaceUser->last_action == "insert") {
    $last_uid_place_user = $this->PlaceUser->last_uid;
    $msg = "created";
} else {
    $msg = "updated";
}

echo json_encode(array("result" => "ok", "msg" => $msg, "place" => $last_uid_place_user));
