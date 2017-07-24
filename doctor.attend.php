<?php
include ('head.php');
include("datepulldown.class.php");
 session_start();
$date1 = new date_pulldown("apptdate");
$date1->setYearStart(date('Y'));

$patientID=$_SESSION['curpid'];

//if ($patientID=="") {

//header("Location: home.php");
	//				}//end if

//get the most recent call date 
	$sql="select max(entryid) as entryid from cliniccall where patientID='" .$patientID . "'" ;
	$crst=$db->execute($sql);
	$cliniccallid=$crst->fields('entryid');
	
	
$action=$_POST['Submit'];
if ($action=='Save') {
	$diagnosis=$_POST['txtDiagnosis'];
	$complaint=$_POST['txtComplaint'];
	$treatment=$_POST['txtTreatment'];
	$prescription=$_POST['txtPrescription'];
	$referral=$_POST['cboHospital'];
	$appdate=$_POST['apptdate'];
	$curuser=$_SESSION['userid'];
	$date=date('Y-m-d');
	$currTime=date('H:i:s');
	$b=$appdate['year'] .'-' . $appdate['mon'] . '-' . $appdate['mday'];
	$logintime=$_POST['LoginTime'];
	//make sure the user entered something before saving
	if (($complaint) and ($diagnosis) and ($treatment))
	{
	//now use this to save the doctors prognosis
	if ($referral!='none') {
	//if a referral was entered then save it
		$sql="insert into `referrals` 
		(cliniccallid, hospid, userid, comment) values ('" . $cliniccallid ."','" . $referral ."','" . $curuser . "','" . $comment . "')";
		$csrt=$db->execute($sql);	
	}//end if
	
	//if any appoitments then save it also
	
	if ($b != date('Y-n-d')) {
		$sql="insert into `appointment` (cliniccallid, date, doctortosee, comment)values	( '" . $cliniccallid . "','" . $b . "','" . $curuser  . "','" .  $comment . "')";
		$crst=$db->execute($sql);
		
	}//end if 
	
	$sql="insert into `doctorprescription` 
	(cliniccallid, prescription)
	values
	('" .  $cliniccallid ."','" . $prescription ."')";
	$db->execute($sql);
	
	$sql="insert into treatment
	(cliniccallid, complaint, treatment, diagnosis,doctor,  timein, timelogged)
	values( '" . $cliniccallid . "','"  . $complaint . "','" . $treatment . "','" . $diagnosis . "','" . $curuser . 
	"','" .  $logintime. "','" . $currTime . "')";
	$crst=$db->execute($sql);
	if ($crst==true) {
		$msg="Information saved successfully";
	} else{
		$msg="There was an error saving the treatment, error was " . $db->errormsg();
	}
	
}// end if

}




?>

<form id="form1" name="form1" method="post" action="">
  <table width="700" border="0" align="center">
    
    <tr>
      <td align="left"><span class="style1"><a href="home.php">Home</a> - Consultation </span></td>
    </tr>
    <tr>
      <td><?php include('show.vitals.php'); ?></td>
    </tr>
    <tr>
      <td>
	  Date of Last Visit 
	  <span style="color:#0066FF">
        <?php
			//check for when the patient last visited
			$sql="SELECT date from cliniccall,treatment where 
			cliniccall.entryid=treatment.cliniccallid and lower(purpose)='to see doctor' and patientid='".
			$patientID."' ORDER BY entryid desc limit 0,1";
			
			$rs2 = $db->execute($sql);
	
			if (!$rs2->EOF){
				//get last visit's info
				echo date('d F Y',strtotime($rs2->fields('date')));
		  	}
		  ?>
      </span></td>
    </tr>
    <tr>
      <td><table width="100%" border="0">
        <tr>
          <td width="21%">Complaints</td>
          <td width="34%"><textarea name="txtComplaint" class="txtarea" id="txtComplaint"></textarea>
            <input name="LoginTime" type="hidden" id="LoginTime" value="<?php echo date('H:i:s');?>" /></td>
          <td width="11%">Diagnosis</td>
          <td width="31%"><textarea name="txtDiagnosis" class="txtarea" id="txtDiagnosis"></textarea>
                <br />
                <br /></td>
          <td width="3%">&nbsp;</td>
        </tr>
        <tr>
          <td>Treatment</td>
          <td><textarea name="txtTreatment" class="txtarea" id="txtTreatment"></textarea></td>
          <td>Prescription</td>
          <td><textarea name="txtPrescription" class="txtarea" id="txtPrescription"></textarea></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>Referral</td>
          <td><select name="cboHospital" class="textfield" id="cboHospital">
		  <option value="none">Select a hospital</option>
              <?php $sql="select * from hospitals ";
			$rs=$db->execute($sql);
			while ($rs->EOF==false):
			?>
              <option value="<?php  echo $rs->fields('entryid');  ?>">
              <?php  echo $rs->fields('hospital');  ?>
              </option>
              <?php $rs->MoveNext(); 
			 endwhile; ?>
          </select>          </td>
          <td>Next Appointment Date</td>
          <td><?php     
			  echo $date1->output();
			  
			  ?></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td class="errormsg"><?php echo $msg?></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td align="right"><input name="Submit" type="submit" class="btnadd" value="Save" /></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td class="errormsg">&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td><?php /* $usql="SELECT 
  `cliniccall`.`date`
FROM
  `cliniccall`
WHERE
  (`cliniccall`.`patientid` ='" . $patientID . "')";
  
  $mrst=$db->execute($usql);
  echo "<table border=0 width=100%><tr>";
  while ($mrst->fields) :
  	echo "<td><a href=doctor.attend.php?cid=". $cliniccallid . ">" . $mrst->fields('date') ."</a></td>";
	$mrst->movenext();
  endwhile;
  echo "</tr></table>";
    */ ?>
  
  
  </td>
    </tr>
    <tr>
      <td><strong>Visits </strong></td>
    </tr>
    <tr>
      <td><?php include('doctorvisit.patient.php'); ?></td>
    </tr>
   
    <tr>
      <td><?php echo "<a href=medhistory.patient.php?pid=" . $patientID .">View</a> Patient Medical History"; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
<?php include ('foot.php');?>
