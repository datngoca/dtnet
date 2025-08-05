<?php
//Get place param
$uid_place_user = isset($array_param["place"]) ? $array_param["place"] : "";

//check valid place
if ($uid_place_user == "") exit(json_encode(array("result" => "false", "msg" => "missing_place")));

//lấy thông tin placeUser
$this->loadModel("PlaceUser");
$array_place_user = $this->PlaceUser->read($uid_place_user);
if (!$array_place_user) exit(json_encode(array("result" => "false", "msg" => "invalid_data")));

//get array place
$array_place = $array_place_user;

//remove id, uid prevent update
$array_place["id"] = "";
$array_place["uid"] = "";

//get id, uid place in array place user
$id_place = $array_place_user["id_place"];
$uid_place = $array_place_user["uid_place"];

$this->loadModel("Place");

//kiểm tra bảng ghi place_user kết nối với Place chưa?
if ($id_place == "") {
    //kiểm tra trường code đã có bên bảng Place chưa?
    $this->Place->cond("code", $array_place_user["code"]);
    $array_place_exist = $this->Place->get();
    if (!empty($array_place_exist)) exit(json_encode(array("result" => "false", "msg" => "already_exists")));

    // Cho insert mới - remove id, uid
    $array_place["id"] = "";
    $array_place["uid"] = "";
} else {
    //kiểm tra bảng ghi có tồn trong bảng place không?, nếu không có thì id_place = "" để insert
    $array_place_check = $this->Place->read($id_place);
    if (empty($array_place_check)) {
        $id_place = "";
        // Cho insert mới - remove id, uid
        $array_place["id"] = "";
        $array_place["uid"] = "";
    } else {
        // Cho update - giữ lại id và uid hiện tại
        $array_place["id"] = $id_place;
        $array_place["uid"] = $uid_place;
    }
}

//update array place
$array_place["id"] = $id_place;
$array_place["approved"] = "1";
$array_place["status"] = "1";
$this->Place->save($array_place);

/*check updating or inserting, get last id & uid*/
$msg = "approved";
$last_id_place = $id_place;
$last_uid_place = $uid_place;
if ($this->Place->last_action == "insert") {
    $msg = "approved";
    $last_id_place = $this->Place->last_id;
    $last_uid_place = $this->Place->last_uid;
}

//update array place_user, last_uid_place
$array_place_user_update = null;
$array_place_user_update["id"] = $array_place_user["id"];
$array_place_user_update["id_place"] = $last_id_place;
$array_place_user_update["uid_place"] = $last_uid_place;
$array_place_user_update["approved"] = "1";
$this->PlaceUser->save($array_place_user_update);

exit(json_encode(array("result" => "ok", "msg" => $msg, "data" => array("place" => $array_place_user["uid"]))));
