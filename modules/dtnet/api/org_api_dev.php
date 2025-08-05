<?php
/*check my data*/
if ($action == "list_my") return $this->run("org/list_my_org", array("array_param" => $params));
if ($action == "save_my") return $this->run("org/save_my_org", array("array_param" => $params));
if ($action == "info_my") return $this->run("org/info_my_org", array("array_param" => $params));
if ($action == "delete_my") return $this->run("org/delete_my_org", array("array_param" => $params));

/*check user data*/
if ($action == "list_user") return $this->run("org/list_user_org", array("array_param" => $params));
if ($action == "info_user") return $this->run("org/info_user_org", array("array_param" => $params));
if ($action == "approve_user") return $this->run("org/approve_user_org", array("array_param" => $params));

/*check user data*/
if ($action == "all") return $this->run("org/all_org", array("array_param" => $params));
if ($action == "list") return $this->run("org/list_org", array("array_param" => $params));
if ($action == "info") return $this->run("org/info_org", array("array_param" => $params));
if ($action == "activate") return $this->run("org/activate_org", array("array_param" => $params));
