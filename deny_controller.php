<?php
include_once "../model/class/class.pending_applications.php";
//this controller is used to call the method that allows an admin to deny an application
	
$applicationId=$_POST['Appli_id'];
$approver_id=$_POST['Approver_id'];
$deny = new application;
$deny->deny_app($applicationId,$approver_id);//calls the method by passing the appropriate parameters
