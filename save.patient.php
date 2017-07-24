<?php 
session_start();
$mode=$_POST['mode'];
	include('conn.php');
	include('functions.php');


?>
<link href="styles.css" rel="stylesheet" type="text/css" />

<table width="100%" border="0">
  <tr>
    <td align="center" valign="top"><table width="600" border="0">
      <tr>
        <td><table width="100%" border="0">
          <tr>
            <td><?php include('banner.header.php') ?></td>
          </tr>
          <tr>
            <td align="right"><a href="logout.php"><span class="bold-blue">&nbsp;welcome <?php echo $_SESSION['username']; ?></span>|&nbsp;logout</a></td>
          </tr>
          <tr>
            <td align="right"><?php include('menu.header.php');  ?></td>
          </tr>
          <tr>
            <td align="right">&nbsp;</td></tr>
        </table></td>
      </tr>
      <tr>
        <td><?php

	
	
	
	$firstname=$_POST['txtFirstname'] ;
	$othername=$_POST['txtOthername'] ;
	$surname=$_POST['txtSurname'] ;
	$patienttype=$_POST['optPatientType'] ;
	$employeeid=$_POST['txtEmployeeID'] ;
	$department=$_POST['txtDept'] ;
	$relatedto=$_POST[' txtRelatedTo'];
	$sex=$_POST['cboSex'] ;
	$mstatus=$_POST['cboMstatus'] ;
	$phone=$_POST['txtPhone'];
	$dob_y=$_POST['dob_y'] ;
	$dob_m=$_POST['dob_m'];
	$dob_d=$_POST['dob_d'];
	$dob=$dob_y . '-' . $dob_m . '-' . $dob_d;
	$address=$_POST['txtAddress'] ;
	$contactperson=$_POST['txtCntPerson'] ;


switch ($mode) :
	case "n":
		//it is a new entry so add
		$sql="insert into `clinicops`.`patientbiodata` (FirstName, OtherName, SurName, PatientType, 			              EmployeeID, Department, RelatedTo, Sex, MStatus, Phone, DOB, Address, ContactPerson)
	         values( '" . $firstname . "','" . $othername . "','" . $surname . "','" . $patienttype .              "','" . $employeeid . "','" . $department . "','" . $relatedto . "','" . $sex . "','" .              $mstatus . "','" . $phone . "','" . $dob . "','" . $address . "','" . $contactperson .              "')";
			 $db->Execute($sql);
			 $patientID = $db->Insert_ID();
			 
			echo "Patient entry saved: Patient Number is :" . $patientID ;
			break;
	case "u":
		//update the existing record
		$sql="UPDATE `clinicops`.`patientbiodata`  SET FirstName='"  . $firstname . "', OtherName='" 	. $othername . "', SurName='" . $surname ."', PatientType='" . $patienttype ."', EmployeeID='" . $$employeeid . "', Department='" .$department ."', RelatedTo='" .$relatedto ."', Sex='" . $sex . "', MStatus='" . $$mstatus ."', Phone='" . $phone . "', DOB='" .$dob . "', Address='" . $address ."', ContactPerson='" . $$contactperson . "' WHERE patientID=" . $patientID ;
		$db->Execute($sql);
		echo "Patient Record for " . $firstname . ' ' . $surname . "has been updated";
		break;		
endswitch;
			
			
			?>&nbsp;&nbsp;&nbsp;&nbsp;<a href ="nurse.attend.php?pid=<?php  echo $patientID; ?>">Continue</a></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
