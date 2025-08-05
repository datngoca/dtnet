<script>
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

        list_user_area();
    }


    function change_area_parent_list(area_code) {

        /*keep selected area_code in cookie*/
        let lang = document.getElementById('select_lang_list').value;
        setCookie("area_user", area_code);

        /* lưu lại area_code vào biến area_str_code */
        $("#area_str_code").val(area_code);

        get_area_parent_list(area_code);
    }
    /* end: function change_area_parent(area_code) */

    function show_list_user_area(result) {
        $("#div_area_table").html(result);
        if (uid_user_area_selected != '') show_area_info(uid_user_area_selected);
    }

    function list_user_area() {

        var str_search = document.getElementById('search').value;
        var area_str_code = document.getElementById('area_str_code').value;
        var lang = document.getElementById('select_lang_list').value;

        /* request user_area/input?action=get_area để lấy area */
        var url_user_area = "<?php echo $this->get_link(array("controller" => "area", "function" => "user", "get" => "action=list")) ?>";
        url_user_area += "&area=" + area_str_code + "&lang=" + lang + "&search=" + str_search;

        self.location.href = '#';

        uid_user_area_selected = "";

        //var array_list_area = {action: 'list',search: str_search, area : area_str_code};
        console.log(url_user_area);

        return get_page(url_user_area, null, show_list_user_area, "div_msg");

    }
    /* end: function list_user_area() */



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
        self.location.href = '#';
        $("#div_area_list").show();
    }
    /*end : function close_window_area() */

    function view_area_tab(tab_name) {
        if (tab_name == 'info') return view_detail_area();
        document.getElementById('tab_area_content').innerHTML = tab_name;
    }

    function view_detail_area() {
        loading('window_area_msg');
        var url_area_detail = "<?php echo $this->get_link(array("controller" => "area", "function" => "user")) ?>";
        if (!url_area_detail.includes("?")) url_area_detail += "?";
        url_area_detail += "area=" + uid_user_area_selected + "&action=info";

        return get_page(url_area_detail, null, show_area_detail, "window_area_msg");
    }

    function show_area_detail(result) {
        /*đưa form vào thẻ tab_area_content */
        document.getElementById('tab_area_content').innerHTML = result;
        document.getElementById('div_msg').innerHTML = '';
    }
    /*end : function view_detail_area(view_uid_user_area) */


    var area_str_code = '';
    var area_setting = '';
    var current_user = '';
    var parent_str_code = '';


    var obj_window_area;
    var uid_user_area_selected = '';



    function approve_area(uid_user_area) {

        uid_user_area_selected = uid_user_area;

        /*request area/input để lấy form */
        var url_area_input = "<?php echo $this->get_link(array("controller" => "area", "function" => "user", "get" => "action=approve")); ?>";
        url_area_input += "&area=" + uid_user_area;

        console.log("url approve: " + url_area_input);
        return get_data(url_area_input, null, show_approve_result, "div_msg");


    }
    /*end : function show_form(uid_user_area) */

    function show_approve_result(obj_result) {

        console.log(obj_result);
        $("#div_msg").css("display", "block");

        if (!obj_result) return $("#div_msg").html("Error");


        if (!obj_result.hasOwnProperty('result')) obj_result.result = "";
        if (!obj_result.hasOwnProperty('msg')) obj_result.msg = "";
        // if (!obj_result.hasOwnProperty('last_uid')) obj_result.last_uid = "";
        if (!obj_result.hasOwnProperty('area')) obj_result.area = "";

        if (obj_result.result != "ok") return alert("Error: " + obj_result.msg);



        alert('Approve successfully');

        // show_area_info(uid_user_area_selected);
        show_area_info(obj_result.area);
    }
</script>