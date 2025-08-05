<?php
$this->loadModel("Post");

$search = isset($array_param["search"]) ? $array_param["search"] : "";
$area_str_code = isset($array_param["area"]) ? $array_param["area"] : "";
$lang = isset($array_param["lang"]) ? $array_param["lang"] : "";
$uid_place = isset($array_param["place"]) ? $array_param["place"] : "";

if ($area_str_code != '') {
    $str_cross_check = str_replace("/", "\\\\\/", $area_str_code);
    $this->Post->search(array("area_str_code" => $area_str_code));
}
if ($search != '') $this->Post->search("title", $search);
if ($lang != '') $this->Post->cond("lang", $lang);
if ($uid_place != '') $this->Post->cond("uid_place", $uid_place);

$this->Post->order = "modified DESC";
$array_post = $this->Post->get();

echo json_encode(array("result" => "ok", "msg" => "success", "data" => $array_post));
