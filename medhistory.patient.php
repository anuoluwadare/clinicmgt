<?php
//this module display the entire medical history for a  patient
include ('head.php');
$patientID=$_SESSION['curpid'];
//$db->debug=true;

if ($patientID) {
    $db->SetFetchMode(ADODB_FETCH_ASSOC);
	$rs=$db->Execute("SELECT * FROM patients WHERE patientid='" . $patientID . "'");

$sql="SELECT * from cliniccall WHERE patientid='" . $patientID . "'";
$rs2=$db->execute($sql);

}

//get the most recent call date 
	$sql="select max(entryid) as entryid from cliniccall where patientID='" .$patientID . "'" ;
	$crst=$db->execute($sql);
	$cliniccallid=$crst->fields('entryid');

?>

<table width="100%" border="0">
  <tr>
    <td align="center" valign="top"><form name="medhistory" action="medhistory.patient.php"><table width="600" border="0">
      <tr>
        <td></td>
      </tr>
      <tr>
        <td><table width="100%" border="0">
          <tr>
            <td height="17" align="right"><strong>Full Name </strong></td>
            <td align="left"><?php if ($rs) {echo $rs->Fields('surname') .  " " . $rs->Fields('firstname') . " " . $rs->Fields('othername') ;} ?></td>
            <td align="right"><strong>Age</strong></td>
            <td align="left"><?php if ($rs) {echo date ('Y-m-d') - $rs->Fields('dob') . " years old" ; } ?></td>
          </tr>
          <tr>
            <td align="right"><strong>Department</strong></td>
            <td align="left"><?php if ($rs) { echo $rs->Fields('dept'); } ?></td>
            <td align="right"><strong>Sex</strong></td>
            <td align="left"><?php if ($rs) {echo $rs->Fields('sex'); }?></td>
          </tr>
          <tr>
            <td align="right"><strong>Address</strong></td>
            <td align="left"><?php if ($rs) {echo $rs->Fields('address'); }?></td>
            <td align="right"><strong>Marital Status </strong></td>
            <td align="left"><?php if ($rs) { echo $rs->Fields('mstatus'); }
 ?></td>
          </tr>
          <tr>
            <td align="right"><strong>Current Treatment Status </strong></td>
            <td align="left"><?php $sql="SELECT * from drugdispensary where cliniccallid='" .$cliniccallid . "' AND dispensarystate='WNB'"  ; $r=$db->execute($sql); if ($r->fields==true) {echo 'INCOMPLETE'; } else { echo 'COMPLETE'; } ?>&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="left">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td class="errormsg"><?php  if (!$rs) { echo "No patient Selected";} ?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><strong>Patient CaseNote History By Date </strong></td>
      </tr>
      <tr>
        <td><?php echo " 
				<table width=100% border=0 class=tblshow_patients>
                  <tr><td></td></tr>"; 
				  while ($rs2->fields==true) :
				  	echo "<tr><td><a href=medhistory.patient.php?callid=" . $rs2->fields("entryid") . ">" .$rs2->fields("date") . "</a></td></tr>";
					$rs2->movenext();
				endwhile;
				echo "</table>";
				?></td>
      </tr>
      <tr>
        <td><?php if ($_GET['callid']) { $sql="SELECT
`cliniccall`.`date`,
`treatment`.`complaint`,
`treatment`.`treatment`,
`treatment`.`diagnosis`,
`vitals`.`temperature`,
`vitals`.`bloodpressure`,
`vitals`.`pulserate`,
users.fullname as 'Nurse' ,
`b`.`fullname`as 'Doctor'
FROM
`cliniccall`
Inner Join `treatment` ON `cliniccall`.`entryid` = `treatment`.`cliniccallid`
Inner Join `vitals` ON `cliniccall`.`entryid` = `vitals`.`cliniccallid`
Inner Join `users`  as b ON `treatment`.`doctor` = `b`.`username`
Inner Join `users` ON `vitals`.`userid` = `users`.`username`
WHERE
`cliniccall`.`entryid` = '" . $_GET['callid'] . "'
"; 
    $pager = new ADODB_Pager($db,$sql); 
    $pager->Render($rows_per_page=1);    ?></td>
      </tr>
      <tr>
        <td><strong>Treatment</strong></td>
      </tr>
      <tr>
        <td><?php  $sql="SELECT 
  `drugstore`.`drugname`,
  `drugstore`.`drugcode`,
  `drugdispensary`.`qtydispensed`,
  `drugdispensary`.`dosage`,
  `drugdispensary`.`dispensemode`,
  `drugdispensary`.`dispensarystate`,
  `drugdispensary`.`cliniccallid`
FROM
  `drugstore`
  INNER JOIN `drugdispensary` ON (`drugstore`.`drugcode` = `drugdispensary`.`drugcode`)
WHERE
`drugdispensary`.`cliniccallid` ='" . $_GET['callid'] . "'";
 $pager = new ADODB_Pager($db,$sql); 
   $pager->Render($rows_per_page=6); 
 } ?>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
    </form></td>
  </tr>
</table>
<?php include ('foot.php');?>
