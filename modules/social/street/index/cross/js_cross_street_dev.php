<script>
    var url_street = "<?php echo $this->get_link(array("controller" => "street", "function" => "index")) ?>";

    function show_list_area_street_cross(result) {
        $("#div_list_cross").html(result);
    }

    function get_list_area_street_cross() {
        $("#div_list_cross").html('loading');

        var url_list = url_street;
        if (!url_list.includes("?")) url_list += "?";
        url_list += "action=list_cross";
        url_list += "&street=" + uid_street_user_selected;
        return get_page(url_list, null, show_list_area_street_cross, "div_msg");
    }
    /*end: functionget_list_area_street_crosslist_area_street_cross() */

    function show_area_input_street_cross(result) {
        /* đưa selectbox vào div_select_area_cross */
        $("#div_select_area_cross").css("display", "block");
        $("#div_select_area_cross").html(result);
        console.log("aaa", result)

        /*autocomplete các input*/
        $(".select_area_cross").autocomplete();

        /* cập nhập str_area_code vào trường hidden */
        document.getElementById('str_cross').value = area_str_code_cross;
    }

    function get_selectbox_area_street_cross() {
        var url_area = url_street;
        if (!url_area.includes("?")) url_area += "?";
        url_area += "action=get_area&source=cross";
        url_area += "&lang=" + street_lang + "&area=" + area_str_code_cross;
        url_area += "&parent=" + street_area_str_code;
        console.log("Loading area selectbox:", url_area);
        return get_page(url_area, null, show_area_input_street_cross, "div_select_area_cross");
    }
    /* end:  function get_area_input_street_cross()  */

    function change_area_cross(area_code) {
        /* lưu khu vực đang chọn vào biến area_str_code_street_cross */
        area_str_code_cross = area_code;
        get_selectbox_area_street_cross();
    }
    /* end: function change_area_parent(area_code) */

    function show_save_cross(obj_result) {

        document.getElementById("button_save").disabled = false;

        if (!obj_result) return alert("Error");

        if (!obj_result.hasOwnProperty('result')) obj_result.result = "";
        if (!obj_result.hasOwnProperty('msg')) obj_result.msg = "";

        if (obj_result.result != "ok") alert("error: " + obj_result.msg);

        return get_list_area_street_cross();

    }

    function save_cross() {
        /* khóa nút bấm, không lưu liên tục */
        document.getElementById("button_save").disabled = true;

        /*data*/
        const formData = new FormData(document.getElementById('form_cross'));

        var url_save = url_street;
        if (!url_save.includes("?")) url_save += "?";
        url_save += "action=save_cross";

        return get_data(url_save, formData, show_save_cross, "div_msg");
    }
    /*end : function save_cross() */


    function delete_cross(num) {
        var url_delete = url_street;
        if (!url_delete.includes("?")) url_delete += "?";
        url_delete += "action=delete_cross";
        url_delete += "&street=" + uid_street_user_selected + "&num=" + num;

        console.log(url_delete);
        return get_page(url_delete, null, get_list_area_street_cross, "div_msg");
    }
    /*end : function save_cross() */
</script>
<script>
    /* hàm được gọi để hiện thị các khu vực mà đường phố băng qua */

    var area_str_code_cross = '';
    //if (area_str_code_cross =='') area_str_code_cross = area_of_street_selected;

    function show_area_street_cross() {
        get_selectbox_area_street_cross();
    }

    function show_edit_cross(code_area, num_cross) {
        $("#div_select_area_cross").html('loading...');

        area_str_code_cross = code_area;
        show_area_street_cross();

        document.getElementById('edit').value = num_cross;

        /* mở khóa nút bấm, không lưu liên tục */
        document.getElementById("button_save").disabled = false;
    }

    function reset_form_cross() {
        area_str_code_cross = '';
        document.getElementById('edit').value = '';
        document.getElementById('str_cross').value = '';
        $("#div_select_area_cross").html('');
        document.getElementById("button_save").disabled = true;
    }
</script>
<!-- <script>
    var area_str_code_cross = '';

    function show_edit_cross(code_area) {
        console.log("Editing area:", code_area);

        $("#div_select_area_cross").html('loading...');

        // Gán area code cần edit vào biến global
        area_str_code_cross = code_area;

        // Load selectbox với area đã chọn
        get_selectbox_area_street_cross();

        // Set giá trị edit vào hidden field
        document.getElementById('edit').value = code_area;
        document.getElementById('str_cross').value = code_area;

        // Mở khóa nút Save
        document.getElementById("button_save").disabled = false;

        // Scroll to form để user dễ thấy
        $('html, body').animate({
            scrollTop: $("#form_cross").offset().top
        }, 500);
    }
</script> -->