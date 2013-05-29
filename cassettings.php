<?php
	include_once('CAS.php');
	
	phpCAS::setDebug();
	phpCAS::client(CAS_VERSION_2_0, 'websso.wwu.edu', 443, '/cas');
	phpCAS::setNoCasServerValidation();
	//phpCAS::setFixedServiceURL($url='http://sw.cs.wwu.edu/~hieberk/cs492/home.php');
	phpCAS::setFixedServiceURL($url='http://sw.cs.wwu.edu/~steeler2/cs492/'. substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1));
	//phpCAS::setFixedServiceURL($url=curPageURL());
	phpCAS::setServerLogoutURL($url='https://websso.wwu.edu/cas/logout?url=https://sw.cs.wwu.edu/~steeler2/cs492/index.php');
	phpCAS::forceAuthentication();

	if (isset($_REQUEST['logout'])) {
		phpCAS::logout();
	}
	
	function curPageURL(){
		$protocol = strpos(strtolower($_SERVER['SERVER_PROTOCOL']),'https') 
                === FALSE ? 'http' : 'https';
		$host     = $_SERVER['HTTP_HOST'];
		$script   = $_SERVER['SCRIPT_NAME'];
		$params   = $_SERVER['QUERY_STRING'];
		 
		$currentUrl = $protocol . '://' . $host . $script . '?' . $params;
		return $currentUrl;
	
	}
?>
