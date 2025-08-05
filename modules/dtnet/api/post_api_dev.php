<?php
/*check my data*/
if ($action == "list_my") return $this->run("post/list_my_post", array("array_param" => $params));
if ($action == "save_my") return $this->run("post/save_my_post", array("array_param" => $params));
if ($action == "info_my") return $this->run("post/info_my_post", array("array_param" => $params));
if ($action == "delete_my") return $this->run("post/delete_my_post", array("array_param" => $params));

/*check user data*/
if ($action == "list_user") return $this->run("post/list_user_post", array("array_param" => $params));
if ($action == "info_user") return $this->run("post/info_user_post", array("array_param" => $params));
if ($action == "approve_user") return $this->run("post/approve_user_post", array("array_param" => $params));

/*check all data*/
if ($action == "list") return $this->run("post/list_post", array("array_param" => $params));
if ($action == "info") return $this->run("post/info_post", array("array_param" => $params));
if ($action == "activate") return $this->run("post/activate_post", array("array_param" => $params));

// <?php 
//    if($action == "insert") exit($this->run("post/insert_post", array( "array_data" => $params)));
//    if($action == "update") exit($this->run("post/update_post", array( "array_data" => $params)));
//    if($action == "save") exit($this->run("post/save_post", array( "array_data" => $params)));
//    if($action == "save_content") exit($this->run("post/save_content_post", array( "array_data" => $params)));
//    if($action == "delete_content_item") exit($this->run("post/delete_content_item_post", array("array_data"=>$params)));


//    if($action == "read") exit($this->run("post/read_post", array("array_data" => $params)));
//    if($action == "list_user") exit($this->run("post/list_user_post", array("array_data" => $params)));
//    if($action == "delete") exit($this->run("post/delete_post", array("array_data" => $params)));
//    if($action == "list") exit($this->run("post/list_post", array("array_post"=>$params)));
//    if($action == "list_friend") exit($this->run("post/list_friend_post", array("array_post"=>$params)));

//    if($action == "save_advance") exit($this->run("post/save_advance_post", array("array_data"=>$params)));
//    // if($action == "member") $this->run("post/member_post", array( "array_post" => $params));

//    /*share, cancel share */
//    if($action == "save_share") exit($this->run("post/save_share_post", array("array_data"=>$params)));
//    if($action == "get_emotion") exit($this->run("post/get_emotion_post", array("array_data" => $params)));

//    exit(json_encode(array("result" =>"false", "msg" => "no_action")));
// 
