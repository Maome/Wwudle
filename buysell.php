<?php
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
		<title><?php Woodle(); ?></title>
		<link href="bootstrap/css/bootstrap.css" rel="stylesheet">
		<link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
		<link href="bootstrap/css/bootstrap-rowlink.css" rel="stylesheet">
		<link href="bootstrap/css/footer.css" rel="stylesheet">
		<link href="datatables/media/css/bootstrap-dt.css" rel="stylesheet">
		<script type="text/javascript" language="javascript" src="datatables/media/js/jquery.js"></script>
		<script type="text/javascript" language="javascript" src="datatables/media/js/jquery.dataTables.js"></script>
		<script type="text/javascript" language="javascript" src="datatables/media/js/paging.js"></script>
		<script>
			function get(name){
			   if(name=(new RegExp('[?&]'+encodeURIComponent(name)+'=([^&]*)')).exec(location.search))
				  return decodeURIComponent(name[1]);
			}
			$(document).ready(function() {
				var courseSearch = get("srchCourse");
				if (courseSearch == null) {
					$("#courseSearch").hide();
				}
				else $("#isbnSearch").hide();
				
				$("#searchType").change(function(e){					
					$("#isbnSearch").toggle();
					$("#courseSearch").toggle();
				});					
			});	
		
			$(document).ready(function() {
				var oTable = $('#bookListings').dataTable( {
					"sPaginationType": "bootstrap",
					"bFilter": false, // Disable filtering
					"aaSorting": [] // Disable auto sort first column
				} );															
			} );		
		</script> 
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
		             <?php BuySellReviewNav(true) ?>
		                 <div class="row-fluid">
						 
							<?php
								 echo '
								 <h4>Find textbooks by
								 <select class="input-medium" id="searchType" style="width: 130px">
									 <option value="ISBN">ISBN or Title</option>
									 <option value="Course" ' .(isset($_GET['srchCourse']) ? 'selected' : '') .'>Course</option>
								 </select>
								</h4>
								';
								$dbc = new dbw(DBSERVER,DBUSER,DBPASS,DBCATALOG);
														
								echo "<div id='isbnSearch'>";
								$FormA=new Form;
								echo $FormA->init('','get',array('class'=>'form-inline'))
									->group('',
										new Text(array('class'=>'input-large','name'=>'srchText','value'=>$_GET['srchText'], 'placeholder'=>(empty($_GET['srchText']) ? 'Enter ISBN or title' : ''))),
										new Submit('Search',array('class'=>'btn btn-primary'))
									)
									->render();
								echo "</div>";												
							
								echo "<div id='courseSearch'>";
								$FormB=new Form;							
								echo $FormB->init('','get',array('class'=>'form-inline'))
									->group('',
										new Select($dbc->queryPairs('SELECT Abbreviation, Description FROM Department ORDER BY RowOrder,Abbreviation'),$_GET['srchDept'], array('class'=>'input-large','name'=>'srchDept')),
										new Text(array('class'=>'input-medium','name'=>'srchCourse','value'=>$_GET['srchCourse'], 'placeholder'=>(empty($_GET['srchCourse']) ? 'Enter course number' : ''))),
										new Submit('Search',array('class'=>'btn btn-primary'))
									)
									->render();
								echo "</div>";
							?>
		                 </div>
						<div class="row-fluid">
							<?php
							
								if (isset($_GET['srchText'])) {
									displayBookListings(array($_GET['srchText']),0);
								}
								else if (isset($_GET['srchCourse']) || isset($_GET['srchDept'])) {
									$dept = trim($_GET['srchDept'] == 'ALL' ? '' : $_GET['srchDept']) .' ';
									displayBookListings(array(trim($dept),trim($_GET['srchCourse'])),1);
								}
								else if (isset($_POST['postID'])) {
									echo "An email has been sent to the seller on your behalf.";
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
    <!--<script src="http://code.jquery.com/jquery-latest.js"></script>-->
    <script src="bootstrap/js/bootstrap.js"></script>    
    <script src="bootstrap/js/bootstrap-rowlink.js"></script>
</html>

