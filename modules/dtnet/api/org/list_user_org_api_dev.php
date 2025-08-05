<?php
$this->loadModel("OrgUser");

$search = isset($array_param["search"]) ? $array_param["search"] : "";
$area_str_code = isset($array_param["area"]) ? $array_param["area"] : "";
$lang = isset($array_param["lang"]) ? $array_param["lang"] : "";
$uid_place = isset($array_param["place"]) ? $array_param["place"] : "";

if ($search != '') $this->OrgUser->search("name", $search);

if ($area_str_code != '') {
    $str_cross_check = str_replace("/", "\\\\\/", $area_str_code);
    $this->OrgUser->search(array("area_str_code" => $area_str_code));
}
if ($lang != '') $this->OrgUser->cond("lang", $lang);
if ($uid_place != '') $this->OrgUser->cond("uid_place", $uid_place);

$this->OrgUser->cond("sent", "1");
$this->OrgUser->cond("status", "3", array("compare" => "<>"));
$this->OrgUser->order = "modified DESC";
$array_org_users = $this->OrgUser->get();

echo json_encode(array("result" => "ok", "msg" => "success", "data" => $array_org_users));
