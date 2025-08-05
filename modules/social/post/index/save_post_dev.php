<?php

$array_data = $_POST['data'];
// Đổi tên trường place_in thành uid_place nếu có
if (isset($array_data["place_in"])) {
    $array_data["uid_place"] = $array_data["place_in"];
    unset($array_data["place_in"]);
}

// Validate required fields
if (!isset($array_data["lang"]) || $array_data["lang"] == "") {
    exit(json_encode(array("result" => "false", "msg" => "no_lang")));
}

if (!isset($array_data["area_str_code"]) || $array_data["area_str_code"] == "") {
    exit(json_encode(array("result" => "false", "msg" => "no_area_str_code")));
}

if (!isset($array_data["uid_street"]) || $array_data["uid_street"] == "") {
    exit(json_encode(array("result" => "false", "msg" => "no_street")));
}

if (!isset($array_data["uid_place"]) || $array_data["uid_place"] == "") {

    exit(json_encode(array("result" => "false", "msg" => "no_place")));
}

if (!isset($array_data["type"]) || $array_data["type"] == "") {
    exit(json_encode(array("result" => "false", "msg" => "no_type")));
}

if (!isset($array_data["category"]) || $array_data["category"] == "") {
    exit(json_encode(array("result" => "false", "msg" => "no_category")));
}

if (!isset($array_data["title"]) || $array_data["title"] == "") {
    exit(json_encode(array("result" => "false", "msg" => "no_title")));
}


// Optional fields with defaults
if (!isset($array_data["sent"])) {
    $array_data["sent"] = "0";
}

if (!isset($array_data["post"])) {
    $array_data["post"] = "";
}

// Call API to save post
$array_result = $this->request_api("post", "save_my", $array_data, false);

exit($array_result);
