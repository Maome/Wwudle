<?php
	require_once('init.php');
	require_once('reviewsfunctions.php');
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
<!DOCTYPE HTML>
<html lang-"en">
    <head>
		<title><?php Woodle(); ?></title>
		<link href="bootstrap/css/bootstrap.css" rel="stylesheet">
		<link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
		<link href="bootstrap/css/datepicker.css" rel="stylesheet">
		<link href="bootstrap/css/bootstrap-modal.css" rel="stylesheet">
		<link href="bootstrap/css/footer.css" rel="stylesheet">
		<script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js'></script>
    </head>
    <body>
		<div id="wrap">
			<!-- Navbar -->
			<?php DisplayNavbar(basename(__FILE__)); ?>
		     
		     <div class="container">
		         <div class="row-fluid">
					<!-- Sidebar -->
					<?php DisplaySidebar(); ?>
		             <div class="span9">
						<?php
								ManagePostsNav(false, false);
							
								$dbc = new dbw(DBSERVER,DBUSER,DBPASS,DBCATALOG);
														
								// Get the post data
								$CourseDept = $_POST['courseDept'];									
								$CourseNumber = $_POST['courseNumber'];
								$Professor = $_POST['professor'];
								$Workload = $_POST['workload'];
								//$Workload = '';
								//if ($WorkloadNum == 0) $Workload = 'Light'; else if ($WorkloadNum == 1) $Workload = 'Moderate'; else $Workload = 'Heavy';
								$LectureQuality = number_format($_POST['lectureQuality'], 2);
								$TestRelevance = number_format($_POST['testRelevance'], 2);
								$RelevanceToProgram = number_format($_POST['relevanceToProgram'], 2);
								$Enjoyable = number_format($_POST['enjoyable'], 2);
								$BookNecessity = $_POST['bookNecessity'];
								//if ($BookNecessityNum == 'Absolutely necessary') $BookNecessity = 0; else if ($BookNecessityNum == 'Somewhat necessary') $BookNecessity = 1; else if ($BookNecessityNum == 'Not necessary') $BookNecessity = 2;
								$Overall = number_format((($LectureQuality + $TestRelevance + $RelevanceToProgram + $Enjoyable) / 4), 2);
								$Comments = $_POST['comments'];
								$PostID = $_POST['PostID'];
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
							
								// Get the UserID
								$email = phpcas::GetUser() . "@students.wwu.edu";
							
								// Display all of the current reviews that the user has posted 
								$qry = "SELECT UserID FROM User WHERE Email='$email';";
								$result = $dbc->query($qry);
								$row = $result->fetch_assoc();
								$UserID = $row['UserID'];

								// Populate a table with the reviews the user currently has posted
								$qry = "SELECT * FROM Review WHERE UserID='$UserID';";
								$result = $dbc->query($qry);
								$row = $result->fetch_assoc();														

								/* 
								 * Check to see if the user is deleting a post
								 */
								if(isset($_POST['delete'])){
									DeleteReviewPost($_POST['pid'], $UserID, $dbc);							
								}
								
								if(isset($_GET['edit']) && isset($_GET['pid'])) {
									$errorResults = array();
	                  		if (!$isValid && $postback) {
	                  			array_push($errorResults, 'courseNum');
	                  		}
									
									if ($isValid && $postback) {																								
										// Set the user id
										//$getData = $result->fetch_row();									
										//$UserID = $getData[0];
										$PostID = $_POST['PostID'];
											
										$sql = "UPDATE Review " .
											"SET RecordStatus=2, " .
											"CourseDept='$CourseDept', " .
											"CourseNumber=$CourseNumber, " .
											"Professor='$Professor', " .
											"Workload=$Workload, " .
											"LectureQuality=$LectureQuality, " .
											"TestRelevance=$TestRelevance, " .
											"RelevanceToProgram=$RelevanceToProgram, ".
											"Enjoyable=$Enjoyable, ".
											"BookNecessity=$BookNecessity, ".
											"Overall=$Overall, ".
											"Comments='$Comments' WHERE PostID=$PostID AND UserID=$UserID;";
										//$dbc->setDebug(true);
										$dbc->query($sql);
							
										echo "<h3>Your information has been submitted</h3>";
									}
									else {
										// Get the information about the review from the db
										$pid = $_GET['pid'];
										$qry = "Select * from Review where PostID='$pid'";
										$result = $dbc->query($qry);
										$row = $result->fetch_assoc();

										if(!isset($_POST['courseDept'])) {
											$CourseDept = $row['CourseDept'];
										}
										if(!isset($_POST['courseNumber'])) {
											$CourseNum = $row['CourseNumber'];
										}
										if(!isset($_POST['professor'])) {
											$Professor = $row['Professor'];
										}
										if(!isset($_POST['workload'])) {
											$Workload = $row['Workload'];
										}
										if(!isset($_POST['lectureQuality'])) {
											$LectureQuality = $row['LectureQuality'];
										}
										if(!isset($_POST['testRelevance'])) {
											$TestRelevance = $row['TestRelevance'];
										}
										if(!isset($_POST['relevanceToProgram'])) {
											$RelevanceToProgram = $row['RelevanceToProgram'];
										}
										if(!isset($_POST['enjoyable'])) {
											$Enjoyable = $row['Enjoyable'];
										}
										if(!isset($_POST['bookNecessity'])) {
											$BookNecessity = $row['BookNecessity'];
										}
										if(!isset($_POST['comments'])) {
											$Comments = $row['Comments'];
										}
										$EditReviewForm=new Form;
										echo $EditReviewForm->init('managepostsreviews.php?edit=true&pid=' . $pid,'post',array('class'=>'form-horizontal', 'name'=>'EditReviewForm', 'id'=>'EditReviewForm'))
											->group('Course',
												new Select($dbc->queryPairs('SELECT Abbreviation,Description FROM Department WHERE RowOrder=1 ORDER BY RowOrder,Abbreviation'), $CourseDept, array('class'=>'input-xlarge','name'=>'courseDept', 'id'=>'courseDept')),
												new Text(array('class'=>'input-small','name'=>'courseNumber', 'id'=>'courseNumber', 'value'=>$CourseNum)),
												new Custom(in_array('courseNum',$errorResults) ? '<span class="help-inline"><p class="text-warning">Please enter a valid course number</p></span>' : '')
											)
											->group('Professor',
												new Select($dbc->queryPairs('SELECT Name,Name FROM Professor WHERE RowOrder=1 ORDER BY RowOrder,Name'), $Professor, array('class'=>'input-xlarge','name'=>'professor', 'id'=>'professor'))
											)
											->group('Workload', 
												new Select(array('Light', 'Moderate', 'Heavy'), (int)$WorkloadNum, array('class'=>'input-xlarge', 'name'=>'workload', 'id'=>'workload'))
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
												new Select(array('Absolutely necessary', 'Somewhat necessary', 'Not necessary'), (int)$BookNecessity, array('class'=>'input-xlarge', 'name'=>'bookNecessity', 'id'=>'bookNecessity', 'value'=>$BookNecessity))
											)
											->group('Additional comments',
												new Textarea($Comments, array('class'=>'input-xlarge', 'rows'=>'8', 'name'=>'comments', 'id'=>'comments'))
											)
											->group('',
												new Submit('Submit', array('class' => 'btn btn-primary')),
												new Custom('<a href="managepostsrides.php" class="btn btn-danger">Cancel</a>')
											)
											->group('', 
												new Hidden(array('name'=>'PostID', 'id'=>'PostID', 'value'=>$pid))
											)	
											->group('',
												new Hidden(array('name'=>'postback', 'id'=>'postback', 'value'=>'true'))
											)
											->render();
									}
								}
								else {
									$qry = "SELECT CourseDept, CourseNumber, Professor, Workload, LectureQuality, TestRelevance, RelevanceToProgram, Enjoyable, BookNecessity, Comments, Overall, PostID FROM Review WHERE UserID = $UserID ORDER BY PostID DESC;";
									ManageReviewTable($dbc, $UserID);
								}
							?>					
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
    	var lqscore = <?php echo $LectureQuality; ?>;
    	var trscore = <?php echo $TestRelevance; ?>;
    	var rtpscore = <?php echo $RelevanceToProgram; ?>;
    	var enjscore = <?php echo $Enjoyable; ?>;
    	//defaults were changed in jquery.raty.js and jquery.raty.min.js to half=true, score=2.5, and 
    	////hints=[very poor, poor, fair, good, very good]. Everything else in unchaged.
    	$('#lq').raty({
    		score: lqscore,
    		scoreName: 'lectureQuality', click: function(lectureQuality) {
    			$.post('managepostsreviews.php', {lectureQuality: lectureQuality})
    	}});
    	$('#tr').raty({
    		score: trscore,
    		scoreName: 'testRelevance', click: function(testRelevance) {
    			$.post('managepostsreviews.php', {testRelevance: testRelevance})},
    		hints: ['Very irrelevant to lecture/homework', 'Irrelevant to lecture/homework', 'Neutral', 'Relevant to lecture/homework', 'Very relevant to lecture/homework']
    	});
    	$('#rtp').raty({
    		score: rtpscore,
    		scoreName: 'relevanceToProgram', click: function(relevanceToProgram) {
    			$.post('managepostsreviews.php', {relevanceToProgram: relevanceToProgram})},
    		hints: ['Very irrelevant', 'Irrelevant', 'Neutral', 'Relevant', 'Very relevant']
    	});
    	$('#enj').raty({
    		score: enjscore,
    		scoreName: 'enjoyable', click: function(enjoyable) {
    			$.post('managepostsreviews.php', {enjoyable: enjoyable})},
    		hints: ['Very unenjoyable', 'Unenjoyable', 'Neutral', 'Enjoyable', 'Very enjoyable']
    	});
    });
    </script>
    <script src="bootstrap/validaty/jquery.validaty.js"></script>
    <script src="bootstrap/validaty/jquery.validaty.min.js"></script>
    <script src="bootstrap/validaty/jquery.validaty.validators.js"></script>
</html>

