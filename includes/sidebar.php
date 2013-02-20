<?php
	function DisplaySidebar() {
		require_once('../../private_html/connect.php');
		echo '
		<div class="span3">
				<ul class="nav nav-tabs nav-stacked">
					<li class="active"><a href="">Western Links</a></li>
		';
			// Display each navbar link
			$connection->real_query("SELECT URL, Text FROM CS492_201310.HyperLink WHERE LinkType = 1 AND RecordStatus <> 3 ORDER BY Position;");
			$field_count = $connection->field_count;

				if ($field_count) {
						 $result = $connection->store_result();

						while ($row = $result->fetch_row()) {
									echo '<li><a href="' .$row[0] .'">' .$row[1] ."</a></li>";
						}
				}
		echo '
				</ul>
		</div>
		';
	}
?>