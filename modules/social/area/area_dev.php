<?php
class area extends Controller
{
    function index()
    {
        /*get action*/
        $action  = "";
        if (isset($_GET['action'])) $action = $_GET['action'];
        if ($action == "list" || $action == "info" || $action == "input" || $action == "delete") return $this->run("index/$action");

        /*parent area*/
        if ($action == "get_parent") return $this->run('index/parent');

        /*save*/
        if (isset($_POST['data'])) return $this->run('index/save');

        /*index page*/
        echo $this->render('index/index');
    }
    /* end :    function index()*/

    function user()
    {

        /*get action*/
        $action  = "";
        if (isset($_GET['action'])) $action = $_GET['action'];

        if ($action == "list" || $action == "info" || $action == "approve") return $this->run("user/$action" . "_user");

        if ($action == "get_parent") return $this->run('index/parent');

        /*index page*/
        echo $this->render('user/user');
    }
    // function all()
    // {
    //     /*get action*/
    //     $action  =  isset($_GET['action']) ?  $_GET['action'] : '';
    //     $array_action = ['list', 'get_parent', 'view', 'approve', 'active'];

    //     if (in_array($action, $array_action)) return $this->run("all/$action");
    //     echo $this->render('all/all');
    // }
    // /* end :    function all()*/
    function all()
    {
        /*get action*/
        $action  =  isset($_GET['action']) ?  $_GET['action'] : '';
        $array_action = ['list', 'info', 'activate'];

        if ($action == "get_parent") return $this->run('index/parent');

        if (in_array($action, $array_action)) return $this->run("all/$action" . "_all");
        echo $this->render('all/all');
    }
    /* end :    function all()*/



    function setting($param1 = "")
    {
        if (isset($_GET['action']) && $_GET['action'] == 'list_user') return $this->run('setting/list_user');
        if (isset($_POST['data'])) return $this->run('setting/save_setting');
        echo $this->render('setting/setting');
    }
    /* end : function setting()*/

    function post_cat($param1 = "")
    {
        if ($param1 == 'all') {
            if (isset($_GET['action']) && $_GET['action'] == 'list') return $this->run('post_cat/list_post_cat', array('source' => 'all'));

            if (isset($_GET['action']) && $_GET['action'] == 'info') return ($this->run('post_cat/info_post_cat', array('source' => 'all')));
            if (isset($_GET['action']) && $_GET['action'] == 'approve') return $this->run('post_cat/approve_post_cat');
            echo $this->render('post_cat/all_post_cat');
            return;
        }

        if ($param1 == 'my') {
            if (isset($_GET['action']) && $_GET['action'] == 'list') return $this->run('post_cat/list_post_cat', array('source' => 'my'));

            if (isset($_GET['action']) && $_GET['action'] == 'info') return ($this->run('post_cat/info_post_cat', array('source' => 'my')));

            echo $this->render('post_cat/my_post_cat');
            return;
        }

        if ($param1 == 'input') {
            if (isset($_POST['data'])) return $this->run('post_cat/save_post_cat');
            if (isset($_GET['action']) && $_GET['action'] == 'get_form') return $this->run('post_cat/input_post_cat');
        }
    }
    /* end : function post_cat()*/
}
/* end: class user_area extends Controller */
