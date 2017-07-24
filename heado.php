<?php
include('conn.inc.php');
include_once('functions.php');
session_start();
putenv("TZ=Africa/Lagos");
//remember to check that patientID exists before storing
$dsql="SELECT * FROM patients where patientID='" . $_POST['txtPatientID'] ."'";
$rst=$db->execute($dsql);

if ($_SESSION['username']=="") {
	header('Location: index.php');
}

if($_POST['txtPatientID']) $_SESSION['curpid']=$_POST['txtPatientID'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="css/clinic_inside.css" rel="stylesheet" type="text/css" />
 
</head>

<body>
<table width="600" border="0" cellspacing="0" cellpadding="0" align="center">
  
  <tr>
    <td align=center valign=top ><IMG SRC="images/clinicops_inside_01.jpg" WIDTH=800 HEIGHT=103  /></td> </tr>
  <tr>
    <td>
	<!--current user and current patient -->
	<?php
	$patientID=$_SESSION['curpid'];
$psql="SELECT 
  CONCAT_WS(' ',`patients`.`firstname`, `patients`.`othername`, `patients`.`surname`) AS  'Fullname'
FROM
  `patients`
WHERE
  (`patients`.`patientid` ='". $patientID ."')";
  $r=@$db->execute($psql);
	?>
	<table width=100% border=0 cellspacing=0 cellpadding=0>
  <tr><td width=48% align=left><span class=bold-blue> <?php echo "Current Patient:&nbsp;" . $_SESSION['curpid'] . ' ' . @$r->fields('Fullname') ; ?></span></td><td width=52% align=right><span class=bold-blue><?php echo "&nbsp;welcome " . $_SESSION['username'] ?></span>|<a href=logout.php>&nbsp;logout</a></td></tr>
  </table>
 
  </td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  <?php
   //now construct the menubar
 $thisFile=basename($_SERVER['PHP_SELF']);
	$userMenu=array(
	'admin'=>array('Setup'=>'admin.setup.php'),
	'nurse'=>array("Take Patient's Vitals"=>'nurse.attend.php'),
	'doctor'=>array('Treat Patient'=>'doctor.attend.php'),
	'pharm'=>array('Dispense Drugs'=>'drug.dispense.php'),
	'gen'=>array('Report'=>'main.reports.php','Help'=>'help.app.htm')
	);
	
	$user= $_SESSION['username'];//@$_REQUEST['user'];
	$sql="select rolename from actingroles where username='".$user."'";
	$rs=$db->execute($sql);
	
	$separator='';
  
  ?>
    <td><?php while ($rs->EOF==false):
		$userLinks=$userMenu[$rs->fields('rolename')];
		
		foreach($userLinks as $caption=>$url){
			echo @$separator;
			
			if(strpos($url,$thisFile)===false){
				//this is a link to another page
				echo '<a href="'.$url.'">'.$caption.'</a>';
			}
			else
			{
				//this is a link to the current page
				echo '<span style="color:#E34D1A; font-weight:bold">'.$caption.'</span>';
			}
			
			$separator=' | ';
		}
		
		$rs->MoveNext(); 
	 endwhile; 
	
	 if($rs->RecordCount()){
	 	$userLinks=$userMenu['gen'];
	 	foreach($userLinks as $caption=>$url) echo $separator.'<a href="'.$url.'">'.$caption.'</a>';
	 }  ?></td>
    <td><form id="form1" name="form1" method="post">
	<table width=100% border=0 cellspacing=0 cellpadding=0 >
    <tr align=right>
      <td height="34"><span class=style4> Attend To Patient </span>
          <input name="txtPatientID" type="text" class="textfield" id="txtPatientID" />
          <input name="Go" type="submit" class="btnadd" id="Go" value="Go" /> <BR/> <a href="new.patient.php" class="style4">New Patient </a></td>
    </tr>
  </table>
	</form>
	</td>
  </tr>
</table>
</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr class="date_header">
    <td width="20%" >Date:</td>
    <td width="22%" ><?php echo date('F j, Y'); ?></td>
    <td width="18%" >Time:</td>
    <td width="21%" ><?php echo date('H:i:s'); ?></td>
    <td width="19%" ></td>
  </tr>
 
</table></td>
  </tr>
</table>
</td>
  </tr>
   <tr >
    <td >

