<?php 
include ('head.php');
include("datepulldown.class.php");
if ($_POST['txtPatientID']){
//we want to update
	$sql="SELECT * FROM Patients WHERE patientID='" . $_POST['txtPatientID'] . "'";
	$myrst=$db->execute($sql);


}

$dobdate = new date_pulldown("dobdate");
//no one should be older than 1940 hopefully
$dobdate->setYearStart(1960);
$dobdate->setYearEnd(date('Y'));
$mode=$_GET['mode'];
$msg="";

	$patientid=$_POST['txtPatientID'];
	$firstname=$_POST['txtFirstname'] ;
	$othername=$_POST['txtOthername'] ;
	$surname=$_POST['txtSurname'] ;
	$employeetype=$_POST['cboEmployType'] ;
	$employeeid=$_POST['txtEmployeeID'] ;
	$department=$_POST['txtDept'] ;
	$sex=$_POST['cboSex'] ;
	$mstatus=$_POST['cboMstatus'] ;
	$phone=$_POST['txtPhone'];
	$dob=$_POST['dobdate'] ;
	$a=$dob['year'] . '-' . $dob['mon'] . '-' .$dob['mday'];
	$address=$_POST['txtAddress'] ;
	$nocname=$_POST['nocName'];
	$nocphone=$_POST['nocPhone'];
	$nocaddress=$_POST['nocAddress'];
	
	if ( ($firstname=="") || ($surname=="" ) || ($patientid=='')) {
$mode='e';
}
switch ($mode) :
	case "n":
		//it is a new entry so add
		$sql="insert into patients (patientid, firstname, othername, surname, employeetype, employeeid, 
	dept, sex, mstatus, phone, dob, address, nokname, nocaddress, nocphone)
	         values( '" . $patientid . "','" . $firstname . "','" . $othername . "','" . $surname . "','" . $employeetype . "','" . $employeeid . "','" . $department . "','"  . $sex . "','" .  $mstatus . "','" . $phone . "','" . $a . "','" . $address . "','" . $nocname . "','" .  $nocaddress . "','" . $nocphone . "')";
		$done= $db->Execute($sql);
		if ($done==true) {
			$msg = "<span class=style4>Patient entry saved:  Patient Number is : " . $patientid . "</span>" ;
		} else {
			$msg= "Patient could not be saved! error was " . $db->errormsg() ;
		}
		break;
	case "u":
		//update the existing record
		$sql="UPDATE patients  SET FirstName='"  . $firstname . "', OtherName='" 	. $othername . "', SurName='" . $surname ."', PatientType='" . $patienttype ."', EmployeeID='" . $$employeeid . "', Department='" .$department ."', RelatedTo='" .$relatedto ."', Sex='" . $sex . "', MStatus='" . $mstatus ."', Phone='" . $phone . "', DOB='" .$dob . "', Address='" . $address ."', nokname='" . $nocname  ."', nocaddress='" . $nocaddress  . "', nocphone='" . $nocphone . "' WHERE patientID='" . $patientID ."'";
		$db->Execute($sql);
		$msg= "Patient Record for " . $firstname . ' ' . $surname . "has been updated";
		break;
	case 'e' : 
	//error entry
		if ($_GET['mode']!=""){
		$msg= "Patient could not be saved!";
		}
		break;		
endswitch;
	

?>
<script language="javascript">
	function Process()
	{
	objform=document.forms("newpatient")
	pid=objform.pid.value
	if (pid) {
		//its an update
		objform.mode.value="u"
				
		} else {
		
		objform.mode.value="n"
		
		
		}// end if
		objform.action="new.patient.php?mode=" + objform.mode.value
		objform.submit()
	
	
	}//end function

</script>


