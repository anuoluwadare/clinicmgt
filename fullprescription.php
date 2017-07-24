<?php
include ('head.php');
if ($_SESSION['username']=="") {
header("Location: index.php");
}
$patientID=$_GET['patientid'];
$cliniccallid=$_GET['callid'];
if ($patientID!="" and $cliniccallid!="") {

$tsql="SELECT `drugs`.`drugname` , drugdispensary.`qty` , drugdispensary.`dosage` , 
drugdispensary_listed.`dispensemode` 
FROM drugs
INNER JOIN `drugstore` ON drugs.entryid = `drugstore`.drugid
INNER JOIN drugdispensary ON drugdispensary.`drugid` = `drugstore`.`drugid` 
INNER JOIN drugdispensary_listed ON drugdispensary.entryid = drugdispensary_listed.dispensaryid
WHERE drugdispensary.`cliniccallid` = '".$cliniccallid."'";

$tsql2="SELECT `drugname` , `qty` , `unitmeasure` , `dosage` 
FROM `drugs` , drugdispensary, drugdispensary_unlisted
WHERE `drugs`.entryid = drugdispensary.drugid
AND drugdispensary.entryid = drugdispensary_unlisted.dispensaryid
AND drugdispensary.`cliniccallid` = '".$cliniccallid."'";


}



?>

<table width="600" border="0" align="center">
  <tr>
    <td></td>
  </tr>
  <tr>
    <td><strong>Drug Prescription </strong></td>
  </tr>
  <tr>
    <td><?php   $pager = new ADODB_Pager($db,$tsql); 
    $pager->Render($rows_per_page=12); ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Other Drugs</strong> </td>
  </tr>
  <tr>
    <td><?php   $pager = new ADODB_Pager($db,$tsql2); 
    $pager->Render($rows_per_page=12); ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<?php include ('foot.php');?>