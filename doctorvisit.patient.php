<?php
//include('conn.inc.php');
session_start();

$patientID=$_SESSION['curpid'];
//if no patientID  was found then
//send to the error page

$cliniccallid=$_GET['cid'];

$sql1="SELECT date,entryid
FROM
  cliniccall
WHERE
  (entryid = '" . $cliniccallid . "')";
  
$rst=$db->execute($sql1);



if ($cliniccallid) {
$sql2="SELECT 
  `cliniccall`.`date`,
  `vitals`.`temperature`,
  `vitals`.`bloodpressure`,
  `vitals`.`pulserate`,
  `treatment`.`complaint`,
  `treatment`.`treatment`,
  `treatment`.`diagnosis`,
  `doctorprescription`.`prescription`
FROM
  `cliniccall`
  INNER JOIN `vitals` ON (`cliniccall`.`entryid` = `vitals`.`cliniccallid`)
  INNER JOIN `treatment` ON (`cliniccall`.`entryid` = `treatment`.`cliniccallid`)
  INNER JOIN `doctorprescription` ON (`doctorprescription`.`cliniccallid` = `treatment`.`cliniccallid`)
WHERE
  (`cliniccall`.`entryid` ='" . $cliniccallid . "')";
  
   $pager = new ADODB_Pager($db,$sql2); 
   
  
}

?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <?php while ($rst->fields==true) :
	echo "<td><a href=doctor.attend.php?cid=" .  $rst->fields('cliniccallid') .">" . $rst->fields('date') . "</a></td>";
	$rst->movenext(); 
	endwhile;
	?>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><?php  if ($cliniccallid) {$pager->Render($rows_per_page=1); } ?></td>
  </tr>
</table>
