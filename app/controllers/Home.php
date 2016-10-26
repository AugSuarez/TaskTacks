<?php

namespace app\controllers\controller;

//require 'Task.php';

class Home
{
    public function show()
    {
        date_default_timezone_set("America/New_York");
        $dateDelSistema = date('m/d/Y h:i:s a', time());

        $priority = ["High", "Medium", "Low", "Leisure"];

        $task = new Task();

        view('home', [
            'date' => $dateDelSistema,
            'sessionId' => session_id(),
            'priority' => $priority,
            'tasks' => $task->allTasks(),
        ]);
    }
}
