<?php
	require_once("../../private_html/connect.php");

	$connection->real_query("SELECT * FROM CS492_201310.User;");

	$field_count = $connection->field_count;

	if ($field_count)
	{
		$result = $connection->store_result();

		while ($row = $result->fetch_row())
		{
			for($i = 0; $i < $field_count; $i++)
			{
				echo $row[$i] ."&nbsp;";
			}
			echo "<br />";
		}
	}

?>
