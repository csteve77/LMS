<?php

//this controller is used to call a method that gets the count of people who are on leave next week
include_once"../model/class/class.query_builder.php";
$new=new query;
$a=$new->get_nextWeek_leave();
echo json_encode($a);
