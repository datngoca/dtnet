<script>
    var url_org = "<?php echo $this->get_link(array("controller" => "org", "function" => "user")) ?>";

    function change_lang() {

        let selected_lang = document.getElementById("select_lang_list").value;

        // Không lưu lang vào cookie nữa
        $("#uid_street").val("");
        // Không lưu street vào cookie nữa

        get_area_list(area_str_code);
    }

    function get_area_list(str_area_code) {
        /*lưu lại str_code_parent_selected */
        str_code_parent_selected = str_area_code;

        let lang = document.getElementById("select_lang_list").value;

        /*lấy select parent_area_code*/
        var url_area = url_org;
        if (!url_area.includes("?")) url_area += "?";
        url_area += "action=get_area&data_type=list";
        url_area += "&area=" + str_area_code + "&lang=" + lang;

        console.log(url_area);
        return get_page(url_area, null, show_area_list, "div_select_area_list");
    }

    function show_area_list(result) {
        /* đưa selectbox vào div_area_parent_input */
        $("#div_select_area_list").css("display", "block");
        $("#div_select_area_list").html(result);

        /*autocomplete các input*/
        $(".select_area_list").autocomplete();

        list_org();
    }


    function change_area_list(area_code) {
        // Không lưu area vào cookie nữa

        /* lưu lại area_code vào biến area_str_code */
        $("#area_str_code").val(area_code);
        // Reset street selection khi thay đổi area
        $("#uid_street").val("");
        // Reset place selection khi thay đổi area
        $("#uid_place").val("");
        // Không lưu street vào cookie nữa

        get_area_list(area_code);
        let lang = document.getElementById("select_lang_list").value;

        // Thêm dòng này để load street list khi area thay đổi
        get_street_list(area_code, lang);
    }
    /* end: function change_area_parent(area_code) */


    function get_street_list(area_code, lang) {
        var url_street = url_org;
        var parent_code = "";
        if (!url_street.includes("?")) url_street += "?";
        url_street += "action=get_street&data_type=list";
        url_street += "&area=" + area_code + "&parent=" + parent_code + "&lang=" + lang;

        return get_page(url_street, null, show_street_list, "div_select_street_list");
    }

    function show_street_list(result) {
        $("#div_select_street_list").css("display", "block");
        $("#div_select_street_list").html(result);

        /*autocomplete street input*/
        $(".select_street_list").autocomplete();

        list_org();
    }

    function change_street_list(street_uid) {
        // Không lưu street vào cookie nữa

        let lang = document.getElementById("select_lang_list").value;

        /* lưu lại street_uid vào biến uid_street */
        $("#uid_street").val(street_uid);
        // Reset place selection khi thay đổi street
        $("#uid_place").val("");

        get_place_in_list(area_str_code, lang, street_uid);
        list_org();
    }
    /* end: function change_street_list(street_uid) */

    function get_place_in_list(area_code, lang, street) {

        var url_place = url_org;
        var parent_code = "";
        if (!url_place.includes("?")) url_place += "?";
        url_place += "action=get_place&data_type=list";
        url_place += "&area=" + area_code + "&parent=" + parent_code + "&lang=" + lang + "&street=" + street;

        return get_page(url_place, null, show_place_in_list, "div_select_place_list");
    }

    function show_place_in_list(result) {
        $("#div_select_place_list").css("display", "block");
        $("#div_select_place_list").html(result);

        /*autocomplete street input*/
        $(".select_place_in_list").autocomplete();
        list_org();
    }

    function change_place_in_list(place_uid) {
        /* lưu lại place_uid vào biến uid_place */
        $("#uid_place").val(place_uid);

        list_org();
    }
    /* end: function change_place_in_list(place_uid) */

    function list_org() {
        loading("div_org_table");

        var str_search = document.getElementById('search').value;
        var area_str_code = document.getElementById('area_str_code') ? document.getElementById('area_str_code').value : '';
        var uid_street = document.getElementById('uid_street') ? document.getElementById('uid_street').value : '';
        var lang = document.getElementById('select_lang_list') ? document.getElementById('select_lang_list').value : '';
        var place = document.getElementById('uid_place') ? document.getElementById('uid_place').value : '';

        /* request org/user?action=list để lấy danh sách org */
        var url_list = url_org;
        if (!url_list.includes("?")) url_list += "?";
        url_list += "action=list";
        url_list += "&area=" + area_str_code + "&lang=" + lang + "&search=" + str_search + "&street=" + uid_street + "&place=" + place;

        return get_page(url_list, null, show_org_list, "div_msg");
    }
    /* end: function list_org() */

    function show_org_list(result) {
        $("#div_org_table").html(result);
        if (uid_org_user_selected != '') show_org_info(uid_org_user_selected);
    }



    function show_org_info(view_uid_org_user) {
        /* backup uid_org_user_selected */
        uid_org_user_selected = view_uid_org_user;

        /* gán uid user area vào url */
        self.location.href = '#' + uid_org_user_selected;


        /* show area name & parent*/
        var str_org_name = "";
        if ($("#org_name_" + view_uid_org_user).length) str_org_name = $("#org_name_" + view_uid_org_user).html();
        if ($("#area_str_name_" + view_uid_org_user).length) str_org_name += " - " + $("#area_str_name_" + view_uid_org_user).html();

        document.getElementById('div_window_org_content_title').innerHTML = str_org_name;
        obj_window_org.show();

        /*show title & tab*/
        $("#div_org_tab").css("display", "block");
        $("#div_window_area_content_title").css("display", "block");

        /*hide area list */
        $("#div_org_form_input").css("display", "none");
        $("#div_org_list").hide();

        /* show tab info default */
        tab_org.click('info');

        $("html, body").animate({
            scrollTop: 0
        }, "fast");
        return;
    }


    function close_window_org() {
        self.location.href = '';
        $("#div_org_list").show();
    }
    /*end : function close_window_org() */


    function view_org_tab(tab_name) {
        if (tab_name == 'info') return view_detail_org();
        document.getElementById('tab_org_content').innerHTML = tab_name;
    }

    function show_detail_org(result) {
        document.getElementById('tab_org_content').innerHTML = result;
    }

    function view_detail_org() {
        //loading('window_org_msg');
        var url_detail = url_org;
        if (!url_detail.includes("?")) url_detail += "?";
        url_detail += "action=info";
        url_detail += "&org=" + uid_org_user_selected;

        return get_page(url_detail, null, show_detail_org, "window_org_msg");
    }
    /*end : function view_detail_org(view_uid_user_area) */

    var area_str_code = '';
    var area_setting = '';
    var current_user = '';
    var parent_str_code = '';
    var str_code_parent_selected = '';

    var obj_window_org;
    var uid_org_user_selected = '';

    function show_approve_org(obj) {
        if (!obj) return alert("error");

        const result = obj?.result;
        const msg = obj?.msg;
        const data = obj?.data

        const str_msg = typeof Word !== 'undefined' && Word[msg] ? Word[msg] : msg;

        if (result !== "ok") return alert("Error: " + str_msg);
        alert(str_msg);

        const uid_org = data?.org;

        show_org_info(uid_org);
    }

    function approve_org() {
        var url_approve_org = url_org;
        url_approve_org += "?action=approve&org=" + uid_org_user_selected;

        return get_data(url_approve_org, null, show_approve_org, "div_msg");
    }
</script>