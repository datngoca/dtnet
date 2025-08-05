<?php
/*check my data*/
if ($action == "list_my") return $this->run("area/list_my_area", array("array_param" => $params));
if ($action == "save_my") return $this->run("area/save_my_area", array("array_param" => $params));
if ($action == "info_my") return $this->run("area/info_my_area", array("array_param" => $params));
if ($action == "delete_my") return $this->run("area/delete_my_area", array("array_param" => $params));

/*check user data*/
if ($action == "list_user") return $this->run("area/list_user_area", array("array_param" => $params));
if ($action == "info_user") return $this->run("area/info_user_area", array("array_param" => $params));
if ($action == "approve_user") return $this->run("area/approve_user_area", array("array_param" => $params));

/*check user data*/
if ($action == "list_all") return $this->run("area/list_all_area", array("array_param" => $params));
if ($action == "info_all") return $this->run("area/info_all_area", array("array_param" => $params));
if ($action == "activate_all") return $this->run("area/activate_all_area", array("array_param" => $params));

/*check input*/
if ($action == "input")    return $this->run("area/input_area");
if ($action == "get_parent") return $this->run("area/get_parent_area", array("array_params" => $params));


// if ($action == "approve") return $this->run("area/approve_area", array("array_area" => $params));

if ($action == "info")    return $this->run("area/info_area", array("array_area" => $params));
if ($action == "save")    return $this->run("area/save_area", array("array_area" => $params));
// if ($action == "approve_user") return $this->run("area/approve_user_area", array("array_area" => $params));


/*area setting*/
if ($action == "save_setting")    return $this->run("area/save_setting_area", array("array_area_setting" => $params));
if ($action == "info_setting")    return $this->run("area/info_setting_area", array("uid_area_setting" => $params));
if ($action == "list_setting")    return $this->run("area/list_setting_area", array("uid_user" => $params));



/*lấy tham số khu vực*/
$param_area = "";
$search = "";

if (isset($_REQUEST["area"])) $param_area = $_REQUEST["area"];
if (isset($_REQUEST["search"])) $search = $_REQUEST["search"];
if (isset($params["area"])) $param_area = $params["area"];
if (isset($params["area"])) $param_area = $params["area"];


$param_area = trim($param_area, "/");



$return = "";
if (isset($_REQUEST["return"])) $return =  $_REQUEST["return"];

if ($return != "file") {
    $this->loadModel("Area");
    if ($param_area != "") $this->Area->cond("parent_str_code", $param_area);
    if ($search != "") $this->Area->search("name", $search);

    $array_area = $this->Area->get();
} else {
    $this->loadLib("LibArea");
    $array_area = $this->LibArea->get_list($param_area);
}

if (isset($_REQUEST["debug"]) && ($_REQUEST["debug"] == "list")) {
    echo "<br>request api, param_area: $param_area, search: $search, return: $return<br>";
    print_r($_REQUEST);
}

if (isset($_REQUEST["debug"]) && ($_REQUEST["debug"] == "list")) {
    echo "<br>data return api:<br>";
    print_r($array_area);
}

echo json_encode($array_area);
