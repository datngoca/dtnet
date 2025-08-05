<?php
$this->loadModel("Language");

$search = isset($array_param["search"]) ? $array_param["search"] : "";
$status = isset($array_param["status"]) ? $array_param["status"] : "";

// Apply search, status filter
if ($search != "") $this->Language->search("name", $search);
if ($status !== "") $this->Language->search("status", $status);

// gọi hàm get của đối tượng model để truy vấn dữ liệu
$array_language = $this->Language->get();

echo json_encode(array("result" => "ok", "msg" => "success", "data" => $array_language));
