<?php
	include('conn.inc.php');
	
	$pid=$_REQUEST['pid'];
	$from=$_REQUEST['from'];
	$to=$_REQUEST['to'];
	$title=$_REQUEST['title'];
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
	echo '<span style="font-weight:bold; color:#0099FF">'.
	$title.' from '.date('d, F Y',strtotime($from)).' to '.date('d, F Y',strtotime($to)).' - </span>';
	
	$page=@$_REQUEST['page']? $_REQUEST['page']: 1;
	$caseId=0;
	
	$sql="Select entryid,date from cliniccall where cliniccall.patientId='".$pid.
	"' and purpose='To see doctor' and cliniccall.date BETWEEN '".
	$from."' AND '".$to."' ORDER BY cliniccall.date";

	$rs=$db->execute($sql);
	while ($rs->EOF==false):
		$currentPos=$rs->AbsolutePosition()+1;
		if($page==$currentPos){
			$caseId=$rs->fields('entryid');
			$caseDate=$rs->fields('date');
			echo @$separator.$currentPos;
		}
		else
			echo @$separator.
			'<a href="?pid='.$pid.'&from='.$from.'&to='.$to.'&title='.$title.'&page='.$currentPos.'">'
			.$currentPos.'</a>';
		
		$separator=' | ';
		
		$rs->MoveNext(); 
	 endwhile; 
	
	$whereClausePart=" where cliniccall.entryid=".$caseId;

	$sql="Select Temperature,BloodPressure,PulseRate from cliniccall,vitals".$whereClausePart.
	" and cliniccall.entryid=vitals.cliniccallid";
?>
</td>
</tr>
<tr>
<td>
<span style="float:right"><a href="javascript:window.print()" style="text-decoration:none">Print</a></span>
<?php 
	$pager = new ADODB_Pager($db,$sql); 
    if($pager){
		echo '<br><br>Case Date: '.@date('d-M-Y',strtotime($caseDate))."<br><br>Patient's Vitals";
		$pager->Render($rows_per_page=20);
	}
		
	$sql="Select Complaint,Diagnosis,Treatment from cliniccall,treatment".$whereClausePart.
	" and cliniccall.entryid=treatment.cliniccallid";
	
	$pager = new ADODB_Pager($db,$sql); 
    if($pager){
		echo '<br><br>Case Note';
		$pager->Render($rows_per_page=20);
	}
		
	$sql="Select Prescription from cliniccall,doctorprescription".$whereClausePart.
	" and cliniccall.entryid=doctorprescription.cliniccallid";
	
	$pager = new ADODB_Pager($db,$sql); 
    if($pager){
		echo '<br><br>Prescription';
		$pager->Render($rows_per_page=20);
	}
		
	$sql="Select Hospital from cliniccall,referrals,hospitals".$whereClausePart.
	" and cliniccall.entryid=referrals.cliniccallid and referrals.hospId=hospitals.entryid";
	
	$pager = new ADODB_Pager($db,$sql); 
    if($pager){
		echo '<br><br>Referral';
		$pager->Render($rows_per_page=20);
	}
?>
</td>
</tr>
</table>
</body>
</html>
