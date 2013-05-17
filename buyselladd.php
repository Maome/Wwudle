<?php
	require_once('init.php');
	require_once('classes/book.php');
	require_once('buysellfunctions.php');
	
	use JasonKaz\FormBuild\Form as Form;
	use JasonKaz\FormBuild\Text as Text;
	use JasonKaz\FormBuild\Submit as Submit;
	use JasonKaz\FormBuild\Password as Password;
	use JasonKaz\FormBuild\Select as Select;	
	use JasonKaz\FormBuild\Reset as Reset;
	use JasonKaz\FormBuild\Custom as Custom;
	use JasonKaz\FormBuild\Textarea as Textarea;
	use JasonKaz\FormBuild\Hidden as Hidden;

?>
<!DOCTYPE HTML>
<html lang-"en">
	<?php printHead('Wwudle'); ?>
	<style type = "text/css">
		.bookImg {
			float: left;
			overflow: hidden;
		}
		.bookForm {
			float: left;
		}
	</style>
    <body>
		<div id="wrap">
			<!-- Navbar -->
			<?php DisplayNavbar("buysell.php"); ?>
				  <div class="container">
				      <div class="row-fluid">
					<!-- Sidebar -->
					<?php DisplaySidebar(); ?>
				          <div class="span9">
				              <div class="row-fluid">
				          	<?php BuySellReviewNav(false) ?>                  
				                  <!--<div class="span6"><h2>Sell a Textbook</h2></div>-->
				              </div>
				              <div class="row-fluid">
									<?php
										// Book search form
										$Form=new Form;
										echo '<h4>Find a textbook by ISBN or title</h4>';
										echo $Form->init('buyselladd.php','get',array('class'=>'form-inline'))
											->group('',
												new Text(array('class'=>'input-large','name'=>'srchText','placeholder'=>'Enter ISBN')),
												new Submit('Search',array('class'=>'btn btn-primary'))
											)
											->render();

									  $dbc = new dbw(DBSERVER,DBUSER,DBPASS,DBCATALOG);

									  // Display book informationm if user is not posting a book listing and search text is not empty
									  if (!empty($_GET['srchText']) && !isset($_POST['isbn'])) {
										$isbn = str_replace('-','',$_GET['srchText']);
										 displayBookList($dbc, $isbn);
									  }

									  // Create a book listing
									  if (isset($_POST['isbn'])) {
											postBookListing($dbc, $_POST['isbn'],$_POST['title'], $_POST['authors']);
									  }
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
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="bootstrap/js/bootstrap.js"></script>
</html>

