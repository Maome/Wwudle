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

								// Get the UserID
								$email = phpcas::GetUser() . "@" .$dbc->configValue('DefaultStudentEmailDomain');
							
								// Display all of the current rides that the user has posted 
								$qry = "SELECT UserID FROM User WHERE Email='$email';";
								$result = $dbc->query($qry);
								$row = $result->fetch_assoc();
								$UserID = $row['UserID'];

							// Populate a table with the rideshares the user currently has posted
							$qry = "
								SELECT PostID, ISBN, Title, Price, Course 
								FROM Book b INNER 
								JOIN BookListing bl ON b.BookID=bl.BookID 
								WHERE bl.UserID='$UserID' AND b.RecordStatus <> 3 AND bl.RecordStatus <> 3 
								ORDER BY PostID DESC;";
							$updateQry = "
								UPDATE BookListing SET
								RecordStatus = 2, RecordStatusDate = NOW(),
								Course = '" .$_POST['subject'] ." " .$_POST['course'] ."',
								Price = " .$_POST['price'] ."
								WHERE PostID = " .$_POST['PostID'];
							$dbc->queryToEditableTable($qry,'BookListing','PostID','bookPosts','managepostsbooks.php','booksmodal.php', $updateQry);											
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

