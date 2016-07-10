<?php

include 'connect.php';

$tasksResult = mysqli_query($con, "SELECT * FROM tasks WHERE is_completed = 0 ORDER BY task_priority");
//guardado de resultado del query