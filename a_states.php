	    	
<?php

//this controller is used to get the possible states of an application. 
//it is used to populate a dropdown for the query builder
include_once "../model/class/class.pending_applications.php";
$new = new application;//it creates a new object of type application
$a=$new->states();//and calls its method states to get the list of application states
echo json_encode($a);//the result is sent back in json format
