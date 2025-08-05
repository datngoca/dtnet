<?php
$this->loadModel("AreaUser");

$search = isset($array_param["search"]) ? $array_param["search"] : "";
$parent = isset($array_param["parent"]) ? $array_param["parent"] : "";
$lang = isset($array_param["lang"]) ? $array_param["lang"] : "";

if ($search != '') $this->AreaUser->search("name", $search);
if ($parent != '') $this->AreaUser->cond("parent_str_code", $parent);
if ($lang != '') $this->AreaUser->cond("lang", $lang);
$this->AreaUser->cond("id_user", $this->CurrentUser->id);
$this->AreaUser->cond("status", "3", array("compare" => "<>"));
$this->AreaUser->order = "modified DESC";
$array_area_users = $this->AreaUser->get();

echo json_encode(array("result" => "ok", "msg" => "success", "data" => $array_area_users));
