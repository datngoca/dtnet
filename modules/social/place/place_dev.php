<?php
class place extends Controller
{
    function index()
    {
        /*get action*/
        $action  = "";
        if (isset($_GET['action'])) $action = $_GET['action'];
        if ($action == "list" || $action == "info" || $action == "input") return $this->run("index/$action");

        /*area, street*/
        if ($action == "get_area" || $action == "get_street") return $this->run("index/$action");

        if ($action == "get_place") return $this->run("index/get");

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
        if ($action == "list" || $action == "info" || $action == "approve") return $this->run("user/$action");

        /*area, street*/
        if ($action == "get_area" || $action == "get_street") return $this->run("index/$action");

        if ($action == "get_place") return $this->run("index/get");

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
        if ($action == "list" || $action == "info" || $action == "activate") return $this->run("all/$action");

        /*area, street*/
        if ($action == "get_area" || $action == "get_street") return $this->run("index/$action");

        if ($action == "get_place") return $this->run("index/get");

        /*index page*/
        echo $this->render('all/all');
    }
    /* END: function all */
}
/* END:  class street extends Controller */
