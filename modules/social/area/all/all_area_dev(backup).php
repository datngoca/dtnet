<?php

/*Hml object, heading*/
$Html = $this->load("html");
$Form = $Html->load('Form');

echo $Html->div("", "id = 'div_info_area' class = 'left w100' ");
echo $Html->heading("List Area");


/*param search, lang*/
$search = isset($_GET["search"]) ? $_GET["search"] : '';
$lang = isset($_GET['lang']) ? $_GET['lang'] : 'vn';
$str_area_code_search = isset($_GET["area"]) ? $_GET["area"] : '';

if ($str_area_code_search == "") $str_area_code_search = $this->Cookie->get("area");
if ($str_area_code_search == "") $str_area_code_search = "vietnam";

/*search content*/
/*select lang */
$array_lang_data = $this->request_api("language", "list");
$array_lang = isset($array_lang_data["data"]) ? $array_lang_data["data"] : null;
if ($array_lang != null) array_unshift($array_lang, array("code" => "", "name" => "..."));
else $array_lang[] = array("code" => "", "name" => "...");
$select_lang = $Html->Form->selectbox(array("name" => "data[lang]", "id" => "select_lang_list", "onchange" => "change_lang()"), $array_lang, $lang);
$div_lang =  $Html->div("&nbsp; Lang: $select_lang", "class='left' style='margin: 0px 20px 0px 0px'");


/*input, button search*/
$Html->load("Form");
$div_area = $Html->div("", "id = 'div_area' style = 'float: left; width: 100'");

$hidden_area = $Html->Form->hidden(array("name" => "area", "value" => $str_area_code_search, "id" => "str_code"));;
$input_name = $Html->Form->textbox(array("name" => "search", "value" => $search, "id" => "search"));;
$button_search = $Html->Form->button(array("id" => "button_search", "type" => "button", "onclick" => "list_area()"), "Search");

$div_search = $Html->div($input_name . $button_search, "id = 'div_area' style = 'float: left; width: 100'");

echo $Html->Form->get(NULL, $div_lang . $div_area . $hidden_area . $div_search);

/*list area*/
echo $Html->div("", "id = 'list_area'");
echo $Html->div("&nbsp", " id = 'div_msg' ");


$return_type = "";
if (isset($_REQUEST["return"])) $return_type = $_REQUEST["return"];
?>
<script>
    var str_area_code_search = "<?php echo $str_area_code_search; ?>";

    function show_parent_area(result) {
        document.getElementById("div_area").innerHTML = result;

        /*autocomplete các input*/
        $(".select_area").autocomplete({
            reset: true
        });
    }

    function get_parent_area_list() {

        loading("div_area");

        str_path_area = document.getElementById("str_code").value;
        let lang = document.getElementById("select_lang_list").value;

        /*begin : Lấy danh sách địa danh*/
        var url_area = "<?php echo $this->get_link(array("controller" => "area", "function" => "all", "get" => "action=get_parent")); ?>";
        if (url_area.indexOf("?") === -1) url_area += "?";
        url_area += "&area=" + str_path_area;
        url_area += "&lang=" + lang;

        return get_page(url_area, null, show_parent_area, "div_select_area_list");

    }
    /* end:function show_area() */

    function change_lang() {
        let lang = document.getElementById('select_lang_list').value;
        get_parent_area_list();
    }

    function change_area_parent_list(str_path) {
        document.getElementById("str_code").value = str_path;
        get_parent_area_list();
        list_area();
    }

    var return_type = "<?php echo $return_type; ?>";

    function view_area(area) {
        /*begin : Lấy danh sách địa danh*/
        var url_area = "<?php echo $this->get_link(array("controller" => "area", "function" => "all", "get" => "action=view")); ?>";
        if (url_area.indexOf("?") === -1) url_area += "?";
        url_area += "&area=" + area;
        $.ajax({
            method: "GET",
            url: url_area,
            data: {}
        }).done(function(msg) {

            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;

            document.getElementById("div_info_area").innerHTML = msg;

            location.hash = "#" + area;


        });
        /*end : Lấy danh sách địa danh*/
    }
    /*end: function view_area(str_code)*/

    function list_area() {

        str_path = document.getElementById("str_code").value;

        /*begin : Lấy danh sách địa danh*/
        var url_area = "<?php echo $this->get_link(array("controller" => "area", "function" => "all", "get" => "action=list")); ?>";
        if (url_area.indexOf("?") === -1) url_area += "?";
        url_area += "&area=" + str_path;
        url_area += "&search=" + document.getElementById("search").value;
        url_area += "&return=" + return_type;

        $.ajax({
            method: "GET",
            url: url_area,
            data: {}
        }).done(function(msg) {
            document.getElementById("list_area").innerHTML = msg;
        });
        /*end : Lấy danh sách địa danh*/
    }
    /*end: function list_area(str_code)*/

    /*function change_area()
    {
    	list_area(document.getElementById("str_code").value);
    }*/


    var uid_area = "";
    var str_file_ext = "jpg,png,jpeg";
    var url_upload = "<?php echo $this->get_link(array("controller" => "file", "function" => "upload")); ?>";
    var uploader1 = null;

    /*hàm ready sẽ được gọi khi thư viện jquery đã tải xong*/
    $(document).ready(function() {

        get_parent_area_list();
        list_area();


        /*check anchor*/
        var anchor = (document.URL.split('#').length > 1) ? document.URL.split('#')[1] : null;
        if (anchor != null) view_area(anchor);

    });
    /*end : $(document).ready(function()*/


    function approve_area(uid_user_area) {

        var uid_area_selected = uid_user_area;

        /*request area/input để lấy form */
        var url_area_input = "<?php echo $this->get_link(array("controller" => "area", "function" => "all", "get" => "action=approve")); ?>";
        url_area_input += "&area=" + uid_area_selected;
        return get_data(url_area_input, null, show_approve_result, "div_msg");
    }
    /*end : function show_form(uid_user_area) */

    function show_active_result(result) {
        alert(result);
    }

    function active_area(area) {
        /*begin : Lấy danh sách địa danh*/
        var url_active = "<?php echo $this->get_link(array("controller" => "area", "function" => "all", "get" => "action=active")); ?>";
        if (url_active.indexOf("?") === -1) url_active += "?";
        url_active += "&area=" + area;
        return get_data(url_area, null, show_active_result);


        /*$.ajax({  method: "GET",  url: url_area,  data: {  } }).done(function( msg ) 
        {
        	
        	document.body.scrollTop = 0; 
        	document.documentElement.scrollTop = 0; 
        	
        	document.getElementById("div_info_area").innerHTML = msg;
        	
        	location.hash = "#" + area;

        				
        });*/
        /*end : Lấy danh sách địa danh*/
    }
    /*end: function active_area(str_code)*/

    function show_approve_result(obj_result) {

        console.log(obj_result);
        $("#div_msg").css("display", "block");

        if (!obj_result) return $("#div_msg").html("Error");


        if (!obj_result.hasOwnProperty('result')) obj_result.result = "";
        if (!obj_result.hasOwnProperty('msg')) obj_result.msg = "";
        if (!obj_result.hasOwnProperty('last_uid')) obj_result.last_uid = "";

        if (obj_result.result != "ok") return alert("Error: " + obj_result.msg);



        alert('Approve successfully');

        view_area(uid_area_selected);
    }


    function upload_file() {

        /*add params: file name, folder, task*/
        uploader1.set("type", "1");
        uploader1.set("folder", "2");
        uploader1.start();
    }
</script>