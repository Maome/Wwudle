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
							echo '<div class="span9">';
							echo '<div class="row-fluid">';
							$dbc = new dbw(DBSERVER,DBUSER,DBPASS,DBCATALOG);
							$post = $dbc->querySingleRow(
								'SELECT DATE_FORMAT(bl.PostDate, "%m/%d/%Y %h:%m %p") "Post Date", b.ISBN, b.Title, b.Authors, b.Edition, bl.Course, bl.Price
								FROM BookListing bl 
								JOIN Book b 
								ON (b.BookID = bl.BookID) 
								WHERE bl.PostID = ' .$_GET['postID'], 
							true);							
							echo '<h4>' .$post['Title'] .'</h4>';	
							echo '</div>';
							
							// Display book listing information
							echo '<div class="row-fluid">';
							echo '<table id="' .$name .'" class="table table-striped">';
							echo '<tbody>';
								foreach ($post as $key => $value) {
									if (!empty($value)) {
										echo '<tr>' .PHP_EOL;
										echo '<td><b>' .$key .'</b></td>';
										echo '<td>' .$value .'</td>';
										echo '</tr>' .PHP_EOL;
									}
								}
							echo '</tbody>';
							echo '</table>';
							echo '</div>';
							
							// Display book request box
							echo "																												
							<form class='form-inline' action='buysellview.php' method='post'>
								<div class='control-group'>
									<label class='control-label' for='Subject'>Subject</label>
									<input class='field span12' type='text' name='Subject' id='Subject' value='Western List Book Sale for " .$post['Title'] ."'> <br /><br />
									<label class='control-label' for='MessageBody'>Message</label>
									<textarea class='field span12' rows='10' placeholder='Type your message here' name='MessageBody' id='MessageBody'></textarea><br /><br />
									<input type='hidden' name='PostID' value='$PostID'>
									<button type='submit' class='btn btn-primary'>Offer Purchase</button>
								</div>
							</form>																	
						";
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