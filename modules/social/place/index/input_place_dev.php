<?php

/* tạo đối tượng html */
$Html = $this->load('html');
echo $Html->heading('Input Place');

$lang = "";
$area_str_code = '';

$id_user_area = '';
$name = '';
$code = '';

$type_name = "";
$type_code = "";

$des_short = "";
$des = '';
$content = "";
$request = '';
$sent = "";

/*street number*/
$uid_street = "";
$street_number = "";

$uid_place_in = "";

/*section, floor, room*/
$section = "";
$floor = "";
$room = "";


/* lấy giá trị tham số area */
$uid_place_user = '';
if (isset($_GET['place'])) $uid_place_user = $_GET['place'];
if (isset($_GET['request'])) $request = $_GET['request'];

/*nếu uid area có giá trị khác '' thì đọc dữ liệu để hiển thị */
if ($uid_place_user != '') {
    $array_place_user_data =  $this->request_api("place", "info_my", ["place" => $uid_place_user]);
    $array_place_user = isset($array_place_user_data["data"]) ? $array_place_user_data["data"] : null;
    if ($array_place_user != null) {
        /*lang, area*/
        $lang = $array_place_user['lang'];
        $area_str_code = $array_place_user['area_str_code'];

        /*street*/
        $uid_street = $array_place_user['uid_street'];
        $street_number = $array_place_user['street_number'];

        $uid_place_in = $array_place_user['uid_place_in'];

        /*section, floor, room*/
        $section = $array_place_user['section'];
        $floor = $array_place_user['floor'];
        $room = $array_place_user['room'];

        /*name, code*/
        $name = $array_place_user['name'];
        $code = $array_place_user['code'];
        $content = $array_place_user['content'];

        /*description*/
        $des_short = $array_place_user['des_short'];
        $des = $array_place_user['des'];

        /*sent, status, approve*/
        $sent = $array_place_user['sent'];
        $status         = $array_place_user["status"];
        $approved         = $array_place_user["approved"];
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

$hidden_str_code_parent = $Form->hidden(array("name" => "data[area_str_code]", "id" => "area_str_code_input", "value" => $area_str_code));

$form_row .= $Form->row("In Area", $div_selectbox_area . $hidden_str_code_parent);

/*input street */
$div_street_input = $Html->div("", "id = 'div_street_input' style = 'float: left; width: 100%'");
$hidden_street = $Form->hidden(array("id" => "hidden_street", "value" => $uid_street));
$hidden_street_data = $Form->hidden(array("name" => "data[uid_street]", "id" => "hidden_street_data", "value" => $uid_street));
$form_row .= $Form->row("Street", $div_street_input . $hidden_street);

/*input place_in */
$div_input_place_in = $Html->div("", "id = 'div_place_in_input' style = 'float: left; width: 100%'");
$hidden_place_in = $Form->hidden(array("id" => "hidden_place_in", "value" => $uid_place_in));
$hidden_place_in_data = $Form->hidden(array("name" => "data[place_in]", "id" => "hidden_place_in_data", "value" => $uid_place_in));

$form_row .= $Form->row("In Place", $div_input_place_in . $hidden_place_in . $hidden_place_in_data);

/*input_street_number */
$input_street_number = $Form->textbox(array("name" => "data[street_number]", "style" => "width: 100%", "value" => $street_number, "onchange" => "change_street_number()"));
$form_row .= $Form->row("Street number", $input_street_number);

/*section */
$input_section = $Form->textbox(array("name" => "data[section]", "value" => $section));
$input_floor = $Form->textbox(array("name" => "data[floor]", "value" => $floor));
$input_room = $Form->textbox(array("name" => "data[room]", "value" => $room));
$form_row .= $Form->row("Section", $input_section . " Floor: " . $input_floor . " Room: " . $input_room);

/* tạo input nhập name */
$input_name = $Form->textbox(array("name" => "data[name]", "id" => "place_name", "value" => $name, "placeholder" => "Place name"));
$input_code = $Form->textbox(array("name" => "data[code]", "id" => "code", "value" => $code, "placeholder" => "Place code"));
$label_name = $Html->span("", "id='lbl_name'");
$form_row .= $Form->row("Name", $input_name . $input_code . $label_name);


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
$button_save = $Form->button(array("type" => "button", "id" => "button_save", 'onclick' => "save_place()"), "Save");
$button_close = $Html->Form->button(array("type" => "button", 'onclick' => "close_input('$request')"), "Close");

$hidden_uid = $Form->hidden(array("name" => "data[place]", "value" => $uid_place_user));
$form_row .= $Form->row("", $button_save . " " . $button_close . $hidden_uid);


$url_save = $this->get_link(array("controller" => "place", "function" => "index"));
echo $Form->get(array("method" => "POST", "action" => $url_save, "id" => "form_place"), $form_row);
