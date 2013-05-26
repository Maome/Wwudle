<?php
	require_once('init.php');
?>
<!DOCTYPE HTML>
<html lang-"en">
    <head>
        <title><?php Woodle(); ?></title>
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
		  <link href="bootstrap/css/datepicker.css" rel="stylesheet">
        <link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
		  <link href="bootstrap/css/bootstrap-modal.css" rel="stylesheet">
        <link href="bootstrap/css/footer.css" rel="stylesheet">
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
								ManagePostsNav(false, true);
								$dbc = new dbw(DBSERVER,DBUSER,DBPASS,DBCATALOG);
								$user = new user($dbc, phpcas::GetUser());

							// Populate a table with the rideshares the user currently has posted
							$qry = "
								SELECT PostID, ISBN, Title, Price, Course 
								FROM Book b 
								JOIN BookListing bl 
								ON (b.BookID=bl.BookID) 
								WHERE bl.UserID=" .dbw::singleQuote($user->getUserID()) ." AND b.RecordStatus <> 3 AND bl.RecordStatus <> 3 
								ORDER BY PostID DESC;";
							$updateQry = "
								UPDATE BookListing SET
								RecordStatus = 2, 
								RecordStatusDate = NOW(),
								Course = '" .$_POST['subject'] ." " .$_POST['course'] ."',
								Price = " .$_POST['price'] ."
								WHERE PostID = " .$_POST['PostID'];
							$dbc->queryToEditableTable($qry,'BookListing','PostID','bookPosts','managepostsbooks.php','testFunction', $updateQry);

							function testFunction($dbc, $id) {
								$qry = 'SELECT Price, Course
								FROM BookListing bl
								WHERE bl.PostID = ' .$id;
								$row = $dbc->querySingleRow($qry);
								
								$form=new Form;							
								echo $form->init('','post',array('class'=>'form-inline'))
									->group('',
										new Select($dbc->queryPairs('SELECT Abbreviation, Description FROM Department ORDER BY RowOrder,Abbreviation'),$_GET['srchDept'], array('class'=>'input-large','name'=>'srchDept')),
										new Text(array('class'=>'input-medium','name'=>'srchCourse','value'=>$_GET['srchCourse'], 'placeholder'=>(empty($_GET['srchCourse']) ? 'Enter course number' : ''))),
										new Submit('Search',array('class'=>'btn btn-primary'))
									)
									->render();
								
								
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
	 <script src="bootstrap/js/bootstrap-modal.js"></script>
	 <script src="bootstrap/js/bootstrap-modalmanager.js"></script>
    <script src="bootstrap/js/bootstrap.js"></script>
</html>

