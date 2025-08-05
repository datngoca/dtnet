<?php
$search = isset($array_param["search"]) ? $array_param["search"] : "";
$status = isset($array_param["status"]) ? $array_param["status"] : "";
$lang = isset($array_param["lang"]) ? $array_param["lang"] : "";

$this->loadModel("Countries");

if ($search != "") $this->Countries->search(array("name", "code", "des"), $search);
if ($status != "") $this->Countries->search("status", $status);
if ($lang != "") $this->Countries->cond("lang", $lang);

$array_country = $this->Countries->get();

echo json_encode(array("result" => "ok", "msg" => "success", "data" => $array_country));
