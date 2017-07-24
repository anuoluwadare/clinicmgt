<?php
include ('head.php');
if ($_GET['pid']!='') {
	$patientID=$_GET['pid'];
	$_SESSION['curpid']=$patientID;
}
$patientID=$_SESSION['curpid'];
//if ($patientID=="") { header("Location: home.php?m=NOPID");}

if ($_SESSION['username']==''){
	header('Location: index.php');

} else {
	$temp=$_POST['Temperature'];
	$BP=$_POST['BloodPressure'];
	$pulse=$_POST['PulseRate'];
	$action=$_POST['Submit'];
	$timeIn=$_POST['TimeIn'];
	$logintime=$_POST['LoginTime'];
	if ($action=='Save'){
		$date=date('Y-m-d');
		$currTime=date('H:i:s');
		$nurse=$_SESSION['userid'];
		$patientID=$_SESSION['curpid'];
		$vticket=getdate();
	//save the call first
	$sql="insert into `cliniccall` 
	(timein, patientid, 
	date, time, userid,visitticket,TimeLogged,purpose)
	values
		( '" . $timeIn . "','" . $patientID . "','" . $date . "','" . $logintime . "','" . $nurse . "','" . 
		$vticket[0] . "','" . $currTime . "','To see doctor')";
	
		$rs = $db->execute($sql);
		$CallID= $db->Insert_ID();
		//save the vitals
		$sql="insert into `vitals` 
	( cliniccallid, temperature, bloodpressure, 
	pulserate, userid) values
			('" . $CallID . "','" . $temp . "','" . $BP . "','" . $pulse . "','" . $nurse . "')";
		$rs=$db->execute($sql);
		
		if ($db->HasFailedTrans==false)
		{
			$msg="Vitals updated";
			
		} else{
			$msg= ("There was an error processing this Patient!");	
		}
		
}	
}	

?>

<table width="100%" border="0">
  <tr>
    <td align="center" valign="top"><table width="600" border="0">
      <tr>
        <td class="errmsg"><?php  echo $msg;  ?></td>
      </tr>
     
      <tr>
        <td align="left"><span class="style2"><a href="home.php">Home</a> - Patient Vitals </span></td>
      </tr>
      <tr>
        <td><?php include('show.patient.php'); ?></td>
      </tr>
      <tr>
        <td></td>
      </tr>
	  <tr>
	    <td align="center" bgcolor="#0099CC"></td>
	    </tr>
	  <tr>
	    <td><?php include('vitals.patient.php'); ?></td>
	    </tr>
	  <tr>
	    <td></td>
	    </tr>
	  <tr>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
<?php include ('foot.php');?>
