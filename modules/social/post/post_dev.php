<?php
class post extends Controller
{
    function index()
    {
        /*get action*/
        $action  = "";
        if (isset($_GET['action'])) $action = $_GET['action'];
        if ($action == "list" || $action == "info" || $action == "input") return $this->run("index/$action");

        /*get data for selects*/
        if ($action == "get_area" || $action == "get_street" || $action == "get_place" || $action == "get_org") return $this->run("index/$action");

        /*save*/
        if (isset($_POST['data'])) return $this->run('index/save');

        /*index page*/
        echo $this->render('index/index');
    }
    /* end: function index()*/

    function user()
    {
        /*get action*/
        $action  = "";
        if (isset($_GET['action'])) $action = $_GET['action'];
        if ($action == "list" || $action == "info" || $action == "approve") return $this->run("user/$action");

        /*get data for selects*/
        if ($action == "get_area" || $action == "get_street" || $action == "get_place" || $action == "get_org") return $this->run("index/$action");

        /*index page*/
        echo $this->render('user/user');
    }
    /* end: function user()*/

    function all()
    {
        /*get action*/
        $action  = "";
        if (isset($_GET['action'])) $action = $_GET['action'];
        if ($action == "list" || $action == "info" || $action == "activate") return $this->run("all/$action");

        /*get data for selects*/
        if ($action == "get_area" || $action == "get_street" || $action == "get_place" || $action == "get_org") return $this->run("index/$action");

        /*index page*/
        echo $this->render('all/all');
    }
    /* end: function all()*/
}
