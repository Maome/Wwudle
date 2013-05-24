<?php
	require_once('init.php');
	use JasonKaz\FormBuild\Form as Form;
	use JasonKaz\FormBuild\Text as Text;
	use JasonKaz\FormBuild\Help as Help;
	use JasonKaz\FormBuild\Checkbox as Checkbox;
	use JasonKaz\FormBuild\Submit as Submit;
	use JasonKaz\FormBuild\Password as Password;
	use JasonKaz\FormBuild\Select as Select;
	use JasonKaz\FormBuild\Radio as Radio;			
	use JasonKaz\FormBuild\Button as Button;		
	use JasonKaz\FormBuild\Reset as Reset;
	use JasonKaz\FormBuild\Custom as Custom;
	use JasonKaz\FormBuild\Textarea as Textarea;
	use JasonKaz\FormBuild\Hidden as Hidden;
	use JasonKaz\FormBuild\Email as Email;
	use JasonKaz\FormBuild\Star as Star;
?>
<?php								
	// Get the post data
	$CourseDept = $_POST['courseDept'];									
	$CourseNumber = $_POST['courseNumber'];
	$Professor = $_POST['professor'];
	$Workload = $_POST['workload'];
	$LectureQuality = number_format($_POST['lectureQuality'], 2);
	$TestRelevance = number_format($_POST['testRelevance'], 2);
	$RelevanceToProgram = number_format($_POST['relevanceToProgram'], 2);
	$Enjoyable = number_format($_POST['enjoyable'], 2);
	$BookNecessity = $_POST['bookNecessity'];			
	$Overall = number_format((($LectureQuality + $TestRelevance + $RelevanceToProgram + $Enjoyable) / 4), 2);
	$Comments = $_POST['comments'];
	$postback = $_POST['postback'];
	$errorResults = array();
							
	// Validate the data									
	if (
		!isset($CourseNumber) || 
		empty($CourseNumber) || (
		strlen($CourseNumber) < 3 ||
		strlen($CourseNumber) > 4 ||
		!is_numeric(substr($CourseNumber,0,3)))
	) {
		$isValid = false;
	}
	else {
		$isValid = true;
	}
