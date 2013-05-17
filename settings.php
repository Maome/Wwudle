<?php
	require_once('init.php');
	require_once('classes/user.php');
?>
<!DOCTYPE HTML>
<html lang-"en">
    <head>
        <title><?php Woodle(); ?></title>
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
        <link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
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
							
								$dbc = new dbw(DBSERVER,DBUSER,DBPASS,DBCATALOG);
								$user = new user($dbc,phpCAS::getUser());
								$emailChanged = false;

								if (isset($_POST['txtEmail'])) {
									$user->setEmail($_POST['txtEmail']);
									unset($_POST['txtEmail']);
								}
							
								echo '
								<h2>General Account Settings</h2><br />
								<table class="table">
									<tr>
											<td><b>Email</b></td><td>';
											echo "<td>";
											echo "<form action='settings.php' method='POST'>";
											echo "<td>" .(isset($_POST['emailEdit']) && !isset($_POST['save'])? "<input type='text'  name='txtEmail' value='" .$user->getEmail() ."' />" : $user->getEmail()) ."</td>";
											echo "<td>" .(isset($_POST['emailEdit'])? "<input type='submit' name = 'save' value='Save' />" : "<input type='submit' name = 'emailEdit' value='Edit' />") ."</td>";
											echo "</form>";
											echo "</td>";								
								echo '							
									</tr>
								</table>';
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
    <script src="bootstrap/js/bootstrap.js"></script>
</html>

