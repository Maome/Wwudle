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
											new Select($dbc->queryPairs('SELECT Name,Name FROM Professor WHERE RowOrder=1 ORDER BY RowOrder,Name'),1, array('class'=>'input-xlarge','name'=>'prof'))
										)
										->group('Homework difficulty', 
											new Star('hwd')
										)
										->group('Test difficulty',
											new Star('td')
										)
										->group('Lecture quality',
											new Star('lq')
										)
										->group('Additional comments',
											new Textarea('', array('class'=>'input-xlarge', 'rows'=>'8'))
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
    	$('#hwd').raty({ half: true, score: 2.5 });
    	$('#td').raty({ half: true, score: 2.5  });
    	$('#lq').raty({ half: true, score: 2.5  });
     });
    </script>
</html>

