var subtaskCount = 0;

	var subtaskStyle = $('head').add("style").html("display: inline-block; background-color: #1b9fc6; \
		margin-bottom: 2em; border:none; padding: 1em;");

function create_Subtask(){

	subtaskCount++;

	$('.create-li').css("width", "38%");
	$('#delete-subtasks').css("display", "table-cell");

	var subtask = $('.subtask-container').add('input');
	subtask.addClass('subtask');
	subtask.id('subtask-' + subtaskCount);//create subtask n
	subtask.attr('name', subtask.id);
	subtask.attr('placeholder', "Subtask Name");
	subtask.attr('style', subtaskStyle + 'width:50%');
	// $('.subtask-container').append(subtask);

	var subtaskImportance = $('.subtask-container').add('select');
	subtaskImportance.addClass('subtask-importance');
	subtaskImportance.id('subtask-importance-' + subtaskCount);
	subtaskImportance.attr('name' subtaskImportance.id);
	subtask.attr('style', subtaskStyle + 'float:right');

	

}