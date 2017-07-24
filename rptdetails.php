<?php
	include('conn.inc.php');
	
	$pid=$_REQUEST['pid'];
	$from=$_REQUEST['from'];
	$to=$_REQUEST['to'];
	$dateFld=$_REQUEST['dateFld'];
	$title=$_REQUEST['title'];
	$fromClause=stripslashes($_REQUEST['fromClause']);
	$detailFlds=$_REQUEST['detailFlds'];
	
	//prepare header info
	$sql="SELECT PatientId,concat( surname, ' ', firstname, ' ', othername ) AS Name, 
	employeeType FROM patients WHERE patientId='".$pid."'";

	if($rs=$db->execute($sql)){
		$headerInfo='<br><br>Patient ID: '.$rs->fields('PatientId').'<br><br>'.
		'Name: '.$rs->fields('Name').'<br><br>'.
		'Employee Type: '.$rs->fields('employeeType');
		
		//prepare detail info	
		$sql="SELECT ".$dateFld." AS `Date`".$detailFlds.$fromClause.
		$dateFld." BETWEEN '".$from."' AND '".$to."' AND patients.PatientId='".$pid."'";
		//echo $sql;
		$rs=$db->execute($sql);

		$headerInfo.='<br><br>'.$rs->RecordCount().' record(s) returned';
		
	}
	
	
	$title.=$headerInfo;
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Patient <?php echo $pid?></title>
<link href="css/clinic_inside.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="100%" border="0">
<tr style="background-color:#FFFFFF">
<td>
<img src="images/clinicops_home+_02.GIF" />
<?php 
	echo '<span style="font-weight:bold; color:#0099FF">'.stripslashes($title).'</span';
?>
</td>
</tr>
<tr>
<td>
<span style="float:right"><a href="javascript:window.print()" style="text-decoration:none">Print</a></span>
<?php 
	$pager = new ADODB_Pager($db,$sql); 
    if($pager)
		$pager->Render($rows_per_page=20);
		
?>
</td>
</tr>
</table>
</body>
</html>
