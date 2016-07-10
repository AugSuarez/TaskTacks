<?php

include 'connect.php';

	$taskName = $_POST['name'];
	// $dueDate = $_POST['month'];
	// $dueDate .= "-" . $_POST['day'];
	// $dueDate .= "-" . $_POST['year'];
	$taskPriority = $_POST['priority'];
	$taskDescription = $_POST['description'];

	mysqli_query($con, "INSERT into tasks (task_name, task_priority, task_description) values('$taskName', '$taskPriority', '$taskDescription')");

	echo mysqli_insert_id($con);
	//para regresar ID de una vez que haga el insert de mysql
