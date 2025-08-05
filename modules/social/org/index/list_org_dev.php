<?php
$search = isset($_GET['search']) ? $_GET['search'] : "";

/* tạo đối tượng html */
$Html = $this->load('html');
$Html->load('Form');

/* Tạo đối tượng html table */
$Html->load('Table');

$table_row = '';

/* tạo đối tượng liên kết với bảng user_area, Đọc DL từ bảng user_area */
// exit($this->request_api('org', "list", $array_params, false));
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

$array_user_org_data = $this->request_api("org", "list_my", ["area" => $area_str_code, "search" => $search, "lang" => $lang, "street" => $street, "place" => $place]);
$array_user_org = isset($array_user_org_data["data"]) ? $array_user_org_data["data"] : null;

$stt = 0;
if ($array_user_org != null) {
    foreach ($array_user_org as $row) {
        $stt++;
        $id = $row["id"];
        $uid_org_user = $row["uid"];

        $str_name = $Html->span($row['name'], "id ='org_name_$uid_org_user'");
        $str_code = $Html->span($row['code'], "class = 'des2'");
        $des = $row["des"];

        $str_row_name = $str_name . "<br>" . $str_code;

        /*img org*/
        $phone = $row['phone'];
        $email = $row['email'];

        /*img business_activity*/
        $business_activity = $row['business_activity'];

        /*parent*/
        $area_str_name = $Html->span($row['area_str_name'], " id ='area_str_name_$uid_org_user'");
        $area_str_code = $Html->span($row['area_str_code'], " id ='area_str_code_$uid_org_user' class = 'des2'");
        $str_area = $area_str_name . "<br>" . $area_str_code;

        /*street*/
        $street_name = isset($row['street_name']) ? $row['street_name'] : '';
        $street_number = isset($row['street_number']) ? $row['street_number'] : '';
        $str_street = '';
        if (!empty($street_name) || !empty($street_number)) {
            $str_street = trim($street_number . ' ' . $street_name);
        }

        /*place*/
        $place_name = isset($row['place_name']) ? $row['place_name'] : '';
        $str_place = $place_name;

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

        /*detail*/
        $button_detail = $Html->Form->button(array("class" => "view", "onclick" => "show_org_info('$uid_org_user')"), "View");
        $table_row .= $Html->Table->row(array($stt, $str_row_name, $business_activity, $str_area, $str_street, $str_place, $phone, $email, $str_status, $button_detail));
    }
} else {
    $table_row = $Html->Table->row(array(array("No data", "colspan = '8'")));
}

$table_header = $Html->Table->row_header(array("Stt", "Name", "Business Activity", "Area", "Street", "Place", "Phone", "Email", "Status", "Options"));
echo $Html->Table->get($table_header . $table_row);
/*array_params data request*/
// $array_params = null;
// $array_params['area'] = $area;
// $array_params['street'] = $street;
// $array_params['place'] = $place;

// $array_params['search'] = $search;
// $array_params['type'] = $type;
// $array_params['business'] = $business_activity;

/*request api*/
