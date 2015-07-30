<?php

/*this controller is used to populate a drop down list with leave types
the list was not hardcoded because it might require updating
getting the values from the database means that if a value needs to be added,
the code need not be touched*/
include_once "../model/class/class.leave_type.php";
$new = new leave_type;//create a new object of type leave_type
$a=$new->get_leave_types();//calls the method that gets the list of leave_types
echo json_encode($a);//the list is returned as json
