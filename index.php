<!DOCTYPE html>
<!-- leave just Name priority and subtasks, and add a more button, which shows due date, other description -->
<head>
<?php
include 'process.php';
include 'taskmanager.php';
?>
<link rel="stylesheet" href="stylesheet.css">
</head>
<html>
	<body class="index-body">
		<div class="container">
			<div class="title">
				TaskTacks
				<h3>
					<em>30 Tasks in 30 Seconds</em>
				</h3>
				<h2>
					Updated:
					<?php 
						date_default_timezone_set("America/New_York");
						$date = date('m/d/Y h:i:s a', time());
						echo $date;
					?>
				</h2>
				<h2>
					<?php echo session_id();?>
				</h2>
			</div>
			<form action="" method="post">
				<div class="add-task-container">
					<input class="task-details task-name" name="task-name" type="text" placeholder="Task Name" required="required">
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
					<select class="priority" name="priority" required="required">
						<!-- <option selected disabled><em>Priority</em></option> -->
						<option name="" id="">High</option>
						<option name="" id="">Medium</option>
						<option name="" id="">Low</option>
						<option name="" id="">Leisure</option>
					</select>
					<Textarea class="task-details task-description" name="task-description" type="text" maxlength="200" placeholder="Task Description: 200 characters max"></Textarea>
					<div class="subtask-container"></div>
					<table class="subtask-manager">
						<tr>
						<td class="create-td" style="width: 50%;">
							<input class="create" name="create" type="submit" value="Create Task">
							</input>
						</td>
						<td>
							<button class="add-subtasks" type="button" id="add-subtasks" name="add-subtasks" onclick="create_Subtask();">
								Add Subtask
							</button>
						</td>
						<td>
							<button class="add-subtasks" id="delete-subtasks" type="button" name="delete-subtasks" onclick="delete_Subtask();" style="display:none;">
							Remove Subtask
							</button>
						</td>
						</tr>
					</table>
				</div>
				<button class="add-task-btn" type="button" name="add-task-btn" onclick="toggleCreator()">+
				</button>
				<?php 

					// if (sizeof($_SESSION['all-renders'])>0) {
						for ($i=0; $i < sizeof($_SESSION['all-renders']); $i++) {
							for ($x=0; $x < sizeof($_SESSION['all-renders'][$i]); $x++) { 
								// echo $_SESSION['all-renders'][$i][$x];
								echo $_SESSION['all-renders'][$i][$x]->htmlRender;
							} 
						}
					// }
					// else
						// echo sizeof($_SESSION['all-renders']);

				?>
			</form>
		</div>

	</body>
	<script type="text/javascript">
	var subtask_count = 0;
	var myStyle = document.createElement('style');
	myStyle.innerHTML = "display:block; background-color: #1b9fc6; margin-bottom: 2em; border:none; padding: 1em;";

		function create_Subtask(){
			subtask_count++;
			
			document.getElementsByClassName('create-td')[0].style.width = "38%";
			document.getElementById('delete-subtasks').style.display = "table-cell";

			var subtask = document.createElement('input');
			subtask.className = 'subtask';
			subtask.id = 'subtask-' + subtask_count;
			subtask.name = subtask.id;
			subtask.placeholder = "Subtask Name";
			subtask.style = myStyle.innerHTML;
			document.getElementsByClassName('subtask-container')[0].appendChild(subtask);
			
		}
		function delete_Subtask(){
			
			var c = document.getElementsByClassName('subtask-container')[0];

			console.log(subtask_count);
			
			console.log(subtask_count);
			
			c.removeChild(document.getElementById('subtask-' + subtask_count));
			if (subtask_count<2) {
				document.getElementById('delete-subtasks').style.display = "none";
				document.getElementsByClassName('create-td')[0].style.width = "50%";
			}

			subtask_count--;

		}

		function toggleCreator(){
			var e = document.getElementsByClassName('add-task-container')[0];
				if (e.style.display == 'block'){
					e.style.display = 'none';
				}
				else{
					e.style.display = 'block';
				}
			var d = document.getElementsByClassName('add-task-btn')[0];
				if (d.innerHTML == '-'){
					d.innerHTML = '+';
				}
				else{
					d.innerHTML = '-';
				}
		}

		function toggleSubtaskCheck(element, progressBar) {
			element.checked = !element.checked;
			progressBar;
		}
	</script>
</html>
