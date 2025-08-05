<?php

/* tạo đối tượng html */
$Html = $this->load('html');
echo $Html->heading('Input Street');

$lang = "";
$area_str_code = '';

$id_user_area = '';
$name = '';
$name_address = '';

$code = '';

$type_name = "";
$type_code = "";

$des_short = "";
$des = '';
$content = "";
$request = '';
$sent = "";

/* lấy giá trị tham số area */
$uid_street_user = '';
if (isset($_GET['street'])) $uid_street_user = $_GET['street'];
if (isset($_GET['request'])) $request = $_GET['request'];

/*nếu uid area có giá trị khác '' thì đọc dữ liệu để hiển thị */
if ($uid_street_user != '') {
    $array_street_user_data = $this->request_api("street", "info_my", ["street" => $uid_street_user]);
    $array_street_user = isset($array_street_user_data["data"]) ? $array_street_user_data["data"] : null;

    if ($array_street_user != null) {
        /*lang, area*/
        $lang = $array_street_user['lang'];
        $area_str_code = $array_street_user['area_str_code'];

        /*name, code*/
        $name = $array_street_user['name'];
        $name_address = $array_street_user['name_address'];
        $code = $array_street_user['code'];

        /*description*/
        $des_short = $array_street_user['des_short'];
        $des = $array_street_user['des'];

        $content = $array_street_user['content'];



        /*sent, status, approve*/
        $sent = $array_street_user['sent'];
        $status         = $array_street_user["status"];
        $approved         = $array_street_user["approved"];
    }
}

$Form = $Html->load('Form');
$form_row = '';


/*select lang */
$array_lang_data = $this->request_api("language", "list");
$array_lang = isset($array_lang_data['data']) ? $array_lang_data['data'] : null;
if ($array_lang != null) array_unshift($array_lang, array("code" => "", "name" => "..."));
else $array_lang[] = array("code" => "", "name" => "...");
$select_lang = $Html->Form->selectbox(array("name" => "data[lang]", "id" => "select_lang_input", "onchange" => "change_lang_input()"), $array_lang, $lang);
$form_row .= $Form->row("Lang", $select_lang);


/* tạo input chọn khu vực */
$str_selectbox_area_parent = "";
$span_area_parent = $Html->span($str_selectbox_area_parent, "id='span_area_parent_input'");
$span_list_select_area =  $Html->span("", "id='span_list_select_area_input'");
$div_selectbox_area = $Html->div($span_area_parent . $span_list_select_area, "");

$hidden_str_code_parent = $Form->hidden(array("name" => "data[area_str_code]", "id" => "area_str_code_input", "value" => $area_str_code));

$form_row .= $Form->row("In", $div_selectbox_area . $hidden_str_code_parent);

/* tạo input nhập name */
$input_name = $Form->textbox(array("name" => "data[name]", "id" => "name", "value" => $name, "placeholder" => "Street name"));
$input_code = $Form->textbox(array("name" => "data[code]", "id" => "code", "value" => $code, "placeholder" => "Street code"));
$input_name_address = $Form->textbox(array("name" => "data[name_address]", "id" => "name_address", "value" => $name_address, "placeholder" => "Name in address"));

$label_name = $Html->span("", "id='lbl_name'");
$form_row .= $Form->row("Name", $input_name . $input_code . $input_name_address . $label_name);


/* input des */
$input_des_short = $Form->textbox(array("name" => "data[des_short]", "value" => $des_short, "style" => "width: 100%"));
$form_row .= $Form->row("Search Description", $input_des_short);

/* input des */
$input_des = $Form->textarea(array("name" => "data[des]", "style" => "width: 100%; height: 100px;"), $des);
$form_row .= $Form->row("Description", $input_des);

/* input content */
$input_content = $Form->textarea(array("name" => "data[content]", "style" => "width: 100%; height: 100px;"), $content);
$form_row .= $Form->row("Content", $input_content);

$array_sent = array("0" => "...", "1" => "Send");
$select_sent = $Html->Form->selectbox(array("name" => "data[sent]", "id" => "select_sent"), $array_sent, $sent);
$form_row .= $Form->row("Status", $select_sent);

/* button save */
$button_save = $Form->button(array("type" => "button", "id" => "button_save", 'onclick' => "save_street()"), "Save");
$button_close = $Html->Form->button(array("type" => "button", 'onclick' => "close_input('$request')"), "Close");

$hidden_uid = $Form->hidden(array("name" => "data[street]", "value" => $uid_street_user));
$form_row .= $Form->row("", $button_save . $hidden_uid);

$url_save = $this->get_link(array("controller" => "street", "function" => "index"));
echo $Form->get(array("method" => "POST", "action" => $url_save, "id" => "form_street"), $form_row);
