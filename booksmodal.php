<?php

	use JasonKaz\FormBuild\Form as Form;
	use JasonKaz\FormBuild\Text as Text;
	use JasonKaz\FormBuild\Submit as Submit;
	use JasonKaz\FormBuild\Password as Password;
	use JasonKaz\FormBuild\Select as Select;	
	use JasonKaz\FormBuild\Reset as Reset;
	use JasonKaz\FormBuild\Custom as Custom;
	use JasonKaz\FormBuild\Textarea as Textarea;
	use JasonKaz\FormBuild\Hidden as Hidden;
	
	function renderModals($dbc, $row, $action, $count) {
	
		// Header
		echo '
			<div id="edit' .$count .'" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
					<h3 id="myModalLabel">Book Listing for ' .$row['Title'] .'</h3>
				</div>
				<div class="modal-body">
		';
				
		// Get subjects and course
		$subjects = $dbc->queryPairs('SELECT Abbreviation,Description FROM Department WHERE RowOrder=1 ORDER BY RowOrder, Abbreviation');
		$course =  explode(' ', $row['Course']);
				
		// Form to edit posts
		echo '
			<form class="form-horizontal" action="' .$action .'" method="POST">
			<input type="hidden" name="PostID" id="PostID' . $count . '" value="' . $row['PostID'] . '">
			<input type="hidden" name="edit" id="edit" value="true">
			<label class="control-label" for="price">Price</label>
			<input id="price' . $count . '" name="price" type="text" value="' . $row['Price'] . '">
				<label class="control-label" for="subject">Subject</label>
					<select name="subject">
		';
					foreach($subjects as $key => $value) {
						if ($key == $course[0]) echo '<option value="' .$key .'" selected>' .$value .'</option>';
						else	echo '<option value="' .$key .'">' .$value .'</option>';
					}
		echo '
				</select>
				<label class="control-label" for="course">Course</label>
				<input id="course" name="course" type="text" value="' .$course[1] .'">
		';
		echo '
			  <div class="modal-footer">
				<input class="btn btn-success" type="submit" value="Save changes">
				<button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Close</button>
			  </div>
			</form>
			</div>
		</div>
		';
	}
?>
