<?php
//Get lang param
$uid_lang_user = isset($array_param["lang"]) ? $array_param["lang"] : "";

//check valid lang
if ($uid_lang_user == "") exit(json_encode(array("result" => "false", "msg" => "no_uid")));

//lấy thông tin languageUser
$this->loadModel("LanguageUser");
$array_lang_user = $this->LanguageUser->read($uid_lang_user);
if (!$array_lang_user)  exit(json_encode(array("result" => "false", "msg" => "invalid_data")));

//get array language
$array_lang = $array_lang_user;

//get id, uid lang in array lang user
$id_lang = $array_lang_user["id_lang"];
$uid_lang = $array_lang_user["uid_language"];

$this->loadModel("Language");

//kiểm tra bảng ghi Language_user kết nối với Language chưa?
if ($id_lang == "") {
    //kiểm tra trường code đã có bên bảng language chưa?
    $this->Language->cond("code", $array_lang_user["code"]);
    $array_lang_exist = $this->Language->get();
    if (!empty($array_lang_exist)) exit(json_encode(array("result" => "false", "msg" => "already_exists")));

    // Cho insert mới - remove id, uid
    $array_lang["id"] = "";
    $array_lang["uid"] = "";
} else {
    //kiểm tra bảng ghi có tồn trong bảng language không?, nếu không có thì id_lang = "" để insert
    $array_lang_check = $this->Language->read($id_lang);
    if (empty($array_lang_check)) {
        $id_lang = "";
        // Cho insert mới - remove id, uid
        $array_lang["id"] = "";
        $array_lang["uid"] = "";
    } else {
        // Cho update - giữ lại id và uid hiện tại
        $array_lang["id"] = $id_lang;
        $array_lang["uid"] = $uid_lang;
    }
}

//update array lang
$array_lang["id"] = $id_lang;
$array_lang["status"] = "1";
$array_lang["approve"] = "1";
$this->Language->save($array_lang);

/*check updating or inserting, get last id & uid*/
$msg = "approved";
$last_id_lang = $id_lang;
$last_uid_lang = $uid_lang;
if ($this->Language->last_action == "insert") {
    $msg = "approved";
    $last_id_lang = $this->Language->last_id;
    $last_uid_lang = $this->Language->last_uid;
}

//update array lang_user, last_uid_lang
$array_lang_user_update = null;
$array_lang_user_update["id"] = $array_lang_user["id"];
$array_lang_user_update["id_lang"] = $last_id_lang;
$array_lang_user_update["uid_language"] = $last_uid_lang;
$array_lang_user_update["approved"] = "1";
$this->LanguageUser->save($array_lang_user_update);

exit(json_encode(array("result" => "ok", "msg" => $msg, "data" => array("lang" => $array_lang_user["uid"]))));
