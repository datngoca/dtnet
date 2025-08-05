<?php
//Get street param
$uid_street_user = isset($array_param["street"]) ? $array_param["street"] : "";

//check valid street
if ($uid_street_user == "") exit(json_encode(array("result" => "false", "msg" => "no_uid")));

//lấy thông tin streetUser
$this->loadModel("StreetUser");
$array_street_user = $this->StreetUser->read($uid_street_user);
if (!$array_street_user) exit(json_encode(array("result" => "false", "msg" => "invalid_data")));

//get array street
$array_street = $array_street_user;

//remove id, uid prevent update
$array_street["id"] = "";
$array_street["uid"] = "";

//get id, uid street in array street user
$id_street = $array_street_user["id_street"];
$uid_street = $array_street_user["uid_street"];

$this->loadModel("Street");

//kiểm tra bảng ghi street_user kết nối với Street chưa?
if ($id_street == "") {
    //kiểm tra trường code đã có bên bảng Street chưa?
    $this->Street->cond("code", $array_street_user["code"]);
    $array_street_exist = $this->Street->get();
    if (!empty($array_street_exist)) exit(json_encode(array("result" => "false", "msg" => "street_exist")));

    // Cho insert mới - remove id, uid
    $array_street["id"] = "";
    $array_street["uid"] = "";
} else {
    //kiểm tra bảng ghi có tồn trong bảng street không?, nếu không có thì id_street = "" để insert
    $array_street_check = $this->Street->read($id_street);
    if (empty($array_street_check)) {
        $id_street = "";
        // Cho insert mới - remove id, uid
        $array_street["id"] = "";
        $array_street["uid"] = "";
    } else {
        // Cho update - giữ lại id và uid hiện tại
        $array_street["id"] = $id_street;
        $array_street["uid"] = $uid_street;
    }
}

//update array street
$array_street["id"] = $id_street;
$array_street["approved"] = "1";
$array_street["status"] = "1";
$this->Street->save($array_street);

/*check updating or inserting, get last id & uid*/
$msg = "update_ok";
$last_id_street = $id_street;
$last_uid_street = $uid_street;
if ($this->Street->last_action == "insert") {
    $msg = "insert_ok";
    $last_id_street = $this->Street->last_id;
    $last_uid_street = $this->Street->last_uid;
}

//update array street_user, last_uid_street
$array_street_user_update = null;
$array_street_user_update["id"] = $array_street_user["id"];
$array_street_user_update["id_street"] = $last_id_street;
$array_street_user_update["uid_street"] = $last_uid_street;
$array_street_user_update["approved"] = "1";
$this->StreetUser->save($array_street_user_update);

exit(json_encode(array("result" => "ok", "msg" => $msg, "data" => array("street" => $uid_street_user))));
