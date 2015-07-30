<?php

//this controller is used to populate the dropdown list for the query builder
//with all employees
include_once "../model/class/class.employee.php";
$new = new employee;
$a=$new->all_employees();
echo json_encode($a);//the reults obtained are passed back as json
