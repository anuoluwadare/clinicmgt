<?php
$dateFormat='d F Y';

if ($patientID) {
	$rs=$db->Execute("SELECT * FROM patients WHERE patientID='" . $patientID . "'");
	$today=date($dateFormat);
	
	if (!$rs->EOF) {
		//check for when the patient last visited
		$sql="SELECT entryid,date from cliniccall where lower(purpose)='to see doctor' and patientid='".
		$patientID."' ORDER BY entryid desc limit 0,1";
		$rs2 = $db->execute($sql);

		if (!$rs2->EOF){
			//get last visit's info
			$lastvisit=date($dateFormat,strtotime($rs2->fields('date')));
			$cliniccallid=$rs2->fields('entryid');
			
			//check for any appointments
			$sql="SELECT `users`.`fullname`,`appointment`.`date`
			FROM `users`,`appointment` WHERE `users`.`staffid` = `appointment`.`doctortosee` and
			appointment.cliniccallid='" . $cliniccallid . "'";
		  
			$rs3=$db->execute($sql);
			if (!$rs3->EOF) $details="appointment with: ".$rs3->fields('Doctor')." on ".date($dateFormat,strtotime($rs3->fields('date')));
			else $details="NO APPOINTMENT";
			
		}
		
		else $lastvisit=date($dateFormat);//no previous visit found. Use today's date	

?>




<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tblshow_patients">
  <tr>
    <td align="left" class="style4">&nbsp;</td>
    <td colspan="2" align="left" class="style4">&nbsp;</td>
  </tr>
  <tr>
    <td width="26%" align="left" class="style4"><strong>PatientID</strong></td>
    <td colspan="2" align="left" class="style4"><?php echo $rs->Fields('patientid'); ?></td>
  </tr>
  <tr>
    <td align="left" class="style4">&nbsp;</td>
    <td colspan="2" align="left" class="style4">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" class="style4"><strong>Fullname</strong></td>
    <td colspan="2" align="left" class="style4"><?php echo $rs->Fields('surname')  .  '  '.  $rs->Fields('firstname') . '  ' . $rs->Fields('othername')   ; ?></td>
  </tr>
  <tr>
    <td align="left" class="style4">&nbsp;</td>
    <td colspan="2" class="style4">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" class="style4"><strong>Last Date Visited</strong></td>
    <td width="13%" align="left" class="style4"><?php echo $lastvisit; ?></td>
    <td width="61%" class="style4"><strong>Appointment</strong>
      <span style="color:#0066FF"><?php  echo $details; ?></span>
	</td>
  </tr>
  <tr>
    <td align="right" class="style4">&nbsp;</td>
    <td colspan="2" class="style4">&nbsp;</td>
  </tr>
</table>
<script type="text/javascript">
var rows = document.getElementsByTagName('tr');
for (var i = 0; i < rows.length; i++) {
	rows[i].onmouseover = function() {
		this.className += ' hilite';
	}
	rows[i].onmouseout = function() {
		this.className = this.className.replace('hilite', '');
	}
}
</script>

<?php
 
	} //end patient record found
	
	else{
		echo 'This Patient Number is invalid!';
	}//end patient record does not exist
	
}// end if patientId not empty

?>
