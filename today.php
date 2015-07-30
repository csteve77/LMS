<?php

//this controller is used to return the count of people who are on leave today
include_once"../model/class/class.query_builder.php";
$new=new query;
$a=$new->get_todays_leave();
echo json_encode($a);
