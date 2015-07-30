<?php  
//this controller is used to get the list of approved applications for the current user
session_start();//ensures that a session is et
include_once "../model/class/class.pending_applications.php";


$id=$_SESSION['emp_id'];//put the contents of the session in a variable called $id
$new = new application;//create a new object of type application
$a=$new->get_state_appli($id,3);//call the method that gets the list of approved applications

echo json_encode($a);//send the result back in json Format


?>
