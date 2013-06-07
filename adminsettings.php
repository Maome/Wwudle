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
	
	
	//$dbc = new dbw(DBSERVER,DBUSER,DBPASS,DBCATALOG);
	
	
	if( isset($_GET["delete"])){
	    //delete teh post yo
	    $deletequery = "DELETE FROM HyperLink WHERE HyperlinkID=" . $_GET["id"] . ";";
	    $dbc->query($deletequery);
	}
	if( isset($_GET["update"])){
	    // update the post yo
	    $updatequery = "UPDATE HyperLink
	                    SET LinkType=1, URL='" . $_GET["URL"] . "', Text='" . $_GET["Text"] . "' , Position=" . $_GET["Position"] . ", ChangeSource=1, RecordStatus=1, RecordStatusDate=1
	                    WHERE HyperlinkID=" . $_GET["id"] . ";";
	    $dbc->query($updatequery);
	}
	if( isset($_GET["new"])){
	    //new!
	    $newquery = "INSERT INTO HyperLink
	                    (LinkType, URL, Text, Position, ChangeSource, RecordStatus, RecordStatusDate)
	                    VALUES (1,'" . $_GET["URL"] . "' , '" . $_GET["Text"] . "' , '" . $_GET["Position"] . "' , 1, 1, 1);";
	    $dbc->query($newquery);
	}
	
	
	
?>
<!DOCTYPE HTML>
<html lang-"en">
	<?php printHead('Wwudle'); ?>
	<head>
		<link href="bootstrap/css/bootstrap.css" rel="stylesheet">
		<link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
		<link href="bootstrap/css/footer.css" rel="stylesheet">
		<link href="datatables/media/css/bootstrap-dt.css" rel="stylesheet">
		<script type="text/javascript" language="javascript" src="datatables/media/js/jquery.js"></script>
		<script type="text/javascript" language="javascript" src="datatables/media/js/jquery.dataTables.js"></script>
		<script type="text/javascript" language="javascript" src="datatables/media/js/paging.js"></script>
		<script>
		

			$(document).ready(function() {
				var oTable = $('#table_id').dataTable( {
					"sPaginationType": "bootstrap",
					"bSort": false
				} );
			} );
		</script>
	</head>
    <body>

       <!-- Modal -->
        <div id="loginModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-body">
                <p>Oops I'm broken..</p>
            </div>
        </div>
	<div id="wrap">
		<!-- Navbar -->
		<?php DisplayNavbar("adminsettings.php"); ?>
		     <div class="container">
		         <div class="row-fluid">
				<!-- Sidebar -->
				<?php DisplaySidebar(); ?>
		             <div class="span9">
		                 <div class="row-fluid">
		                     <div class="span6"><h2>Site Settings</h2></div>
		                 </div>
		                 <div class="row-fluid">
						<?php
						
						$query = "SELECT * FROM HyperLink WHERE RecordStatus=1";
						$data = $dbc->query($query);
						
						echo '<table id="table_id" class="table table-striped" data-provides="rowlink">';
						
						while ($row = $data->fetch_assoc()) {
						    echo '  <tr>';
						    echo '  <form>';
						    echo '  <input type="hidden" value="true" name="update">';
						    echo '  <input type="hidden" value="' . $row["HyperlinkID"] . '" name="id">';
						    echo '  <td><input name="URL" value="' . $row["URL"] . '"></td>
						            <td><input name="Text" value="' . $row["Text"] . '"></td>
						            <td><input name="Position" value="'. $row["Position"] . '"></td>
						            <td><input type="submit" value="Save" class="btn btn-submit">
						            <a href="?delete=true&id=' . $row["HyperlinkID"] . '" class="btn btn-danger">Delete</a>';	
						    echo '  </form>';
						    echo '  </tr>';			
						    }	 
						    
						echo '  <form>';
						echo '  <input type="hidden" name="new" value="true">';
						echo '  <td><input name="URL" value=""></td>
						        <td><input name="Text" value=""></td>
						        <td><input name="Position" value=""></td>
						        <td><input type="submit" value="Add" class="btn btn-submit"></td>';
						        
						echo '</table>';      
						//$dbc->queryToTable('SELECT Abbreviation, Description FROM Department ORDER BY Description','table_id');
						?>
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
</html>


