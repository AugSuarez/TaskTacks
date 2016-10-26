<?php

//namespace app\controllers\controller;

class Task
{
    private $con;

    public function __construct()
    {
        $this->con = mysqli_connect('localhost', 'root', '', 'tasks');
    }

    public function create()
    {
        $taskName = $_POST['name'];
        // $dueDate = $_POST['month'];
        // $dueDate .= "-" . $_POST['day'];
        // $dueDate .= "-" . $_POST['year'];
        $taskPriority = $_POST['priority'];
        $taskDescription = $_POST['description'];

        mysqli_query($con, "INSERT into tasks (task_name, task_priority, task_description) values('$taskName', '$taskPriority', '$taskDescription')");

        echo mysqli_insert_id($con);
        //para regresar ID de una vez que haga el insert de mysql
    }

    public function read()
    {
    }

    public function delete()
    {

        mysqli_query($con, "DELETE from tasks WHERE task_id = 5") or die(mysqli_error($con));
    }

    public function isComplete()
    {
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
    }

    public function allTasks()
    {
        $tasks = mysqli_query($this->con, 'SELECT * FROM tasks WHERE is_completed = 0 ORDER BY task_priority');

        $arrayTask = [];

        while ($task = mysqli_fetch_assoc($tasks)) {
            $arrayTask[] = $task;
        }

        return $arrayTask;
    }
}
