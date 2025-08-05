<?php
// Lấy thư viện Html, Table
$Html = $this->load("Html");
$Table = $Html->load("Table");
$Form = $Html->load("Form");

$search = isset($_GET["search"]) ? $_GET["search"] : "";
$status = isset($_GET["status"]) ? $_GET["status"] : "";

// Get data from API
$array_lang_users_data = $this->request_api("language", "all", ["search" => $search, "status" => $status]);
$array_language_users = isset($array_lang_users_data["data"]) ? $array_lang_users_data["data"] : [];

// Build table rows
$str_row = "";
$i = 0;
if ($array_language_users !== null && count($array_language_users) > 0) {
    foreach ($array_language_users as $row) {
        $i++;

        $uid_lang = $row["uid"];
        $button_view = $Form->button(array("class" => "view", "type" => "button", "onclick" => "view_lang('$uid_lang')"), "View");

        $array_row["col1"] = array($i);
        $array_row["col2"] = array($row['name']);
        $array_row["col3"] = array($row['code']);
        $array_row["col4"] = array($row['des']);
        $array_row["col5"] = $row['status'] == "1" ? "Hoạt động" : "Tạm ngưng";
        $array_row["col6"] = array($button_view);
        $str_row .= $Table->row($array_row);
    }
} else {
    $str_row = "<tr><td colspan='5'>No data found</td></tr>";
}

// Create header
$array_header = null;
$array_header["col1"] = array("NO");
$array_header["col2"] = array("Name");
$array_header["col3"] = array("Code");
$array_header["col4"] = array("Description");
$array_header["col5"] = array("Status");
$array_header["col6"] = array("Action");
$str_header = $Table->row_header($array_header);

// Generate table
$str_table = $Table->get($str_header . $str_row);

echo $str_table;
