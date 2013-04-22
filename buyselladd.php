<?php
	require_once('init.php');
	require_once('classes/book.php');
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
	require_once 'google-api-php-client/src/Google_Client.php';
	require_once 'google-api-php-client/src/contrib/Google_BooksService.php';
?>
<!DOCTYPE HTML>
<html lang-"en">
	<?php printHead('Western List'); ?>
	<style type = "text/css">
		.bookImg {
			height: 230px;
			width: 130px;
			float: left;
			overflow: hidden;
		}
		.bookInfo {
			float: left;
			width: 500px;
			margin-left: 10px;
		}
	</style>
    <body>

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
								$Form=new Form;
								echo '<h4>Find a textbook by ISBN or title</h4>';
								echo $Form->init('buyselladd.php','get',array('class'=>'form-inline'))
									->group('',
										new Text(array('class'=>'input-large','name'=>'srchText','placeholder'=>'Enter ISBN or title')),
										new Submit('Search',array('class'=>'btn btn-primary'))
									)
									->render();

							  $dbc = new dbw(DBSERVER,DBUSER,DBPASS,DBCATALOG);

							  /* display a list of volumes */
							  if (isset($_GET['srchText'])) {
								 $srchText =  (is_numeric(str_replace('-','',$_GET['srchText']))? 'isbn:' : 'intitle:') .str_replace('-','',$_GET['srchText']);
								 displayBookList($dbc, getBookInformation($srchText));
							  }

							  if (isset($_POST['isbn'])) {
									postBookListing($dbc, $_POST['isbn'],$_POST['title']);
							  }
							?>
					</div>
				</div>
			</div>
		</div>
        
    </body>
    <script src="holder/holder.js"></script>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="bootstrap/js/bootstrap.js"></script>
</html>

