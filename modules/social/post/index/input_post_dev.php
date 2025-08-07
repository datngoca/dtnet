<?php

/* tạo đối tượng html */
$Html = $this->load('html');
echo $Html->heading('Input Post');

$lang = "";
$area_str_code = '';
$uid_street = "";
$uid_place = "";

$title = '';
$des = '';
$content = "";
$type = "";
$category = "";
$request = '';
$sent = "";
$uid_org = "";

$uid_post_user = "";

/* lấy giá trị tham số post */
if (isset($_GET['post'])) $uid_post_user = $_GET['post'];
if (isset($_GET['request'])) $request = $_GET['request'];

/*nếu uid post có giá trị khác '' thì đọc dữ liệu để hiển thị */
if ($uid_post_user != '') {
    $array_post_user_data =  $this->request_api("post", "info_my", ["post" => $uid_post_user]);
    $array_post_user = isset($array_post_user_data["data"]) ? $array_post_user_data["data"] : null;
    if ($array_post_user != null) {
        /*lang, area*/
        $lang = $array_post_user['lang'];
        $area_str_code = $array_post_user['area_str_code'];

        /*street, place*/
        $uid_street = $array_post_user['uid_street'];
        $uid_place = $array_post_user['uid_place'];

        /*title, des, content*/
        $title = $array_post_user['title'];
        $des = $array_post_user['des'];
        $content = $array_post_user['content'];

        /*type, category*/
        $type = $array_post_user['type'];
        $category = $array_post_user['category'];

        /*sent, status, approve*/
        $sent = $array_post_user['sent'];
        $status = $array_post_user["status"];
        $approved = $array_post_user["approved"];

        $uid_org = $array_post_user["org"];
    }
}

$Form = $Html->load('Form');
$form_row = '';

/*select lang */
<<<<<<< HEAD
$array_lang_data = $this->request_api("org", "list");
$array_lang = isset($array_lang_data["data"]) ? $array_lang_data["data"] : null;
if ($array_org != null) array_unshift($array_org, array("uid" => "", "name" => "..."));
else $array_org[] = array("uid" => "", "name" => "...");

$select_org = $Html->Form->selectbox(array("name" => "data[org]", "id" => "select_org_input", "onchange" => "change_org_input()"), $array_org, $org);
$form_row .= $Form->row("Org", $select_org);

=======
$array_lang_data = $this->request_api("language", "list");
$array_lang = isset($array_lang_data["data"]) ? $array_lang_data["data"] : null;
if ($array_lang != null) array_unshift($array_lang, array("code" => "", "name" => "..."));
else $array_lang[] = array("code" => "", "name" => "...");
$select_lang = $Html->Form->selectbox(array("name" => "data[lang]", "id" => "select_lang_input", "onchange" => "change_lang_input()"), $array_lang, $lang);
$form_row .= $Form->row("Lang", $select_lang);
>>>>>>> ecb0f9b (updated from huy's computer)

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
<<<<<<< HEAD
$form_row .= $Form->row("Street", $div_street_input . $hidden_street);
=======
$form_row .= $Form->row("Street", $div_street_input . $hidden_street . $hidden_street_data);
>>>>>>> ecb0f9b (updated from huy's computer)

/*input place_in */
$div_input_place_in = $Html->div("", "id = 'div_input_place_in' style = 'float: left; width: 100%'");
$hidden_place_in = $Form->hidden(array("id" => "hidden_place_in", "value" => $uid_place));
$hidden_place_in_data = $Form->hidden(array("name" => "data[place_in]", "id" => "hidden_place_in_data", "value" => $uid_place));

$form_row .= $Form->row("In Place", $div_input_place_in . $hidden_place_in . $hidden_place_in_data);

<<<<<<< HEAD
/*select Org */
$array_org_data = $this->request_api("org", "list");
$array_lang = isset($array_org_data["data"]) ? $array_org_data["data"] : null;
if ($array_lang != null) array_unshift($array_lang, array("uid" => "", "name" => "..."));
else $array_lang[] = array("code" => "", "name" => "...");
$select_lang = $Html->Form->selectbox(array("name" => "data[org]", "id" => "select_org_input", "onchange" => "change_lang_input()"), $array_lang, $lang);
$form_row .= $Form->row("Lang", $select_lang);
=======
/*input org */
$div_org_input = $Html->div("", "id = 'div_org_input' style = 'float: left; width: 100%'");
$hidden_org = $Form->hidden(array("id" => "hidden_org", "value" => $uid_org));
$hidden_org_data = $Form->hidden(array("name" => "data[uid_org]", "id" => "hidden_org_data", "value" => $uid_org));
$form_row .= $Form->row("Org", $div_org_input . $hidden_org . $hidden_org_data);
>>>>>>> ecb0f9b (updated from huy's computer)

/* Type selection */
$array_type = array(
    array("code" => "", "name" => "..."),
    array("code" => "news", "name" => "News"),
    array("code" => "event", "name" => "Event"),
    array("code" => "article", "name" => "Article"),
    array("code" => "announcement", "name" => "Announcement")
);
$select_type = $Html->Form->selectbox(array("name" => "data[type]", "id" => "select_type_input"), $array_type, $type);
$form_row .= $Form->row("Type", $select_type);

/* Category selection */
$array_category = array(
    array("code" => "", "name" => "..."),
    array("code" => "general", "name" => "General"),
    array("code" => "business", "name" => "Business"),
    array("code" => "education", "name" => "Education"),
    array("code" => "entertainment", "name" => "Entertainment"),
    array("code" => "sports", "name" => "Sports"),
    array("code" => "technology", "name" => "Technology")
);
$select_category = $Html->Form->selectbox(array("name" => "data[category]", "id" => "select_category_input"), $array_category, $category);
$form_row .= $Form->row("Category", $select_category);

/* tạo input nhập title */
$input_title = $Form->textbox(array("name" => "data[title]", "id" => "post_title", "value" => $title, "placeholder" => "Post title", "style" => "width: 100%"));
$label_title = $Html->span("", "id='lbl_title'");
$form_row .= $Form->row("Title", $input_title . $label_title);

/* input des */
$input_des = $Form->textarea(array("name" => "data[des]", "style" => "width: 100%; height: 100px;"), $des);
$form_row .= $Form->row("Description", $input_des);

/* input content */
$input_content = $Form->textarea(array("name" => "data[content]", "style" => "width: 100%; height: 200px;"), $content);
$form_row .= $Form->row("Content", $input_content);

$array_sent = array("0" => "...", "1" => "Send");
$select_sent = $Html->Form->selectbox(array("name" => "data[sent]", "id" => "select_sent"), $array_sent, $sent);
$form_row .= $Form->row("Status", $select_sent);

/* button save */
$button_save = $Form->button(array("type" => "button", "id" => "button_save", 'onclick' => "save_post()"), "Save");
$button_close = $Html->Form->button(array("type" => "button", 'onclick' => "close_input('$request')"), "Close");

$hidden_uid = $Form->hidden(array("name" => "data[post]", "value" => $uid_post_user));
$form_row .= $Form->row("", $button_save . " " . $button_close . $hidden_uid);

$url_save = $this->get_link(array("controller" => "post", "function" => "index"));
echo $Form->get(array("method" => "POST", "action" => $url_save, "id" => "form_post"), $form_row);

// echo $this->run('index/js_common');
