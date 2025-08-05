<?php
$area_str_code = '';
$search = '';
$lang = "";
$street = "";
$place_in = "";
if (isset($_GET['area'])) $area_str_code = $_GET['area'];
if (isset($_GET['search'])) $search = $_GET['search'];
if (isset($_GET['lang'])) $lang = $_GET['lang'];
if (isset($_GET['street'])) $street = $_GET['street'];
if (isset($_GET['place_in'])) $place_in = $_GET['place_in'];



/* tạo đối tượng html */
$Html = $this->load('html');
$Html->load('Form');

/* Tạo đối tượng html table */
$Html->load('Table');


$table_row = '';

/* tạo đối tượng liên kết với bảng user_area, Đọc DL từ bảng user_area */
$array_user_place_data = $this->request_api("place", "list_user", ["area" => $area_str_code, "search" => $search, "lang" => $lang, "street" => $street, "place_in" => $place_in]);
$array_place_user = isset($array_user_place_data["data"]) ? $array_user_place_data["data"] : null;
$stt = 0;
if ($array_place_user != null) {
    foreach ($array_place_user as $row) {
        $stt++;
        $id = $row["id"];
        $uid_place_user = $row["uid"];

        /*name, code, des*/
        $name = $row['name'];
        $code = $row['code'];

        /*str name*/
        $str_name = $Html->span($name, " id ='place_name_$uid_place_user'");
        $str_name .= " - " . $code;

        /*parent*/
        $area_str_name = $Html->span($row['area_str_name'], " id ='area_str_name_$uid_place_user'");
        $area_str_code = $Html->span($row['area_str_code'], " id ='area_str_code_$uid_place_user' class = 'des2'");
        $str_area = $area_str_name . "<br>" . $area_str_code;

        /*span_sent*/
        $sent = $row['sent'];
        $str_sent = "Unsent";
        if ($sent == "1") $str_sent = "Sent";
        $span_sent = $Html->span($str_sent, " class ='des2'");

        /*span_approve*/
        $approved = $row['approved'];
        $str_approve = "Unapproved";
        if ($approved == "1") $str_approve = "Approved";
        $span_approve = $Html->span($str_approve, " class ='des3'");

        /*str_status*/
        $str_status = $span_sent . "<br>" . $span_approve;

        $des     = $row['des'];

        $lang = $row['lang'];

        $str_street = $row['street_name'];
        $str_user = $row['user_fullname'];


        /*detail*/
        $button_view = $Html->Form->button(array("class" => "view", "onclick" => "show_place_info('$uid_place_user')"), "View");
        $table_row .= $Html->Table->row(array($stt, $lang, $str_name, $str_area, $str_street, $str_status, $str_user, $button_view));
    }
} else {
    $table_row = $Html->Table->row(array(array("No data", "colspan = '6'")));
}




$table_header = $Html->Table->row_header(array("Stt", "Lang", "Name", "In Area", "Street", "Status", "User", "Approve"));
echo $Html->Table->get($table_header . $table_row);
