<?php

	include 'connect.php';


	if (!empty($_GET['task-id'])) {//modificia la bases de datos del id que mod campo bool 0->1
		$myId = $_GET['task-id'];

		$response = mysqli_query($con, "UPDATE tasks SET is_completed = 1 WHERE task_id = '$myId' ");//$result para buenos habitos!! si $result == 1 fue exitosa. 0 -> no 

		if ($response) {
			$removeFromDB = mysqli_query($con, "DELETE FROM tasks WHERE is_completed = 1");

			if ($removeFromDB) {
				echo "ok";
			}
			else {
				echo "task completed, not deleted";
			}
		}

	}