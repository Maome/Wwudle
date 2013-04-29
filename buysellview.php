<?php
	// Redirect if no postID parameter set
	if (empty($_GET['postID'])) {
		header("Location: buysell.php");
	}
	require_once('buysellfunctions.php');
	use JasonKaz\FormBuild\Form as Form;
	use JasonKaz\FormBuild\Text as Text;
	use JasonKaz\FormBuild\Help as Help;
	use JasonKaz\FormBuild\Checkbox as Checkbox;
	use JasonKaz\FormBuild\Submit as Submit;
	use JasonKaz\FormBuild\Password as Password;
	use JasonKaz\FormBuild\Select as Select;
	use JasonKaz\FormBuild\Radio as Radio;			
	use JasonKaz\FormBuild\Button as Button;		
	use JasonKaz\FormBuild\Reset as Reset;
	use JasonKaz\FormBuild\Custom as Custom;
	use JasonKaz\FormBuild\Textarea as Textarea;
	use JasonKaz\FormBuild\Hidden as Hidden;
	use JasonKaz\FormBuild\Email as Email;
?>
<!DOCTYPE HTML>
<html lang-"en">
    <head>
        <title>Western List</title>
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
        <link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
        <link href="bootstrap/css/bootstrap-rowlink.css" rel="stylesheet">
		<link href="datatables/media/css/bootstrap-dt.css" rel="stylesheet">     
		<script type="text/javascript" language="javascript" src="datatables/media/js/jquery.js"></script>
		<script type="text/javascript" language="javascript" src="datatables/media/js/jquery.dataTables.js"></script>
		<script type="text/javascript" language="javascript" src="datatables/media/js/paging.js"></script>
    </head>
    <body>

		<!-- Navbar -->
		<?php DisplayNavbar(basename(__FILE__)); ?>
        
        <div class="container">
            <div class="row-fluid">
				<!-- Sidebar -->
				<?php DisplaySidebar(); ?>
                <div class="span9">
                    <div class="row-fluid">
						<?php
							BuySellReviewNav(true);
							echo '<div class="row-fluid">';
							$dbc = new dbw(DBSERVER,DBUSER,DBPASS,DBCATALOG);
							$post = $dbc->querySingleRow('SELECT bl.*, b.* FROM BookListing bl JOIN Book b ON (b.BookID = bl.BookID) WHERE bl.PostID = ' .$_GET['postID'], true);							
							echo '<h4>' .$post['Title'] .'</h4>';	
							echo '</div>';
							
							echo '<div class="row-fluid">';
							echo '<table id="' .$name .'" class="table table-striped">';
							echo '<tbody>';
								while($row = $result->fetch_array()) {
									echo '<tr>' .PHP_EOL;
									for($i = 0; $i < $result->field_count; $i++) {
										echo '<td>' .$row[$i] .'</td>';
									}
									echo '</tr>' .PHP_EOL;
								}
							echo '</tbody>';
							echo '</table>';
							echo '</div>';
						?>
                    </div>
                </div>
            </div>
        </div>
        
    </body>
    <script src="holder/holder.js"></script>
    <script src="bootstrap/js/bootstrap.js"></script>    
    <script src="bootstrap/js/bootstrap-rowlink.js"></script>
</html>