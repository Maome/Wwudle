 <?php
 	require_once('cassettings.php');
	
	function DisplayNavbar($filename) {
		if (!isset($_REQUEST['index'])) {
			CheckCreateUser();
		}
		echo '
			<div class="navbar navbar-inverse navbar-fixed-top">
				<div class="navbar-inner">
					<div class="container">
						<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-responsive-collapse">
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</a>
						<a class="brand" href="index.php" style="font-size: 26px">Western List</a>
						<div class="nav-collapse collapse navbar-responsive-collapse">
							<ul class="nav" style = "font-size: 16px">
								' .li_type($filename,"index.php") .'<a href="index.php">Home</a></li>
								<li class="dropdown">
									<a class="dropdown-toggle" href="" role="button" data-toggle="dropdown">Reviews<b class="caret"></b></a>
									<ul class="dropdown-menu" role="menu" aria-labelledby="dropl">
										' .li_type($filename,"courses.php") .'<a tabindex="-1" href="courses.php">Courses</a></li>
										' .li_type($filename,"textbooks.php") .'<a tabindex="-1" href="textbooks.php">Textbooks</a></li>
										' .li_type($filename,"professors.php") .'<a tabindex="-1" href="professors.php">Professors</a></li>
									</ul>
								</li>
								' .li_type($filename,"rideshare.php") .'<a href="rideshare.php">Rideshare</a></li>
								' .li_type($filename,"buysell.php") .'<a href="buysell.php">Textbooks</a></li>
							</ul>
							</div>
							<div class="pull-right">';
								if (!isset($_REQUEST['index'])) {
									echo '
								<div class="btn-group">
								<a class="btn btn-primary" href="#"><i class="icon-user icon-white"></i>&nbsp;Logged in as ' .phpCAS::getUser() .'</a>
								<a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
								<ul class="dropdown-menu">
								<li><a href="settings.php"><i class="icon-cog"></i> Settings</a></li>
								<li><a href="?logout"><i class="icon-off"></i> Logout</a></li>
								</ul>
								</div>
									';
								}
								else {
									echo '
										<a href="?login" role="button" class="btn btn-primary btn-medium">Log In</a>
									';
								}
								echo '
							</div>
						</div><!--/.nav-collapse -->
					</div>
				</div>
			</div>
			<div class="bottompadding">
			</div>
		';
	}

	function li_type($filename,$expected_filename) {
		if ($filename == $expected_filename) return '<li class="active">';
		else return '<li>';
	}

	function GetUserID($userName) {
		global $connection;							
		$sql = "Select UserId from User where UserName = '" .$userName ."';";
		$result = $connection->query($sql);
		$row = $result->fetch_row();

		if ($result->num_rows == 0) return NULL;
		else return $row[0];
	}

	// Create / update user record if user_record session variable is not set
	function CheckCreateUser() {
		global $connection;	
		session_start();
		
		if (!isset($_SESSION['userID'])) {
			$email = PHPCAS::GetUser() ."@students.wwu.edu";
			$userID = GetUserID(PHPCAS::GetUser());
			
			// Insert new user record
			if ($userID == NULL) {
				$sql = "INSERT INTO User
						  (UserName, Email,FirstLoginDate,LastLoginDate,ChangeSource,RecordStatus,RecordStatusDate)
						  VALUES('" .PHPCAS::GetUser()  ."','" .$email ."',NOW(), NOW(), 0, 1, NOW())";
			  	$connection->query($sql);

				$_SESSION['userID'] = GetUserID(PHPCAS::GetUser());
			}
			// Update existing user record
			else {
				$_SESSION['userID'] = $userID;
				$sql = 'UPDATE User
						  SET LastLoginDate = NOW(), RecordStatus = 2, RecordStatusDate = NOW()
						  WHERE UserID = ' .$userID;
				$result = $connection->query($sql);
			}
		}
	}
?>
