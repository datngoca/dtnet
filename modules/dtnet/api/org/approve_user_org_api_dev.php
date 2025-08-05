<?php
//Get org param
$uid_org_user = isset($array_param["org"]) ? $array_param["org"] : "";

//check valid org
if ($uid_org_user == "") exit(json_encode(array("result" => "false", "msg" => "missing_org")));

//lấy thông tin OrgUser
$this->loadModel("OrgUser");
$array_org_user = $this->OrgUser->read($uid_org_user);
if (!$array_org_user) exit(json_encode(array("result" => "false", "msg" => "invalid_data")));

//get array org
$array_org = $array_org_user;

//remove id, uid prevent update
$array_org["id"] = "";
$array_org["uid"] = "";

//get id, uid org in array org user
$id_org = $array_org_user["id_org"];
$uid_org = $array_org_user["uid_org"];

$this->loadModel("Org");

//kiểm tra bảng ghi org_user kết nối với Org chưa?
if ($id_org == "") {
    //kiểm tra trường code đã có bên bảng Org chưa?
    $this->Org->cond("code", $array_org_user["code"]);
    $array_org_exist = $this->Org->get();
    if (!empty($array_org_exist)) exit(json_encode(array("result" => "false", "msg" => "already_exists")));

    // Cho insert mới - remove id, uid
    $array_org["id"] = "";
    $array_org["uid"] = "";
} else {
    //kiểm tra bảng ghi có tồn trong bảng Org không?, nếu không có thì id_org = "" để insert
    $array_org_check = $this->Org->read($id_org);
    if (empty($array_org_check)) {
        $id_org = "";
        // Cho insert mới - remove id, uid
        $array_org["id"] = "";
        $array_org["uid"] = "";
    } else {
        // Cho update - giữ lại id và uid hiện tại
        $array_org["id"] = $id_org;
        $array_org["uid"] = $uid_org;
    }
}

//update array org
$array_org["id"] = $id_org;
$array_org["approved"] = "1";
$array_org["status"] = "1";
$this->Org->save($array_org);

/*check updating or inserting, get last id & uid*/
$msg = "approved";
$last_id_org = $id_org;
$last_uid_org = $uid_org;
if ($this->Org->last_action == "insert") {
    $msg = "approved";
    $last_id_org = $this->Org->last_id;
    $last_uid_org = $this->Org->last_uid;
}

//update array org_user, last_uid_org
$array_org_user_update = null;
$array_org_user_update["id"] = $array_org_user["id"];
$array_org_user_update["id_org"] = $last_id_org;
$array_org_user_update["uid_org"] = $last_uid_org;
$array_org_user_update["approved"] = "1";
$this->OrgUser->save($array_org_user_update);

exit(json_encode(array("result" => "ok", "msg" => $msg, "data" => array("org" => $array_org_user["uid"]))));
