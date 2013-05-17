<?php
	require_once('init.php');
	require_once('ridesharefunctions.php');

	$source = $_GET['from'];
	$destination = $_GET['to'];	
	$departingDate = $_GET['departingDate'];
	$returningDate = $_GET['returningDate'];
	$maxPrice = $_GET['maxPrice'];
	$ridesAlongTheWay = $_GET['ridesAlongTheWay'];	
?>
<!DOCTYPE HTML>
<html lang="en">
    <head>
		<title><?php Woodle(); ?></title>
		<link href="bootstrap/css/bootstrap.css" rel="stylesheet">
		<link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
		<link href="bootstrap/css/bootstrap-rowlink.css" rel="stylesheet">
		<link href="bootstrap/css/footer.css" rel="stylesheet">
		<link href="datatables/media/css/bootstrap-dt.css" rel="stylesheet">     
        <link href="bootstrap/css/datepicker.css" rel="stylesheet">
		<script type="text/javascript" language="javascript" src="datatables/media/js/jquery.js"></script>
		<script type="text/javascript" language="javascript" src="datatables/media/js/jquery.dataTables.js"></script>
		<script type="text/javascript" language="javascript" src="datatables/media/js/paging.js"></script>
		<script>
			// Pagination for the rideshare table
			$(document).ready(function() {
				var oTable = $('#table_id').dataTable( {
					"sPaginationType": "bootstrap",
					 "fnDrawCallback": function() {				      
						$("#table_id tbody tr").on('click',function() {   
						    var id = $(this).attr('id');
						    document.location.href = "rideinfo?PostID=" + id;       
						}); 
				    }							
				});													
			});
			
			// Toggles on/off the advanced search
			$(document).ready(function() {
				$("#advancedSearch").hide();
				
				$("#advSearchBtn").click(function(e){					
					$("#advancedSearch").toggle();
				});
			});						
		</script> 
        <script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places" type="text/javascript"></script>
        <script type="text/javascript">
		   	function initialize() {
			   	var options = {
				  types: ['(cities)'],
				  componentRestrictions: {country: "us"},				  
				};				
		      	var departInput = document.getElementById('from');
		      	var autocomplete = new google.maps.places.Autocomplete(departInput, options);
		      	
		      	var destInput = document.getElementById('to');
		      	var autocomplete = new google.maps.places.Autocomplete(destInput, options);
		      	
		   }
		   google.maps.event.addDomListener(window, 'load', initialize);
		</script> 
		<style>
			.tableAdvSearch td{	
				border-top:0px;
			}			
		</style>
		       
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
		                 <div class="row-fluid">
							<?php RideshareNav(true); ?>                        		                     
		                 </div>		     
		                             
		                 <button id="advSearchBtn" class="btn btn-primary">Advanced Search</button>
		                <a class="btn btn-primary" href="rideshare.php">Reset Search</a>
		                 
			             <div class="row-fluid">
			             	<div class="span9">		                 
		                 		<div id="advancedSearch">	
			                    	<form class="offset1 form-inline" action="rideshare.php" method="get">
			                    		<input type="hidden" name="search" value="true"/>
			                        	<table class='table tableAdvSearch'>
			                        		<tbody>
			                        		<tr>
					                        	<td><label class="control-label" for="to">Departing </label></td>
					                        	<td><input id="departingDate" name="departingDate" type="text" data-date-format="mm/dd/yyyy" class="datepicker input-medium" <?php if(isset($_GET['departingDate'])){echo "value='$departingDate'"; } else {echo "placeholder='Departing'";} ?>></td>
					                        	<td><label class="control-label" for="from">Leaving From </label></td>
												<td><input class="input-medium" type="text" name="from" id="from" <?php if(isset($_GET['from'])){echo "value='$source'"; } else {echo "placeholder='Leaving From'";} ?>></td>
				                        	</tr>
				                        	<tr>
												<td><label class="control-label" for="to">Returning </label></td>
												<td><input id="returningDate" name="returningDate" type="text"  data-date-format="mm/dd/yyyy" class="datepicker input-medium" <?php if(isset($_GET['returningDate'])){echo "value='$returningDate'"; } else {echo "placeholder='Returning'";} ?>></td>											
												<td><label class="control-label" for="to">Going To </label></td>
												<td><input class="input-medium" type="text" name="to" id="to" <?php if(isset($_GET['to'])){echo "value='$destination'"; } else {echo "placeholder='Going To'";} ?>></td>
				                        	</tr>
				                        	<tr>											
												<td><label class="control-label" for="to">Max Price </label></td>
												<td><input class="input-medium" type="text" name="maxPrice" id="maxPrice" <?php if(isset($_GET['maxPrice'])){echo "value='$maxPrice'"; } else {echo "placeholder='Max Price'";} ?>></td>	
												<td style="text-align: right;"><input type="checkbox" name="ridesAlongTheWay" <?php if($ridesAlongTheWay){echo "checked='checked'";} ?> value="true"></td>
												<td>Include rides along the way*</td>
											</tr>
											<tr>
				                            	<td><button type="submit" class="btn btn-primary">Search</button></td>
				                            </tr>
				                            </tbody>
			                            </table>
			                            * Note that this option is only available for those travelling along the i5 in Washington
			                        </form>
			                     </div>
			                 </div>		                 	                 			                 		    
		                 </div>
		                 <?php
							// Check to see if we are doing a search or not																												
							if(isset($_GET['search'])){
								ShowRides(true, $source, $destination, $departingDate, $returningDate, $maxPrice, $ridesAlongTheWay);			                 
							}
							else{						
		                 		// Show the most resent ride shares posted 
								ShowRides(false, null, null, null, null, null, null);
							}
		                 ?>
		             </div>
		         </div>
		     </div>
        </div>
    	<?php DisplayFooter(); ?>
    </body>
    <script src="holder/holder.js"></script>
    <!--<script src="http://code.jquery.com/jquery-latest.js"></script>-->
    <script src="bootstrap/js/bootstrap.js"></script>    
    <script src="bootstrap/js/bootstrap-rowlink.js"></script>
    <script src="bootstrap/js/bootstrap-datepicker.js"></script>
    <script>$('.datepicker').datepicker();</script>    
</html>

