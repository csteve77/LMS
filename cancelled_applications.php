<?php  
//this controller gets the list of all cancelled applications for a particular individual
session_start();
include_once "../model/class/class.pending_applications.php";


$id=$_SESSION['emp_id'];//put the value of the session array into a avriable
$new = new application;//create a new object of type application
$a=$new->get_state_appli($id,5);//call it's method by passing parameters for 
//filtering by employeeIid and state=cancelled(5)

echo json_encode($a);//return the result in json format


?>
