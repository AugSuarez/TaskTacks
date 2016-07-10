<!DOCTYPE html>
<!-- leave just Name priority and subtasks, and add a more button, which shows due date, other description -->
<head>
<?php
	// include 'process.php';
	include 'echotask.php';
	// include 'newtask.php';
?>
<link rel="stylesheet" href="stylesheet.css">
<script src="js/jquery.min.js"></script>
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
			<form action="newtask.php" method="post">
				<div class="add-task-container">

						<input class="task-details task-name" name="task-name" type="text" placeholder="Task Name" required="required">
						<label class="task-priority">Priority:</label>
						<select class="priority" name="priority" required="required">
							<!-- <option selected disabled><em>Priority</em></option> -->
							<option name="" id="" value="0">High</option>
							<option name="" id="" value="1">Medium</option>
							<option name="" id="" value="2">Low</option>
							<option name="" id="" value="3">Leisure</option>
						</select>

						<button class="task-details" id="show-more-btn" type="button" onclick="showMore()">Show More Options</button>

						<label class="due-date show-more">Due Date:</label>
						<select class="date-select show-more" name="month">
							<?php
								for($i = 1; $i <= 12; $i++):
								echo '<option>' . $i . '</option>';
								endfor;
							?>
						</select>
						<select class="date-select show-more" name="day">
							<?php
								for($i = 1; $i <= 31; $i++):
								echo '<option>' . $i . '</option>';
								endfor;
							?>
						</select>
						<select class="date-select show-more" name="year">
							<?php
								for($i = 2016; $i <= 2099; $i++):
								echo '<option>' . $i . '</option>';
								endfor;
							?>
						</select>

					<Textarea class="task-details task-description show-more" name="task-description" type="text" maxlength="200" placeholder="Task Description: 200 characters max"></Textarea>
					<div class="subtask-container"></div>
					<div class="subtask-manager">
						<ul>
						<li class="create-li" style="width: 50%;">
							<a class="create" name="create">Create Task
							</a>
						</li>
						<li>
							<button class="add-subtasks" type="button" id="add-subtasks" name="add-subtasks" onclick="create_Subtask();">
								Add Subtask
							</button>
						</li>
						<li>
							<button class="add-subtasks" id="delete-subtasks" type="button" name="delete-subtasks" onclick="delete_Subtask();" style="display:none;">
							Remove Subtask
							</button>
						</li>
						</ul>
					</div>
				</div>
				<div class="add-container">
					<button class="add-task-btn" type="button" name="add-task-btn" onclick="toggleCreator()">+
					</button>
					<label class="add-label">Create a New Task</label>
				</div>
			</form>
			<div class="task-container">
				<?php 

						$priority = ["High", "Medium", "Low", "Leisure"];

						while ($data = mysqli_fetch_assoc($tasksResult)):?>

							<table data-id="<?= $data['task_id'] ?>" class="<?= $priority[$data['task_priority']] ?>">
								<tbody class="lvl">
									<tr>
										<td class="progress-bar"><p>0%</p>
											<div class="progress-amount" id="progress-amount-' <?=  $data['task_name'] ?> '">&nbsp;</div>
										</td>
									</tr>
									<tr>
										<td class="main-1"> <?= $data['task_name'] ?> </td>
										<td><a data-id="<?= $data['task_id'] ?>" class="complete-btn" >&#10004;</a></td>
									</tr>
								</tbody>
							</table>

						<?php endwhile;
				?>
			</div>
		</div>

	</body>
	<script type="text/javascript">

		$(function(){

			$(".create").click(function(){//CREATE A NEW TASK

				if (!$("[name=task-name]").val() && !confirm("Leave Task Unnamed?")) {
					return;
				}

				var param = {
					name: $("[name=task-name]").val(),
					priority: $("[name=priority]").val(),
					description: $("[name=task-description]").val()
				};//objeto que pasara como paramentros al post de ajax, busca el valor que tenga la etiqueta encontrada por el paramentro y returna su valor

				$.post("newtask.php", param, function(response){

					console.log(response);

					var priority = ["High", "Medium", "Low", "Leisure"];

					priority = priority[Number($("[name=priority]").val())];

					var html = 
					'<table data-id="' + response + '" class="' + priority + '">\
						<tbody class="lvl">\
							<tr>\
								<td class="progress-bar"><p>0%</p>\
									<div class="progress-amount" id="progress-amount-' + $("[name=task-name]").val() + '">&nbsp;</div>\
								</td>\
							</tr>\
							<tr>\
								<td class="main-1">' + $("[name=task-name]").val() + '</td>\
								<td><a data-id="' + response + '" class="complete-btn" >&#10004;</a></td>\
							</tr>\
						</tbody>\
					</table>';

					if ($("." + priority).length) {
						$("." + priority + ":last-child").after(html);
					}
					else
						$(".task-container").append(html);

					$("[name=task-name]").val("");
					$("[name=priority]").val("0");
					$("[name=task-description]").val("");

				})//parametros: ruta, valores pasados al post, respuesta, "\" permite hacer variable multilinea

			});

			$(".complete-btn").click(function(){//TASK COMPLETED

				var myId = $(this).attr("data-id");

				$.get("complete.php?task-id=" + myId, function(response){//hace llamado get a pagina
					console.log(response);

					if (response == "ok")
					{
						$("table[data-id=" + myId + "]").fadeOut();
					}
				});

			});

		});

	</script>
	<script type="text/javascript">
	
		var subtask_count = 0;
		
		var myStyle = document.createElement('style');

		myStyle.innerHTML = "display: inline-block; background-color: #1b9fc6; margin-bottom: 2em; border:none; padding: 1em;";

			function create_Subtask(){
				
				subtask_count++;
				
				document.getElementsByClassName('create-li')[0].style.width = "38%";
				document.getElementById('delete-subtasks').style.display = "table-cell";

				var subtask = document.createElement('input');
				subtask.className = 'subtask';
				subtask.id = 'subtask-' + subtask_count;
				subtask.name = subtask.id;
				subtask.placeholder = "Subtask Name";
				subtask.style = myStyle.innerHTML + "width:50%;";
				document.getElementsByClassName('subtask-container')[0].appendChild(subtask);
				
				var subtaskImportance = document.createElement('select');
				subtaskImportance.className = 'subtask-importance';
				subtaskImportance.id = 'subtask-importance-' + subtask_count;
				subtaskImportance.name = subtaskImportance.id;
				subtaskImportance.style = myStyle.innerHTML + "float:right";
				document.getElementsByClassName('subtask-container')[0].appendChild(subtaskImportance);

				var optionNoSelect = document.createElement('option');
				optionNoSelect.innerHTML = "Subtask %";
				document.getElementById(subtaskImportance.id).appendChild(optionNoSelect);

				for (var i = 10; i<=100; i+=10) {
					var option = document.createElement('option');
					option.innerHTML = i +"%";
					document.getElementById(subtaskImportance.id).appendChild(option);
				}

			}

			function delete_Subtask(){
				
				var c = document.getElementsByClassName('subtask-container')[0];

				c.removeChild(document.getElementById('subtask-' + subtask_count));
				c.removeChild(document.getElementById('subtask-importance-' + subtask_count));
				
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
				var progressBar;

			}

			function showMore() {
				for (var i = 0; i < 5; i++) {

					var e = document.getElementsByClassName('show-more')[i];

					if (e.style.display == "inline-block") {
						e.style.display = "none";
					}
					else
						e.style.display = "inline-block";
				}

				var e = document.getElementById('show-more-btn');
				if (e.innerHTML == "Show More Options")
					e.innerHTML = "Show Fewer Options";
				else
					e.innerHTML = "Show More Options";
			}


	</script>
</html>
