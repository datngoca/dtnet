<script>
    // URL constants
    var url_place = "<?php echo $this->get_link(array("controller" => "place", "function" => "index")) ?>";

    var request = '';
    var str_code_parent_selected = '';

    function change_area_input(str_code) {

        $("#area_str_code_input").val(str_code);

        // Lấy dữ liệu area tiếp theo
        get_area_input(str_code);
    }

    function change_lang_input() {
        get_area_input(str_code_parent_selected);
    }

    function show_area_input(result) {
        /* đưa selectbox vào div_area_parent_input */
        $("#span_list_select_area_input").css("display", "block");
        $("#span_list_select_area_input").html(result);

        /*autocomplete các input theo cấu trúc area*/
        $(".select_area_input").autocomplete();

        /*get street input sau khi area load xong*/
        let lang = $("#select_lang_input").val() || "";
        let uid_street = $("#hidden_street").val() || "";

        get_street_input(str_code_parent_selected, uid_street, lang);
    }

    function get_area_input(str_area_code) {
        /*lưu lại str_code_parent_selected */
        str_code_parent_selected = str_area_code;
        let lang = $("#select_lang_input").val() || "";

        /*lấy select parent_area_code theo cấu trúc area*/
        var url_area_input = url_place + "?action=get_area&data_type=input";
        url_area_input += "&area=" + str_area_code + "&parent=&lang=" + lang;

        return get_page(url_area_input, null, show_area_input, "span_list_select_area_input");
    }

    function show_street_input(result) {
        /*show div_street_input*/
        $("#div_street_input").css("display", "block");
        $("#div_street_input").html(result);

        // Set giá trị từ hidden field
        var hidden_street_value = $("#hidden_street").val();

        /*autocomplete street input theo cấu trúc area*/
        $(".select_street_input").autocomplete();

        /*get place input sau khi street load xong*/
        get_place_input();
    }

    function get_street_input(area_code, uid_street, lang) {
        /*get street input*/
        var url_street_input = url_place + "?action=get_street&data_type=input";
        url_street_input += "&area=" + area_code + "&street=" + uid_street + "&lang=" + lang;

        console.log("get_street_input URL: ", url_street_input);
        return get_page(url_street_input, null, show_street_input, "div_street_input");
    }

    function change_street_input() {
        // Lưu giá trị street vào cookie
        var street_value = $("#select_street_input").val();
        setCookie("street_index", street_value);

        get_place_input();
    }

    function show_input_place_in(result) {
        /*show div_input_place_in*/
        $("#div_input_place_in").css("display", "block");
        $("#div_input_place_in").html(result);

        /*autocomplete place input theo cấu trúc area*/
        $(".select_place_in_input").autocomplete();
    }

    function change_place_in_input() {
        // Cập nhật giá trị place_in được chọn
        var selected_place_in = $(".select_place_in_input").val();

        $("#hidden_place_in").val(selected_place_in);
        $("#hidden_place_in_data").val(selected_place_in);

    }

    function get_place_input() {
        var uid_street_input = $(".select_street_input").val() || "";
        var lang = $("#select_lang_input").val() || "";
        var uid_place_in = $(".select_place_in_input").val() || "";

        /*get input place_in theo cấu trúc area*/
        var url_input = url_place + "?action=get_place&data_type=input";
        url_input += "&lang=" + lang + "&area=" + str_code_parent_selected;
        url_input += "&street=" + uid_street_input + "&place=" + uid_place_in;

        return get_page(url_input, null, show_input_place_in, "div_input_place_in");
    }


    function save_place_info(obj_result) {
        console.log(obj_result);
        $("#div_msg").css("display", "block");

        document.getElementById("button_save").disabled = false;

        if (!obj_result) return $("#div_msg").html("Error");

        if (!obj_result.hasOwnProperty('result')) obj_result.result = "";
        if (!obj_result.hasOwnProperty('msg')) obj_result.msg = "";
        if (!obj_result.hasOwnProperty('place')) obj_result.place = "";

        if (obj_result.result != "ok") return alert("Error: " + obj_result.msg);

        alert('Save successfully');
        show_place_info(obj_result.place);
    }

    function save_place() {
        /* khóa nút bấm, không lưu liên tục */
        document.getElementById("button_save").disabled = true;
        document.getElementById('lbl_name').innerHTML = "";

        /*kiểm tra input name có dữ liệu không? */
        if ($("#place_name").val() == "") {
            document.getElementById('lbl_name').innerHTML = "Xin vui lòng nhập tên địa điểm";
            $("#place_name").focus();
            document.getElementById("button_save").disabled = false;
            return;
        }

        /*data*/
        const formData = $('#form_place').serialize();

        var url_save = url_place + "?action=save";

        return request_data(url_save, formData, save_place_info, "div_msg");
    }
    /*end : function save_place() */
</script>