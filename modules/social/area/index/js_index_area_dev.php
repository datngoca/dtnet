<script>
    var url_area = "<?php echo $this->get_link(array("controller" => "area", "function" => "index")); ?>";

    function get_area_parent_list(str_area_code) {
        var url_area_parent = url_area;
        if (!url_area_parent.includes("?")) url_area_parent += "?";

        /*keep selected area in cookie*/
        setCookie("area_index", str_area_code);

        /*lưu lại str_code_parent_selected */
        str_code_parent_selected = str_area_code;

        let lang = document.getElementById("select_lang_list").value;

        /*lấy select parent_area_code*/
        url_area_parent += "action=get_parent&data_type=list&area=" + str_area_code + "&parent=&lang=" + lang;

        return get_page(url_area_parent, null, show_area_parent_list, "div_select_area_list");

    }

    function show_area_parent_list(result) {
        /* đưa selectbox vào div_area_parent_input */
        $("#div_select_area_list").css("display", "block");
        $("#div_select_area_list").html(result);

        /*autocomplete các input*/
        $(".select_area_list").autocomplete();

        list_area();
    }


    function change_area_parent_list(area_code) {
        /* lưu lại area_code vào biến area_str_code */
        $("#area_str_code").val(area_code);

        get_area_parent_list(area_code);
    }
    /* end: function change_area_parent(area_code) */

    function show_list(html_result) {
        /**Đưa dữ liệu html vào thẻ div_lang_list */
        document.getElementById('div_area_table').style.display = "block";
        document.getElementById('div_area_table').innerHTML = html_result;
    }


    function list_area() {

        loading("div_area_table");

        var str_search = document.getElementById('search').value;
        var area_str_code = document.getElementById('area_str_code').value;
        var lang = document.getElementById('select_lang_list').value;

        var url_area_list = url_area;
        if (!url_area_list.includes("?")) url_area_list += "?";
        /* request user_area/input?action=get_area để lấy area */
        url_area_list += "action=list&area=" + area_str_code + "&lang=" + lang + "&search=" + str_search;

        //var array_list_area = {action: 'list',search: str_search, area : area_str_code};
        console.log(url_area_list);

        return get_page(url_area_list, null, show_list, "div_msg");

    }
    /* end: function list_area() */



    function show_area_info(view_uid_user_area) {
        /* backup uid_user_area_selected */
        uid_user_area_selected = view_uid_user_area;

        /* gán uid user area vào url */
        self.location.href = '#' + uid_user_area_selected;


        /* show area name & parent*/
        str_area_name = "";
        if ($("#area_name_" + view_uid_user_area).length) str_area_name = $("#area_name_" + view_uid_user_area).html() + " - " + $("#parent_str_name_" + view_uid_user_area).html();
        document.getElementById('div_window_area_content_title').innerHTML = str_area_name;
        obj_window_area.show();

        /*show title & tab*/
        $("#div_area_tab").css("display", "block");
        $("#div_window_area_content_title").css("display", "block");

        /*hide area list */
        $("#div_area_form_input").css("display", "none");
        $("#div_area_list").hide();

        /* show tab info default */
        tab_area.click('info');

        $("html, body").animate({
            scrollTop: 0
        }, "fast");
        return;
    }


    function close_window_area() {
        self.location.href = '';
        $("#div_area_list").show();
    }
    /*end : function close_window_area() */


    function view_area_tab(tab_name) {
        if (tab_name == 'info') return view_detail_area();
        document.getElementById('tab_area_content').innerHTML = tab_name;
    }

    function view_detail_area() {
        var url_area_detail = url_area;
        if (!url_area_detail.includes("?")) url_area_detail += "?";
        url_area_detail += "area=" + uid_user_area_selected + "&action=info";

        loading('window_area_msg');

        return get_page(url_area_detail, null, show_area_detail, "window_area_msg");
    }

    function show_area_detail(result) {
        /*đưa form vào thẻ tab_area_content */
        document.getElementById('tab_area_content').innerHTML = result;
        document.getElementById('div_msg').innerHTML = '';
    }
    /*end : function view_detail_area(view_uid_user_area) */

    function change_lang() {
        /*keep selected lang in cookie*/
        let lang = document.getElementById('select_lang_list').value;
        setCookie("lang_index", lang);

        get_area_parent_list(area_str_code);
    }

    var area_str_code = '';
    var area_setting = '';
    var current_user = '';
    var parent_str_code = '';


    var obj_window_area;
    var uid_user_area_selected = '';



    function input_area(uid_user_area) {
        var url_area_input = url_area;
        if (!url_area_input.includes("?")) url_area_input += "?";

        obj_window_area.show();

        /*request area/input để lấy form */
        url_area_input += "action=input&area=" + uid_user_area;
        return get_page(url_area_input, null, show_form_input, "div_msg");


    }
    /*end : function show_form(uid_user_area) */

    function delete_area(uid_user_area) {
        var url_area_delete = url_area;
        if (!url_area_delete.includes("?")) url_area_delete += "?";

        url_area_delete += "action=delete&area=" + uid_user_area;
        return get_page(url_area_delete, null, null, "div_msg");
    }

    function show_form_input(result) {
        /*đưa form vào thẻ div_window_area_content */
        $("#div_area_form_input").html(result);
        $("#div_area_form_input").css("display", "block");

        /*hide tab info*/
        $("#div_area_tab").css("display", "none");
        $("#div_window_area_content_title").css("display", "none");



        /*autocomplete các input*/
        $("#select_area_parent_input").autocomplete();
        $("#select_lang_input").autocomplete();
        $("#select_sent").autocomplete();

        /*hide list*/
        $('#div_area_list').hide();

        /*get str_code_parent_selected */
        let parent_str_code_input = document.getElementById('parent_str_code').value;

        /*get_area_parent_input */
        get_area_parent_input(parent_str_code_input);

    }
</script>