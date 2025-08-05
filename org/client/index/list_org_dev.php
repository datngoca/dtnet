<?php

/*get param*/
$area = "";
$street = "";
$place = "";

$search = "";
$type = "";
$business_activity = "";

$page = "";
$token_list = "";
$num_row = "";

if (isset($_GET['area'])) $area = $_GET['area'];
if (isset($_GET['street'])) $street = $_GET['street'];
if (isset($_GET['place'])) $place = $_GET['place'];

if (isset($_GET['search'])) $search = $_GET['search'];
if (isset($_GET['type'])) $type = $_GET['type'];
if (isset($_GET['business'])) $business_activity = $_GET['business'];

if (isset($_GET['page'])) $page = $_GET['page'];
if (isset($_GET['token_list'])) $token_list = $_GET['token_list'];
if (isset($_GET['num_row'])) $num_row = $_GET['num_row'];

if (!is_numeric($page) || ($page < 1))    $page = 1;
if (!is_numeric($num_row) || ($num_row < 1))    $num_row = 5;

/*array_params data request*/
$array_params = null;
$array_params['area'] = $area;
$array_params['street'] = $street;
$array_params['place'] = $place;

$array_params['search'] = $search;
$array_params['type'] = $type;
$array_params['business'] = $business_activity;

$array_params['page'] = $page;
$array_params['token_list'] = $token_list;
$array_params['limit'] = $num_row;

/*request api*/
exit($this->request_api('org', "list", $array_params, false));
