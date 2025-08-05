<?php
//Get country param
$uid_country_user = isset($array_param["country"]) ? $array_param["country"] : "";

//check valid country
if ($uid_country_user == "") exit(json_encode(array("result" => "false", "msg" => "no_uid")));

//lấy thông tin CountryUser
$this->loadModel("CountryUser");
$array_country_user = $this->CountryUser->read($uid_country_user);
if (!$array_country_user)  exit(json_encode(array("result" => "false", "msg" => "invalid_data")));

//get array country
$array_country = $array_country_user;

//reset 2 trường id và uid
$array_country["id"] = "";
$array_country["uid"] = "";

//get id, uid country in array country user để xác định country user kết nối với countries chưa?s
$id_country = $array_country_user["id_country"];
$uid_country = $array_country_user["uid_country"];

if ($id_country === "0") $id_country = "";

$this->loadModel("Countries");

//kiểm tra bảng ghi Country_user kết nối với Countries chưa?
if ($id_country == "") {
    //kiểm tra trường code đã có bên bảng country chưa?
    $this->Countries->cond("code", $array_country_user["code"]);
    $this->Countries->cond("lang", $array_country_user["lang"]);

    $array_country_exist = $this->Countries->get();
    if (!empty($array_country_exist)) exit(json_encode(array("result" => "false", "msg" => "country_exist")));
} else {
    //kiểm tra bảng ghi có tồn trong bảng country không?, nếu không có thì id_country = "" để insert
    $array_country_check = $this->Countries->read($id_country);
    if (empty($array_country_check)) {
        $id_country = "";
        $uid_country = "";
    }
}

//update array country
$array_country["id"] = $id_country;
$array_country["status"] = "1";
$array_country["approved"] = "1";
$this->Countries->save($array_country);

/*check updating or inserting, get last id & uid*/
$msg = "update_ok";
$last_id_country = $id_country;
$last_uid_country = $uid_country;
if ($this->Countries->last_action == "insert") {
    $msg = "insert_ok";
    $last_id_country = $this->Countries->last_id;
    $last_uid_country = $this->Countries->last_uid;
}

//update array country_user, last_uid_country
$array_country_user_update = null;
$array_country_user_update["id"] = $array_country_user["id"];
$array_country_user_update["id_country"] = $last_id_country;
$array_country_user_update["uid_country"] = $last_uid_country;
$array_country_user_update["approved"] = "1";
$this->CountryUser->save($array_country_user_update);

exit(json_encode(array("result" => "ok", "msg" => $msg, "data" => array("country" => $array_country_user["uid"]))));
