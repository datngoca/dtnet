<?php

$array_data = $array_param;

$uid_post = isset($array_data["post"]) ? $array_data["post"] : "";

if ($uid_post == "") exit(json_encode(array("result" => "false", "msg" => "missing_post_id")));

/* Load models */
$this->loadModel('PostUser');

/* Delete post (set status to 3 - deleted) */
$this->PostUser->cond('uid', $uid_post);
$this->PostUser->cond('id_user', $this->CurrentUser->id);

$array_update = array(
    'status' => '3',
    'modified' => date('Y-m-d H:i:s')
);

$result = $this->PostUser->update($array_update);

if ($result) {
    echo json_encode(array("result" => "ok", "msg" => "delete_success"));
} else {
    echo json_encode(array("result" => "false", "msg" => "delete_failed"));
}
