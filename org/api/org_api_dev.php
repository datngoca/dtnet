<?php
if (($action == "info")) exit($this->run("org/info_org", array("array_org" => $params)));
if (($action == "info_user")) exit($this->run("org/info_user_org", array("array_org" => $params)));
if (($action == "save")) exit($this->run("org/save_org", array("array_org" => $params)));
if (($action == "active")) exit($this->run("org/active_org", array("array_org" => $params)));

if (($action == "save_user")) exit($this->run("org/save_user_org", array("array_user_org" => $params)));
if (($action == "approve_user")) exit($this->run("org/approve_user_org", array("array_approve" => $params)));

if (($action == "list_my")) exit($this->run("org/list_my_org", array("array_org" => $params)));
if (($action == "list_user")) exit($this->run("org/list_user_org", array("array_org" => $params)));
if (($action != "list" && $action != "all")) exit("no_action");

/*get param*/
$area_str_code = "";
$uid_street = "";
$uid_place = "";
$search = "";

$page = "";
$token_list = "";
$num_row = "";

if (isset($params["area"])) $area_str_code = $params["area"];
if (isset($params["street"])) $uid_street = $params["street"];
if (isset($params["place"])) $uid_place = $params["place"];
if (isset($params["search"])) $search = $params["search"];

/*page, token list, num row*/
if (isset($params['page'])) $page = $params['page'];
if (isset($params['token_list'])) $token_list = $params['token_list'];
if (isset($params['num_row'])) $num_row = $params['num_row'];

if (!is_numeric($page) || ($page < 1))    $page = 1;
if (!is_numeric($num_row) || ($num_row < 1))    $num_row = 10;

$this->loadModelExt("Org");
if ($area_str_code != "") $this->Org->search("area_str_code", $area_str_code);
if ($uid_street != "") $this->Org->cond("uid_street", $uid_street);
if ($uid_place != "") $this->Org->cond("uid_place", $uid_street);
if ($search != "") $this->Org->search("name", $search);
if ($action == "list") $this->Org->search("status", "1");

/*page & limit */
$this->Org->limit = $num_row;
$this->Org->page = $page;

if ($page > 1) {
    if ($token_list == "")  exit(json_encode(array("result" => "false", "msg" => "emty_token_list")));
    $check_token = $this->Org->set_token($token_list, $page);
    if ($check_token["result"] != "ok") exit(json_encode($check_token));
}
$array_org_result = $this->Org->query();

/*get token, datalist*/
$token_list = "";
$data_list = null;
if (isset($array_org_result["token"])) $token_list = $array_org_result["token"];
if (isset($array_org_result["data_list"])) $data_list = $array_org_result["data_list"];

exit(json_encode(array("request_time" => date("Y-m-d H:i:s"), "token_list" => $token_list, "data_list" => $data_list)));
