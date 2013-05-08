<?php
	include_once('CAS.php');
	
	phpCAS::setDebug();
	phpCAS::client(CAS_VERSION_2_0, 'websso.wwu.edu', 443, '/cas');
	phpCAS::setNoCasServerValidation();
	phpCAS::setFixedServiceURL($url='http://sw.cs.wwu.edu/~steeler2/cs492/home.php');
	phpCAS::setServerLogoutURL($url='https://websso.wwu.edu/cas/logout?url=https://sw.cs.wwu.edu/~steeler2/cs492/index.php');
	phpCAS::forceAuthentication();

	if (isset($_REQUEST['logout'])) {
		phpCAS::logout();
	}
?>
