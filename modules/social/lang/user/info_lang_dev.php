<?php
$Html = $this->load("Html");
$Table = $Html->load("Table");
$Form = $Html->load("Form");

// Lấy tham số
$uid_lang_user = isset($_GET["lang"]) ? $_GET["lang"] : "";

if ($uid_lang_user === "") exit(array("result" => "false", "msg" => "Không tìm thấy nội dung"));

// Lấy thông tin ngôn ngữ từ API
$array_lang_user_data = $this->request_api("language", "info_user", ["lang" => $uid_lang_user]);
$array_language_user = isset($array_lang_user_data["data"]) ? $array_lang_user_data["data"] : null;

//form bên trái
if ($array_language_user === null) exit($Html->div("Không tìm thấy thông tin ngôn ngữ!"));


$form_row = "";
// Hiển thị các trường thông tin cần thiết
$form_row .= $Form->row("Tên ngôn ngữ", $array_language_user['name']);
$form_row .= $Form->row("Mã ngôn ngữ", $array_language_user['code']);
$form_row .= $Form->row("Mô tả", $array_language_user['des']);

// Hiển thị trạng thái duyệt
$approved_text = isset($array_language_user['approved']) ?
    ($array_language_user['approved'] == 1 ? "Đã duyệt" : "Chưa duyệt") : "Không xác định";
$form_row .= $Form->row("Trạng thái", $approved_text);

$form_row .= $Form->row("Người nhập", $array_language_user['username']);


if (isset($array_language_user['modified'])) {
    $form_row .= $Form->row("Ngày cập nhật", date('d/m/Y H:i:s', strtotime($array_language_user['modified'])));
}

// Thêm các nút hành động
$button_approve = $Form->button(array("id" => "button_approve", "class" => "edit", "type" => "button", "onclick" => "approve_lang('$uid_lang_user')"), "Duyệt");
$form_row .= $Form->row("", $array_language_user['approved'] != "1" ? $button_approve : "");

$form_left = $Form->get(array("method" => "POST"), $form_row);
$heading_left = $Html->heading("Language User Information");
$left_column = $Html->div($heading_left . $form_left, "class='w50 left'");

//lấy dữ liệu language
$uid_lang = $array_language_user["uid_language"];
$array_lang_data = $this->request_api("language", "info", ["lang" => $uid_lang]);
$array_language = isset($array_lang_data["data"]) ? $array_lang_data["data"] : null;


// Tạo form_row_main cho cột phải
$right_column = "";
if ($array_language !== null) {
    $form_row_main = "";
    $form_row_main .= $Form->row("Tên ngôn ngữ", $array_language['name']);
    $form_row_main .= $Form->row("Mã ngôn ngữ", $array_language['code']);
    $form_row_main .= $Form->row("Mô tả", $array_language['des']);
    $form_row_main .= $Form->row("Hoạt động", $array_language['status'] == "1" ? "Mở" : "Đóng");


    $form_right = $Form->get(array("method" => "POST"), $form_row_main);
    $heading_right = $Html->heading("Language Information");
    $right_column = $Html->div($heading_right . $form_right, "class='w50 right'");
}
echo $Html->div($left_column . $right_column, "class='w100 left'");
