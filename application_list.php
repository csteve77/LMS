<?php
//this controller is used to get all applications to populate a drop-down for the query builder
include_once "../model/class/class.pending_applications.php";
$new = new application;//it creates a new object application
$a=$new->appli();//and this method to retrieve the whole list of applications
echo json_encode($a);//the result is sent back in json format
