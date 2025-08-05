<?php
/* kiểm tra khu vực có hợp lệ? */
$uid_place = '';
if (isset($_GET['place'])) $uid_place = $_GET['place'];
if ($uid_place  == '') exit('invalid');

$array_place_data =  $this->request_api("place", "info", ["place" => $uid_place]);
$array_place = isset($array_place_data["data"]) ? $array_place_data["data"] : null;
if ($array_place == null)  exit('invalid_place');

/* tạo đối tượng html */
$Html = $this->load('html');

/*lang, area*/
$lang = $array_place['lang'];
$area_str_code = $array_place['area_str_code'];
$area_str_name = $array_place['area_str_name'];

$street_name = $array_place['street_name'];
$street_number = $array_place['street_number'];

$place_name_in  = $array_place['place_name_in'];

/*name, code, des*/
$name = $array_place['name'];
$code = $array_place['code'];
$str_code = $array_place['str_code'];
$des = $array_place['des'];

$approved = $array_place['approved'];
$status = $array_place['status'];
$url_key = $array_place['url_key'];


$str_approved = "Unapproved";
if ($approved == "1") $str_approved = "Approved";

$str_status = "Inactive";
if ($status == "1") $str_status = "Active";


$Html->load('Form');
$form_row = '';


/* button activate */
$button_activate = $Html->Form->button(array("type" => "button", "class" => "edit", "onclick" => "activate_place('$uid_place')"), $status === "1" ? "InActivate" : "Activate");

$title_left = $Html->heading('Place Information');

$form_row .= $Html->Form->row("Language", $lang);
$form_row .= $Html->Form->row("Place name", $name);
$form_row .= $Html->Form->row("Code", $str_code);
$form_row .= $Html->Form->row("Url key", $url_key);
$form_row .= $Html->Form->row("Street Name", $street_name);
$form_row .= $Html->Form->row("In Area", $area_str_name . '</br>' . $area_str_code);

$form_row .= $Html->Form->row("Street number", $street_number);

$form_row .= $Html->Form->row("In Place", $place_name_in);

$form_row .= $Html->Form->row("Description", $des);
$form_row .= $Html->Form->row("Status ", $str_status . " - " . $str_approved);

$form_row .= $Html->Form->row("", $button_activate);

$form_left = $Html->Form->get(array("method" => "POST", "action" => '', "id" => "form_place"), $form_row);

echo $Html->div($title_left . $form_left, "class='w100 left'");
