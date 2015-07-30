<?php  
//this controller is used to get the list of all approved applications
//whose end_date is greater than today which means that they are not expired
session_start();//ensure that a session is set
include_once "../model/class/class.pending_applications.php";


$id=$_SESSION['emp_id'];//set the value of the session to a variable called $id
$new = new application;//create an object of type application
$a=$new->get_all_states($id,3);//call the method and pass the admin id and the state which is 3. 3=approved

echo json_encode($a);


?>
