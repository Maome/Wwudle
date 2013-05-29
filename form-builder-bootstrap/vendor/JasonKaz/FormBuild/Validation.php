<?php
namespace JasonKaz\FormBuild;

class Validation extends FormInput	{
	private $condition;
	
	public function __construct($condition, $message, $textWarningClass = false){
		$this->condition = $condition;
		if ($condition) {
			if ($textWarningClass) {
				$this->Code='<span class="help-inline"><p class="text-warning">' .$message .'</p></span>';
			}
			else $this->Code='<span class="help-inline">' .$message .'</span>';
		}
	}
	
	public function getCondition() {
		return $this->condition;
	}
}
?>
