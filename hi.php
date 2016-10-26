<?php
$con = mysqli_connect("localhost", "root", "", "tasks");

$tasks = mysqli_query($con, "SELECT task_name FROM tasks WHERE is_completed = 0 ORDER BY task_priority"); 


var_dump(mysqli_fetch_array($tasks));