<?php	
	function printHead($title) {
        echo sprintf('
		<head>
			<title>%s</title>
			<link href="bootstrap/css/bootstrap.css" rel="stylesheet">
			<link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
			<link href="bootstrap/css/footer.css" rel="stylesheet">
		</head>
		',$title);
	}
?>
