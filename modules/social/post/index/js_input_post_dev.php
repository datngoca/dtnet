<script>
    // URL constants
    var url_post = "<?php echo $this->get_link(array("controller" => "post", "function" => "index")) ?>";

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
        var url_area_input = url_post + "?action=get_area&data_type=input";
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
        var url_street_input = url_post + "?action=get_street&data_type=input";
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
        console.log("Place in changed to: ", selected_place_in);

    }

    function get_place_input() {
        var uid_street_input = $(".select_street_input").val() || "";
        var lang = $("#select_lang_input").val() || "";
        var uid_place_in = $(".select_place_in_input").val() || "";

        console.log("Getting place input - street:", uid_street_input, "area:", str_code_parent_selected);

        /*get input place_in theo cấu trúc area*/
        var url_input = url_post + "?action=get_place&data_type=input";
        url_input += "&lang=" + lang + "&area=" + str_code_parent_selected;
        url_input += "&street=" + uid_street_input + "&place=" + uid_place_in;

        console.log("get_place_input URL:", url_input);

        return get_page(url_input, null, show_input_place_in, "div_input_place_in");
    }


    function show_save_post(obj) {
        document.getElementById("button_save").disabled = false;
        if (!obj) return alert("error");

        const result = obj?.result;
        const msg = obj?.msg;
        const data = obj?.data;

        // Nếu có object Word để dịch thông báo
        const str_msg = typeof Word !== 'undefined' && Word[msg] ? Word[msg] : msg;

        if (result !== "ok") return alert("Error: " + str_msg);
        alert(str_msg);

        const uid_post = data?.post;
        show_post_info(uid_post);
        // Có thể gọi list_post() nếu muốn reload danh sách
    }

    function save_post() {
        document.getElementById("button_save").disabled = true;
        // if (document.getElementById('post_title').value == "") {
        //     document.getElementById('lbl_title').innerHTML = "Please input post title";
        //     document.getElementById('post_title').focus();
        //     document.getElementById("button_save").disabled = false;
        //     return;
        // }
        const formData = $('#form_post').serialize();
        var url_save = url_post + "?action=save";
        return request_data(url_save, formData, show_save_post, "div_msg");
    }
    /*end : function save_post() */
</script>