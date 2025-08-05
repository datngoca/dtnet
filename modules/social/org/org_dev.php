<?php
class org extends Controller
{
    // function index($param_org = "")
    // {
    //     /**Lấy giá trị tham số action*/
    //     $action = "";
    //     if (isset($_GET["action"])) $action = $_GET["action"];
    //     if ($action == "") if (isset($_POST["action"])) $action = $_POST["action"];

    //     if ($action == "save") return $this->run("index/save");
    //     if ($action == "list") return $this->run("index/list");
    //     if ($action == "my") return $this->run("index/my");
    //     if ($action == "view") return $this->run("index/info");
    //     if ($action == "get_area") return $this->run("index/get_area");
    //     if ($action == "get_street") return $this->run("index/get_street");
    //     if ($action == "get_place") return $this->run("index/get_place");
    //     if ($action == "input" || $action == "edit") exit($this->run("index/input"));

    //     if ($param_org == "") if (isset($_GET["org"])) $param_org = $_GET["org"];
    //     if ($param_org != "") {
    //         if ($action == "info") exit($this->run('view/info'));
    //         if ($action == "layout") exit($this->run("view/index", array("uid_org" => $param_org)));
    //         exit($this->render('view/index', array("uid_org" => $param_org)));

    //         return;
    //     }


    //     /*Kiểm tra có tham số data thì thực thi file sub controller index/save_country */
    //     echo $this->render("index/index");
    // }
    function index()
    {
        $action = isset($_GET["action"]) ?  $_GET["action"] : "";

        if ($action == "list" || $action == "info" || $action == "input") return $this->run("index/$action");

        /*area, street*/
        if ($action == "get_area" || $action == "get_street" || $action == "get_place") return $this->run("index/$action");

        if (isset($_POST['data'])) return $this->run('index/save');

        echo $this->render("index/index");
    }

    function user()
    {
        $action = isset($_GET["action"]) ?  $_GET["action"] : "";

        if ($action == "list" || $action == "info" || $action == "approve") return $this->run("user/$action");

        /*area, street*/
        if ($action == "get_area" || $action == "get_street" || $action == "get_place") return $this->run("index/$action");


        echo $this->render("user/user");
    }
    /*End: function user()*/
    function all()
    {
        $action = isset($_GET["action"]) ?  $_GET["action"] : "";

        if ($action == "list" || $action == "info" || $action == "activate") return $this->run("all/$action");

        /*area, street*/
        if ($action == "get_area" || $action == "get_street" || $action == "get_place") return $this->run("index/$action");


        echo $this->render("all/all");
    }
    /*End: function user()*/
    // function all()
    // {
    //     if (isset($_GET['action']) && $_GET['action'] == 'list') return $this->run('all/list_all');
    //     if (isset($_GET['action']) && $_GET['action'] == 'active') return $this->run('all/active');
    //     if (isset($_GET['action']) && $_GET['action'] == 'view') return $this->run('all/info');
    //     echo $this->render("all/all");
    // }
    // /*End: function all()*/
    // function view($param = '', $param2 = '')
    // {
    //     if (isset($_GET['action']) && $_GET['action'] == 'info') return $this->run('view/info');
    //     if (isset($_REQUEST['layout']) && $_REQUEST['layout'] == "false") return $this->run("view/index", array("uid_org" => $param2));
    //     echo $this->render('view/index', array("uid_org" => $param2));
    // }
}
/*End: class config extends Main */
