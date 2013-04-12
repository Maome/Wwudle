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
		<?php DisplayNavbar("professors.php"); ?>
        
        <div class="container">
            <div class="row-fluid">
				<!-- Sidebar -->
				<?php DisplaySidebar(); ?>
                <div class="span9">
                    <div class="row-fluid">
                    <?php ProfessorReviewNav(false); ?>                    
                        <!--<div class="span6">
                            <h2>Professor Review</h2>
                        </div>-->
                    </div>
                    <div class="row-fluid">
                     	<?php
                     		$dbc = new dbw(DBSERVER,DBUSER,DBPASS,DBCATALOG);
						
									$ProfReviewForm=new Form;
									echo $ProfReviewForm->init('','post',array('class'=>'form-horizontal'))
										->group('Professor Name',
											new Select($dbc->queryPairs('SELECT Name,Name FROM Professor WHERE RowOrder=1 ORDER BY RowOrder,Name'),1, array('class'=>'input-large','name'=>'prof'))
										)
										->group('Homework difficulty', 
											new Radio('1', array('name'=>'hw', 'id'=>'hw1'), true),
											new Radio('2', array('name'=>'hw', 'id'=>'hw2'), true),
											new Radio('3', array('name'=>'hw', 'id'=>'hw3', 'checked'), true),
											new Radio('4', array('name'=>'hw', 'id'=>'hw4'), true),
											new Radio('5', array('name'=>'hw', 'id'=>'hw5'), true)
										)
										->group('Test difficulty',
											new Radio('1', array('name'=>'test', 'id'=>'test1'), true),
											new Radio('2', array('name'=>'test', 'id'=>'test2'), true),
											new Radio('3', array('name'=>'test', 'id'=>'test3', 'checked'), true),
											new Radio('4', array('name'=>'test', 'id'=>'test4'), true),
											new Radio('5', array('name'=>'test', 'id'=>'test5'), true)
										)
										->group('Lecture quality',
											new Radio('1', array('name'=>'lec', 'id'=>'lec1'), true),
											new Radio('2', array('name'=>'lec', 'id'=>'lec2'), true),
											new Radio('3', array('name'=>'lec', 'id'=>'lec3', 'checked'), true),
											new Radio('4', array('name'=>'lec', 'id'=>'lec4'), true),
											new Radio('5', array('name'=>'lec', 'id'=>'lec5'), true)
										)
										->group('Additional comments',
											new Textarea()
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
</html>

