	    	
<?php

/*this controller is used to get the list of genders from the database
the list was not hardcoded because you never know if it requires updating
getting the values from the database means that if a value needs to be added,
the code need not be touched*/
include_once "../model/class/class.pending_applications.php";
$new = new application;
$a=$new->gender();
echo json_encode($a);
