<?php
namespace JasonKaz\FormBuild;

class Validation extends FormInput	{
	public function __construct($condition, $message){
		if ($condition) $this->Code='<span class="help-inline">' .$message .'</span>';
	}
}
?>
