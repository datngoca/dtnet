<?php
/* kiểm tra khu vực có hợp lệ? */
$uid_street = '';
if (isset($_GET['street'])) $uid_street = $_GET['street'];
if ($uid_street  == '') exit('no_street');

// $this->loadModel("StreetUser");
// $array_street_user = $this->StreetUser->read($uid_street);

$array_street_user_data = $this->request_api("street", "info", ["street" => $uid_street]);
$array_street_user = isset($array_street_user_data["data"]) ? $array_street_user_data["data"] : null;

if ($array_street_user == null)  exit('invalid_street');

/* tạo đối tượng html */
$Html = $this->load('html');

/*lang, area*/
$lang = $array_street_user['lang'];
$span_street_lang = $Html->span($lang, "id = 'span_street_lang'");

$area_str_code = $array_street_user['area_str_code'];
$area_str_name = $array_street_user['area_str_name'];

$span_area_name = $Html->span($area_str_name, "id = 'span_area_name'");
$span_street_area_code = $Html->span($area_str_code, "id = 'span_street_area_code'");

/*name, code, des*/
$name = $array_street_user['name'];
$name_address = $array_street_user['name_address'];

$span_street_name = $Html->span($name, "id = 'span_street_name'");

$code = $array_street_user['code'];
$str_code = $array_street_user['str_code'];

$des        = $array_street_user['des'];
$des_short = $array_street_user['des_short'];

$status = $array_street_user['status'];
$url_key = $array_street_user['url_key'];

$str_status = "Unactive";
if ($status == "1") $str_status = "Active";

$Html->load('Form');
$form_row = '';

/* button activate */
$button_activate = $Html->Form->button(array("type" => "button", "class" => "edit", "onclick" => "activate_street('$uid_street')"), $status ? "Unactivate" : "Activate");

$title_left = $Html->heading('User Street Information');

$form_row .= $Html->Form->row("Language", $span_street_lang);
$form_row .= $Html->Form->row("In", $span_area_name . '</br>' . $span_street_area_code);
$form_row .= $Html->Form->row("Street Name", $span_street_name . '</br>' . "($code)");
$form_row .= $Html->Form->row("Name in address", $name_address);

$form_row .= $Html->Form->row("Code", $str_code);
$form_row .= $Html->Form->row("Url key", $url_key);

$form_row .= $Html->Form->row("Search", $des_short);

$form_row .= $Html->Form->row("Description", $des);
$form_row .= $Html->Form->row("Status ", $str_status);

$form_row .= $Html->Form->row("", $button_activate);

$form_left = $Html->Form->get(array("method" => "POST", "action" => '', "id" => "form_street"), $form_row);

$div_left = $Html->div($title_left . $form_left, "class='w50 left'");
echo $div_street = $Html->div($div_left, "class='w100 left'");
