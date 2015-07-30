<?php  
//this gets the list of denied application for the current employee
session_start();
include_once "../model/class/class.pending_applications.php";


$id=$_SESSION['emp_id'];//puts the value of the session in a variable
$new = new application;//create an object of type application
$a=$new->get_state_appli($id,4);//call the method that gets the list of denied applications

echo json_encode($a);//return the result to populate the accordion for a particular employee


?>