?>
<!DOCTYPE HTML>
<html lang-"en">
    <head>
        <title><?php Woodle(); ?></title>
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
        <link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
        <link href="bootstrap/css/footer.css" rel="stylesheet">
    </head>
    <body>
		<div id="wrap">
			<!-- Navbar -->
			<?php DisplayNavbar("reviews.php"); ?>
		     
		     <div class="container">
		         <div class="row-fluid">
					<!-- Sidebar -->
					<?php DisplaySidebar(); ?>
		             <div class="span9">
		                 <div class="row-fluid">
		                 	<?php ReviewNav(false) ?>
		                 </div>
		                 <div class="row-fluid">           
		                  	<?php
		                  		$dbc = new dbw(DBSERVER,DBUSER,DBPASS,DBCATALOG);
		                  		
		                  		$errorResults = array();
		                  		if (!$isValid && $postback) {
		                  			array_push($errorResults, 'courseNum');
		                  		}
										
										if ($isValid && $postback) {
											$username = PHPCAS::GetUser();
								
											// See if the user is in the Users table
											$username = $username . "@students.wwu.edu";
											$sql = "Select * from User where Email = '$username';";
											$result = $dbc->query($sql);								
											// Check if the name is in the table
											$rows = $result->num_rows;																					
								
											if ($rows == 0) {
												echo "<h2>You must log in!</h2>";
											}
											else {						
												// Set the user id
												$getData = $result->fetch_row();									
												$UserID = $getData[0];									
												// Get the post data
													
												$sql = "INSERT INTO Review (PostDate, UserID, CourseDept, CourseNumber, Professor, Workload, LectureQuality, TestRelevance, RelevanceToProgram, Enjoyable, BookNecessity, Overall, Comments, ViewCount, ChangeSource, RecordStatus, RecordStatusDate) VALUES (CURDATE(), $UserID, '$CourseDept', '$CourseNumber', '$Professor', $Workload, $LectureQuality, $TestRelevance, $RelevanceToProgram, $Enjoyable, $BookNecessity, $Overall, '$Comments', 0, 0, 1, CURDATE());"; 
												//$dbc->setDebug(true);
												$dbc->query($sql);
									
									
												echo "<h3>Your information has been submitted</h3>";
								
												// Show the user all of the info that has been recieved 
												echo "
													<table id='table_id' class='table table-striped'>
														<tbody>
															<tr>
																<td><b>Course</b></td><td>$CourseDept $CourseNumber</td>
															</tr>
															<tr>
																<td><b>Professor</b></td><td>$Professor</td>
															</tr>
															<tr>
																<td><b>Workload</b></td><td>"; if($Workload == 0) echo "Light"; else if($Workload == 1) echo "Moderate"; else echo "Heavy"; echo "</td>
															</tr>
															<tr>
																<td><b>Lecture Quality</b></td><td>$LectureQuality</td>
															</tr>
															<tr>
																<td><b>Test Relevance</b></td><td>$TestRelevance</td>
															</tr>
															<tr>
																<td><b>Relevance To Program</b></td><td>$RelevanceToProgram</td>
															</tr>
															<tr>
																<td><b>Enjoyable</b></td><td>$Enjoyable</td>
															</tr>												
															<tr>
																<td><b>Book necessity</b></td><td>"; if($BookNecessity == 0) echo "Absolutely necessary"; else if($BookNecessity == 1) echo "Somewhat necessary"; else echo "Not necessary"; echo "</td>
															</tr>
															<tr>
																<td><b>Overall</b></td><td>$Overall</td>
															</tr>	
															<tr>
																<td><b>Comments</b></td><td>$Comments</td>
															</tr>												
														</tbody>
													</table>";											
											}
										}
										else {
											$ReviewForm=new Form;
											echo $ReviewForm->init('reviewsadd.php','post',array('class'=>'form-horizontal', 'name'=>'reviewForm', 'id'=>'reviewForm'))
												->group('Course',
													new Select($dbc->queryPairs('SELECT Abbreviation,Description FROM Department WHERE RowOrder=1 ORDER BY RowOrder,Abbreviation'), 1, array('class'=>'input-xlarge','name'=>'courseDept', 'id'=>'courseDept')),
													new Text(array('class'=>'input-small','name'=>'courseNumber', 'id'=>'courseNumber', 'placeholder'=>'Course #')),
													new Custom(in_array('courseNum',$errorResults) ? '<span class="help-inline"><p class="text-warning">Please enter a valid course number</p></span>' : '')
												)
												->group('Professor',
													new Select($dbc->queryPairs('SELECT Name,Name FROM Professor WHERE RowOrder=1 ORDER BY RowOrder,Name'),false, array('class'=>'input-xlarge','name'=>'professor', 'id'=>'professor'))
												)
												->group('Workload', 
													new Select(array('Light', 'Moderate', 'Heavy'), false, array('class'=>'input-xlarge', 'name'=>'workload', 'id'=>'workload'))
												)
												->group('Lecture quality',
													new Star('lq')
												)
												->group('Test relevance',
													new Star('tr')
												)
												->group('Relevance to program',
													new Star('rtp')
												)
												->group('Enjoyable',
													new Star('enj')
												)
												->group('Book necessity',
													new Select(array('Absolutely necessary', 'Somewhat necessary', 'Not necessary'), 0, array('class'=>'input-xlarge', 'name'=>'bookNecessity', 'id'=>'bookNecessity'))
												)
												->group('Additional comments',
													new Textarea('', array('class'=>'input-xlarge', 'rows'=>'8', 'name'=>'comments', 'id'=>'comments'))
												)
												->group('',
													new Submit('Submit', array('class' => 'btn btn-primary'))
												)
												->group('',
													new Hidden(array('name'=>'postback', 'id'=>'postback', 'value'=>'true'))
												)
												->render();
										}
		                  	?>
		                 </div>
		             </div>
		         </div>
		     </div>
		     <div id="push"></div>
        </div>
        <?php DisplayFooter(); ?>
    </body>
    <script src="holder/holder.js"></script>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="bootstrap/js/bootstrap.js"></script>
    <script src="bootstrap/raty/jquery.raty.js"></script>    
    <script src="bootstrap/raty/jquery.raty.min.js"></script>
    <script>
     $(function() {
    	$.fn.raty.defaults.path = 'bootstrap/raty/img';
    	//defaults were changed in jquery.raty.js and jquery.raty.min.js to half=true, score=2.5, and 
    	////hints=[very poor, poor, fair, good, very good]. Everything else in unchaged.
    	$('#lq').raty({
    		scoreName: 'lectureQuality', click: function(lectureQuality) {
    			$.post('reviewsaddRCV.php', {lectureQuality: lectureQuality})
    	}});
    	$('#tr').raty({
    		scoreName: 'testRelevance', click: function(testRelevance) {
    			$.post('reviewsaddRCV.php', {testRelevance: testRelevance})},
    		hints: ['Very irrelevant to lecture/homework', 'Irrelevant to lecture/homework', 'Neutral', 'Relevant to lecture/homework', 'Very relevant to lecture/homework']
    	});
    	$('#rtp').raty({
    		scoreName: 'relevanceToProgram', click: function(relevanceToProgram) {
    			$.post('reviewsaddRCV.php', {relevanceToProgram: relevanceToProgram})},
    		hints: ['Very irrelevant', 'Irrelevant', 'Neutral', 'Relevant', 'Very relevant']
    	});
    	$('#enj').raty({
    		scoreName: 'enjoyable', click: function(enjoyable) {
    			$.post('reviewsaddRCV.php', {enjoyable: enjoyable})},
    		hints: ['Very unenjoyable', 'Unenjoyable', 'Neutral', 'Enjoyable', 'Very enjoyable']
    	});
    });
    </script>
    <script src="bootstrap/validaty/jquery.validaty.js"></script>
    <script src="bootstrap/validaty/jquery.validaty.min.js"></script>
    <script src="bootstrap/validaty/jquery.validaty.validators.js"></script>
</html>

