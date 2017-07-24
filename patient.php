<?php
//
include('functions.php');
include('conn.php');
$patientID=$_POST['txtPatientID'];
if ($patientID) {
    $db->SetFetchMode(ADODB_FETCH_ASSOC);
	$rs=$db->Execute("SELECT * FROM patientbiodata WHERE patientID='" . $patientID . "'");
	if ($rs->EOF!=true) {
		
	}
		
	
}


?>
<html>
<link href="styles.css" rel="stylesheet" type="text/css">
<body>
<table width="800" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="20%">Date:</td>
    <td width="22%"><?php echo date('l dS \of F Y '); ?></td>
    <td width="18%">Time:</td>
    <td width="21%"><?php echo date('h:i:s'); ?></td>
    <td width="19%">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#00CCFF">&nbsp;</td>
    <td bgcolor="#00CCFF">&nbsp;</td>
    <td bgcolor="#00CCFF">&nbsp;</td>
    <td bgcolor="#00CCFF">&nbsp;</td>
    <td bgcolor="#00CCFF">&nbsp;</td>
  </tr>
  <tr>
    <td class="tut-step">Patient Details </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>PatientID</td>
    <td class="ItemTitle">Firstname</td>
    <td class="ItemTitle">Surname</td>
    <td class="ItemTitle">Other name </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><?php echo $rs->Fields('PatientID'); ?></td>
    <td><?php echo $rs->Fields('FirstName'); ?></td>
    <td><?php echo $rs->Fields('SurName'); ?></td>
    <td><?php echo $rs->Fields('othername'); ?></td>
    <td></td>
  </tr>
  <tr>
    <td>Patient Type: </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input name="radiobutton" type="radio" value="radiobutton" />      
    Employee</td>
    <td><input name="radiobutton" type="radio" value="radiobutton" />
      Non Employee</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>EmployeeID</td>
    <td>Related to </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><?php echo $rs->Fields('employeeid') ?></td>
    <td><?php echo $rs->Fields('relatedto') ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Department</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><?php echo $rs->Fields('department') ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td></td>
    <td>&nbsp;</td>
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
    <td>Sex</td>
    <td><?php echo $rs->Fields('sex') ?></td>
    <td>Date of Birth </td>
    <td><?php echo  $rs->Fields('dob') ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>M/Status</td>
    <td><?php echo $rs->Fields('mstatus'); ?></td>
    <td>Address</td>
    <td><?php echo $rs->Fields('address'); ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Phone</td>
    <td><?php echo $rs->Fields('phone') ?></td>
    <td>Contact person </td>
    <td><?php echo $rs->Fields('contactperson'); ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
