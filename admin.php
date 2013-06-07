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
	</head>
    <body>

	<div id="wrap">
		<!-- Navbar -->
		<?php DisplayNavbar("admin.php"); ?>
		     <div class="container">
		         <div class="row-fluid">
				<!-- Sidebar -->
				<?php DisplaySidebar(); ?>
		             <div class="span9">
		                 <div class="row-fluid">
		                     <div class="span6"><h2>Admin Control Panel</h2></div>
		                 </div>
		                 <div class="row-fluid">
                            
                            <?php //content?>
                            <table id='admin_options' class='table table-striped' data-provides="rowlink">
                            <thead>
                                <tr>
                                    <th>Action</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="rowlink">
                                    <td>Site Settings</td><td>Manage site settings including Name, Sidebar Links
                                        <a class="edit" href="adminsettings.php"></a></td>
                                </tr>
                                <tr class="rowlink">
                                    <td>Manage User Posts</td><td>Search, edit, and delete posts from any user
                                        <a class="edit" href="adminposts.php"></a></td>
                                </tr>
                                <tr class="rowlink">
                                    <td>Manage Flagged Posts</td><td>Search, edit, and delete flagged posts
                                        <a class="edit" href="adminflaggedposts.php"></a></td>
                                </tr>                                
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


