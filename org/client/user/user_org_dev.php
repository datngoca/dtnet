<?php
$Html = $this->load("Html");
$Table = $Html->load("Table");

echo $Html->heading("Danh sách org user");
echo $Html->div("", " id ='div_msg'");
echo $Html->div("", " id ='div_window_org_user'");

$Form = $Html->load("Form");
$search = '';
$input_search = $Form->textbox(array("name" => "search", "value" => $search, "id" => "input_search", "onkeyup" => "get_user_org()"));
$button_search = $Form->button(array("type" => "button", "onclick" => "get_user_org()"), "Search");
// $button_search = "<button type = 'submit'>Search</button>";

/**Tạo chuỗi form_content gồm có Tìm kiếm:, input_search, button_search, link_input  */
$form_content = "Tìm Kiếm" . $input_search . $button_search;

/*Gọi hàm get() của đối tượng form để lấy thẻ <form> </form> */
$form_search = $Form->get(array("method" => "GET"), $form_content);
/**$form_search = "<form method = 'GET' action = '/task/index' > </form>"; */

echo $form_search;
echo $Html->div("", " id ='div_list_user_org'");
echo $Html->js($this->template_url . "js/form/window");
?>
<script>
    function get_user_org() {
        /*Lấy giá trị input_search  */
        var search = document.getElementById('input_search').value;

        /*lấy urrl_list_org*/
        var url_list_org = "<?php echo $this->get_link(array("controller" => "org", "function" => "user", "get" => "action=list")) ?>";
        url_list_org += "&search=" + search;

        /*console.log(url_list_org);*/

        /**request đến đường link url_list_orgđể lấy dữ liệu*/
        return get_page(url_list_org, null, show_org, "div_list_user_org");

    }

    function show_org(html_result) {
        /**Đưa dữ liệu html vào thẻ div_org_list */
        document.getElementById('div_list_user_org').style.display = "block";
        document.getElementById('div_list_user_org').innerHTML = html_result;
    }

    function get_org_user_info(result) {

        document.getElementById("button_save").disabled = false;

        /**Show window org */
        obj_window_org.close();

        /**Hiển thị danh sách ngôn ngữ */
        document.getElementById('div_list_user_org').style.display = "block";
        get_user_org();
    }

    function close_window_org() {
        /**Hiển thị danh sách ngôn ngữ */
        document.getElementById('div_list_user_org').style.display = "block";

    }

    function show_org_info(html_result) {
        /**Hiển thị div_country_input */
        document.getElementById('div_org_user_form_input').style.display = "block";

        /**Đưa dữ liệu html vào thẻ div_country_input */
        document.getElementById('div_org_user_form_input').innerHTML = html_result;

        /**Ẩn div_country_list */
        document.getElementById('div_list_user_org').style.display = "none";
    }

    function show_approve_org(html_result) {
        alert(html_result);
    }

    function approve_org(uid_org) {
        /**Taọ link approve_org  */
        var url_approve_org = "<?php echo $this->get_link(array("controller" => "org", "function" => "user", "get" => "action=approve")) ?>";
        url_approve_org += "&org=" + uid_org;

        console.log(url_approve_org);
        /**Request đến link approve_org  */
        return get_page(url_approve_org, null, show_approve_org, "div_msg");
    }

    function view_org_user(uid_org) {
        /**Show window org */
        obj_window_org.show();
        var url_info = "<?php echo $this->get_link(array("controller" => "org", "function" => "user", "get" => "action=view")) ?>";
        url_info += "&org=" + uid_org;
        console.log(url_info);
        return get_page(url_info, null, show_org_info, "div_org_user_form_input");
    }

    /**Hàm được gọi sau khi client tải hết javascript  */
    var obj_window_org;
    $(document).ready(function() {
        /*tạo đối tượng window org*/
        obj_window_org = new Window({
            "target": "div_window_org_user",
            "close": close_window_org,
            "title": "org User Information"
        });

        /*window_area_content*/
        window_org_content = "<div id = 'div_org_user_form_input'>.......</div>";
        obj_window_org.set(window_org_content);


        /**Gọi hàm get_user_org() để lấy danh sách ngôn ngữ */
        get_user_org();
    });
</script>