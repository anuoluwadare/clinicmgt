<?php
if ($patientID) {
	$today=date('Y-m-d');
	
	//get the most recent callid for this patient
	$sql="select max(entryid) as callid  from cliniccall where date = '" . date('Y-m-d'). 
	"' AND patientID='" .$patientID . "'";
	$rs=$db->execute($sql);
	$callid=$rs->fields('callid');

	$sql="SELECT CONCAT_WS(' ', FirstName,OtherName,SurName) AS `Full Name`,
	Temperature as `Temp`,BloodPressure as `B.P`,Pulserate AS `Pulse Rate`,cliniccall.Date
	FROM patients,cliniccall,vitals WHERE patients.patientid=cliniccall.patientid
	AND cliniccall.entryid=vitals.cliniccallid and vitals.cliniccallid='".$callid."'";

    $pager = new ADODB_Pager($db,$sql); 
    $pager->Render($rows_per_page=1);
}
?>

