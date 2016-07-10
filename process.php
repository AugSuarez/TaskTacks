<?php

$_SESSION['Hi'] = array();
$_SESSION['Med'] = array();
$_SESSION['Lo'] = array();
$_SESSION['Leis'] = array();
$_SESSION['all-tasks'] = array();

session_id("ADMIN");
session_start();
// checkbox
class Task
{
	
	public $html;
	public $dueDate;
	public $priority;
	public $description;
	public $subtaskImportance;

	public static $taskCount = 0;

	public function getTaskInfo()
	{
		$this->taskName = $_POST['task-name'];
		$this->dueDate = $_POST['month'];
		$this->dueDate .= "-" . $_POST['day'];
		$this->dueDate .= "-" . $_POST['year'];
		$this->priority = $_POST['priority'];
		$this->description = $_POST['task-description'];
		$this->html = '
			<table class="' . $this->priority . '">
				<tbody class="lvl">
				<tr>
					<td class="progress-bar"><p>0%</p>
						<div class="progress-amount" id="progress-amount-' . $this->taskName . '">&nbsp;</div>
					</td>
				</tr>
				<tr>
						<!-- <td class="td-task-name">' . $this->priority . '</td> -->
					</tr>
					<tr>
						<td class="main-1">' . $this->taskName . '</td>
						<td><input type="submit" name="' . $this->taskName . '" class="delete-btn" value="&#10004;"></td>
					</tr>';
	}

	public function getSubTasks()
	{
		$subtaskCount = 1;
		if (!empty($_POST['subtask-' . $subtaskCount])) {
			$this->html .= '<tr>	
								<td class="td-subtask">Subtasks:</td>						
							</tr>';
		}
		while (!empty($_POST['subtask-' . $subtaskCount])) {
			$this->subtask = $_POST['subtask-' . $subtaskCount];
			$this->subtaskImportance = $_POST['subtask-importance-' . $subtaskCount];
			$this->html .= 					
						'<tr>	
							<td class="sub">'. $_POST['subtask-' . $subtaskCount] . '</td>					
							<td>
								<input class="progress-checkbox" type="checkbox" name="checkbox-' . $this->taskName . "-" . $subtaskCount . '" onchange="toggleSubtaskCheck(this, progress-amount-' . $this->taskName . ',' . $this->subtaskImportance . '");">
							</td>
						</tr>';
			$subtaskCount += 1;
		}

			$this->html .= 	'</tbody>
								</table>';
	}

	public function __construct(){
		
		Task::$taskCount++;

		for ($i=0; $i < sizeof($_SESSION['all-tasks']); $i++) {
				for ($x=0; $x < sizeof($_SESSION['all-tasks'][$i]); $x++) {
					if($_POST['task-name'] == $_SESSION['all-tasks'][$i][$x]->taskName){
						$_POST['task-name'] .= Task::$taskCount;
					} 
				}
		}

		$this->getTaskInfo();
		$this->getSubTasks();

		if ($this->priority == "High") 
			array_push($_SESSION['Hi'], $this);

		else if ($this->priority == "Medium") 
			array_push($_SESSION['Med'], $this);

		else if ($this->priority == "Low") 
			array_push($_SESSION['Lo'], $this);

		else if ($this->priority == "Leisure") 
			array_push($_SESSION['Leis'], $this);


		$_SESSION['all-tasks'] = array($_SESSION['Hi'],$_SESSION['Med'],$_SESSION['Lo'],$_SESSION['Leis']);
	
	}

}


if (isset($_POST['create'])) {

	$newTask = new Task();

}

// for ($i=0; $i < sizeof($_SESSION['all-tasks']); $i++) {
// 	for ($x=0; $x < sizeof($_SESSION['all-tasks'][$i]); $x++) { 
// 		if (!empty($_POST[$_SESSION['all-tasks'][$i][$x]->taskName])) {
// 			// array_splice($_SESSION['all-tasks'][$i], $x, 1);
// 			echo $_SESSION['all-tasks'][$i][$x]->taskName;
// 		}
// 	} 
// }


//<?php if (!empty($_POST['checkbox'])) echo 'checked="checked"';?> 