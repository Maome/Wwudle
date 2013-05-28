<?php
	class utils {
		// getInvalidData -- Takes variable number of arguments. Each argument should be an array with
		// three values which are a regular expression, a pattern to match, and the value to return if no match
		// An array will be returned with all the non matches
		public static function getNonMatches() {
			$argc = func_num_args();
			$argv = func_get_args();
			$results = array();
			
			for($i = 0; $i < $argc; $i++) {
				if (is_array($argv[$i])) {
					$regex = $argv[$i][0];
					$pattern = $argv[$i][1];
					$returnID = $argv[$i][2];
					$ignoreIfNull = (count($argv[$i]) < 4 ? false : $argv[$i][3]);
					
					// Skip data if ignoreNotSet is true and the variable
					// is not set
					if (!($ignoreIfNull && is_null($pattern))) {
						if (!preg_match($regex,$pattern)) {
							array_push($results, $returnID);
							//echo "Non match {" .$argv[$i][0] .", " .$argv[$i][1] .", " .$argv[$i][2] ."}<br />";
						}
					}
				}
			}
			return $results;
		}
	}
?>
