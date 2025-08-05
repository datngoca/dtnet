<?php
//Get area param
$uid_area_user = isset($array_param["area"]) ? $array_param["area"] : "";

//check valid area
if ($uid_area_user == "") exit(json_encode(array("result" => "false", "msg" => "missing_area")));

//lấy thông tin areaUser
$this->loadModel("AreaUser");
$array_area_user = $this->AreaUser->read($uid_area_user);
if (!$array_area_user) exit(json_encode(array("result" => "false", "msg" => "invalid_data")));

//get array area
$array_area = $array_area_user;

//remove id, uid prevent update
$array_area["id"] = "";
$array_area["uid"] = "";

//get id, uid area in array area user
$id_area = $array_area_user["id_area"];
$uid_area = $array_area_user["uid_area"];

$this->loadModel("Area");

//kiểm tra bảng ghi Area_user kết nối với Area chưa?
if ($id_area == "") {
    //kiểm tra trường code đã có bên bảng Area chưa?
    $this->Area->cond("code", $array_area_user["code"]);
    $array_area_exist = $this->Area->get();
    if ($array_area_exist != null) exit(json_encode(array("result" => "false", "msg" => "already_exists")));
} else {
    //kiểm tra bảng ghi có tồn trong bảng area không?, nếu không có thì id_area = "" để insert
    $array_area_check = $this->Area->read($id_area);
    if ($array_area_check == null)  $id_area = "";
}

//update array area
$array_area["id"] = $id_area;
$array_area["approved"] = "1";
$array_area["status"] = "1";
$this->Area->save($array_area);

/*check updating or inserting, get last id & uid*/
$msg = "approved";
$last_id_area = $id_area;
$last_uid_area = $uid_area;
if ($this->Area->last_action == "insert") {
    $msg = "approved";
    $last_id_area = $this->Area->last_id;
    $last_uid_area = $this->Area->last_uid;
}

//update array area_user, last_uid_area
$array_area_user_update = null;
$array_area_user_update["id"] = $array_area_user["id"];
$array_area_user_update["id_area"] = $last_id_area;
$array_area_user_update["uid_area"] = $last_uid_area;
$array_area_user_update["approved"] = "1";
$this->AreaUser->save($array_area_user_update);

exit(json_encode(array("result" => "ok", "msg" => $msg, "data" => array("area" => $array_area_user["uid"]))));
