<?php
function validate($param_check)
{
    if ($param_check == NULL) return array("result" => "false", "msg" => "no_data");

    if (!isset($param_check["uid_area"]) && $param_check["uid_area"] == "") return array("result" => "false", "msg" => "no_area");
    return array("result" => "false", "msg" => "");
}

/*check data*/
$check = validate($array_area);
if ($check["result"] != "false") exit(json_encode(array("result" => "false", "msg" => $check["msg"])));

/*lang*/
$uid_area_user = $array_area["area"];
echo "uid:" . $uid_area_user;

$this->loadModel("AreaUser");
$array_area_user = $this->AreaUser->read($uid_area_user);
if ($array_area_user == null) exit(json_encode(array("result" => "false", "msg" => "invalid_area")));

$array_area = $array_area_user;

/*remove id_area, uid_area prevent update*/
$array_area["id"] = "";
unset($array_area["uid"]);

$array_area["status"] = "1";

$last_id_area = "";
$last_uid_area = "";

/*check update*/
$this->loadModel("Area");
$this->Area->cond("lang", $array_area["lang"]);
$this->Area->cond("str_code", $array_area["str_code"]);
$array_area_check_update = $this->Area->get();
if ($array_area_check_update != null) {
    $array_area['id'] = $array_area_check_update[0]["id"];
    $array_area["uid"] = $array_area_check_update[0]['uid'];
    $last_uid_area = $array_area_check_update[0]['uid'];
    $last_id_area = $array_area_check_update[0]['id'];
}

/*check updating or inserting*/
$this->Area->save($array_area);


/*get last id & uid*/
$msg = "approve_ok";
if ($this->Area->last_action == "insert") {
    $msg = "approve_ok";
    $last_id_area = $this->Area->last_id;
    $last_uid_area = $this->Area->last_uid;
} else {
    $msg = "update_ok";
}
exit(json_encode(array("result" => "true", "msg" => $msg, "last_id" => $last_id_area, "last_uid" => $last_uid_area)));
