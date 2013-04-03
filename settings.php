<?php
	require_once('cassettings.php');
	require_once('includes/navbar.php');
	require_once('includes/sidebar.php');
	include_once("../../private_html/connect.php");
?>
<!DOCTYPE HTML>
<html lang-"en">
    <head>
        <title>Western List</title>
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
        <link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
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
							function GetEmail() {
								global $connection;
								$qry = "SELECT Email
											 FROM User
											 WHERE UserID = " .$_SESSION['userID'];
								$result = $connection->query($qry);
								$row = $result->fetch_assoc();
								return $row['Email'];
							}
							
							$emailChanged = false;
							if (isset($_POST['txtEmail'])) {
								global $connection;
								$qry = "UPDATE User
											 SET Email = '{$_POST['txtEmail']}',
												RecordStatus = 2,
												RecordStatusDate = NOW()
											 WHERE UserID = " .$_SESSION['userID'];
								$result = $connection->query($qry);
								unset($_POST['txtEmail']);
							}
							
							echo '
							<h2>General Account Settings</h2><br />
							<table class="table">
								<tr>
										<td><b>Email</b></td><td>';
										echo "<td>";
										echo "<form action='settings.php' method='POST'>";
										echo "<td>" .(isset($_POST['emailEdit']) && !isset($_POST['save'])? "<input type='text'  name='txtEmail' value='" .GetEmail() ."' />" : GetEmail()) ."</td>";
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
        
    </body>
    <script src="holder/holder.js"></script>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="bootstrap/js/bootstrap.js"></script>
</html>

