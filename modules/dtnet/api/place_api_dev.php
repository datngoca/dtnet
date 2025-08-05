<?php
/*check my data*/
if ($action == "list_my") return $this->run("place/list_my_place", array("array_param" => $params));
if ($action == "save_my") return $this->run("place/save_my_place", array("array_param" => $params));
if ($action == "info_my") return $this->run("place/info_my_place", array("array_param" => $params));
if ($action == "delete_my") return $this->run("place/delete_my_place", array("array_param" => $params));

/*check user data*/
if ($action == "list_user") return $this->run("place/list_user_place", array("array_param" => $params));
if ($action == "info_user") return $this->run("place/info_user_place", array("array_param" => $params));
if ($action == "approve_user") return $this->run("place/approve_user_place", array("array_param" => $params));

/*check user data*/
if ($action == "all") return $this->run("place/all_place", array("array_param" => $params));
if ($action == "list") return $this->run("place/list_place", array("array_param" => $params));
if ($action == "info") return $this->run("place/info_place", array("array_param" => $params));
if ($action == "activate") return $this->run("place/activate_place", array("array_param" => $params));
