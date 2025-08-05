<?php
/* kiểm tra tổ chức có hợp lệ? */
$uid_org_user = '';
if (isset($_GET['org'])) $uid_org_user = $_GET['org'];
if ($uid_org_user == '') exit('invalid');

$array_org_user_data = $this->request_api("org", "info", ["org" => $uid_org_user]);
$array_org_user = isset($array_org_user_data["data"]) ? $array_org_user_data["data"] : null;
if ($array_org_user == null) exit('invalid_org');

/* tạo đối tượng html */
$Html = $this->load('html');

/*lang, name, code*/
$lang = $array_org_user['lang'];
$name = $array_org_user['name'];
$code = $array_org_user['code'];
$des = $array_org_user['des'];
$phone = $array_org_user['phone'];
$website = $array_org_user['website'];
$email = $array_org_user['email'];
$content = $array_org_user['content'];
$sent = $array_org_user['sent'];
$status = $array_org_user['status'];

/*address*/
$area_str_name = $array_org_user['area_str_name'];
$street_name = $array_org_user['street_name'];
$street_number = $array_org_user['street_number'];
$place_name = $array_org_user['place_name'];

/*str_address*/
$address = '';
if ($area_str_name != '') $address .= $area_str_name;
if ($street_number != '' && $street_name != '') $address .= ", " . $street_number . " " . $street_name;
if ($street_name != '' && $street_number == '') $address .= ", " . $street_name;
if ($place_name != '' && $place_name != $street_number . " " . $street_name) $address .= ", " . $place_name;

$str_activate = "InActivate";
if ($status == "1") $str_activate = "Activate";

$str_sent = "UnSent";
if ($sent == "1") $str_sent = "Sent";

$str_status = $str_sent . " - " . $str_activate;

$Html->load('Form');
$form_row = '';

/* button edit */
$button_approve = $Html->Form->button(array("type" => "button", "class" => "edit", "onclick" => "activate_org('$uid_org_user')"), $status == "1" ? "InActivate" : "Activate");

$title_left = $Html->heading('User Org');

$form_row .= $Html->Form->row("Language", $lang);
$form_row .= $Html->Form->row("Name", $name);
$form_row .= $Html->Form->row("Code", $code);
$form_row .= $Html->Form->row("Phone", $phone);
$form_row .= $Html->Form->row("Email", $email);
$form_row .= $Html->Form->row("Address", $address);
$form_row .= $Html->Form->row("Website", $website);
$form_row .= $Html->Form->row("Description", $des);
$form_row .= $Html->Form->row("Content", $content);
$form_row .= $Html->Form->row("Status", $str_status);
$form_row .= $Html->Form->row("", $button_approve);

$form_left = $Html->Form->get(array("method" => "POST", "action" => '', "id" => "form_org"), $form_row);



$div_left = $Html->div($title_left . $form_left, "class='w50 left'");
echo $div_org = $Html->div($div_left, "class='w100 left'");
