<script>
    const Word = {
        "street_exist": "Đường phố đã tồn tại",
        "invalid_data": "Dữ liệu không hợp lệ",
        "no_uid": "Thiếu UID",
        "no_lang": "Thiếu ngôn ngữ",
        "no_area_code": "Thiếu mã khu vực",
        "no_name": "Thiếu tên đường phố",
        "no_code": "Thiếu mã đường phố",
        "update_ok": "Duyệt thành công",
        "insert_ok": "Duyệt thành công",
        "success": "Thành công",
    };

    function get_area_parent_list(str_area_code) {
        /*lưu lại str_code_parent_selected */
        str_code_parent_selected = str_area_code;

        let lang = document.getElementById("select_lang_list").value;

        /*lấy select parent_area_code*/
        var url_area_parent = "<?php echo $this->get_link(array("controller" => "area", "function" => "index", "get" => "action=get_parent&data_type=list")) ?>";
        url_area_parent += "&area=" + str_area_code + "&parent=&lang=" + lang;

        console.log(url_area_parent);
        return get_page(url_area_parent, null, show_area_parent_list, "div_select_area_list");

    }

    function show_area_parent_list(result) {
        /* đưa selectbox vào div_area_parent_input */
        $("#div_select_area_list").css("display", "block");
        $("#div_select_area_list").html(result);

        /*autocomplete các input*/
        $(".select_area_list").autocomplete();

        list_street();
    }


    function change_area_parent_list(area_code) {
        /* lưu lại area_code vào biến area_str_code */
        $("#area_str_code").val(area_code);

        get_area_parent_list(area_code);
    }
    /* end: function change_area_parent(area_code) */


    function show_list_street(result) {
        $("#div_street_table").html(result);
    }

    function list_street() {


        var str_search = document.getElementById('search').value;
        var area_str_code = document.getElementById('area_str_code').value;
        console.log("area_str_code:" + area_str_code);
        var lang = document.getElementById('select_lang_list').value;

        /* request user_area/input?action=get_area để lấy area */
        var url_street = "<?php echo $this->get_link(array("controller" => "street", "function" => "user", "get" => "action=list")) ?>";
        url_street += "&area=" + area_str_code + "&lang=" + lang + "&search=" + str_search;

        console.log(url_street);
        return get_page(url_street, null, show_list_street, "div_msg");
    }
    /* end: function list_street() */



    function show_street_info(view_uid_street_user) {
        /* backup uid_street_user_selected */
        uid_street_user_selected = view_uid_street_user;

        /* gán uid user area vào url */
        self.location.href = '#' + uid_street_user_selected;


        /* show area name & parent*/
        var str_street_name = "";
        if ($("#street_name_" + view_uid_street_user).length) str_street_name = $("#street_name_" + view_uid_street_user).html();
        if ($("#area_str_name_" + view_uid_street_user).length) str_street_name += " - " + $("#area_str_name_" + view_uid_street_user).html();

        document.getElementById('div_window_street_content_title').innerHTML = str_street_name;
        obj_window_street.show();

        /*show title & tab*/
        $("#div_street_tab").css("display", "block");
        $("#div_window_area_content_title").css("display", "block");

        /*hide area list */
        $("#div_street_form_input").css("display", "none");
        $("#div_street_list").hide();

        /* show tab info default */
        tab_street.click('info');

        $("html, body").animate({
            scrollTop: 0
        }, "fast");
        return;
    }


    function close_window_street() {
        self.location.href = '';
        $("#div_street_list").show();
    }
    /*end : function close_window_street() */


    function view_street_tab(tab_name) {
        if (tab_name == 'info') return view_detail_street();
        if (tab_name == 'cross') return view_cross_street_tab();

        document.getElementById('tab_street_content').innerHTML = tab_name;
    }



    /* hàm được gọi khi click vào tab cross ở trong window street*/
    function view_cross_street_tab() {

        var url_street_cross = "<?php echo $this->get_link(array("controller" => "street", "function" => "user", "get" => "action=cross")) ?>";
        url_street_cross += "&street=" + uid_street_user_selected;

        return get_page(url_street_cross, null, get_list_area_street_cross, "window_street_msg");
    }
    /*end : function area_cross() */

    function show_list_area_street_cross(result) {
        $("#tab_street_content").html(result);
    }

    function get_list_area_street_cross() {

        var url_list_area_street_cross = "<?php echo $this->get_link(array("controller" => "street", "function" => "user", "get" => "action=list_cross")) ?>";
        url_list_area_street_cross += "&street=" + uid_street_user_selected;
        return get_page(url_list_area_street_cross, null, show_list_area_street_cross, "div_msg");

    }
    /*end: functionget_list_area_street_crosslist_area_street_cross() */

    function show_detail_street(result) {
        document.getElementById('tab_street_content').innerHTML = result;
    }

    function show_approve_street(obj) {
        if (!obj) return alert("error");
        console.log("obj: ", typeof obj);
        const result = obj?.result;
        const msg = obj?.msg;
        const data = obj?.data;

        const str_msg = Word[msg] || msg;

        if (result !== "ok") return alert("Error: " + str_msg);
        alert(str_msg);

        const uid_street = data?.street;
        if (uid_street) {
            show_street_info(uid_street);
        }
        list_street();
    }

    function approve_street() {
        var url_approve_street = "<?php echo $this->get_link(array("controller" => "street", "function" => "user", "get" => "action=approve")) ?>";
        url_approve_street += "&street=" + uid_street_user_selected;

        return get_data(url_approve_street, null, show_approve_street, "window_street_msg");
    }

    function view_detail_street() {
        //loading('window_street_msg');
        var url_street_detail = "<?php echo $this->get_link(array("controller" => "street", "function" => "user", "get" => "action=info")) ?>";
        url_street_detail += "&street=" + uid_street_user_selected;
        console.log(url_street_detail);

        return get_page(url_street_detail, null, show_detail_street, "window_street_msg");

    }
    /*end : function view_detail_street(view_uid_user_area) */

    function change_lang() {

        selected_lang = document.getElementById("select_lang_list").value;
        setCookie("lang", selected_lang);
        get_area_parent_list(area_str_code);
    }

    var selected_lang = "";
    var area_str_code = '';
    var area_setting = '';
    var current_user = '';
    var parent_str_code = '';


    var obj_window_street;
    var uid_street_user_selected = '';
</script>