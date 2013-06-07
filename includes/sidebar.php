<?php
	function DisplaySidebar() {
		require_once('connect.php');
		require_once('classes/dbw.php');
		echo '
		<div class="span2">
				<img src="images/wwu_logo2.png" alt="WWU Logo" style= "width: 100%"/>
				<br />
				<br />
				<ul class="nav nav-tabs nav-stacked">
					<li class="active"><a href="">External Resources</a></li>
		';
		$dbc = new dbw(DBSERVER,DBUSER,DBPASS,DBCATALOG);
		$links = $dbc->queryPairs('SELECT URL, Text FROM CS492_201310.HyperLink WHERE LinkType = 1 AND RecordStatus <> 3 ORDER BY Position');
		foreach($links as $url => $text) {
			echo sprintf('<li><a href="%s">%s</a></li>',$url,$text);
		}
		echo '
				</ul>
		</div>
		';
	}
?>
