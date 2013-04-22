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
<!DOCTYPE HTML>
<html lang-"en">
    <head>
        <title>Western List</title>
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
        <link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
    </head>
    <body>

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
						
									$ReviewForm=new Form;
									echo $ReviewForm->init('reviewsaddRCV.php','post',array('class'=>'form-horizontal', 'name'=>'reviewForm', 'id'=>'reviewForm'))
										->group('Course',
											new Select($dbc->queryPairs('SELECT Abbreviation,Description FROM Department WHERE RowOrder=1 ORDER BY RowOrder,Abbreviation'), 1, array('class'=>'input-xlarge','name'=>'courseDept', 'id'=>'courseDept')),
											new Text(array('class'=>'input-small','name'=>'courseNumber', 'id'=>'courseNumber', 'placeholder'=>'Course #'))
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
										->render();
                     	?>
                    </div>
                </div>
            </div>
        </div>
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

