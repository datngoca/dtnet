<?php
$this->loadModel("LanguageUser");

$search = isset($array_param["search"]) ? $array_param["search"] : "";

if ($search != "") $this->LanguageUser->search("name", $search);

// Điều kiện: id_user = 5 AND status <> 3
$this->LanguageUser->cond("id_user", $this->CurrentUser->id);
$this->LanguageUser->cond("status", "3", array("compare" => "<>", "combine" => "AND"));

$this->LanguageUser->order = "modified DESC";
$array_language_users = $this->LanguageUser->get();

exit(json_encode(array("result" => "ok", "msg" => "success", "data" => $array_language_users)));
