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
    }

    public function read()
    {
    }

    public function delete()
    {
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
