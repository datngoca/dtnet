<?php
class street extends Controller
{
    function index()
    {
        /*get action*/
        $action  = "";
        if (isset($_GET['action'])) $action = $_GET['action'];
        if ($action == "list" || $action == "info" || $action == "input") return $this->run("index/$action");

        if ($action == "cross" || $action == "list_cross" ||  $action == "delete_cross") return $this->run("index/cross/$action");

        /*parent area*/
        if ($action == "get_area") return $this->run('index/get_area');

        /*save*/
        if (isset($_POST['data'])) return $this->run('index/save');

        if (isset($_POST['data2'])) return $this->run('index/cross/save_cross');

        /*index page*/
        echo $this->render('index/index');
    }
    /* end :    function index()*/

    function user()
    {
        /*get action*/
        $action  = "";
        if (isset($_GET['action'])) $action = $_GET['action'];
        if ($action == "list" || $action == "info" || $action == "approve" || $action == "cross" || $action == "list_cross") return $this->run("user/$action");

        /*parent area*/
        if ($action == "get_area") return $this->run('index/get_area');


        /*index page*/
        echo $this->render('user/user');
    }
    /* end :    function index()*/

    function all()
    {
        /*get action*/
        $action  = "";
        if (isset($_GET['action'])) $action = $_GET['action'];
        if ($action == "list" || $action == "info" || $action == "activate" || $action == "cross" || $action == "list_cross") return $this->run("all/$action");

        /*parent area*/
        if ($action == "get_area") return $this->run('index/get_area');

        /*index page*/
        echo $this->render('all/all');
    }
    /* END: function all() */
}
/* END:  class street extends Controller */
