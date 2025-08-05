<?php

$this->loadModel("CountryUser");

// Lấy các giá trị country 
$lang = "";
$name = "";
$code = "";
$des = "";

// Kiểm tra có tham số country
$uid_country = isset($_GET["country"]) ? $_GET["country"] : "";

// Get data when exist uid_country
$array_country_user_data = $this->request_api("country", "info_my", ["country" => $uid_country]);
$array_country_user = [];
if (isset($array_country_user_data["data"])) {
    $array_country_user = $array_country_user_data["data"];
    $lang = $array_country_user["lang"];
    $name = $array_country_user["name"];
    $code = $array_country_user["code"];
    $des = $array_country_user["des"];
}

// Tạo nội dung form 
$form_row = "";

$Html = $this->load("Html");
$Form = $Html->load("Form");

/*select lang */
$array_lang_data = $this->request_api("language", "list");
$array_lang = isset($array_lang_data["data"]) ? $array_lang_data["data"] : null;

if ($array_lang != null) array_unshift($array_lang, array("code" => "", "name" => "..."));
else $array_lang[] = array("code" => "", "name" => "...");
$select_lang = $Html->Form->selectbox(array("name" => "data[lang]", "id" => "select_lang_input", "onchange" => "change_lang_input()"), $array_lang, $lang);
$form_row .= $Form->row("Lang", $select_lang);

// Tạo dòng language

// Tạo dòng name
$input_name = $Form->textbox(array("name" => "data[name]", "id" => "name", "value" => $name));
$lbl_name = $Html->span("", "id='lbl_name'");
$form_row .= $Form->row("Name", $input_name . $lbl_name);

// Tạo dòng code
$input_code = $Form->textbox(array("name" => "data[code]", "id" => "code", "value" => $code));
$form_row .= $Form->row("Code", $input_code);

// Tạo dòng description
$input_des = $Form->textbox(array("name" => "data[des]", "id" => "des", "value" => $des));
$form_row .= $Form->row("Description", $input_des);

// Tạo dòng Save
$button_save = $Form->button(array("id" => "button_save", "class" => "save", "type" => "button", "onclick" => "save_country()"), "Save");
$hidden_country = $Form->hidden(array("name" => "data[country]", "value" => $uid_country));
$form_row .= $Form->row("", $button_save . $hidden_country);

// get form_input
$url_input = $this->get_link(array("controller" => "country", "function" => "index"));
$form_input = $Form->get(array("method" => "POST", "action" => $url_input, "id" => "form_input_country"), $form_row);

echo $Html->heading($uid_country !== "" ? "Edit country" : "Add new country");
echo $form_input;
