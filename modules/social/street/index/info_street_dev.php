<?php
/* kiểm tra khu vực có hợp lệ? */
$uid_street_user = '';
if (isset($_GET['street'])) $uid_street_user = $_GET['street'];
if ($uid_street_user  == '') exit('no_street');

// $this->loadModel("StreetUser");
// $array_street_user = $this->StreetUser->read($uid_street_user);

$array_street_user_data = $this->request_api("street", "info_my", ["street" => $uid_street_user]);
$array_street_user = isset($array_street_user_data["data"]) ? $array_street_user_data["data"] : null;

if ($array_street_user == null)  exit('invalid_street');
/* tạo đối tượng html */
$Html = $this->load('html');

/*lang, area*/
$lang = $array_street_user['lang'];
$area_str_code = $array_street_user['area_str_code'];
$area_str_name = $array_street_user['area_str_name'];

/*name, code, des*/
$name = $array_street_user['name'];
$name_address = $array_street_user['name_address'];

$code = $array_street_user['code'];
$str_code = $array_street_user['str_code'];

$des_short = $array_street_user['des_short'];
$des = $array_street_user['des'];

$approved = $array_street_user['approved'];
$sent = $array_street_user['sent'];
$url_key = $array_street_user['url_key'];


$str_approve = "Unaprroved";
if ($approved == "1") $str_approve = "Aprroved";

$str_sent = "UnSent";
if ($sent == "1") $str_sent = "Sent";


$Html->load('Form');
$form_row = '';


/* button edit */
$button_edit = $Html->Form->button(array("type" => "button", "class" => "edit", "onclick" => "input_street('$uid_street_user')"), "Edit");
$button_delete = $Html->Form->button(array("type" => "button", "class" => "delete", "onclick" => "delete_street('$uid_street_user')"), "Delete");

$title_left = $Html->heading('User Input');

$form_row .= $Html->Form->row("Language", $lang);
$form_row .= $Html->Form->row("In", $area_str_name . '</br>' . $area_str_code);
$form_row .= $Html->Form->row("Street Name", $name . "($code)");
$form_row .= $Html->Form->row("Name in address", $name_address);

$form_row .= $Html->Form->row("Code", $str_code);
$form_row .= $Html->Form->row("Url key", $url_key);

$form_row .= $Html->Form->row("Search", $des_short);

$form_row .= $Html->Form->row("Description", $des);
$form_row .= $Html->Form->row("Status ", $str_approve);

$form_row .= $Html->Form->row("", $button_edit . $button_delete);

$form_left = $Html->Form->get(array("method" => "POST", "action" => '', "id" => "form_area"), $form_row);

/* Phần bên phải */

/*request api:lấy dữ liệu bản chính street*/
$uid_street = $array_street_user['uid_street'];

$array_street_data = $this->request_api("street", "info", ["street" => $uid_street]);
$array_street = isset($array_street_data["data"]) ? $array_street_data["data"] : null;

$title_right = $Html->heading("Street");
$form_row_right = "No information";

if ($array_street != null) {
    /*lang*/
    $lang = $array_street['lang'];

    /*area*/
    $area_str_code = $array_street['area_str_code'];
    $area_str_name = $array_street['area_str_name'];
    $approved = $array_street['approved'];

    /*name, code, des, url_key*/
    $name = $array_street['name'];
    $name_address = $array_street['name_address'];

    $des = $array_street['des'];
    $code = $array_street['code'];
    $str_code = $array_street['str_code'];
    $url_key = $array_street['url_key'];


    $img = $array_street['img'];

    /*status, approved*/
    $status = $array_street['status'];

    $str_approve = "Not approved yet";
    if ($approved == "1") $str_approve = "Approved";

    $str_status = "In active";
    if ($status == "1") $str_status = "Active";

    $form_row_right = '';
    $form_row_right .= $Html->Form->row("Lang", $lang);
    $form_row_right .= $Html->Form->row("In", $area_str_name . '</br>' . $area_str_code);
    $form_row_right .= $Html->Form->row("Street Name", $name . "($code)");
    $form_row_right .= $Html->Form->row("Name in address", $name_address);

    $form_row_right .= $Html->Form->row("Code", $str_code);
    $form_row_right .= $Html->Form->row("Url key", $url_key);

    $form_row_right .= $Html->Form->row("Search ", $des_short);
    $form_row_right .= $Html->Form->row("Description", $des);
    $form_row_right .= $Html->Form->row("Status ", $str_status . " - " . $str_approve);
}
/* end: if ($array_post_cat != null) */

$form_right = $Html->Form->get(array("method" => "POST", "action" => '', "id" => "form_area_right"), $form_row_right);

$div_left = $Html->div($title_left . $form_left, "class='w50 left'");
$div_right = $Html->div($title_right . $form_right, "class='w50 right'");
echo $div_area = $Html->div($div_left . $div_right, "class='w100 left'");
