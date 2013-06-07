<?php
	require_once('cassettings.php');
	require_once("../../private_html/connect.php");
	require_once('classes/dbw.php');
	// Check if the user is an admin
	$dbc = new dbw(DBSERVER,DBUSER,DBPASS,DBCATALOG);
	$qry = "SELECT SecurityLevel from User where UserName='" . PHPCAS::GetUser() ."';";
	$result = $dbc->query($qry);
	$row = $result->fetch_assoc();
	// if the user is not an admin redirect them to the home page
	if($row['SecurityLevel'] != 0){
	  header("Location: home.php");
	}
	require_once('init.php');
	
	
	if(isset($_GET['delete'])){								
									$dbc = new dbw(DBSERVER,DBUSER,DBPASS,DBCATALOG);
									$qry = "UPDATE Flag " . 
											"SET RecordStatus='3' " .
											"WHERE TableName='" . $_GET['type'] . "'" .
											"AND PostID='" . $_GET['pid'] . "';";
									$dbc->query($qry);	

									$qry = "DELETE FROM " . $_GET['type'] . " " .
											"WHERE PostID='" . $_GET['pid'] . "';";
									$dbc->query($qry);
								}	
?>
<!DOCTYPE HTML>
<html lang-"en">
	<?php /*printHead('Western List');*/ ?>
	<head>
		<link href="bootstrap/css/bootstrap.css" rel="stylesheet">
		<link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
		<link href="bootstrap/css/footer.css" rel="stylesheet">
		<link href="datatables/media/css/bootstrap-dt.css" rel="stylesheet">
		<link href="bootstrap/css/bootstrap-rowlink.css" rel="stylesheet">
		<script type="text/javascript" language="javascript" src="datatables/media/js/jquery.js"></script>
		<script type="text/javascript" language="javascript" src="datatables/media/js/jquery.dataTables.js"></script>
		<script type="text/javascript" language="javascript" src="datatables/media/js/paging.js"></script>
   <script>
			$(document).ready(function() {
				var oTable = $('#table_id').dataTable( {
				    "iDisplayLength": -1,
					"sPaginationType": "bootstrap"
				} );															
			} );
			
		</script>  
	</head>
    <body>

	<div id="wrap">
		<!-- Navbar -->
		<?php DisplayNavbar("adminposts.php"); ?>
		     <div class="container">
		         <div class="row-fluid">
				<!-- Sidebar -->
				<?php DisplaySidebar(); ?>
		             <div class="span9">
		                 <div class="row-fluid">
		                     <div class="span6"><h2>User Posts</h2></div>
		                 </div>
		                 <div class="row-fluid">
							  <table id="table_id" class="table table-striped" data-provides="rowlink">
							<thead>
								<tr>
									 <th>UserName</th>
									 <th>Type</th>
									 <th>UserID</th>
									<th>PostID</th>
									<th>Item</th>
									<th>Edit</th>
								</tr>
							</thead>
							<tbody>
							<?php
								$dbc = new dbw(DBSERVER,DBUSER,DBPASS,DBCATALOG);
								$data = $dbc->query('SELECT u.Username, a.Type, a.UserID, a.PostID, a.ItemID, a.RecordStatus FROM(
		                                                 SELECT "BookListing" AS Type, PostID, UserID, RecordStatus, BookID as ItemID FROM BookListing
		                                                 UNION ALL
		                                                 SELECT "Review" AS Type, PostID, UserID, RecordStatus, Professor as ItemID FROM Review
		                                                 UNION ALL
		                                                 SELECT "RideShare" AS Type, PostID, UserID, RecordStatus, DestCity as ItemID FROM RideShare
		                                              )a JOIN User u ON (u.userID = a.userID) WHERE a.RecordStatus <> 3 ORDER BY UserID;');
								while ($row = $data->fetch_assoc()) {
									echo '
									<tr class="rowlink">
										 <td>' .$row['Username'] .'</td>
										 <td>' .$row['Type'] .'</td>
										 <td>' .$row['UserID'] .'</td>
										<td>' .$row['PostID'] .'</td>
										<td>' .$row['ItemID'] . '</td>';
										
										if(strcmp($row['Type'], "RideShare") == 0){
										$id = "managepostsrides?edit=true&pid=" . $row['PostID'];
									    }
									    if(strcmp($row['Type'], "BookListing") == 0){
										    $id = 'managepostsbooks.php?edit=' . $row['PostID'];
									    }
									    if(strcmp($row['Type'], "Review") == 0){
										    $id = "managepostsreviews?edit=true&pid=" . $row['PostID'];
									    }
										
										
										echo '<td>';
										echo '
										<a class="edit" href="' . $id . '"></a>
										<a href="' . $id .'" class="btn btn-primary">Edit Post</a>
										<a href="?delete=true&type=' . $row['Type'] . '&pid='. $row['PostID'] .'" class="btn btn-danger">Delete Post</a>';
										
					                    /*
										
										echo '<a class="edit" href="';
                                    
                                        if ($row['Type'] === "RideShare")
                                            echo 'managepostsrides.php?edit=true&pid=' . $row['PostID'];
                                        if ($row['Type'] === "ProfessorReview")
                                            echo 'managepostsreviews.php?edit=true&pid=' . $row['PostID'];
                                        if ($row['Type'] === "BookListing")
                                            echo 'managepostsbooks.php?edit=' . $row['PostID'];
                                        //add for prof and book listings when available
                                        echo '"></a></td>
                                        */
                                        echo '</td>
									</tr>';
								}
							?>
							</tbody>
						</table>
						</div>
					</div>
				</div>
			</div>
			<div id="push"></div>
      </div>
    	<?php DisplayFooter(); ?>
    	</body>
    <script src="holder/holder.js"></script>
    <!--<script src="http://code.jquery.com/jquery-latest.js"></script>-->
    <script src="bootstrap/js/bootstrap.js"></script>
    <script src="bootstrap/js/bootstrap-rowlink.js"></script>

</html>


