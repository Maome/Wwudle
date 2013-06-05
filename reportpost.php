<?php
	// Redirect if required parameters not set or they are invalid
	$validPostTypes = array('BookListing','Rideshare','Review');
	if (!((isset($_GET['postID']) && isset($_GET['postType'])) || 
		(isset($_POST['postID']) && isset($_POST['postType']))) ||
		(isset($_GET['postType']) && !in_array($_GET['postType'], $validPostTypes)) ||
		(isset($_POST['postType']) && !in_array($_POST['postType'], $validPostTypes))) {
			header("Location: home.php");
	}
	require_once('init.php');
	require_once('classes/user.php');
	use JasonKaz\FormBuild\Form as Form;
	use JasonKaz\FormBuild\Text as Text;
	use JasonKaz\FormBuild\Submit as Submit;
	use JasonKaz\FormBuild\Textarea as Textarea;
	use JasonKaz\FormBuild\Hidden as Hidden;
	use JasonKaz\FormBuild\Custom as Custom;
?>
<!DOCTYPE HTML>
<html lang-"en">
    <head>
        <title><?php Woodle(); ?></title>
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
        <link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
        <link href="bootstrap/css/footer.css" rel="stylesheet">
		<script src="http://code.jquery.com/jquery-latest.js"></script>
		<script src="holder/holder.js"></script>
		<script src="bootstrap/js/bootstrap.js"></script>
		<script type="text/javascript" language="javascript" src="bootstrap/js/bootstrap-limit.js"></script>
		<script>
			$(document).ready(function() {
				$(".limit").limit();
			});
		</script>
    </head>
    <body>
		
		<!-- Navbar -->
        <div id="wrap">
        	<?php DisplayNavbar(basename(__FILE__)); ?>
		     <div class="container">
		         <div class="row-fluid">
					<!-- Sidebar -->
					<?php DisplaySidebar(); ?>
		             <div class="span6">
						<h2>Report Post to Site Admin</h2>
						<?php
							$dbc = new dbw(DBSERVER,DBUSER,DBPASS,DBCATALOG, true);
							
							if (isset($_GET['postType'])) {							
								if ($_GET['postType'] == 'RideShare') $postDesc = 'ride share';
								else if ($_GET['postType'] == 'BookListing') $postDesc = 'book listing';
								else if ($_GET['postType'] == 'Review') $postDesc = 'review';
								
								echo "What's the issue? If this " .$dbc->configValue('SiteName') ." " .$postDesc ." post does not follow Western policy, please let us know why.";
								
								echo '<div class="row-fluid">&nbsp</div>';
								echo '<section id="limit">';
								$form=new Form;
								echo $form->init('reportpost.php','post',array('class'=>'form-horizontal'))
									->group('',
										new Textarea('', array('class'=>'input-xlarge','name'=>'comments','id'=>'comments', 'rows'=>'8','data-provide'=>"limit",'data-counter'=>'#counter','placeholder'=>'Enter reason here'))
									)
									->group('',
										new Hidden(array('name'=>'postID','value'=>$_GET['postID'])),
										new Hidden(array('name'=>'postType','value'=>$_GET['postType'])),
										new Custom('<em id="counter">150 </em><em> characters remaining&nbsp;&nbsp;</em>'),
										new Submit('Submit', array('class' => 'btn btn-primary'))
									)
									->render();
								echo '</section>';
								
							}
							else if (isset($_POST['postType'])) {
								$rowExists = $dbc->queryUnique($_POST['postType'], 'COUNT(*)', ('RecordStatus <> 3 AND PostID = ' .$_POST['postID']));
								if ($rowExists == 0) {
									echo '<p class="text-error">That post does not exist!</p>';
								}
								else {
									$comments = substr($_POST['comments'],0,150);
									$user = new user($dbc,PHPCAS::GetUser());
									$qry = '
										INSERT INTO Flag
										(TableName, PostID, UserID, Comments, RecordStatus, RecordStatusDate)
										VALUES(' .dbw::singleQuote($_POST['postType']) .',' .$_POST['postID'] .',' .$user->getUserID() .',' .dbw::singleQuote($comments) .',1,NOW())
									';
									$dbc->query($qry);
									echo 'Thank you for your feedback!';
								}
							}
							else {
								// This should never be reached
								echo '<p class="text-error">Error</p>';
							}
						?>
		            </div>
		         </div>
		     </div>
		     <div id="push"></div>
		  </div>
        <?php DisplayFooter(); ?>
    </body>
</html>
