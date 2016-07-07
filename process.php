<?php
//start session, load task array
//every created session pushes the array
//create task object


$_SESSION['Hi'] = array();
$_SESSION['Med'] = array();
$_SESSION['Lo'] = array();
$_SESSION['Leis'] = array();
$_SESSION['all-tasks'] = array();

session_id("ADMIN");
session_start();

class Task
{
	
	public $htmlRender;
	public $dueDate;
	public $priority;
	public $description;

	public static $taskCount = 0;

	public function getTaskInfo()
	{
		$this->taskName = $_POST['task-name'];
		$this->dueDate = $_POST['month'];
		$this->dueDate .= "-" . $_POST['day'];
		$this->dueDate .= "-" . $_POST['year'];
		$this->priority = $_POST['priority'];
		$description = $_POST['task-description'];
		$this->htmlRender = '
			<table class="' . $this->priority . '">
				<tbody  class="lvl">
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
			$this->htmlRender .= '<tr>	
								<td class="td-subtask">SUBTASKS:</td>						
							</tr>';
		}
		while (!empty($_POST['subtask-' . $subtaskCount])) {
			$this->subtask = $_POST['subtask-' . $subtaskCount];
			$this->htmlRender .= 					
						'<tr>	
							<td class="sub">'. $_POST['subtask-' . $subtaskCount] . '</td>						
							<td>
								<input type="checkbox" name="checkbox-' . $this->taskName . "-" . $subtaskCount . '" onchange="toggleSubtaskCheck(this, progress-amount-' . $this->taskName . ');">
							</td>
						</tr>';
			$subtaskCount += 1;
		}

			$this->htmlRender .= 	'</tbody>
								</table>';
	}

	public function __construct(){
		for ($i=0; $i < sizeof($_SESSION['all-tasks']); $i++) {
			if($_POST['task-name'] == $_SESSION['all-tasks'][$i]->taskName){
				$_POST['task-name'] .= Task::$taskCount;
			} 
		}

		$this->getTaskInfo();
		$this->getSubTasks();

		// array_push($_SESSION['all-tasks'], $this);

		if ($this->priority == "High") 
			array_push($_SESSION['Hi'], $this);

		else if ($this->priority == "Medium") 
			array_push($_SESSION['Med'], $this);

		else if ($this->priority == "Low") 
			array_push($_SESSION['Lo'], $this);

		else if ($this->priority == "Leisure") 
			array_push($_SESSION['Leis'], $this);

		
		// array_splice($_SESSION['Hi'], 0, 1);
		//needs index from array
		//gets arr


		$_SESSION['all-renders'] = array($_SESSION['Hi'],$_SESSION['Med'],$_SESSION['Lo'],$_SESSION['Leis']);
	
		Task::$taskCount++;

		// $_SESSION['Hi'] = array();
		// $_SESSION['Med'] = array();
		// $_SESSION['Lo'] = array();
		// $_SESSION['Leis'] = array();
		// $_SESSION['all-renders'] = array();
		// $_SESSION['all-tasks'] = array();

	}

}

class TaskManager
{
	function __construct(){
	}
	
};

// TaskManger::__construct(){
	// $_SESSION['allTasks'] = this->$allTasks;
// }

if (isset($_POST['create'])) {

	$newTask = new Task();

	// $contents_to_write = '';
	// $contents_to_write = getTaskInfo($contents_to_write);
	// $contents_to_write = getSubTasks($contents_to_write);
	// file_put_contents("contents.txt", $contents_to_write);//contents.txt will be $task.Name . ".txt"

}

if (isset($_POST['delete'])) {



}


//<?php if (!empty($_POST['checkbox'])) echo 'checked="checked"';?> 