<?php
	require_once('init.php');
	require_once('classes/book.php');
	require_once('buysellfunctions.php');
	
	use JasonKaz\FormBuild\Form as Form;
	use JasonKaz\FormBuild\Text as Text;
	use JasonKaz\FormBuild\Submit as Submit;
	use JasonKaz\FormBuild\Select as Select;	
	use JasonKaz\FormBuild\Custom as Custom;
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
				              </div>
				              <div class="row-fluid">
									<?php
										
										// Get errors if this has been called via get or post
										$submitErrors = utils::getNonMatches(
											(isset($_GET['srchText']) ? array('/^[0-9]{10}$|^[0-9]{13}$/',str_replace('-','',$_GET['srchText']),'srchText') : ''),
											(isset($_POST['price']) ? array('/^(?=.)[0-9]{0,4}(\.[0-9]{2})?$/',$_POST['price'],'price') : ''),
											(!empty($_POST['courseNumber']) && $_POST['subject'] == 'NULL' ? array('/^((?!NULL).)*$/',$_POST['subject'],'subject') : ''),
											(!empty($_POST['courseNumber']) ? array('/^[1-6][0-9]{2}[A-Za-z]{0,1}$/',$_POST['courseNumber'],'courseNumber') : '')
										);
									
										// Book search form
										$Form=new Form;
										echo '<h4>Find a textbook by ISBN</h4>';
										echo $Form->init('buyselladd.php','get',array('class'=>'form-inline','name'=>'bookSearch'))
											->group('',
												new Text(array('class'=>'input-large','name'=>'srchText','placeholder'=>'Enter ISBN'))
											)
											->group('',
												new Submit('Search',array('class'=>'btn btn-primary')),
												new Custom(in_array('srchText',$submitErrors) ? '<span class="help-inline"><p class="text-warning">Please enter a valid ISBN</p></span>' : '')
											)
											->render();

										if (in_array('srchText',$submitErrors)) return;
										else {
											$dbc = new dbw(DBSERVER,DBUSER,DBPASS,DBCATALOG);

											$searching = isset($_GET['srchText']) && !isset($_POST['isbn']);
											$posting = isset($_POST['isbn']);

											// Display book information if user is not posting book information
											// except for if the user is posting with errors
											if ($searching || count($submitErrors) > 0) {
												$isbn = ($searching ? str_replace('-','',$_GET['srchText']) : $_POST['isbn']);
												displayBookList($dbc, $isbn, $submitErrors);
											}
											// Create a book listing
											else if ($posting) {
												postBookListing($dbc, $_POST['isbn'],$_POST['title'], $_POST['authors']);
											}
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

