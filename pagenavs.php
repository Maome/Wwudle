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
						<a href="rideshare.php">Search for a Ride</a>
				    </li>
				    <li>
				    	<a href="rideshareadd.php">Add a Ride</a>
				    </li>
				</ul>						
			';
		}
		else
		{
			echo '
                <ul class="nav nav-tabs">
					<li>
						<a href="rideshare.php">Search for a Ride</a>
				    </li>
				    <li class="active">
				    	<a href="rideshareadd.php">Add a Ride</a>
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
						<a href="courses.php">Search</a>
				    </li>
				    <li>
				    	<a href="coursesadd.php">Review a Course</a>
				    </li>
				</ul>						
			';
		}
		else
		{
			echo '
                <ul class="nav nav-tabs">
					<li>
						<a href="courses.php">Search</a>
				    </li>
				    <li class="active">
				    	<a href="coursesadd.php">Review a Course</a>
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
						<a href="textbooks.php">Search</a>
				    </li>
				    <li>
				    	<a href="textbooksadd.php">Review a Textbook</a>
				    </li>
				</ul>						
			';
		}
		else
		{
			echo '
                <ul class="nav nav-tabs">
					<li>
						<a href="textbooks.php">Search</a>
				    </li>
				    <li class="active">
				    	<a href="textbooksadd.php">Review a Textbook</a>
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
						<a href="professors.php">Search</a>
				    </li>
				    <li>
				    	<a href="professorsadd.php">Review a Professor</a>
				    </li>
				</ul>						
			';
		}
		else
		{
			echo '
                <ul class="nav nav-tabs">
					<li>
						<a href="professors.php">Search</a>
				    </li>
				    <li class="active">
				    	<a href="professorsadd.php">Review a Professor</a>
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
						<a href="reviews.php">Search</a>
				    </li>
				    <li>
				    	<a href="reviewsadd.php">Review a Professor/Course</a>
				    </li>
				</ul>						
			';
		}
		else
		{
			echo '
                <ul class="nav nav-tabs">
					<li>
						<a href="reviews.php">Search</a>
				    </li>
				    <li class="active">
				    	<a href="reviewsadd.php">Review a Professor/Course</a>
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
						<a href="buysell.php">Search</a>
				    </li>
				    <li>
				    	<a href="buyselladd.php">Sell a Book</a>
				    </li>
				</ul>						
			';
		}
		else
		{
			echo '
                <ul class="nav nav-tabs">
					<li>
						<a href="buysell.php">Search</a>
				    </li>
				    <li class="active">
				    	<a href="buyselladd.php">Sell a Book</a>
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
						<a href="managepostsrides.php">Rideshare</a>
				    </li>
				    <li>
				    	<a href="managepostsbooks.php">Textbooks</a>
				    </li>
				    <li>
				    	<a href="managepostsreviews.php">Reviews</a>
				    </li>
				</ul>						
			';
		}
		else if($isBooks)
		{
			echo '
                <ul class="nav nav-tabs">
					<li>
						<a href="managepostsrides.php">Rideshare</a>
				    </li>
				    <li class="active">
				    	<a href="managepostsbooks.php">Textbooks</a>
				    </li>
				    <li>
				    	<a href="managepostsreviews.php">Reviews</a>
				    </li>
				</ul>						
			';		
		}
		else
		{
			echo '
                <ul class="nav nav-tabs">
					<li>
						<a href="managepostsrides.php">Rideshare</a>
				    </li>
				    <li>
				    	<a href="managepostsbooks.php">Textbooks</a>
				    </li>
				    <li class="active">
				    	<a href="managepostsreviews.php">Reviews</a>
				    </li>
				</ul>						
			';		
		}
	}
?>
