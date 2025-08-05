<?php
// Lấy thư viện Html, Table
$Html = $this->load("Html");
$Table = $Html->load("Table");
$Form = $Html->load("Form");

function validate($param_check)
{
    if ($param_check == NULL) return array("result" => "false", "msg" => "invalid_data");
    if (!isset($param_check["uid"]) || ($param_check["uid"] == "")) return array("result" => "false", "msg" => "no_uid");
    return array("result" => "ok", "msg" => "");
}

// Lấy tham số uid_country
$uid_country = isset($_GET["country"]) ? $_GET["country"] : "";

$array_uid_country = array("uid" => $uid_country);

/*check data*/
$check = validate($array_uid_country);
if ($check["result"] != "ok") return $this->redirect(array("controller" => "country", "function" => "all", "get" => "msg=" . $check["msg"]));

$array_country_data = $this->request_api("country", "info", ["country" => $uid_country]);
$array_country = isset($array_country_data["data"]) ? $array_country_data["data"] : null;

if ($array_country == null) exit("Lỗi");
$form_row = "";

// Hiển thị các trường thông tin cần thiết
$form_row .= $Form->row("Ngôn ngữ", $array_country['lang']);
$form_row .= $Form->row("Tên quốc gia", $array_country['name']);
$form_row .= $Form->row("Mã quốc gia", $array_country['code']);
$form_row .= $Form->row("Mô tả", $array_country['des']);

// Hiển thị trạng thái duyệt
$approved_text = isset($array_country['approved']) ?
    ($array_country['approved'] == 1 ? "Đã duyệt" : "Chưa duyệt") : "Không xác định";
$form_row .= $Form->row("Trạng thái", $approved_text);

if (isset($array_country['modified'])) {
    $form_row .= $Form->row("Ngày cập nhật", date('d/m/Y H:i:s', strtotime($array_country['modified'])));
}

// Thêm các nút hành động
$button_activate = $Form->button(array("class" => "edit", "type" => "button", "onclick" => "activate_country('$uid_country')"), $array_country["status"] ? "Đóng" : "Mở");
$form_row .= $Form->row("", $button_activate);

$form_left = $Form->get(array("method" => "POST"), $form_row);
$heading_left = $Html->heading("Country User Information");
$left_column = $Html->div($heading_left . $form_left, "class='w50 left'");

echo $Html->div($left_column, "class='w100 left'");
