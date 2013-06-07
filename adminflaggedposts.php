<?php
	require_once('init.php');
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
					"sPaginationType": "bootstrap",							
				});													
			});
			
		</script>  
	</head>
    <body>

	<div id="wrap">
		<!-- Navbar -->
		<?php DisplayNavbar("adminflaggedposts.php"); ?>
		     <div class="container">
		         <div class="row-fluid">
				<!-- Sidebar -->
				<?php DisplaySidebar(); ?>
		             <div class="span9">
		                 <div class="row-fluid">
		                     <div class="span6"><h2>Flagged Posts</h2></div>
		                 </div>
		                 <div class="row-fluid">
							<table id="table_id" class="table table-striped">
							<thead>
								<tr class="rowlink">
									<th>UserName</th>
									<th>Table</th>
									<th>Comments</th>
									<th>Edit</th>
								</tr>
							</thead>
							<tbody>
							<?php
								// Check if they are deleting a post
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
								
								
								// Check if a flag is being removed
								if(isset($_GET['removeFlag'])){								
									$dbc = new dbw(DBSERVER,DBUSER,DBPASS,DBCATALOG);
									$qry = "UPDATE Flag " . 
											"SET RecordStatus='3' " .
											"WHERE TableName='" . $_GET['type'] . "'" .
											"AND PostID='" . $_GET['pid'] . "';";
									$dbc->query($qry);									
								}
							
							
								$dbc = new dbw(DBSERVER,DBUSER,DBPASS,DBCATALOG);
								$data = $dbc->query("select UserName, TableName, PostID, Comments from User inner join Flag On User.UserID=Flag.UserID where Flag.RecordStatus='1' OR Flag.RecordStatus='2';");
								while ($row = $data->fetch_assoc()) {
									// Get the url									
									if(strcmp($row['TableName'], "RideShare") == 0){
										$id = "managepostsrides?edit=true&pid=" . $row['PostID'];
									}
									if(strcmp($row['TableName'], "BookListing") == 0){
										$id = 'managepostsbooks.php?edit=' . $row['PostID'];
									}
									if(strcmp($row['TableName'], "Review") == 0){
										$id = "managepostsreviews?edit=true&pid=" . $row['PostID'];
									}
									$cmt = FixComment($row['Comments']);
									echo '
									<tr>
										 <td>' .$row['UserName'] .'</td>
										 <td>' .$row['TableName'] .'</td>
										 <td>' . $cmt .'</td>
										 <td>
											<a href="' . $id .'" class="btn btn-primary">Edit Post</a>
										    <a href="?delete=true&type=' . $row['TableName'] . '&pid='. $row['PostID'] .'" class="btn btn-danger">Delete Post</a>
											<a href="?removeFlag=true&type=' . $row['TableName'] . '&pid='. $row['PostID'] .'" class="btn btn-warning">Remove Flag</a>										
									</tr>';
								}
								
								
								// break up long comments every 20 words
								function FixComment($comment){
									$fixedComment = "";
									$words = explode(" ", $comment);
									for ($i=0; $i<sizeof($words); $i++){
										if($i % 20 == 0 && $i!=0){
											$fixedComment .= "</br>";
										}
										$fixedComment .= " " . $words[$i];
										
									}
									return $fixedComment;
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


