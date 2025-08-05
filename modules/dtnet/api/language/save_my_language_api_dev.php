<?php
$array_lang_user = $array_param["array_lang_user"];

$this->loadModel("LanguageUser");
$msg = "created";
$is_update = false;
$uid_lang = isset($array_lang_user["lang"]) ? $array_lang_user["lang"] : "";
if ($uid_lang !== "") {
    $array_lang_check = $this->LanguageUser->read($uid_lang);
    if ($array_lang_check) {
        $msg = "updated";
        $is_update = true;
        $array_lang_user["id"] = $array_lang_check["id"];
    }
}

//Them thong tin nguoi dung hien tai
$array_lang_user["id_user"] = $this->CurrentUser->id;
$array_lang_user["uid_user"] = $this->CurrentUser->uid;
$array_lang_user["username"] = $this->CurrentUser->username;
$array_lang_user["approved"] = "0";

//lưu dữ liệu vào bảng language_users
$this->LanguageUser->save($array_lang_user);

if (!$is_update) {
    $uid_lang = $this->LanguageUser->last_uid;
}
//chuyển về danh sách user
exit(json_encode(array("result" => "ok", "msg" => $msg, "data" => ["lang" => $uid_lang])));
