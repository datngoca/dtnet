<?php
$this->loadModel("Org");

$search = isset($array_param["search"]) ? $array_param["search"] : "";
$area_str_code = isset($array_param["area"]) ? $array_param["area"] : "";
$lang = isset($array_param["lang"]) ? $array_param["lang"] : "";
$uid_place = isset($array_param["place"]) ? $array_param["place"] : "";

if ($search != '') $this->Org->search("name", $search);

if ($area_str_code != '') {
    $str_cross_check = str_replace("/", "\\\\\/", $area_str_code);
    $this->Org->search(array("area_str_code" => $area_str_code));
}
if ($lang != '') $this->Org->cond("lang", $lang);
if ($uid_place != '') $this->Org->cond("uid_place", $uid_place);

$this->Org->cond("status", "1");
$this->Org->cond("approved", "1");
$this->Org->fields = " uid, name";
$array_org = $this->Org->get();

echo json_encode(array("result" => "ok", "msg" => "success", "data" => $array_org));
