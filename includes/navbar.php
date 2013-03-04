 <?php
 	require_once('cassettings.php');
	function DisplayNavbar($filename) {
		CheckCreateUser();
		echo '
			<div class="navbar navbar-inverse navbar-fixed-top">
				<div class="navbar-inner">
					<div class="container">
						<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-responsive-collapse">
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</a>
						<a class="brand" href="index.php">Western List</a>
						<div class="nav-collapse collapse navbar-responsive-collapse">
							<ul class="nav">
								' .li_type($filename,"index.php") .'<a href="index.php">Home</a></li>
								<li class="dropdown">
									<a class="dropdown-toggle" href="" role="button" data-toggle="dropdown">Reviews<b class="caret"></b></a>
									<ul class="dropdown-menu" role="menu" aria-labelledby="dropl">
										' .li_type($filename,"courses.php") .'<a tabindex="-1" href="courses.php">Courses</a></li>
										' .li_type($filename,"textbooks.php") .'<a tabindex="-1" href="textbooks.php">Textbooks</a></li>
										' .li_type($filename,"professors.php") .'<a tabindex="-1" href="professors.php">Professors</a></li>
									</ul>
								</li>
								' .li_type($filename,"rideshare.php") .'<a href="rideshare.php">Rides</a></li>
								' .li_type($filename,"buysell.php") .'<a href="buysell.php">Buy / Sell</a></li>
							</ul>
						
							<p class="navbar-text pull-right">Logged in as <a href="#" class="navbar-link">' .phpCAS::getUser() .'</a></p>
							<ul class="nav pull-right"><li class="divider-vertical"></li></ul>
							<form class="navbar-search pull-right">
								<input type="text" class="navbar-search search-query" placeholder="search">
							</form>
						</div><!--/.nav-collapse -->
					</div>
				</div>
			</div>
			<div class="bottompading">
			</div>
		';
	}

	function li_type($filename,$expected_filename) {
		if ($filename == $expected_filename) return '<li class="active">';
		else return '<li>';
	}

	// Create / update user record if user_record session variable is not set
	function CheckCreateUser() {
		global $connection;	
		session_start();
		if (!isset($_SESSION['user_record'])) {
			$username = PHPCAS::GetUser() ."@students.wwu.edu";							
			$sql = "Select UserId from User where Email = '$username';";
			$result = $connection->query($sql);
			$row = $result->fetch_row();
			
			// Insert new user record
			if ($result->num_rows == 0) {
				$sql = "INSERT INTO User
						  (Email,FirstLoginDate,LastLoginDate,ChangeSource,RecordStatus,RecordStatusDate)
						  VALUES('" .$username ."',NOW(), NOW(), 0, 1, NOW())";
			  	$connection->query($sql);
			}
			// Update existing user record
			else {
				$sql = 'UPDATE User
						  SET LastLoginDate = NOW(), RecordStatus = 2, RecordStatusDate = NOW()
						  WHERE UserID = ' .$row[0];
				$result = $connection->query($sql);
			}
			$_SESSION['user_record'] = $username;
		}
	}
?>
