<?php
//Global connection parameters
include('adodb/adodb.inc.php');
include_once('adodb/adodb-pager.inc.php');
//set timezone
putenv("TZ=Africa/Lagos");
	$server='localhost';
	$user='root';
	$password='password';
	$database='clinicops';
	$db = ADONewConnection('mysql');
	$db->debug =false;
	@$db->Connect($server, $user, $password, $database) or die('Cannot connect to Database');

?>
