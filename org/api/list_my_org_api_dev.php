<?php

$search = "";
$page = "";
$token_list = "";
$limit = "";

if (isset($array_org["search"])) $search = $array_org["search"];

/*page, token_list, limit*/
if (isset($array_org['page'])) $page = $array_org['page'];
if (isset($array_org['token_list'])) $token_list = $array_org['token_list'];
if (isset($array_org['limit'])) $limit = $array_org['limit'];

if (!is_numeric($page) || $page < 1) $page = 1;
if (!is_numeric($limit) || $limit < 1) $limit = 10;


$this->loadModelExt("OrgUser");
$this->OrgUser->cond("uid_user", $this->CurrentUser->uid);
if ($search != "") $this->OrgUser->search("name", $search);

$this->OrgUser->limit = $limit;
$this->OrgUser->page = $page;
if ($page > 1) {
    if ($token_list == "")  exit(json_encode(array("result" => "false", "msg" => "emty_token_list")));
    $check_token = $this->OrgUser->set_token($token_list, $page);
    if ($check_token["result"] != "ok") exit(json_encode($check_token));
}


$array_org_user_result = $this->OrgUser->query();

/*get token, datalist*/
$token_list = "";
$data_list = null;
if (isset($array_org_user_result["token"])) $token_list = $array_org_user_result["token"];
if (isset($array_org_user_result["data_list"])) $data_list = $array_org_user_result["data_list"];

exit(json_encode(array("request_time" => date("Y-m-d H:i:s"), "token_list" => $token_list, "data_list" => $data_list)));
