<?php
//this controller is used to cancel a pending or approved application
include_once "../model/class/class.pending_applications.php";

$applicationId=$_POST['Appli_id'];//assign the aplication id to a variable
$del = new application;//a new object is created
$del->cancel_app($applicationId);//the method to cancel the application is called. 
//The application_id is passed as a parameter

