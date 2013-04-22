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
		<?php DisplayNavbar(basename(__FILE__)); ?>
        
        <div class="container">
            <div class="row-fluid">
				<!-- Sidebar -->
				<?php DisplaySidebar(); ?>
                <div class="span9">
                    <div class="row-fluid">
                    <?php ReviewNav(true) ?>
                    </div>
                    <div class="row-fluid">
                        <?php
                     		$dbc = new dbw(DBSERVER,DBUSER,DBPASS,DBCATALOG);
                     		echo '<h4>Find reviews by course</h4>';
                     		$ReviewSearchCourseForm=new Form;
									echo $ReviewSearchCourseForm->init('reviewsSearchCourse.php','post',array('class'=>'form-inline', 'name'=>'reviewSearchCourseForm', 'id'=>'reviewSearchCourseForm'))
										->group('',
											new Select($dbc->queryPairs('SELECT Abbreviation,Description FROM Department ORDER BY RowOrder,Abbreviation'), 1, array('class'=>'input-xlarge','name'=>'courseDept', 'id'=>'courseDept')),
											new Text(array('class'=>'input-small','name'=>'courseNumber', 'id'=>'courseNumber', 'placeholder'=>'Course #')),
											new Submit('Search',array('class'=>'btn btn-primary'))
										)
										->render();
									echo '<b>OR</b>';
									echo '<h4>Find reviews by professor</h4>';
									$ReviewSearchProfForm=new Form;
									echo $ReviewSearchProfForm->init('reviewsSearchProf.php','post',array('class'=>'form-inline', 'name'=>'reviewSearchProfForm', 'id'=>'reviewSearchProfForm'))
										->group('',
											new Select($dbc->queryPairs('SELECT Name,Name FROM Professor ORDER BY RowOrder,Name'),1, array('class'=>'input-xlarge','name'=>'searchProf', 'id'=>'searchProf')),
											new Submit('Search',array('class'=>'btn btn-primary'))
										)
										->render();
								?>
                    </div>
                    <div class="row-fluid">
		                 <?php
							
								if (isset($_GET['searchProf'])) {
									displayReviews();
								}
								else if (isset($_GET['courseDept']) && isset($_GET['courseNumber'])) {
									displayReviews();
								}
								else if (isset($_POST['courseDept'])) {
									displayReviews();
								}
							?>
						</div>
                </div>
            </div>
        </div>
    </body>
    <script src="holder/holder.js"></script>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="bootstrap/js/bootstrap.js"></script>
</html>

