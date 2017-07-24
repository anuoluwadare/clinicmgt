<?php 
//fetch Existing patients and doctors
session_start();
include('conn.php');

//check if user logged in
if ($_SESSION['username']=='') {
	header('Location: default.php?msg=' . 'you must login in order to continue');
	
	}
$sql="SELECT * from users where role='doctor'";
$rs=$db->execute($sql);
$sql="select patientid,concat(SurName , ' ', FirstName, ' ', othername) as fullname from patientbiodata ";
$rs2=$db->execute($sql);

if ($_POST['submit']) {
	$PatientID=$_POST['cboPatient'];
	$DoctorToSee=$_POST['cboDoctor'];
	$ApptDate=$_POST['dob_y'] . '-' . $_POST['dob_m'] . '-' . $_POST['dob_d'] ;
	$ApptTime=$_POST['txtTime'];
	
	$sql="insert into `clinicops`.`appointments` 
	(PatientID, DoctorToSee, ApptDate, ApptTime)
	values ($PatientID" . ",'" . $DoctorToSee . "'," . $ApptDate . "," . $ApptTime .")";
	$db->Begintrans();
	$rs3=$db->execute($sql);
	if (!$rs3) {
		$db->Committrans();
		$msg="Appointment Saved";
	} else {
		$db->Rollbacktrans();
		$msg ="There was a problem saving the appointment";
		
	}
}
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
            <td align="left"><?php include('menu.header.php');  ?></td>
          </tr>
          <tr>
            <td align="right"><a href="logout.php">logout</a> &nbsp;|&nbsp;<span class="bold-blue">welcome <?php echo $_SESSION['username']; ?></span></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><form method="post">
          <table width="100%" border="0">
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>Patient Name</td>
              <td><select name="cboPatient" id="cboPatient">
              <?php
              
              if ($rs2->EOF!=true){
						while (!$rs2->EOF):
                   echo '<option value="' . $rs2->fields('patientid').'">' . $rs2->fields('fullname') . "</option>" ; 
                   $rs2->movenext(); 
                  endwhile;
              } 
              ?>
              </select>     
                </td>
             
            </tr>
            <tr>
              <td>Doctor to see </td>
              <td><select name="cboDoctor" id="cboDoctor" >
              
                  <?php  
                  if ($rs->EOF!=true){
						while (!$rs->EOF):
                   echo '<option value="' . $rs->fields('username').'">' . $rs->fields('fullname') . "</option>" ; 
                   $rs->movenext(); 
                  ?>
              </select>  </td>
			  <?php endwhile; } ?>
            </tr>
            <tr>
              <td>Date</td>
              <td><input name="dob_d" type="text" id="dob_d" size="3" />
-
  <input name="dob_m" type="text" id="dob_m" size="3" />
-
<input name="dob_y" type="text" id="dob_y" size="4" />
(dd-mm-yyyy)</td>
            </tr>
            <tr>
              <td>Time</td>
              <td><input name="txtTime" type="text" id="txtTime" /></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td><input name="submit" type="submit" id="submit" value="save" /></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td class="errormsg"><?php echo $msg; ?></td>
            </tr>
          </table>
        </form></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
