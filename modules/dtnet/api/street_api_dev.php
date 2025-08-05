<?php
/*check my data*/
if ($action == "list_my") return $this->run("street/list_my_street", array("array_param" => $params));
if ($action == "save_my") return $this->run("street/save_my_street", array("array_param" => $params));
if ($action == "info_my") return $this->run("street/info_my_street", array("array_param" => $params));
if ($action == "delete_my") return $this->run("street/delete_my_street", array("array_param" => $params));

if ($action == "save_cross") return $this->run("street/save_cross_street", array("array_param" => $params));
if ($action == "list_cross") return $this->run("street/list_cross_street", array("array_param" => $params));
if ($action == "delete_cross") return $this->run("street/delete_cross_street", array("array_param" => $params));


/*check user data*/
if ($action == "list_user") return $this->run("street/list_user_street", array("array_param" => $params));
if ($action == "info_user") return $this->run("street/info_user_street", array("array_param" => $params));
if ($action == "approve_user") return $this->run("street/approve_user_street", array("array_param" => $params));

/*check user data*/
if ($action == "list") return $this->run("street/list_street", array("array_param" => $params));
if ($action == "info") return $this->run("street/info_street", array("array_param" => $params));
if ($action == "activate") return $this->run("street/activate_street", array("array_param" => $params));
if ($action == "all") return $this->run("street/all_street", array("array_param" => $params));

if ($action == "get_parent") return $this->run("street/get_parent_street", array("array_params" => $params));
