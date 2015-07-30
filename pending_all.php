<?php  
//this gets the list of all pending applications for all employees
session_start();
include_once "../model/class/class.pending_applications.php";


$id=$_SESSION['emp_id'];//put the contents of the session in a variabl
$new = new application;//create  a new object of type application
$a=$new->get_all_states($id,2);//call a method that returns the desired list

echo json_encode($a);//result is returned in json format


?>
