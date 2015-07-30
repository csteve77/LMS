<?php
session_start();
/*this controller is used to determine what leave types are assigned to a particular employee
How many days he is entitled for for each leave type
and teh remaining balance for each leave type for that employee*/

include_once "../model/class/class.leave_type.php";
$id=$_SESSION['emp_id'];
$new = new leave_type;
$a=$new->get_leave_info($id);
echo json_encode($a);





