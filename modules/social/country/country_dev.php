<?php
class country extends Controller
{
    function index()
    {
        // Kiểm tra có tham số POST data 
        if (isset($_POST["data"])) return $this->run("index/save");

        // Check action
        $action = isset($_GET['action']) ? $_GET['action'] : "";
        if ($action == "list" || $action == "info" || $action == "input" || $action == "delete") return $this->run("index/$action");

        echo $this->render("index/index");
    }

    function user()
    {
        // check action
        $action = isset($_GET['action']) ? $_GET['action'] : "";

        if ($action == "list" || $action == "info" || $action == "approve") return $this->run("user/$action");
        echo $this->render("user/user");
    }

    function all()
    {
        // Check action
        $action = isset($_GET['action']) ? $_GET['action'] : "";

        if ($action == "list" || $action == "info" || $action == "activate") return $this->run("all/$action");
        echo $this->render("all/all");
    }
}
