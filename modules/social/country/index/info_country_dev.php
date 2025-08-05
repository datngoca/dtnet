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
$uid_country_user = isset($_GET["country"]) ? $_GET["country"] : "";

$array_uid_country_user = array("uid" => $uid_country_user);

/*check data*/
$check = validate($array_uid_country_user);
if ($check["result"] != "ok") return $this->redirect(array("controller" => "country", "function" => "index", "get" => "msg=" . $check["msg"]));

$array_country_user_data = $this->request_api("country", "info_my", ["country" => $uid_country_user]);
$array_country_user = isset($array_country_user_data["data"]) ? $array_country_user_data["data"] : null;

if ($array_country_user == null) exit($Html->div("No data"));

$form_row = "";

// Hiển thị các trường thông tin cần thiết
$form_row .= $Form->row("Ngôn ngữ", $array_country_user['lang']);
$form_row .= $Form->row("Tên quốc gia", $array_country_user['name']);
$form_row .= $Form->row("Mã quốc gia", $array_country_user['code']);
$form_row .= $Form->row("Mô tả", $array_country_user['des']);


// Hiển thị trạng thái duyệt
$approved_text = isset($array_country_user['approved']) ?
    ($array_country_user['approved'] == 1 ? "Đã duyệt" : "Chưa duyệt") : "Không xác định";
$form_row .= $Form->row("Trạng thái", $approved_text);

if (isset($array_country_user['modified'])) {
    $form_row .= $Form->row("Ngày cập nhật", date('d/m/Y H:i:s', strtotime($array_country_user['modified'])));
}

// Thêm các nút hành động
$button_edit = $Form->button(array("class" => "edit", "type" => "button", "onclick" => "input_country('$uid_country_user')"), "Chỉnh sửa");
$button_delete = $Form->button(array("class" => "delete", "type" => "button", "onclick" => "delete_country('$uid_country_user')"), "Xóa");
$form_row .= $Form->row("", $button_edit . " " . $button_delete);

$form_left = $Form->get(array("method" => "POST"), $form_row);
$heading_left = $Html->heading("Country User Information");
$left_column = $Html->div($heading_left . $form_left, "class='w50 left'");

//lấy dữ liệu countries
$uid_country = $array_country_user["uid_country"];
$array_country_data = $this->request_api("country", "info", ["country" => $uid_country]);
$array_country = isset($array_country_data["data"]) ? $array_country_data["data"] : null;

// Tạo form_row_main cho cột phải
$right_column = "";
if ($array_country !== null) {
    $form_row_main = "";
    $form_row_main .= $Form->row("Ngôn ngữ", $array_country['name']);
    $form_row_main .= $Form->row("Tên quốc gia", $array_country['name']);
    $form_row_main .= $Form->row("Mã quốc gia", $array_country['code']);
    $form_row_main .= $Form->row("Mô tả", $array_country['des']);
    $form_row_main .= $Form->row("Trạng thái", $array_country['status'] == "1" ? "Mở" : "Đóng");


    $form_right = $Form->get(array("method" => "POST"), $form_row_main);
    $heading_right = $Html->heading("Country Information");
    $right_column = $Html->div($heading_right . $form_right, "class='w50 right'");
}
echo $Html->div($left_column . $right_column, "class='w100 left'");
