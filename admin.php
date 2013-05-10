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
		<script type="text/javascript" language="javascript" src="datatables/media/js/jquery.js"></script>
		<script type="text/javascript" language="javascript" src="datatables/media/js/jquery.dataTables.js"></script>
		<script type="text/javascript" language="javascript" src="datatables/media/js/paging.js"></script>
		<script>
		
			function editRow ( oTable, nRow )
			{
				var aData = oTable.fnGetData(nRow);
				var jqTds = $('>td', nRow);
				jqTds[0].innerHTML = '<input type="text" value="'+aData[0]+'">';
				jqTds[1].innerHTML = '<input type="text" value="'+aData[1]+'">';
				jqTds[2].innerHTML = '<a class="edit" href="">Save</a>';
			}
			
			function saveRow ( oTable, nRow )
			{
				var jqInputs = $('input', nRow);
				oTable.fnUpdate( jqInputs[0].value, nRow, 0, false );
				oTable.fnUpdate( jqInputs[1].value, nRow, 1, false );
				oTable.fnUpdate( '<a class="edit" href="">Edit</a>', nRow, 2, false );
				oTable.fnDraw();
			}
			
			$(document).ready(function() {
				
				/*$("#table_id tr").click(function(event) {
					if ($(event.target.parentNode).hasClass('table_highlight'))
						$(event.target.parentNode).removeClass('table_highlight');
					else
						$(event.target.parentNode).addClass('table_highlight');
				});*/
			
				var oTable = $('#table_id').dataTable( {
					"sPaginationType": "bootstrap",
					"bSort": false
				} );
				
				    var nEditing = null;
     
				$('#table_id a.edit').live('click', function (e) {
					
					e.preventDefault();
					 
					/* Get the row as a parent of the link that was clicked on */
					var nRow = $(this).parents('tr')[0];
					 
					if ( nEditing !== null && nEditing != nRow ) {
						/* A different row is being edited - the edit should be cancelled and this row edited */
						restoreRow( oTable, nEditing );
						editRow( oTable, nRow );
						nEditing = nRow;
					}
					else if ( nEditing == nRow && this.innerHTML == "Save" ) {
						/* This row is being edited and should be saved */
						saveRow( oTable, nEditing );
						nEditing = null;
					}
					else {
						/* No row currently being edited */
						editRow( oTable, nRow );
						nEditing = nRow;
					}
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
		<?php DisplayNavbar("buysell.php"); ?>
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
							/*echo '
							<table id="table_id" class="table">
							<thead>
								<tr>
									<th>Abbreviation</th>
									<th>Description</th>
									<!--<th>Edit</th>-->
								</tr>
							</thead>
							<tbody>';
								$dbc = new dbw(DBSERVER,DBUSER,DBPASS,DBCATALOG);
								$data = $dbc->query('SELECT Abbreviation, Description FROM Department ORDER BY Description');
								while ($row = $data->fetch_assoc()) {
									echo '
									<tr>
										<td>' .$row['Abbreviation'] .'</td>
										<td>' .$row['Description'] .'</td>';
										//<td><a class="edit" href="">Edit</a></td>
									echo '</tr>';
								}
						echo '
							</tbody>
						</table>';*/
						$dbc = new dbw(DBSERVER,DBUSER,DBPASS,DBCATALOG);
						$dbc->queryToTable('SELECT Abbreviation, Description FROM Department ORDER BY Description','table_id');
						?>
						</div>
					</div>
				</div>
			</div>
    </div>
    <?php DisplayFooter(); ?>
    </body>
    <script src="holder/holder.js"></script>
    <!--<script src="http://code.jquery.com/jquery-latest.js"></script>-->
    <script src="bootstrap/js/bootstrap.js"></script>
</html>


