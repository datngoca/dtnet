<?php
function validate($param_check)
{
    if ($param_check == NULL) return array("result" => "false", "msg" => "invalid_data");
    if (!isset($param_check["lang"]) || ($param_check["lang"] == "")) return array("result" => "false", "msg" => "no_lang");
    if (!isset($param_check["area_str_code"]) || $param_check["area_str_code"] == "") return array("result" => "false", "msg" => "no_area_code");
    if (!isset($param_check["name"]) || $param_check["name"] == "") return array("result" => "false", "msg" => "no_name");
    if (!isset($param_check["code"])) return array("result" => "false", "msg" => "no_code");
    return array("result" => "ok", "msg" => "valid");
}

$array_data = $array_param["array_data"];
$check = validate($array_data);
if ($check["result"] != "ok") exit(json_encode(array("result" => "false", "msg" => $check["msg"])));

$lang = $array_data["lang"];
$code = $array_data["code"];

if ($code == "") $code = $this->MyString->remove_special_char($array_data['name']);

/*lấy mã khu vực*/
$area_str_code = $array_data['area_str_code'];

/* đọc thông tin khu vực */
// $array_area_data = $this->request_api("area", "info", array("str_code" => $area_str_code, "lang" => $lang));
// $array_area = isset($array_area_data["data"]) ? $array_area_data["data"] : null;

$this->loadModel("Area");
$this->Area->cond("str_code", $area_str_code);

$this->Area->cond("lang", $lang);
$array_area = $this->Area->get();
if (isset($array_area[0])) $array_area = $array_area[0];

if ($array_area == null) exit(json_encode(array("result" => "false", "msg" => "invalid_data")));

$array_data["id_area"] = $array_area["id"];
$array_data["uid_area"] = $array_area["uid"];
$array_data['code'] = $code;
$array_data["area_name"] = $array_area["name"];
$array_data["area_code"] = $array_area["code"];
$array_data["area_str_code"] = $array_area["str_code"];
$array_data["area_str_name"] = $array_area["str_name"];
$array_data["country_code"] = $array_area["country_code"];

/*$area_str_code*/
$area_str_code = trim($array_area["str_code"], "/");
$area_str_code = str_replace("/", "-", $area_str_code);

$area_str_code_reverse = trim($array_area["str_code_reverse"], "/");
$area_str_code_reverse = str_replace("/", "-", $area_str_code_reverse);

/*str_code*/
$str_code = $code;
if ($area_str_code != "") $str_code = $area_str_code . "-" . $code;
$array_data["str_code"] = $str_code;

/*str_code_reverse*/
$str_code_reverse = $code;
if ($str_code_reverse != "") $str_code_reverse = $code . "-" . $area_str_code_reverse;
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

/* load model user_streets */
$this->loadModel('StreetUser');

/*check update*/
$uid_street_user = $array_data["street"];
if ($uid_street_user != "") {
    $array_check = $this->StreetUser->read($uid_street_user);
    if ($array_check) $array_data["id"] = $array_check["id"];
}

$this->StreetUser->save($array_data);

$last_uid_street_user = $uid_street_user;
if ($this->StreetUser->last_action == "insert") {
    $last_uid_street_user = $this->StreetUser->last_uid;
    $msg = "insert_ok";
} else {
    $msg = "update_ok";
}

echo json_encode(array("result" => "ok", "msg" => $msg, "data" => array("street" => $last_uid_street_user)));
