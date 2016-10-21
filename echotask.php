<?php

include 'connect.php';

$tasksResult = mysqli_query($con, "SELECT * FROM tasks WHERE is_completed = 0 ORDER BY task_priority");
if (!$tasksResult) {
	printf("Error: %s \n" , mysqli_error($con));
	exit();
}
//guardado de resultado del query