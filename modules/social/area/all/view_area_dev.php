<?php
/*Html & Form*/
$Html = $this->load("Html");
$Form = $Html->load("Form");

echo $Html->heading("Thông tin khu vực");

$uid_area = "";
if (isset($_GET["area"])) $uid_area = $_GET["area"];
if ($uid_area == "") exit("no_area");


/*read area info*/
/*data to request api area*/
/*$this->loadLib("Api");
	$array_api_param = null;
	$array_api_param["token_action"] = $this->Token->get(array("data" =>"area","action" =>"info", "params" =>array("area" =>$uid_area)));
	if(isset($_GET["debug"]) && ($_GET["debug"] == "view"))	$array_api_param["debug_api"] = "true";
	$array_area = $this->Api->send($array_api_param, true);*/

$array_area = $this->request_api("area", "info", array("area" => $uid_area));
if ($array_area == null) exit("no_area");

$str_name_parent     = $array_area["str_name_parent"];
$str_code     = $array_area["str_code"];
$area_str_code     = $Html->span("($str_code)");

$parent_str_code     = $array_area["parent_str_code"];
$parent_str_code     = $Html->span("($parent_str_code)");

$name     = $array_area["name"];
$code     = $array_area["code"];
$code     = $Html->span("($code)");
$url_key     = $array_area["url_key"];


$des     = $array_area["des"];
$des_short     = $array_area["des_short"];

$status = $array_area["status"];
// $approved = $array_area["approved"];


// /*approve*/
// $str_approve = "Chưa duyệt";
// $label_button_approve = "Duyệt";
// if ($approved == "1") {
//     $str_approve = "Đã duyệt";
//     $label_button_approve = "Bỏ Duyệt";
// }
// $button_approve = $Form->button(array("id" => "button_approve", "type" => "button", "onclick" => "approve_area('$uid_area')"), $label_button_approve);

/*status*/
$str_status = "";
if ($status === "" || $status === "0") $str_status = "Chưa hoạt động";
if ($status == "2") $str_status = "Đang khóa";

$label_button_status = "Mở khóa";
if ($status == "1") {
    $str_status = "Đang hoạt động";
    $label_button_status = "Khóa";
}

$button_status = $Form->button(array("id" => "button_status", "type" => "button", "onclick" => "active_area('$uid_area')"), $label_button_status);

/* Create Form */
$form_row = "";

/* Khu vực */
$form_row .= $Form->row("Tên khu vực", $name . $code . "<br>" . $area_str_code);
$form_row .= $Form->row("Url key", $url_key);

$form_row .= $Form->row("Nằm trong ", $str_name_parent . $parent_str_code);

$form_row .= $Form->row("Mô tả tìm kiếm", $des_short);

$form_row .= $Form->row("Mô tả ", $des);

// $form_row .= $Form->row("Trạng thái", $str_approve . "&nbsp;&nbsp;" . $button_approve);
$form_row .= $Form->row("Tình trạng", $str_status . "&nbsp;&nbsp;" . $button_status);
echo $Form->get(array("method" => "POST", "action" => "#"), $form_row);
