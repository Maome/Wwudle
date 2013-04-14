<?php
namespace JasonKaz\FormBuild;

class Star extends FormInput	{
	public function __construct($id ='', $Value='', $Attribs=array()){
		$this->Code='<div id="'.$id.'"'.parent::parseAttribs($Attribs).'>'.$Value.'</div>';
	}
}
?>
