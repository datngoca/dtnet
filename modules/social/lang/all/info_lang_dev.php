<?php
$Html = $this->load("Html");
$Table = $Html->load("Table");
$Form = $Html->load("Form");

// Lấy tham số
$uid_lang = isset($_GET["lang"]) ? $_GET["lang"] : "";

if ($uid_lang !== "") {
    // Lấy thông tin ngôn ngữ từ API
    $array_lang_data = $this->request_api("language", "info", ["lang" => $uid_lang]);
    $array_language = isset($array_lang_data["data"]) ? $array_lang_data["data"] : [];

    if ($array_language !== null && !empty($array_language)) {
        $form_row = "";

        // Hiển thị các trường thông tin cần thiết
        $form_row .= $Form->row("Tên ngôn ngữ", $array_language['name']);
        $form_row .= $Form->row("Mã ngôn ngữ", $array_language['code']);
        $form_row .= $Form->row("Mô tả", $array_language['des']);

        // Hiển thị trạng thái
        $status_text = isset($array_language['status']) ?
            ($array_language['status'] == 1 ? "Hoạt động" : "Tạm dừng") : "Không xác định";
        $form_row .= $Form->row("Trạng thái", $status_text);


        if (isset($array_language['modified'])) {
            $form_row .= $Form->row("Ngày cập nhật", date('d/m/Y H:i:s', strtotime($array_language['modified'])));
        }

        // Thêm các nút hành động
        $button_style = $array_language['status'] == 1 ? "background-color: #dc3545; color: white;" : "background-color: #28a745; color: white;";
        $button_text = $array_language['status'] == 1 ? "Đóng" : "Mở";
        $button_activate = $Form->button(array(
            "id" => "button_activate",
            "type" => "button",
            "style" => $button_style,
            "onclick" => "activate_lang('$uid_lang')"
        ), $button_text);
        $form_row .= $Form->row("", $button_activate);

        $url_input = $this->get_link(array("controller" => "lang", "function" => "index"));
        $form_input = $Form->get(array("method" => "POST", "action" => $url_input), $form_row);

        echo $form_input;
    } else {
        echo $Html->div("Không tìm thấy thông tin ngôn ngữ!", "class='error-message'");
    }
} else {
    echo $Html->div("Thiếu tham số ngôn ngữ!", "class='error-message'");
}
