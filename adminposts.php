<?php
	require_once('init.php');
?>
<!DOCTYPE HTML>
<html lang-"en">
	<?php /*printHead('Western List');*/ ?>
	<head>
		<link href="bootstrap/css/bootstrap.css" rel="stylesheet">
		<link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
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


	<!-- Navbar -->
	<?php DisplayNavbar("buysell.php"); ?>
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
							$data = $dbc->query('SELECT u.Username, a.Type, a.UserID, a.PostID, a.ItemID FROM(
                                                    SELECT "BookListing" AS Type, PostID, UserID, BookID as ItemID FROM BookListing
                                                    UNION ALL
                                                    SELECT "ProfessorReview" AS Type, PostID, UserID, Professor as ItemID FROM Review
                                                    UNION ALL
                                                    SELECT "RideShare" AS Type, PostID, UserID, DestCity as ItemID FROM RideShare
                                                 )a JOIN User u ON (u.userID = a.userID) ORDER BY UserID;');
							while ($row = $data->fetch_assoc()) {
								echo '
								<tr class="rowlink">
								    <td>' .$row['Username'] .'</td>
								    <td>' .$row['Type'] .'</td>
								    <td>' .$row['UserID'] .'</td>
									<td>' .$row['PostID'] .'</td>
									<td>' .$row['ItemID'] .'</td>
									<td><a class="edit" href="">Edit</a></td>
								</tr>';
							}
						?>
						</tbody>
					</table>
					</div>
				</div>
			</div>
		</div>
        
    </body>
    <script src="holder/holder.js"></script>
    <!--<script src="http://code.jquery.com/jquery-latest.js"></script>-->
    <script src="bootstrap/js/bootstrap.js"></script>
    <script src="bootstrap/js/bootstrap-rowlink.js"></script>

</html>


