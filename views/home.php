<!DOCTYPE html>
<!-- leave just Name priority and subtasks, and add a more button, which shows due date, other description -->
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="/assets/css/stylesheet.css">
<script src="/assets/js/jquery.min.js"></script>
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
					<?= $date ?>
				</h2>
				<h2>
					<?= $sessionId ?>
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
				foreach ($tasks as $task):
					?>
				<table data-id="<?= $task['task_id'] ?>" class="<?= $priority[$task['task_priority']] ?>">
					<tbody class="lvl">
						<tr>
							<td class="progress-bar"><p>0%</p>
							<div class="progress-amount" id="progress-amount-' <?=  $task['task_name'] ?> '">&nbsp;</div>
						</td>
					</tr>
					<tr>
						<td class="main-1"> <?= $task['task_name'] ?> </td>
						<td><a data-id="<?= $task['task_id'] ?>" class="complete-btn" >&#10004;</a></td>
					</tr>
				</tbody>
				</table>
				<?php endforeach; ?>
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

			$(".lvl").on('click', '.complete-btn', function(){//TASK COMPLETED

				var myId = $(this).attr("data-id");
				console.log($(this).attr('class'));
				console.log(myId);

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
				
				// document.getElementsByClassName('create-li')[0].style.width = "38%";
				$('.create-li').css('width', '38%');

				// document.getElementById('delete-subtasks').style.display = "table-cell";
				$('#delete-subtasks').css('display', 'table-cell');

				// var subtask = document.createElement('input');
				// subtask.className = 'subtask';
				// subtask.id = 'subtask-' + subtask_count;
				// subtask.name = subtask.id;
				// subtask.placeholder = "Subtask Name";
				// subtask.style = myStyle.innerHTML + "width:50%;";
				// document.getElementsByClassName('subtask-container')[0].appendChild(subtask);

				var subtask = $('<input></input>');

				subtask.addClass('subtask');

				subtask.attr('id', 'subtask-' + subtask_count);

				subtask.attr('name', subtask.attr('id'));

				subtask.attr('placeholder', "Subtask Name");

				subtask.addClass('subtask');

				$('.subtask-container').append(subtask);



				var subtaskImportance = $('<select></select>');

				subtaskImportance.addClass('subtask');

				subtaskImportance.attr('style', 'float: right');

				subtaskImportance.attr('id', 'subtask-importance-' + subtask_count);

				subtaskImportance.attr('name', subtaskImportance.attr('id'));

				$('.subtask-container').append(subtaskImportance);
				
				// var subtaskImportance = document.createElement('select');
				// subtaskImportance.className = 'subtask-importance';
				// subtaskImportance.id = 'subtask-importance-' + subtask_count;
				// subtaskImportance.name = subtaskImportance.id;
				// subtaskImportance.style = myStyle.innerHTML + "float:right";
				// document.getElementsByClassName('subtask-container')[0].appendChild(subtaskImportance);

				// var optionNoSelect = document.createElement('option');
				var optionNoSelect = $('<option></option>');

				// optionNoSelect.innerHTML = "Subtask %";
				optionNoSelect.html('Subtask %');

				// document.getElementById(subtaskImportance.id).appendChild(optionNoSelect);
				$('#subtask-importance-' + subtask_count).append(optionNoSelect);

				for (var i = 10; i<=100; i+=10) {

					var option = $('<option></option>');

					option.html(i + '%');

					console.log(optionNoSelect.html());

					$('#subtask-importance-' + subtask_count).append(option);

				}

			}

			function delete_Subtask(){
				
				// var c = document.getElementsByClassName('subtask-container')[0];

				// c.removeChild(document.getElementById('subtask-' + subtask_count));
				// c.removeChild(document.getElementById('subtask-importance-' + subtask_count));

				if (subtask_count > 0) {
					
					$('#subtask-' + subtask_count).remove();

					$('#subtask-importance-' + subtask_count).remove();

					console.log(subtask_count);
				
					subtask_count--;

				}


				if (subtask_count == 0) {

					$('#delete-subtasks').css('display', 'none');
					
					$('.create-td').css('width', "50%");

				}


			}

			function toggleCreator(){


				$('.add-task-container').css('display', function(){

					 var display = ($(this).css('display') == 'block') ? 'none' : 'block';

					 return display;

				});


				$('.add-task-btn').html(function(){

					var html = ($(this).html() == '-') ? '+' : '-';

					return html;

				});

				console.log("toggleCreator called");

			}

			function toggleSubtaskCheck(element, progressBar) {

				element.checked = !element.checked;
				var progressBar;

			}

			function showMore() {

				// for (var i = 0; i < 5; i++) {

				// 	var e = document.getElementsByClassName('show-more')[i];

				// 	if (e.style.display == "inline-block") {
				// 		e.style.display = "none";
				// 	}
				// 	else
				// 		e.style.display = "inline-block";
				// }

				$('.show-more').css('display', function(){

					var display = ($(this).css('display') == 'inline-block') ? 'none' : 'inline-block';

					return display;

				});

				$('#show-more-btn').html(function(){

					var html = ($(this).html() == "Show More Options") ? "Show Fewer Options" : "Show More Options";

					return html;

				});


				// if (e.innerHTML == "Show More Options")
				// 	e.innerHTML = "Show Fewer Options";
				// else
				// 	e.innerHTML = "Show More Options";
			}


	</script>
</html>
