<script>
    var url_place = "<?php echo $this->get_link(array("controller" => "place", "function" => "all")) ?>";

    function get_area_list(str_area_code) {
        /*lưu lại str_code_parent_selected */
        str_code_parent_selected = str_area_code;

        let lang = document.getElementById("select_lang_list").value;

        /*lấy select parent_area_code*/
        var url_area = url_place;
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

        // let lang = document.getElementById("select_lang_list").value;
        // let uid_street = $("#uid_street").val() || "";

        // get_street_list(area_str_code, lang);
        list_place();
    }


    function change_area_list(area_code) {
        // Không lưu area vào cookie nữa

        /* lưu lại area_code vào biến area_str_code */
        $("#area_str_code").val(area_code);
        // Reset street selection khi thay đổi area
        $("#uid_street").val("");
        // Reset place selection khi thay đổi area
        $("#uid_place").val("");

        get_area_list(area_code);
        let lang = document.getElementById("select_lang_list").value;

        // Thêm dòng này để load street list khi area thay đổi
        get_street_list(area_code, lang);
    }
    /* end: function change_area_parent(area_code) */


    function get_street_list(area_code, lang) {
        var url_street = url_place;
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

        list_place();
    }

    function change_street_list(street_uid) {
        let lang = document.getElementById("select_lang_list").value;
        let area_code = document.getElementById('area_str_code').value;

        /* lưu lại street_uid vào biến uid_street */
        $("#uid_street").val(street_uid);
        // Reset place selection khi thay đổi street
        $("#uid_place").val("");

        get_place_in_list(area_code, lang, street_uid);
        list_place();


    }
    /* end: function change_street_list(street_uid) */

    function get_place_in_list(area_code, lang, street) {

        var url_place_in = url_place;
        var parent_code = "";
        if (!url_place_in.includes("?")) url_place_in += "?";
        url_place_in += "action=get_place&data_type=list";
        url_place_in += "&area=" + area_code + "&parent=" + parent_code + "&lang=" + lang + "&street=" + street;

        return get_page(url_place_in, null, show_place_in_list, "div_select_place_list");
    }

    function show_place_in_list(result) {
        $("#div_select_place_list").css("display", "block");
        $("#div_select_place_list").html(result);

        /*autocomplete street input*/
        $(".select_place_in_list").autocomplete();
        list_place();
    }

    function change_place_in_list(place_uid) {
        /* lưu lại place_uid vào biến uid_place */
        $("#uid_place").val(place_uid);

        list_place();
    }
    /* end: function change_place_in_list(place_uid) */

    function list_place() {

        loading("div_place_table");

        var str_search = document.getElementById('search').value;
        var area_str_code = document.getElementById('area_str_code').value;
        var uid_street = document.getElementById('uid_street').value;
        var lang = document.getElementById('select_lang_list').value;
        var uid_place = document.getElementById('uid_place').value;

        /* request place/all?action=list để lấy danh sách place */
        var url_list = url_place;
        if (!url_list.includes("?")) url_list += "?";
        url_list += "action=list";
        url_list += "&area=" + area_str_code + "&lang=" + lang + "&search=" + str_search + "&street=" + uid_street + "&place_in=" + uid_place;


        return get_page(url_list, null, show_place_list, "div_msg");


    }
    /* end: function list_place() */

    function show_place_list(result) {
        $("#div_place_table").html(result);
        console.log("check result: ", result);
        if (uid_place_selected != '') show_place_info(uid_place_selected);
    }



    function show_place_info(view_uid_place) {
        /* backup uid_place_selected */
        uid_place_selected = view_uid_place;

        /* gán uid place vào url */
        self.location.href = '#' + uid_place_selected;


        /* show place name & parent*/
        var str_place_name = "";
        if ($("#place_name_" + view_uid_place).length) str_place_name = $("#place_name_" + view_uid_place).html();
        if ($("#area_str_name_" + view_uid_place).length) str_place_name += " - " + $("#area_str_name_" + view_uid_place).html();

        document.getElementById('div_window_place_content_title').innerHTML = str_place_name;
        obj_window_place.show();

        /*show title & tab*/
        $("#div_place_tab").css("display", "block");
        $("#div_window_place_content_title").css("display", "block");

        /*hide place list */
        $("#div_place_form_input").css("display", "none");
        $("#div_place_list").hide();

        /* show tab info default */
        tab_place.click('info');

        $("html, body").animate({
            scrollTop: 0
        }, "fast");
        return;
    }


    function close_window_place() {
        self.location.href = '';
        $("#div_place_list").show();
    }
    /*end : function close_window_place() */


    function view_place_tab(tab_name) {
        if (tab_name == 'info') return view_detail_place();
        document.getElementById('tab_place_content').innerHTML = tab_name;
    }

    function show_detail_place(result) {
        document.getElementById('tab_place_content').innerHTML = result;
    }

    function show_activate_place(obj_result) {
        console.log(obj_result);

        $("#div_msg").css("display", "block");

        if (!obj_result) return $("#div_msg").html("Error");


        if (!obj_result.hasOwnProperty('result')) obj_result.result = "";
        if (!obj_result.hasOwnProperty('msg')) obj_result.msg = "";
        if (!obj_result.hasOwnProperty('last_uid')) obj_result.last_uid = "";

        console.log(obj_result.result);
        if (obj_result.result != "ok") return alert("Error: " + obj_result.msg);



        alert('Activate successfully');

        show_place_info(uid_place_selected);
    }

    function activate_place() {
        var url_activate_place = "<?php echo $this->get_link(array("controller" => "place", "function" => "all", "get" => "action=activate")) ?>";
        url_activate_place += "&place=" + uid_place_selected;

        return get_data(url_activate_place, null, show_activate_place, "window_place_msg");
    }

    function view_detail_place() {
        //loading('window_place_msg');
        var url_place_detail = "<?php echo $this->get_link(array("controller" => "place", "function" => "all", "get" => "action=info")) ?>";
        url_place_detail += "&place=" + uid_place_selected;
        console.log(url_place_detail);

        return get_page(url_place_detail, null, show_detail_place, "window_place_msg");

    }
    /*end : function view_detail_place(view_uid_place) */

    function change_lang() {

        let selected_lang = document.getElementById("select_lang_list").value;

        /*keep selected lang in cookie*/
        $("#uid_street").val("");

        get_area_list(area_str_code);
    }

    var area_str_code = '';
    var area_setting = '';
    var current_user = '';
    var parent_str_code = '';


    var obj_window_place;
    var uid_place_selected = '';
</script>