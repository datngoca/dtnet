<?php

$Html = $this->load("Html");
$Table = $Html->load("Table");
$Form = $Html->load("Form");

// Lấy giá trị tham số search
$search = isset($_GET["search"]) ? $_GET["search"] : "";
$lang = isset($_GET["lang"]) ? $_GET["lang"] : "";

$array_country_users_data = $this->request_api("country", "list_my", ["search" => $search, "lang" => $lang]);
$array_country_users = isset($array_country_users_data["data"]) ? $array_country_users_data["data"] : null;

// Duyệt tất cả dữ liệu của mảng
$str_row = "";
$i = 0;
if ($array_country_users !== null) {

    foreach ($array_country_users as $row) {
        $i++;

        $uid_country = $row["uid"];
        $button_view = $Form->button(array("type" => "button", "class" => "view", "onclick" => "view_country('$uid_country')"), "View");

        // Tạo rows
        $array_row = null;
        $array_row["col1"] = array($i);
        $array_row["col2"] = array($row["lang"]);
        $array_row["col3"] = array($row["name"]);
        $array_row["col4"] = array($row["code"]);
        $array_row["col5"] = array($row["des"]);
        $array_row["col6"] = array($row["modified"]);
        $array_row["col7"] = array($row["approved"] ? "Đã duyệt" : "Chưa duyệt");
        $array_row["col8"] = array($button_view);
        $str_row .= $Table->row($array_row);
    }
}

// Tạo header
$array_header = null;
$array_header["col1"] = array("Num");
$array_header["col2"] = array("Language");
$array_header["col3"] = array("Name");
$array_header["col4"] = array("Code");
$array_header["col5"] = array("Description");
$array_header["col6"] = array("Date");
$array_header["col7"] = array("Status");
$array_header["col8"] = array("Action");
$str_header = $Table->row_header($array_header);

/*lấy về chuỗi <table></table> */
$str_table =  $Table->get($str_header . $str_row);

echo $str_table;
