<?php
	require_once 'form-builder-bootstrap/SplClassLoader.php';

	$ClassLoader=new SplClassLoader('JasonKaz\FormBuild', 'vendor');
	$ClassLoader->register();
?>