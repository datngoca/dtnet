<?php
$area_str_code = '';
$search = '';
$lang = "";
if (isset($_GET['area'])) $area_str_code = $_GET['area'];
if (isset($_GET['search'])) $search = $_GET['search'];
if (isset($_GET['lang'])) $lang = $_GET['lang'];


/* tạo đối tượng html */
$Html = $this->load('html');
$Html->load('Form');

/* Tạo đối tượng html table */
$Html->load('Table');


$table_row = '';

$str_cross_check = str_replace("/", "\\\\\/", $area_str_code);

/* tạo đối tượng liên kết với bảng user_area, Đọc DL từ bảng user_area */
// $this->loadModel('StreetUser');
// if ($area_str_code != '') {
//     $str_cross_check = str_replace("/", "\\\\\/", $area_str_code);
//     $this->StreetUser->search(array("area_str_code" => $area_str_code, "str_cross" => $str_cross_check));
// }

// if ($search != '') $this->StreetUser->search("name", $search);
// if ($lang != '') $this->StreetUser->cond("lang", $lang);
// $this->StreetUser->cond("id_user", $this->CurrentUser->id);

// $array_user_street = $this->StreetUser->get();

$array_user_street_data = $this->request_api("street", "list_my", ["search" => $search, "area" => $area_str_code, "lang" => $lang]);
$array_user_street = isset($array_user_street_data["data"]) ? $array_user_street_data["data"] : null;

$stt = 0;
if ($array_user_street != null) {
    foreach ($array_user_street as $row) {
        $stt++;
        $id = $row["id"];
        $uid_street_user = $row["uid"];

        /*name, code, des*/
        $name = $row['name'];
        $code = $row['code'];



        /*str name*/
        $str_name = $Html->span($name, " id ='street_name_$uid_street_user'");
        $str_name .= " - " . $code;

        /*parent*/
        $area_str_name = $Html->span($row['area_str_name'], " id ='area_str_name_$uid_street_user'");
        $area_str_code = $Html->span($row['area_str_code'], " id ='area_str_code_$uid_street_user' class = 'des2'");
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



        /*detail*/
        $button_detail = $Html->Form->button(array("class" => "view", "onclick" => "show_street_info('$uid_street_user')"), "View");
        $table_row .= $Html->Table->row(array($stt, $str_name, $str_area, $str_status, $lang, $button_detail));
    }
} else {
    $table_row = $Html->Table->row(array(array("No data", "colspan = '6'")));
}




$table_header = $Html->Table->row_header(array("Stt", "Name", "In Area", "Status", "Lang", "Options"));
echo $Html->Table->get($table_header . $table_row);