<table width="100%" border="0">
  <tr>
 
    <td align="center" valign="top"><table width="600" border="0">
      <tr>
        <td></td>
      </tr>
      <tr>
        <td><form method="post" action="new.patient.php" name="newpatient"><table width="100%" border="0">
          
          <tr>
            <td colspan="5" align="left" class="poll"><strong><a href="home.php">Home </a>- New Patient </strong></td>
          </tr>
          <tr>
            <td colspan="5" align="left" class="poll"></td>
          </tr>
          <tr>
            <td colspan="5" align="left" class="errormsg"><?php echo $msg; ?></td>
            </tr>
          <tr>
            <td width="20%" align="right" class="poll">PatientID</td>
            <td width="28%" align="left"><input name="txtPatientID" type="text" class="textfield" id="txtPatientID" value="<?php if ($myrst->fields) { echo $myrst->fields('patientid') ; }  ?>"/>
              <input name="pid" type="hidden" id="pid" value="<?php if ($myrst->fields) { echo "u" ; }  ?>"/></td>
            <td width="14%" align="right"><span class="poll">Surname</span></td>
            <td width="38%" colspan="2" align="left"><input name="txtSurname" type="text" class="textfield" id="txtSurname" value="<?php if ($myrst->fields) { echo $myrst->fields('surname') ; }  ?>"/></td>
            </tr>
          <tr>
            <td align="right" class="poll">Firstname</td>
            <td align="left"><input name="txtFirstname" type="text" class="textfield" id="txtFirstname" value="<?php if ($myrst->fields) { echo $myrst->fields('firstname') ; }  ?>"/>
              <input name="mode" type="hidden" id="mode" /></td>
            <td align="right"><span class="poll">Othername</span></td>
            <td colspan="2" align="left"><input name="txtOthername" type="text" class="textfield" id="txtOthername" value="<?php if ($myrst->fields) { echo $myrst->fields('othername') ; }  ?>"/></td>
            </tr>
          <tr>
            <td align="right" class="poll">&nbsp;</td>
            <td align="left">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td colspan="2" align="left">&nbsp;</td>
            </tr>
          <tr>
            <td align="right" class="poll">Sex</td>
            <td align="left"><select name="cboSex" id="cboSex">
              <option value="male" selected="selected">Male</option>
              <option value="female">Female</option>
            </select></td>
            <td align="right"><span class="poll">Marital Status </span></td>
            <td colspan="2" align="left"><select name="cboMstatus" id="cboMstatus">
              <?php
              $sql="SELECT * from mstatus";
			  $rs2=$db->execute($sql);
             
						while ($rs2->EOF==false):
                   echo '<option value="' . $rs2->fields('entryid').'">' . $rs2->fields('mstatus') . "</option>" ; 
                   $rs2->movenext(); 
                  endwhile;
              ?>
            </select></td>
          </tr>
          <tr>
            <td align="right" class="poll">Date of Birth<br />
              <span class="smallfont">(dd-mm-yyyy) </span></td>
            <td align="left"> <?php echo $dobdate->output(); ?></td>
            <td align="right"><span class="poll">Phone</span></td>
            <td colspan="2" align="left"><input name="txtPhone" type="text" class="textfield" id="txtPhone" value="<?php if ($myrst->fields) { echo $myrst->fields('phone') ; }  ?>" /></td>
            </tr>
          <tr>
            <td align="right" class="poll">Address</td>
            <td align="left" class="poll">&nbsp;</td>
            <td align="right" class="poll">&nbsp;</td>
            <td colspan="2" align="left" class="poll">&nbsp;</td>
            </tr>
          
          <tr>
            <td align="right" class="poll">&nbsp;</td>
            <td align="left" class="poll">&nbsp;</td>
            <td align="right" class="poll">&nbsp;</td>
            <td colspan="2" align="left">&nbsp;</td>
          </tr>
          <tr>
            <td align="right" class="poll">Employee Type</td>
            <td align="left" class="poll">&nbsp;</td>
            <td align="right" class="poll">&nbsp;</td>
            <td colspan="2" align="left">&nbsp;</td>
            </tr>
          <tr>
            <td align="right" class="poll">Employee ID </td>
            <td align="left"><input name="txtEmployeeID" type="text" class="textfield" id="txtEmployeeID" value="<?php if ($myrst->fields) { echo $myrst->fields('employeeid') ; }  ?>"/></td>
            <td align="right">Employee Type</td>
            <td colspan="2" align="left"><select name="cboEmployType" id="cboEmployType">
              <option value="permanent">Permanent</option>
              <option value="contract">Contract</option>
            </select></td>
            </tr>
          <tr>
            <td align="right" valign="top" class="poll"><p>Department</p>
              <p>Address</p></td>
            <td align="left"><input name="txtDept" type="text" class="textfield" id="txtDept" value="<?php if ($myrst->fields) { echo $myrst->fields('dept') ; }  ?>"/>
              <span class="poll">
              <textarea name="txtAddress" cols="14" id="txtAddress"><?php if ($myrst->fields) { echo $myrst->fields('address') ; }  ?>
              </textarea>
              </span></td>
            <td align="right">&nbsp;</td>
            <td colspan="2" align="left">&nbsp;</td>
            </tr>
          <tr>
            <td height="23" align="right" class="poll">&nbsp;</td>
            <td align="left">&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2" align="left">&nbsp;</td>
          </tr>
          <tr>
            <td height="23" align="right" class="poll">Next of Kin </td>
            <td align="left">&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2" align="left">&nbsp;</td>
          </tr>
          <tr>
            <td height="23" align="right" class="poll">Name</td>
            <td align="left"><input name="nocName" type="text" class="textfield" id="nocName" value="<?php if ($myrst->fields) { echo $myrst->fields('nokname') ; }  ?>"/></td>
            <td align="right">Address</td>
            <td colspan="2" align="left"><textarea name="nocAddress" id="nocAddress"><?php if ($myrst->fields) { echo $myrst->fields('nocaddress') ; }  ?></textarea></td>
          </tr>
          <tr>
            <td height="23" align="right" class="poll">Phone</td>
            <td align="left"><input name="nocPhone" type="text" class="textfield" id="nocPhone" value="<?php if ($myrst->fields) { echo $myrst->fields('nocphone') ; }  ?>" /></td>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td height="23" align="right" class="poll">&nbsp;</td>
            <td align="left">&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2"><input name="Button" type="button" class="btnlogin" value="Save" onclick="Process()" /></td>
            </tr>
          <tr>
            <td align="right" class="poll">&nbsp;</td>
            <td align="left">&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
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

<?php include ('foot.php');?>
