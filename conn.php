<?php
//Global connection parameters
include('adodb/adodb.inc.php');
include_once('adodb/adodb-pager.inc.php');
	$server='localhost';
	$user='root';
	$password='';
	$database='clinicops';
	
	$db = ADONewConnection('mysql'); 
	$db->debug =false; 
	$db->Connect($server, $user, $password, $database); 
	
?>
