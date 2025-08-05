<?php
$array_country_user = $array_param;

$this->loadModel("CountryUser");
$msg = "insert_ok";
$is_update = false;
$uid_country = isset($array_country_user["country"]) ? $array_country_user["country"] : "";
if ($uid_country !== "") {
    $array_country_check = $this->CountryUser->read($uid_country);
    if ($array_country_check) {
        $msg = "update_ok";
        $is_update = true;
        $array_country_user["id"] = $array_country_check["id"];
    }
}

//Them thong tin nguoi dung hien tai
$array_country_user["id_user"] = $this->CurrentUser->id;
$array_country_user["uid_user"] = $this->CurrentUser->uid;
$array_country_user["username"] = $this->CurrentUser->username;
$array_country_user["approved"] = "0";

//lưu dữ liệu vào bảng country_users
$this->CountryUser->save($array_country_user);

if (!$is_update) {
    $uid_country = $this->CountryUser->last_uid;
}
//chuyển về danh sách user
echo json_encode(array("result" => "ok", "msg" => $msg, "data" => array("country" => $uid_country)));
