<?php
$this->loadModel("StreetUser");

$search = isset($array_param["search"]) ? $array_param["search"] : "";
$area_str_code = isset($array_param["area"]) ? $array_param["area"] : "";
$lang = isset($array_param["lang"]) ? $array_param["lang"] : "";

if ($search != '') $this->StreetUser->search("name", $search);
if ($area_str_code != '') {
    $str_cross_check = str_replace("/", "\\\\\/", $area_str_code);
    $this->StreetUser->search(array("area_str_code" => $area_str_code, "str_cross" => $str_cross_check));
}
if ($lang != '') $this->StreetUser->cond("lang", $lang);

$this->StreetUser->cond("id_user", $this->CurrentUser->id);
$this->StreetUser->cond("status", "3", array("compare" => "<>"));
$this->StreetUser->order = "modified DESC";
$array_street_users = $this->StreetUser->get();

echo json_encode(array("result" => "ok", "msg" => "success", "data" => $array_street_users));
