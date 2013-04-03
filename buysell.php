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
                    <div class="row-fluid">
                        <div class="span4">
                            <h2>Buy / Sell</h2>
                        </div>
                        <div class="span4 offset4">
                            <a class="btn btn-success" type="button" href="buyselladd.php">Sell an item</a>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span6 offset1">
                            <form class="form-inline">
                                Find a textbook: <input class="input-large" type="text" name="searchText" placeholder="Enter the Title or ISBN">
                                <button type="submit" class="btn btn-primary">Search</button>
                            </form>
                        </div>
                    </div>
					<div class="row-fluid">
						<?php
						
							function displayBookListings($searchText) {
								global $connection;
								if (!isset($connection)) echo 'Unset!';
								if (is_numeric($searchText)) {
									$where_clause = "WHERE b.ISBN = " .$searchText;
								}
								else $where_clause = "WHERE COALESCE(b.Title,'') LIKE '%" .$searchText ."%'";
								
								$qry = "SELECT
											 bl.PostID,
											 b.ISBN,
											 b.Title,
											 bl.Price Price, 
											 bc.Description
											 FROM BookListing bl
											 JOIN Book b
											 ON (b.BookID = bl.BookID)
											 LEFT JOIN BookCondition bc
											 ON (bc.BookConditionID = bl.BookConditionID)" .$where_clause;
								$result = $connection->query($qry);
								
								if ($result->num_rows > 0) {
									$fields = array("ISBN","Title","Price","Description");
									echo "<table class='table'>";
										echo "<tr>";
											foreach ($fields as $i) {
												echo "<td>" .$i ."</td>";
											}
											echo "<td>Buy</td>";
										echo "</tr>";
										while ($row = $result->fetch_assoc()) {
											echo "<tr>";
												foreach ($fields as $i){
													echo "<td>" .$row[$i] ."</td>";
												}
												echo "<td>";
												echo "<form action='buysell.php' method='POST'>";
												echo "<input type='hidden' name='postID' value='" .$row["PostID"] ."' />";
												echo "<input type='submit' value='Buy' />";
												echo "</form>";
												echo "</td>";
											echo "</tr>";
										}
									echo "</table>";
								}
								else echo "No results found";
							}
							
							if (isset($_GET['searchText'])) {
								displayBookListings($_GET['searchText']);
							}
							else if (isset($_POST['postID'])) {
								echo "An email has been sent to the seller on your behalf.";
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

