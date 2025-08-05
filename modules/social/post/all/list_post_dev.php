<?php
$area_str_code = '';
$search = '';
$lang = "";
$street = "";
$place = "";

if (isset($_GET['area'])) $area_str_code = $_GET['area'];
if (isset($_GET['search'])) $search = $_GET['search'];
if (isset($_GET['lang'])) $lang = $_GET['lang'];
if (isset($_GET['street'])) $street = $_GET['street'];
if (isset($_GET['place'])) $street = $_GET['place'];




/* tạo đối tượng html */
$Html = $this->load('html');
$Html->load('Form');

/* Tạo đối tượng html table */
$Html->load('Table');


$table_row = '';

/* tạo đối tượng liên kết với bảng user_area, Đọc DL từ bảng user_area */

$array_user_post_data = $this->request_api("post", "list", ["area" => $area_str_code, "search" => $search, "lang" => $lang, "street" => $street, "place" => $place]);
$array_user_post = isset($array_user_post_data["data"]) ? $array_user_post_data["data"] : null;
$stt = 0;
if ($array_user_post != null) {
    foreach ($array_user_post as $row) {
        $stt++;
        $id = $row["id"];
        $uid_post_user = $row["uid"];

        /*name, code, des*/
        $title = $row['title'];
        $category = $row['post_cat_title'];
        $type = $row['type'];
        $des = $row['des'];
        $content = $row['des'];



        /*span_approve*/
        $status = $row['status'];
        $str_activate = "Unactivate";
        if ($status == "1") $str_activate = "Activate";
        $span_status = $Html->span($str_activate, " class ='des3'");

        /*str_status*/
        $str_status =  $span_status;




        /*detail*/
        $button_detail = $Html->Form->button(array("class" => "view", "onclick" => "show_post_info('$uid_post_user')"), "View");
        $table_row .= $Html->Table->row(array($stt, $title, $type, $category, $str_status, $button_detail));
    }
} else {
    $table_row = $Html->Table->row(array(array("No data", "colspan = '6'")));
}




$table_header = $Html->Table->row_header(array("Stt", "Title", "Type", "Category", "Status",  "Options"));
echo $Html->Table->get($table_header . $table_row);
