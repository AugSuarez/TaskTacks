<?php
include 'connect.php';

mysqli_query($con, "DELETE from tasks WHERE task_id = 5") or die(mysqli_error($con));