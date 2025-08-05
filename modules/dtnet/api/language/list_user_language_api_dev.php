<?php
$this->loadModel("LanguageUser");

$search = isset($array_param["search"]) ? $array_param["search"] : "";
$approved = isset($array_param["approved"]) ? $array_param["approved"] : "";

if ($search != "") $this->LanguageUser->search("name", $search);
if ($approved != "") $this->LanguageUser->search("approved", $approved);

// gọi hàm get của đối tượng model để truy vấn dữ liệu
$this->LanguageUser->cond("status", "3", array("compare" => "<>"));
$this->LanguageUser->order = "modified DESC";
$array_language_users = $this->LanguageUser->get();

echo json_encode(array("result" => "ok", "msg" => "success", "data" => $array_language_users));
