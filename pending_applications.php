<?php
session_start();
include_once "../model/class/class.pending_applications.php";
/*this controller is used to return the list of pending 
applications for a particular employee. The result is passed 
to the view to populate the accordion with the returned information*/

$id=$_SESSION['emp_id'];
$new = new application;
$a=$new->get_state_appli($id,2);

echo json_encode($a);


?>
