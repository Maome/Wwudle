<?php
	class dbw {
		private $conn;
		private $debug;
		
		public static function singleQuote($value) {
			return '\'' .$value . '\'';
		}
		
		public static function nullIfEmpty($value) {
			return empty($value) ? 'NULL' : $value;
		}
		
		function dbw($server, $user, $pass, $catalog,$debug = false) {
			$this->conn = new mysqli($server, $user, $pass, $catalog);
			$this->debug = $debug;
			if (!$this->conn)  die("<p>The database server is unavailable.</p>");
		}
		
		function setDebug($debug) {
			if (is_bool($debug)) $this->debug = $debug;
			else return -1;
		}
		
		function query($qry) {
			if ($this->debug) echo $qry .'<br />';
			$rv = $this->conn->query($qry);
			return $rv;
		}
		
		function queryUnique($table,$value,$where) {
			$qry = sprintf('SELECT %s FROM %s WHERE %s',$value,$table,$where);
			$result = $this->query($qry);
			if ($result->num_rows != 1) return null;
			else {
				$row = $result->fetch_row();
				return $row[0];
			}
		}
		
		function updateData($table,$values,$where) {
			$qry = 'UPDATE ' .$table .' SET ';
			$i = 0;
			foreach($values as $key => $value) {
				$qry .= ' ' .$key .' = ' .$value .($i == count($values) - 1 ? '' : ', ');
				$i++;
			}
			$qry .= ' WHERE ' .$where;
			return $this->query($qry);
		}
		
		// Get key value pair array from query
		function queryPairs($qry) {
			$result = $this->query($qry);
			$rv = array();
			while ($row = $result->fetch_row()) {
				$rv[$row[0]] = $row[1];
			}
			return $rv;
		}

		function queryToTable($qry, $name, $headers = NULL, $classOverride = NULL) {
			echo '<table id="' .$name .'" class="table ' .(empty($classOverride) ? 'table-striped' : $classOverride) .'">';
			echo '<thead>';
				echo '<tr>';
				$result = $this->query($qry);
				if (!empty($headers)) {
					for($i = 0; $i < count($headers); $i++) echo '<th>' .$headers[$i] .'</th>';
				}
				else {
					$fields = $result->fetch_fields();
					for($i = 0; $i < count($fields); $i++) echo '<th>' .$fields[$i]->name .'</th>';
				}
				echo '</tr>';
			echo '</thead>';
			echo '<tbody>';
				while($row = $result->fetch_array()) {
					echo '<tr>';
					for($i = 0; $i < count($row); $i++) {
						echo '<td>' .$row[$i] .'</td>';
					}
					echo '</tr>';
				}
			echo '</tbody>';
			echo '</table>';
		}
		
		function getError() {
			return $this->conn->error;
		}
	}
?>
