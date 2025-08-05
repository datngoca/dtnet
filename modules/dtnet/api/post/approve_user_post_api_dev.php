<?php
//Get post param
$uid_post_user = isset($array_param["post"]) ? $array_param["post"] : "";

//check valid post
if ($uid_post_user == "") exit(json_encode(array("result" => "false", "msg" => "missing_post")));

//lấy thông tin PostUser
$this->loadModel("PostUser");
$array_post_user = $this->PostUser->read($uid_post_user);
if (!$array_post_user) exit(json_encode(array("result" => "false", "msg" => "invalid_data")));

//get array post
$array_post = $array_post_user;

//remove id, uid prevent update
$array_post["id"] = "";
$array_post["uid"] = "";

//get id, uid post in array post user
$id_post = $array_post_user["id_post"];
$uid_post = $array_post_user["uid_post"];

$this->loadModel("Post");

//kiểm tra bảng ghi post_user kết nối với Post chưa?
if ($id_post == "") {
    //kiểm tra trường code đã có bên bảng Post chưa?
    $this->Post->cond("code", $array_post_user["code"]);
    $array_post_exist = $this->Post->get();
    if (!empty($array_post_exist)) exit(json_encode(array("result" => "false", "msg" => "already_exists")));

    // Cho insert mới - remove id, uid
    $array_post["id"] = "";
    $array_post["uid"] = "";
} else {
    //kiểm tra bảng ghi có tồn trong bảng Post không?, nếu không có thì id_post = "" để insert
    $array_post_check = $this->Post->read($id_post);
    if (empty($array_post_check)) {
        $id_post = "";
        // Cho insert mới - remove id, uid
        $array_post["id"] = "";
        $array_post["uid"] = "";
    } else {
        // Cho update - giữ lại id và uid hiện tại
        $array_post["id"] = $id_post;
        $array_post["uid"] = $uid_post;
    }
}

//update array post
$array_post["id"] = $id_post;
$array_post["approved"] = "1";
$array_post["status"] = "1";
$this->Post->save($array_post);

/*check updating or inserting, get last id & uid*/
$msg = "approved";
$last_id_post = $id_post;
$last_uid_post = $uid_post;
if ($this->Post->last_action == "insert") {
    $msg = "approved";
    $last_id_post = $this->Post->last_id;
    $last_uid_post = $this->Post->last_uid;
}

//update array post_user, last_uid_post
$array_post_user_update = null;
$array_post_user_update["id"] = $array_post_user["id"];
$array_post_user_update["id_post"] = $last_id_post;
$array_post_user_update["uid_post"] = $last_uid_post;
$array_post_user_update["approved"] = "1";
$this->PostUser->save($array_post_user_update);

exit(json_encode(array("result" => "ok", "msg" => $msg, "data" => array("post" => $array_post_user["uid"]))));
