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
		<?php DisplayNavbar("courses.php"); ?>
        
        <div class="container">
            <div class="row-fluid">
				<!-- Sidebar -->
				<?php DisplaySidebar(); ?>
                <div class="span9">
                    <div class="row-fluid">
                    <?php CourseReviewNav(false) ?>
                        <!--<div class="span6">
                            <h2>Course Review</h2>
                        </div>-->
                    </div>
                    <div class="row-fluid">    
                      
                    <div id="star"></div>              
                    
                     	<?php
                     		$dbc = new dbw(DBSERVER,DBUSER,DBPASS,DBCATALOG);
						
									$CourseReviewForm=new Form;
									echo $CourseReviewForm->init('','post',array('class'=>'form-horizontal'))
										->group('Course',
											new Select($dbc->queryPairs('SELECT Abbreviation,Description FROM Department WHERE RowOrder=1 ORDER BY RowOrder,Abbreviation'),1, array('class'=>'input-large','name'=>'dept')),
											new Text(array('class'=>'input-medium','name'=>'course', 'placeholder'=>'Enter course number'))
										)
										->group('Usefulness', 
											new Radio('1', array('name'=>'use', 'id'=>'use1'), true),
											new Radio('2', array('name'=>'use', 'id'=>'use2'), true),
											new Radio('3', array('name'=>'use', 'id'=>'use3', 'checked'), true),
											new Radio('4', array('name'=>'use', 'id'=>'use4'), true),
											new Radio('5', array('name'=>'use', 'id'=>'use5'), true)
										)
										->group('Quality of content',
											new Radio('1', array('name'=>'cq', 'id'=>'cq1'), true),
											new Radio('2', array('name'=>'cq', 'id'=>'cq2'), true),
											new Radio('3', array('name'=>'cq', 'id'=>'cq3', 'checked'), true),
											new Radio('4', array('name'=>'cq', 'id'=>'cq4'), true),
											new Radio('5', array('name'=>'cq', 'id'=>'cq5'), true)
										)
										->group('Relevance to program',
											new Radio('1', array('name'=>'rel', 'id'=>'rel1'), true),
											new Radio('2', array('name'=>'rel', 'id'=>'rel2'), true),
											new Radio('3', array('name'=>'rel', 'id'=>'rel3', 'checked'), true),
											new Radio('4', array('name'=>'rel', 'id'=>'rel4'), true),
											new Radio('5', array('name'=>'rel', 'id'=>'rel5'), true)
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
    <script src="bootstrap/raty/jquery.raty.js"></script>    
    <script src="bootstrap/raty/jquery.raty.min.js"></script>
    <script>
     $(function() {
    	$.fn.raty.defaults.path = 'bootstrap/raty/img';
    	$('#star').raty({ half: true });
    });
    </script>
</html>

