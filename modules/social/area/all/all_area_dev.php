<?php
/* tạo đối tượng html */
$Html = $this->load('html');

/*tạo đối tượng Form cho html */
$Form = $Html->load('Form');

$msg = "";
echo $Html->div($msg, "id='div_msg'");

/*div chứa form nhập area*/
$span_user_area_input = $Html->span("", "id='span_user_area_input'");
echo $Html->div($span_user_area_input, "id='div_input' style='display:none'");
echo $Html->div('', "id='div_window_area'");

/* lấy giá trị tham số Search */
$search = '';
$area_str_code = "";
$lang = "";

if (isset($_GET['search'])) $search = $_GET['search'];
if (isset($_GET['area'])) $area_str_code = $_GET['area'];
if ($lang == '') if (isset($_COOKIE["lang"]))   $lang = $_COOKIE["lang"];
if ($area_str_code == '') if (isset($_COOKIE["area_all"]))   $area_str_code = $_COOKIE["area_all"];


/*select lang */
$array_lang_data = $this->request_api("language", "list");
$array_lang = isset($array_lang_data["data"]) ? $array_lang_data["data"] : null;
if ($array_lang != null) array_unshift($array_lang, array("code" => "", "name" => "..."));
else $array_lang[] = array("code" => "", "name" => "...");
$select_lang = $Html->Form->selectbox(array("name" => "data[lang]", "id" => "select_lang_list", "onchange" => "change_lang_list()"), $array_lang, $lang);

/* Input Search,Button Search*/
$input_search = $Form->textbox(array("name" => "search", "value" => $search, "onkeyup" => "list_area()", 'id' => 'search'));
$button_search = $Form->button(array("class" => "search", "type" => "button", "onclick" => 'list_area()'), "Tìm kiếm");


$area_str_code_root = '';

/* Xác định user hiện tại đang được phân quyền khu vực nào? */
//$array_area_setting = $this->request_api("area","list_setting", $this->CurrentUser->uid);
$array_area_setting = null;
$array_area_root = null;

if (isset($array_area_setting['data'])) $array_area_root = $array_area_setting['data'];

$span_area_root = "Area: " . $Html->span("", "id='span_area_root'");
$hidden_area_root = $Form->hidden(array("name" => "data[area_str_code_root]", "id" => "area_str_code_root", "value" => $area_str_code_root));
$div_area_root = $Html->div($span_area_root, "id='div_area_root' class = 'left'") . $hidden_area_root;


$div_select_area_list =  $Html->div("", "id='div_select_area_list'");
$hidden_area_str_code = $Form->hidden(array("name" => "data[area_str_code]", "id" => "area_str_code", "value" => $area_str_code));



$form_search_content =  $Html->div("Lang: " . $select_lang, "id='div_lang_search'");

$form_search_content .= $div_area_root . $div_select_area_list .  $input_search . $hidden_area_str_code;

/*form search */
$url_search = $this->get_link(array("controller" => "all_area", "function" => "all"));
$form_search = $Form->get(array("method" => "GET", "action" => $url_search), $form_search_content);

/*Danh sách khu vực*/
$list_title = $Html->span('List Area');
echo $Html->div($list_title, "class= 'w100 left' id = 'div_title'");


/* table area */
$div_table_area_list = $Html->div("", "id='div_area_table' class= 'w100 left'");
echo $Html->div($form_search . $div_table_area_list, "id='div_area_list'");


/* thư viện js window */
echo $Html->js($this->template_url . "js/form/window");

echo $this->run('all/js_all');
?>
<script>
    var area_str_code = '<?php echo $area_str_code; ?>';

    $(document).ready(function() {

        /*gọi hàm show_area hiển thị khu vực cha */
        get_area_parent_list(area_str_code);

        /*window org*/
        obj_window_area = new Window({
            "target": "div_window_area",
            "close": close_window_area,
            "title": "Area Information"
        });

        /*window_area_content*/
        window_area_content = "<div id = 'div_area_form_input'>...</div>";
        window_area_content += "<h1 id = 'div_window_area_content_title'></h1>";
        window_area_content += "<div id = 'div_area_tab'>tab</div>";
        obj_window_area.set(window_area_content);


        /*tab cho thẻ div_window_area_tab*/
        tab_area = new Tab({
            "name": "area",
            "tabs": {
                "info": "Information"
            },
            "target": "div_area_tab",
            "content": "single",
            "click": view_area_tab
        });

        /*check anchor*/
        var anchor = (document.URL.split('#').length > 1) ? document.URL.split('#')[1] : null;
        if (anchor != null) uid_area_selected = anchor;


        list_area();
    });
    /*end : $(document).ready(function()*/
</script>
<style>
    #div_area_root {
        padding: 7px 0px;
        margin: 0px 0px 0px 15px;
    }

    #div_lang_search {
        width: auto;
        float: left;
    }

    #div_select_area_list {
        float: left;
        width: auto;
    }

    #div_title {
        margin: 20px 0px 10px
    }

    #div_title span {
        margin: 20px;
        color: green;
        font-weight: bold;
    }

    .autocomplete_frame {
        width: auto !important;
    }
</style>