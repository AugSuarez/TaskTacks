<!DOCTYPE html>
<head>
<?php
include 'process.php';
?>
<link rel="stylesheet" href="stylesheet.css">
<div class="add-task-container">
	<input class="task-details task-name" name="task-name" type="text" placeholder="Task Name">
	<label class="due-date">Due Date:</label>
	<select class="date-select" name="month">
		<?php
			for($i = 1; $i <= 12; $i++):
			echo '<option>' . $i . '</option>';
			endfor;
		?>
	</select>
	<select class="date-select" name="day">
		<?php
			for($i = 1; $i <= 31; $i++):
			echo '<option>' . $i . '</option>';
			endfor;
		?>
	</select>
	<select class="date-select" name="year">
		<?php
			for($i = 2016; $i <= 2099; $i++):
			echo '<option>' . $i . '</option>';
			endfor;
		?>
	</select>
	<label class="task-priority">Priority:</label>
	<select class="priority" name="priority">
		<!-- <option selected disabled><em>Priority</em></option> -->
		<option name="" id="">High</option>
		<option name="" id="">Medium</option>
		<option name="" id="">Low</option>
		<option name="" id="">Leisure</option>
	</select>
	<Textarea class="task-details task-description" name="task-description" type="text" maxlength="200" placeholder="Task Description: 200 characters max"></Textarea>
	<div class="subtask-container"></div>
	<input class="create" name="create" type="submit" value="Create Task">
	</input>
	<button class="add-subtasks" type="button" name="add-subtasks" onclick="create_Subtask();">
	Add Subtask
	</button>
</div>
	<script type="text/javascript">
	var subtask_count = 1;
	var myStyle = document.createElement('style');
	myStyle.innerHTML = "display:block; background-color: #1b9fc6; margin-bottom: 2em; border:none; padding: 1em;";

	function create_Subtask(){
		var subtask = document.createElement('input');
		subtask.className = 'subtask';
		subtask.name = 'subtask-' + subtask_count;
		subtask.placeholder = "Subtask Name"
		subtask.style = myStyle.innerHTML;
		document.getElementsByClassName('subtask-container')[0].appendChild(subtask);
		subtask_count += 1;
	}

	</script>