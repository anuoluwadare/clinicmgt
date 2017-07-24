<?php
	include('conn.inc.php');
	
	$from=$_REQUEST['from'];
	$to=$_REQUEST['to'];
	$dateFld=$_REQUEST['dateFld'];
	$title=$_REQUEST['title'];
	if($dateFld) $title.=' from '.date('d, F Y',strtotime($from)).' to '.date('d, F Y',strtotime($to));
	$sql=stripslashes($_REQUEST['sql']);
	$fromClause=stripslashes($_REQUEST['fromClause']);
	$grpBy=stripslashes($_REQUEST['grpBy']);
	
	//extend hyperlink querystring
	$sql=str_replace('.php?','.php?from='.$from.'&to='.$to.'&fromClause='.
	str_replace("'","''",$fromClause).'&dateFld='.$dateFld.'&title='.$title.'&',$sql);
	
	$sql.=$fromClause;
	if($dateFld) $sql.=$dateFld." BETWEEN '".$from."' AND '".$to."'";
	$sql.=$grpBy;
	
	//echo htmlspecialchars($sql);
	
	$rs=$db->execute($sql);
	
	$title.=' ('.$rs->RecordCount().')';
	
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title><?php echo $title?></title>
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
    if($pager) $pager->Render($rows_per_page=20);
?>
</td>
</tr>
</table>
</body>
</html>
