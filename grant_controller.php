<?php
include_once "../model/class/class.pending_applications.php";
//this controller is used to allow an admin to approve an application

$applicationId=$_POST['Appli_id'];//the parameters are passed to the controller via the $_POST method
$approver_id=$_POST['Approver_id'];
$grant = new application;
$grant->approve_app($applicationId,$approver_id);//the method is called using the appropriate parameters
//of the application to be approved
