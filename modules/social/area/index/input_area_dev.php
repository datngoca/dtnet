<?php

/* tạo đối tượng html */
$Html = $this->load('html');
echo $Html->heading('Input Area');

$lang = "";
$parent_str_code = '';

$id_user_area = '';
$name = '';
$name_address = "";
$code = '';

$type_name = "";
$type_code = "";

$des = '';
$des_short = "";

$content = "";
$request = '';
$sent = "";

/* lấy giá trị tham số area */
$uid_area_user = '';
if (isset($_GET['area'])) $uid_area_user = $_GET['area'];
if (isset($_GET['request'])) $request = $_GET['request'];

/*nếu uid area có giá trị khác '' thì đọc dữ liệu để hiển thị */
if ($uid_area_user != '') {
    // $this->loadModel("AreaUser");
    // $array_area_user = $this->AreaUser->read($uid_area_user);
    $array_area_user_data = $this->request_api("area", "info_my", ["area" => $uid_area_user]);
    $array_area_user = isset($array_area_user_data["data"]) ? $array_area_user_data["data"] : [];

    if ($array_area_user != null) {
        $lang = $array_area_user['lang'];
        $parent_str_code = $array_area_user['parent_str_code'];

        $id_user_area = $array_area_user['id'];
        $name = $array_area_user['name'];
        $code = $array_area_user['code'];
        $name_address = $array_area_user['name_address'];


        $type_name = $array_area_user['type_name'];
        $type_code = $array_area_user['type_code'];

        $des = $array_area_user['des'];
        $des_short = $array_area_user['des_short'];



        $sent = $array_area_user['sent'];
    }
}

$Form = $Html->load('Form');
$form_row = '';


/*select lang */
$array_lang_data = $this->request_api("language", "list");
$array_lang = isset($array_lang_data["data"]) ? $array_lang_data["data"] : null;

if ($array_lang != null) array_unshift($array_lang, array("code" => "", "name" => "..."));
else $array_lang[] = array("code" => "", "name" => "...");
$select_lang = $Html->Form->selectbox(array("name" => "data[lang]", "id" => "select_lang_input", "onchange" => "change_lang_input()"), $array_lang, $lang);
$form_row .= $Form->row("Lang", $select_lang);


/* tạo input chọn khu vực */
$str_selectbox_area_parent = "";
$span_area_parent = $Html->span($str_selectbox_area_parent, "id='span_area_parent_input'");
$span_list_select_area =  $Html->span("", "id='span_list_select_area_input'");
$div_selectbox_area = $Html->div($span_area_parent . $span_list_select_area, "");

$hidden_str_code_parent = $Form->hidden(array("name" => "data[parent_str_code]", "id" => "parent_str_code", "value" => $parent_str_code));

$form_row .= $Form->row("In", $div_selectbox_area . $hidden_str_code_parent);

/* tạo input nhập name */
$input_name = $Form->textbox(array("name" => "data[name]", "id" => "name", "value" => $name, "placeholder" => "Area name"));
$input_code = $Form->textbox(array("name" => "data[code]", "id" => "code", "value" => $code, "placeholder" => "Area code"));
$input_name_address = $Form->textbox(array("name" => "data[name_address]", "id" => "name", "value" => $name_address, "placeholder" => "Name in address"));

$label_name = $Html->span("", "id='lbl_name'");
$form_row .= $Form->row("Name", $input_name . $input_code . $input_name_address . $label_name);

/* input type */
$input_type_name = $Form->textbox(array("name" => "data[type_name]", "id" => "type_name", "value" => $type_name, "placeholder" => "Area type"));
$input_type_code = $Form->textbox(array("name" => "data[type_code]", "id" => "type_code", "value" => $type_code, "placeholder" => "Area type code"));
$form_row .= $Form->row("Type", $input_type_name . $input_type_code);

/* input des */
$input_des_short = $Form->textarea(array("name" => "data[des_short]", "style" => "width: 100%; height: 100px;"), $des_short);
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
$button_save = $Form->button(array("type" => "button", "id" => "button_save", 'onclick' => "save_area()"), "Save");
$button_close = $Html->Form->button(array("type" => "button", 'onclick' => "close_input('$request')"), "Close");

$hidden_uid = $Form->hidden(array("name" => "data[area]", "value" => $uid_area_user));
$form_row .= $Form->row("", $button_save . $button_close . $hidden_uid);

$url_save = $this->get_link(array("controller" => "area", "function" => "input"));
echo $Form->get(array("method" => "POST", "action" => $url_save, "id" => "form_area"), $form_row);
