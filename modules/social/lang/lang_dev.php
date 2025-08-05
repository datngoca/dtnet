<?php
class lang extends Controller
{
    function index()
    {
        //Kiểm tra có tham số POST data
        if (isset($_POST["data"])) return $this->run("index/save");

        // Check action
        $action = isset($_GET['action']) ? $_GET['action'] : "";

        if ($action === "list") return $this->run("index/list");
        if ($action === "input") return $this->run("index/input");
        if ($action === "info") return $this->run("index/info");
        if ($action === "delete") return $this->run("index/delete");
        if ($action === "check") return $this->run("index/check");

        echo $this->render("index/index");
    }

    function user()
    {
        $action = isset($_GET["action"]) ? $_GET["action"] : "";

        if ($action === "list") return $this->run("user/list");
        if ($action === "info") return $this->run("user/info");
        if ($action === "approve") return $this->run("user/approve");
        echo $this->render("user/user");
    }
    function all()
    {
        $action = isset($_GET["action"]) ? $_GET["action"] : "";

        if ($action === "list") return $this->run("all/list");
        if ($action === "info") return $this->run("all/info");
        if ($action === "activate") return $this->run("all/activate");

        echo $this->render("all/all");
    }
}
