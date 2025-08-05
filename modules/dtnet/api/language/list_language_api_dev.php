<?php
$this->loadModel("Language");

// Apply search filter
$search = isset($array_param["search"]) ? $array_param["search"] : "";
if ($search != "") $this->Language->search("name", $search);

$this->Language->fields = "code, name, des";
$this->Language->first_row = array("code" => "", "name" => "");
$this->Language->cond("status", "1");

$this->Language->order = "modified DESC";
$array_language = $this->Language->get();

echo json_encode(array("result" => "ok", "msg" => "success", "data" => $array_language));
