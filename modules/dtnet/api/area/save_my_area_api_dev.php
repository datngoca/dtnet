<?php
function validate($param_check)
{
    if ($param_check == NULL) return array("result" => "false", "msg" => "missing_data");
    if (!isset($param_check["lang"]) || ($param_check["lang"] == "")) return array("result" => "false", "msg" => "missing_lang");
    if (!isset($param_check["parent_str_code"]) || $param_check["parent_str_code"] == "") return array("result" => "false", "msg" => "missing_parent_code");
    if (!isset($param_check["code"]) || $param_check["code"] == "") return array("result" => "false", "msg" => "missing_code");
    return array("result" => "ok", "msg" => "valid");
}

$array_data = $array_param["array_data"];
$check = validate($array_data);
if ($check["result"] != "ok") exit(json_encode(array("result" => "false", "msg" => $check["msg"])));

$lang = $array_data['lang'];

$country_code = '';

/*lấy mã khu vực cha */
$parent_str_code = '';
if (isset($array_data['parent_str_code'])) $parent_str_code = $array_data['parent_str_code'];
if ($parent_str_code == '') exit(json_encode(array("result" => "false", "msg" => "missing_parent")));

/* lấy mã quốc gia */
$array_parent_code = explode('/', $parent_str_code);
if (isset($array_parent_code[0])) $country_code = $array_parent_code[0];
if ($country_code == '') exit(json_encode(array("result" => "false", "msg" => "missing_country")));

// $array_country =  $this->request_api("country", "info", array("code" => $country_code, "lang" => $lang));
$this->loadModel("Countries");
$this->Countries->cond("code", $country_code);
$this->Countries->cond("lang", $lang);
$array_country = $this->Countries->get();

if ($array_country == null) exit(json_encode(array("result" => "false", "msg" => "invalid_data")));

$array_country = $array_country[0];
$country_name = $array_country['name'];

/* xử lý code (true là k dấu gạch ngang) */
$array_data['code'] = trim($array_data['code']);
if ($array_data['code'] == '') $array_data['code'] = $this->MyString->remove_special_char($array_data['name'], true);

/* đọc thông tin của nhóm cha */
// $array_area_parent =  $this->request_api("area", "info", array("str_code" => $parent_str_code, "lang" => $lang));
$this->loadModel("Area");
$this->Area->cond("str_code", $parent_str_code);
$this->Area->cond("lang", $lang);
$array_area_parent = $this->Area->get();
if (isset($array_area_parent[0])) $array_area_parent = $array_area_parent[0];
/* cập nhập các trường cấp cha vào bảng user_area */
$parent_code = '';
$parent_name = '';
$parent_str_name = '';
$parent_str_code_reverse = '';
$parent_str_name_reverse = '';

$parent_str_address = '';

/* nếu có dữ liệu nhóm cha */
if ($array_area_parent != null) {
    $parent_code = $array_area_parent['code'];

    $parent_str_code = $array_area_parent['str_code'];

    $parent_str_code_reverse = $array_area_parent['str_code_reverse'];

    $parent_name = $array_area_parent['name'];
    $parent_str_name = $array_area_parent['str_name'];
    $parent_str_name_reverse = $array_area_parent['str_name_reverse'];

    $parent_str_address = $array_area_parent['str_address'];
} else {
    $parent_code = $country_code;
    $parent_str_code = $country_code;
    $parent_str_code_reverse = $country_code;

    $parent_name = $country_name;
    $parent_str_name = $country_name;
    $parent_str_name_reverse = $country_name;

    $parent_str_address = $country_name;
}

$array_data['lang'] = $lang;
$array_data['country_code'] = $country_code;
$array_data['country_name'] = $country_name;

$array_data['str_code'] = $parent_str_code . "/" . $array_data['code'];
$array_data['parent_code'] = $parent_code;
$array_data['str_code_reverse'] = $array_data['code'] . "/" . $parent_str_code_reverse;

$array_data['str_name'] = $parent_str_name . ", " . $array_data['name'];
$array_data['parent_name'] = $parent_name;
$array_data['parent_str_name'] = $parent_str_name;
$array_data['str_name_reverse'] = $array_data['name'] . "," . $parent_str_name_reverse;
$array_data['str_address'] = $array_data['name_address'] . ", " . $parent_str_address;

$array_data['url_key'] = str_replace('/', '-', $array_data['str_code_reverse']);

/* lấy thông tin người nhập hiện tại */
$array_data['id_user'] = $this->CurrentUser->id;
$array_data['uid_user'] = $this->CurrentUser->uid;
$array_data['user_fullname'] = $this->CurrentUser->fullname;
$array_data['created'] = date("Y-m-d H:i:s");
$array_data['status'] = 0;
$array_data['approved'] = 0;


/*check update*/
$this->loadModel('AreaUser');
$uid_area_user = $array_data["area"];
if ($uid_area_user != "") {
    $array_check = $this->AreaUser->read($uid_area_user);
    if ($array_check) $array_data["id"] = $array_check["id"];
}

/*Lưu dữ liệu vào bảng user_areas */
$this->AreaUser->save($array_data);

$last_uid_area = $uid_area_user;
if ($this->AreaUser->last_action == "insert") {
    $last_uid_area = $this->AreaUser->last_uid;
    $msg = "created";
} else {
    $msg = "updated";
}
echo json_encode(array("result" => "ok", "msg" => $msg, "data" => array("area" => $last_uid_area)));
