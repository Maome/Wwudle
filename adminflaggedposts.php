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
					 "fnDrawCallback": function() {				      
						$("#table_id tbody tr").on('click',function() {   
						    var id = $(this).attr('id');
						    document.location.href = id;       
						}); 
				    }							
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
							<table id="table_id" class="table table-striped" data-provides="rowlink">
							<thead>
								<tr class="rowlink">
									<th>UserName</th>
									<th>Table</th>
									<th>Comments</th>
								</tr>
							</thead>
							<tbody>
							<?php
								$dbc = new dbw(DBSERVER,DBUSER,DBPASS,DBCATALOG);
								$data = $dbc->query("select UserName, TableName, PostID, Comments from User inner join Flag On User.UserID=Flag.UserID where Flag.RecordStatus='1';");
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
									echo '
									<tr id="' . $id . '" class="rowlink">
										 <td>' .$row['UserName'] .'</td>
										 <td>' .$row['TableName'] .'</td>
										 <td>' .$row['Comments'] .'</td>                                        
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


