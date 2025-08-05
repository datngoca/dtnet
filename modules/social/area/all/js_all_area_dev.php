<script>
    var url_area = "<?php echo $this->get_link(array("controller" => "area", "function" => "all")) ?>";

    function change_lang_list() {
        /*keep selected lang in cookie*/
        let lang = document.getElementById('select_lang_list').value;
        setCookie("lang", lang);

        get_area_parent_list(str_code_parent_selected);
    }

    function get_area_parent_list(str_area_code) {
        lang = document.getElementById("select_lang_list").value;

        /*lưu lại str_code_parent_selected */
        str_code_parent_selected = str_area_code;

        /*lấy select parent_area_code*/
        var url_area_parent = "<?php echo $this->get_link(array("controller" => "area", "function" => "index", "get" => "action=get_parent&data_type=list")) ?>";
        url_area_parent += "&area=" + str_area_code + "&parent=&lang=" + lang;
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

        /*keep selected area_code in cookie*/
        let lang = document.getElementById('select_lang_list').value;
        setCookie("area_all", area_code);

        /* lưu lại area_code vào biến area_str_code */
        $("#area_str_code").val(area_code);

        get_area_parent_list(area_code);
    }
    /* end: function change_area_parent(area_code) */

    function show_list_area(result) {
        $("#div_area_table").html(result);
        if (uid_area_selected != '') show_area_info(uid_area_selected);
    }

    function list_area() {
        var url_area_list = url_area;
        if (!url_area_list.includes("?")) url_area_list += "?";

        var str_search = document.getElementById('search').value;
        var area_str_code = document.getElementById('area_str_code').value;
        var lang = document.getElementById('select_lang_list').value;


        /* request user_area/input?action=get_area để lấy area */
        url_area_list += "action=list&area=" + area_str_code + "&lang=" + lang + "&search=" + str_search;

        self.location.href = '#';

        uid_area_selected = "";

        //var array_list_area = {action: 'list',search: str_search, area : area_str_code};
        console.log(url_area_list);

        return get_page(url_area_list, null, show_list_area, "div_msg");

    }
    /* end: function list_user_area() */



    function show_area_info(view_uid_area) {
        /* backup uid_area_selected */
        uid_area_selected = view_uid_area;

        /* gán uid user area vào url */
        self.location.href = '#' + uid_area_selected;


        /* show area name & parent*/
        str_area_name = "";
        if ($("#area_name_" + view_uid_area).length) str_area_name = $("#area_name_" + view_uid_area).html() + " - " + $("#parent_str_name_" + view_uid_area).html();
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
        self.location.href = '#';
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
        url_area_detail += "area=" + uid_area_selected + "&action=info";

        loading('window_area_msg');

        return get_page(url_area_detail, null, show_area_detail, "window_area_msg");
    }

    function show_area_detail(result) {
        /*đưa form vào thẻ tab_area_content */
        document.getElementById('tab_area_content').innerHTML = result;
        document.getElementById('div_msg').innerHTML = '';
    }
    /*end : function view_detail_area(view_uid_area) */


    var area_str_code = '';
    var area_setting = '';
    var current_user = '';
    var parent_str_code = '';


    var obj_window_area;
    var uid_area_selected = '';



    function activate_area(uid_area) {
        var url_area_activate = url_area;
        if (!url_area_activate.includes("?")) url_area_activate += "?";

        uid_area_selected = uid_area;

        /*request area/activate để activate */
        url_area_activate += "action=activate&area=" + uid_area;

        return get_data(url_area_activate, null, show_activate_result, "div_msg");


    }
    /*end : function show_form(uid_area) */

    function show_activate_result(obj_result) {

        console.log(obj_result);
        $("#div_msg").css("display", "block");

        if (!obj_result) return $("#div_msg").html("Error");


        if (!obj_result.hasOwnProperty('result')) obj_result.result = "";
        if (!obj_result.hasOwnProperty('msg')) obj_result.msg = "";
        // if (!obj_result.hasOwnProperty('last_uid')) obj_result.last_uid = "";
        if (!obj_result.hasOwnProperty('area')) obj_result.area = "";

        if (obj_result.result != "ok") return alert("Error: " + obj_result.msg);



        alert('Activate successfully');

        // show_area_info(uid_area_selected);
        show_area_info(obj_result.area);
    }
</script>