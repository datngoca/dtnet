<?php
/* tạo đối tượng html */
$Html = $this->load('html');

/*tạo đối tượng Form cho html */
$Form = $Html->load('Form');

$msg = "";
echo $Html->div($msg, "id='div_msg'");

/*div chứa form nhập area*/

$span_user_street_input = $Html->span("", "id='span_user_street_input'");
echo $Html->div($span_user_street_input, "id='div_input' style='display:none'");
echo $Html->div('', "id='div_window_street'");

/* lấy giá trị tham số Search */
$lang = "";
$area_str_code = "";
$search = '';

if (isset($_GET['lang'])) $lang = $_GET['lang'];
if (isset($_GET['search'])) $search = $_GET['search'];
if (isset($_GET['area'])) $area_str_code = $_GET['area'];

if ($lang == '') if (isset($_COOKIE["lang_index"]))   $lang = $_COOKIE["lang_index"];
if ($area_str_code == '') if (isset($_COOKIE["area_index"]))   $area_str_code = $_COOKIE["area_index"];

/*select lang */
$array_lang_data = $this->request_api("language", "list");
$array_lang = isset($array_lang_data['data']) ? $array_lang_data['data'] : null;
if ($array_lang != null) array_unshift($array_lang, array("code" => "", "name" => "..."));
else $array_lang[] = array("code" => "", "name" => "...");
$select_lang = $Html->Form->selectbox(array("name" => "data[lang]", "id" => "select_lang_list", "onchange" => "change_lang()"), $array_lang, $lang);
$div_lang =  $Html->div("&nbsp; Lang: $select_lang", "class='left' style='margin: 0px 20px 0px 0px'");

/* Xác định user hiện tại đang được phân quyền khu vực nào? */
//$array_area_setting = $this->request_api("area","list_setting", $this->CurrentUser->uid);
$area_str_code_root = '';
$array_area_setting = null;
$array_area_root = null;
if (isset($array_area_setting['data'])) $array_area_root = $array_area_setting['data'];

$span_area_root = "Area: " . $Html->span("", "id='span_area_root'");
$hidden_area_root = $Form->hidden(array("name" => "data[area_str_code_root]", "id" => "area_str_code_root", "value" => $area_str_code_root));
$div_area_root = $Html->div($span_area_root, "id='div_area_root' class = 'left' style='padding: 7px 0px'");

$div_select_area_list =  $Html->div("", "id='div_select_area_list'");
$hidden_area_str_code = $Form->hidden(array("name" => "data[area_str_code]", "id" => "area_str_code", "value" => $area_str_code));
$str_area = $div_area_root . $div_select_area_list . $hidden_area_str_code . $hidden_area_root;



/* Input Search,Button Search*/
$input_search = $Form->textbox(array("name" => "search", "value" => $search, "onkeyup" => "list_street()", 'id' => 'search'));
$button_search = $Form->button(array("class" => "search", "type" => "button", "onclick" => 'list_street()'), "Search");
$button_input = $Form->button(array("class" => "add right", "type" => "button", "onclick" => "input_street('')"), "Add new");

/*form search content*/
$form_search_content =   $div_lang . $str_area . $input_search . $button_search . $button_input;

/*form search */
$url_search = $this->get_link(array("controller" => "user_street", "function" => "my"));
$form_search = $Form->get(array("method" => "GET", "action" => $url_search), $form_search_content);

/*Danh sách khu vực*/
$list_title = $Html->span('List Street');
echo $Html->div($list_title, "class= 'w100 left' id = 'div_title'");


/* table area */
$div_table_area_list = $Html->div("", "id='div_street_table' class= 'w100 left'");
echo $Html->div($form_search . $div_table_area_list, "id='div_street_list'");


/* thư viện js window */
echo $Html->js($this->template_url . "js/form/window");

echo $this->run('index/js_index');
echo $this->run('index/js_input');
echo $this->run('index/cross/js_cross');

?>
<script>
    var area_str_code = '<?php echo $area_str_code; ?>';

    $(document).ready(function() {

        /*gọi hàm show_area hiển thị khu vực cha */
        get_area_list(area_str_code);

        /*window org*/
        obj_window_street = new Window({
            "target": "div_window_street",
            "close": close_window_street,
            "title": "Street Information"
        });

        /*window_street_content*/
        window_street_content = "<div id = 'div_street_form_input'>...</div>";
        window_street_content += "<h1 id = 'div_window_street_content_title'></h1>";
        window_street_content += "<div id = 'div_street_tab'>tab</div>";
        obj_window_street.set(window_street_content);


        /*tab cho thẻ div_window_street_tab*/
        tab_street = new Tab({
            "name": "street",
            "tabs": {
                "info": "Street Information",
                "cross": "Area Cross"
            },
            "target": "div_street_tab",
            "content": "single",
            "click": view_street_tab
        });

        /*check anchor*/
        var anchor = (document.URL.split('#').length > 1) ? document.URL.split('#')[1] : null;
        if (anchor != null) {
            uid_street_user_selected = anchor;
        }

        list_street();

        if (uid_street_user_selected != '') show_street_info(uid_street_user_selected);

    });
    /*end : $(document).ready(function()*/
</script>
<style>
    #div_select_area_list {
        float: left;
    }

    #div_title {
        margin: 20px 0px 10px
    }

    #div_title span {
        margin: 20px;
        color: green;
        font-weight: bold;
    }

    #tab_street_content {
        min-height: 300px
    }
</style>