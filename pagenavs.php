<?php
	// Functions for the navbars - search vs. add a ride etc...
	
	// Navs for rideshare
	function RideshareNav($isSearch)
	{
		if($isSearch)
		{
			echo '
                <ul class="nav nav-tabs">
					<li class="active">
						<a href="rideshare.php"><b>Search for a Ride</b></a>
				    </li>
				    <li>
				    	<a href="rideshareadd.php"><b>Add a Ride</b></a>
				    </li>
				</ul>						
			';
		}
		else
		{
			echo '
                <ul class="nav nav-tabs">
					<li>
						<a href="rideshare.php"><b>Search for a Ride</b></a>
				    </li>
				    <li class="active">
				    	<a href="rideshareadd.php"><b>Add a Ride</b></a>
				    </li>
				</ul>						
			';		
		}
	}
	
	// Navs for Course Reviews
	function CourseReviewNav($isSearch)
	{
		if($isSearch)
		{
			echo '
                <ul class="nav nav-tabs">
					<li class="active">
						<a href="courses.php"><b>Search</b></a>
				    </li>
				    <li>
				    	<a href="coursesadd.php"><b>Review a Course</b></a>
				    </li>
				</ul>						
			';
		}
		else
		{
			echo '
                <ul class="nav nav-tabs">
					<li>
						<a href="courses.php"><b>Search</b></a>
				    </li>
				    <li class="active">
				    	<a href="coursesadd.php"><b>Review a Course</b></a>
				    </li>
				</ul>						
			';		
		}
	}

	// Navs for textbook Reviews
	function TextbookReviewNav($isSearch)
	{
		if($isSearch)
		{
			echo '
                <ul class="nav nav-tabs">
					<li class="active">
						<a href="textbooks.php"><b>Search</b></a>
				    </li>
				    <li>
				    	<a href="textbooksadd.php"><b>Review a Textbook</b></a>
				    </li>
				</ul>						
			';
		}
		else
		{
			echo '
                <ul class="nav nav-tabs">
					<li>
						<a href="textbooks.php"><b>Search</b></a>
				    </li>
				    <li class="active">
				    	<a href="textbooksadd.php"><b>Review a Textbook</b></a>
				    </li>
				</ul>						
			';		
		}
	}
	
	// Navs for Professor Reviews
	function ProfessorReviewNav($isSearch)
	{
		if($isSearch)
		{
			echo '
                <ul class="nav nav-tabs">
					<li class="active">
						<a href="professors.php"><b>Search</b></a>
				    </li>
				    <li>
				    	<a href="professorsadd.php"><b>Review a Professor</b></a>
				    </li>
				</ul>						
			';
		}
		else
		{
			echo '
                <ul class="nav nav-tabs">
					<li>
						<a href="professors.php"><b>Search</b></a>
				    </li>
				    <li class="active">
				    	<a href="professorsadd.php"><b>Review a Professor</b></a>
				    </li>
				</ul>						
			';		
		}
	}
	
	// Navs for Reviews
	function ReviewNav($isSearch)
	{
		if($isSearch)
		{
			echo '
                <ul class="nav nav-tabs">
					<li class="active">
						<a href="reviews.php"><b>Search</b></a>
				    </li>
				    <li>
				    	<a href="reviewsadd.php"><b>Review a Professor/Course</b></a>
				    </li>
				</ul>						
			';
		}
		else
		{
			echo '
                <ul class="nav nav-tabs">
					<li>
						<a href="reviews.php"><b>Search</b></a>
				    </li>
				    <li class="active">
				    	<a href="reviewsadd.php"><b>Review a Professor/Course</b></a>
				    </li>
				</ul>						
			';		
		}
	}
	
	// Navs for Textbook buy/sell
	function BuySellReviewNav($isSearch)
	{
		if($isSearch)
		{
			echo '
                <ul class="nav nav-tabs">
					<li class="active">
						<a href="buysell.php"><b>Search</b></a>
				    </li>
				    <li>
				    	<a href="buyselladd.php"><b>Sell a Book</b></a>
				    </li>
				</ul>						
			';
		}
		else
		{
			echo '
                <ul class="nav nav-tabs">
					<li>
						<a href="buysell.php"><b>Search</b></a>
				    </li>
				    <li class="active">
				    	<a href="buyselladd.php"><b>Sell a Book</b></a>
				    </li>
				</ul>						
			';		
		}
	}
	
	function ManagePostsNav($isRideshare, $isBooks)
	{
		if($isRideshare)
		{
			echo '
                <ul class="nav nav-tabs">
					<li class="active">
						<a href="managepostsrides.php"><b>Rideshare</b></a>
				    </li>
				    <li>
				    	<a href="managepostsbooks.php"><b>Textbooks</b></a>
				    </li>
				    <li>
				    	<a href="managepostsreviews.php"><b>Reviews</b></a>
				    </li>
				</ul>						
			';
		}
		else if($isBooks)
		{
			echo '
                <ul class="nav nav-tabs">
					<li>
						<a href="managepostsrides.php"><b>Rideshare</b></a>
				    </li>
				    <li class="active">
				    	<a href="managepostsbooks.php"><b>Textbooks</b></a>
				    </li>
				    <li>
				    	<a href="managepostsreviews.php"><b>Reviews</b></a>
				    </li>
				</ul>						
			';		
		}
		else
		{
			echo '
                <ul class="nav nav-tabs">
					<li>
						<a href="managepostsrides.php"><b>Rideshare</b></a>
				    </li>
				    <li>
				    	<a href="managepostsbooks.php"><b>Textbooks</b></a>
				    </li>
				    <li class="active">
				    	<a href="managepostsreviews.php"><b>Reviews</b></a>
				    </li>
				</ul>						
			';		
		}
	}
?>
