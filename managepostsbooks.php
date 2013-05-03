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
    </head>
    <body>
		
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
							$email = phpcas::GetUser() . "@students.wwu.edu";
							
							// Display all of the current rides that the user has posted 
							$qry = "SELECT UserID FROM User WHERE Email='$email';";
							$result = $dbc->query($qry);
							$row = $result->fetch_assoc();
							$UserID = $row['UserID'];

							// Populate a table with the rideshares the user currently has posted
							$qry = "SELECT ISBN, Title, Price FROM Book b INNER JOIN BookListing bl ON b.BookID=bl.BookID WHERE bl.UserID='$UserID' ORDER BY PostID DESC;";
							$dbc->queryToEditableTable($qry,'bookPosts',0,'managepostsbooks.php');
							include('ridesharemodal.php');
							/*$result = $dbc->query($qry);
							$row = $result->fetch_assoc();														

							if ($result->num_rows > 0) {
								$fields = array("Title", "ISBN", "Price");
								echo "<table class='table table-striped'>";
									// Display header
									echo "<thead>";
										foreach ($fields as $i) echo "<th>" .$i ."</th>";
									echo "</thead><tbody>";
									
									// Display rows
									while ($row = $result->fetch_assoc()) {
										echo "<tr>";
											foreach ($fields as $i){
												echo "<td>" .$row[$i] ."</td>";
											}
										echo "</tr>";
									}
									echo "</tbody></table>";
							}
							else echo "You currently have no books posted";*/												
						?>
                </div>
            </div>
        </div>
        
    </body>
    <script src="holder/holder.js"></script>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
	 <script src="bootstrap/js/bootstrap-modal.js"></script>
	 <script src="bootstrap/js/bootstrap-modalmanager.js"></script>
    <script src="bootstrap/js/bootstrap.js"></script>
</html>

