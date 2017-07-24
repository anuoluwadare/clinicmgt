<?php
include('head.php');
include_once('functions.php');
include("datepulldown.class.php");

$from = new date_pulldown("fromdate");
$to = new date_pulldown("todate");
$tab='&nbsp;&nbsp;&nbsp;';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>All Reports</title>
<!--<link href="reports/styles.css" rel="stylesheet" type="text/css" />-->
<link href="clinic_inside.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style3 {color: #CC0000; font-weight: bold; }
.style6 {color: #FF6600}
.style7 {color: #0000CC}
-->
</style>
</head>


<script language="javascript">
function date2Str(dateObjName){
	datestr=document.getElementsByName(dateObjName+'[year]')[0].value+'-'+
	document.getElementsByName(dateObjName+'[mon]')[0].value+'-'+
	document.getElementsByName(dateObjName+'[mday]')[0].value
	
	return datestr
}

function setRptSource(url){
	from=date2Str('fromdate')
	to=date2Str('todate')

	url+='&from='+from+'&to='+to
	
	window.open(url,'','height='+(screen.height-70)+',width='+screen.width+',left=0,top=0')
}

function getReport(title,sql,fromClause,dateFld,grpBy){
	sql=escape(sql)
	
	//from=date2Str('fromdate')
	//to=date2Str('todate')

	url='report.php?title='+title+'&sql='+sql+'&fromClause='+fromClause+'&dateFld='+dateFld+'&grpBy='+grpBy
	//+'&from='+from+'&to='+to
	
	//window.open(url,'','height='+(screen.height-70)+',width='+screen.width+',left=0,top=0')
	setRptSource(url)
}

function prepareRpt(selectedText,selectedValue,title,sql,fromClause,dateFld,grpBy){
	title+=selectedText
	fromClause+="'"+selectedValue+"' and "
	getReport(title,sql,fromClause,dateFld,grpBy)
}
</script>


<table width="800px" class="reports" align="center">
			
          <tr>
            <td width="10%"></td>
            <td width="80%"></td>
            <td width="10%"></td>
          </tr>
          <tr>
            <td  >&nbsp;</td>
            <td align="left"><span class="style3">View Records  From 
              <?php echo $from->output().' To '.$to->output()?> Of</span>            </td>
            <td >&nbsp;</td>
          </tr>
          <tr>
            <td  >&nbsp;</td>
            <td align="left"><?php echo $tab?>
			  <span class="style6">Patients</span></td>
            <td >&nbsp;</td>
          </tr>
          <tr>
            <td width="10%"  >&nbsp;</td>
            <td align="left">
			<?php 
				echo $tab.$tab;

				$title='Patients who visited the clinic';
				
				$detailFlds=',cliniccall.purpose as `Purpose of Visit`';
				
				/*just in case you are wondering why the set of statements below was not compressed to one statement,
				it's b'cos breaking it up this way does not give an error when it is passed as an argument to an object event
				e.g onChange event.
				
				## is a place holder for table flds
				# is a place holder for $detailFlds
				*/

				$sql="Select patients.PatientId as `Patient ID`,concat(surname,' ',firstname,' ',othername) as Name,".
				htmlspecialchars(makeHtmlElementCol('Frequency',
				"<a href=\"rptdetails.php?pid=##&detailFlds=#\">##</a>",
				array('patients.PatientId','count(*)'))).",employeeType as `Employee Type`";
				
				$sql=addslashes($sql);
				
				$fromClause=' from cliniccall,patients where cliniccall.patientId=patients.patientId and ';
				
				$dateFld='cliniccall.date';
				$grpBy=' GROUP BY patients.PatientId, surname, firstname, othername ORDER BY patients.PatientId';
				
				echo 
				" <a href=\"javascript:getReport('".$title."','".str_replace("#",$detailFlds,$sql)."','".$fromClause.
				"','".$dateFld."','".$grpBy."')\">".$title;
			?>
			</a></td>
            <td width="10%" >&nbsp;</td>
          </tr>
          
          <tr>
            <td width="10%" >&nbsp;</td>
            <td align="left" >
			<?php 
				echo $tab.$tab;

				$title='Patients who had ';
				
				$fromClause=' from treatment ,cliniccall,patients where cliniccall.patientId=patients.patientId';
				$fromClause.=' and cliniccall.entryid=treatment.cliniccallid and diagnosis=';
				
				echo 
				'<span class="style7">'.$title.'</span>';
				
				echo
				"<select name=\"ailments\" style=\"width:300px\" onchange=\"if(this.value)
				prepareRpt(this.value,this.value,'".$title."','".str_replace("#","",$sql)."','".$fromClause.
				"','".$dateFld."','".$grpBy."')\">
				<option value=\"\">---select an ailment---</option>";

              	$list_sql="select distinct diagnosis from treatment order by diagnosis";
				$rs=$db->execute($list_sql);
				while ($rs->EOF==false):
					echo 
					'<option value="'.$rs->fields('diagnosis').'">'.$rs->fields('diagnosis').'</option>';
					$rs->MoveNext(); 
				 endwhile; 
			 ?>
			</select>			</td>
            <td width="10%" >&nbsp;</td>
          </tr>
          <tr>
            <td width="10%" >&nbsp;</td>
            <td align="left" >
			<?php 
				echo $tab.$tab;

				$title='Patients who requested for ';
				
				$fromClause=' from drugs inner join drugdispensary on drugs.entryid=drugdispensary.drugid'.
				' inner join cliniccall on drugdispensary.cliniccallid=cliniccall.entryid'.
				' inner join patients on cliniccall.patientId=patients.patientId'.
				' left join drugdispensary_listed on drugdispensary.entryid=drugdispensary_listed.dispensaryid'.
				' where drugs.entryid=';
				
				$detailFlds=',drugdispensary.qty as `Quantity`,'.
				'drugdispensary_listed.dispensemode as `Dispensed on`,'.
				'drugdispensary_listed.dispensarystate as `Status`';
				
				echo 
				'<span class="style7">'.$title.'</span>';
				
				echo
				"<select name=\"drugs\" style=\"width:300px\" onchange=\"if(this.value)
				prepareRpt(this.options[this.selectedIndex].text,this.value,'".
				$title."','".str_replace("#",$detailFlds,$sql)."','".$fromClause."','".$dateFld."','".$grpBy."')\">
				<option value=\"\">---select a drug---</option>";

              	$list_sql="select * from drugs order by drugname";
				$rs=$db->execute($list_sql);
				while (!$rs->EOF):
					echo 
					'<option value="'.$rs->fields('entryid').'">'.$rs->fields('drugname').'</option>';
					$rs->MoveNext(); 
				endwhile; 
			 ?>
			</select>			</td>
            <td width="10%" >&nbsp;</td>
          </tr>
          <tr>
            <td >&nbsp;</td>
            <td align="left" >
			<?php 
			  	echo $tab.$tab;
				
				$title='Medical history for patient ';
				
				echo 
				'<span class="style7">'.$title.'</span>';
				
				$url="'rptCaseFile.php?title=".$title."'+patientId.value+'&pid='+patientId.value";
				
				echo
				'<input type="text" id="patientId" name="patientId" size="15" style="color:#000099"'. 
				"onkeydown=\"if(event.keyCode==13 && this.value) setRptSource(".$url.")\" />".
				'<input type="button" name="go" value="Go!" style="border: 1px outset #00008B; background-color:#ADD8E6"'.
				"onclick=\"if(patientId.value) setRptSource(".$url.")\" />";
			?>			</td>
            <td >&nbsp;</td>
          </tr>
          <tr>
            <td >&nbsp;</td>
            <td align="left" ><?php echo $tab?>
			  <span class="style6">Drugs</span></td>
            <td >&nbsp;</td>
          </tr>
          <tr>
            <td width="10%" >&nbsp;</td>
            <td align="left" >
			<?php 
				echo $tab.$tab;

				$title='Drug dispensary';
				
				/*just in case you are wondering why the set of statements below was not compressed to one statement,
				it's b'cos breaking it up this way does not give an error when it is passed as an argument to an object event
				e.g onChange event*/
				
				$sql="Select drugname as `Drug Name`,concat(sum(qty),' ',".
				"IFNULL( drugdispensary_unlisted.unitmeasure, drugstore.unitmeasure )) as `Qty Demanded`,".
				"IFNULL( dispensarystate, 'Not Available' ) as `Dispensary Status`,".
				"count(*) as `Status Frequency`";
				$sql=addslashes($sql);
				
				$fromClause='FROM cliniccall'.
				' INNER JOIN drugdispensary ON cliniccall.entryid = drugdispensary.cliniccallid'.
				' INNER JOIN drugs ON drugs.entryid = drugdispensary.drugid'.
				' LEFT JOIN drugstore ON drugs.entryid = drugstore.drugid'.
				' LEFT JOIN drugdispensary_listed ON drugdispensary.entryid = drugdispensary_listed.dispensaryid'.
				' LEFT JOIN drugdispensary_unlisted ON drugdispensary.entryid = drugdispensary_unlisted.dispensaryid'.
				' WHERE ';

				$dateFld='date';
				$grpBy=' GROUP BY drugname,`Dispensary Status`'.
				' ORDER BY drugname,`Dispensary Status`';

				echo 
				" <a href=\"javascript:getReport('".$title."','".$sql."','".$fromClause.
				"','".$dateFld."','".$grpBy."')\">".$title;
			?>			</td>
            <td width="10%" >&nbsp;</td>
          </tr>
          <tr>
            <td >&nbsp;</td>
            <td align="left" ><?php echo $tab?>
			  <span class="style6">Clinic Services</span></td>
            <td >&nbsp;</td>
          </tr>
          <tr>
            <td width="10%" >&nbsp;</td>
            <td align="left" >
			<?php 
				echo $tab.$tab;

				$title='Average patient waiting time for a  nurse';
				
				$colName='`Average Waiting Time`';
				$sql="SELECT SEC_TO_TIME( AVG( TIME_TO_SEC( TIMEDIFF(`time`,`timeIN`) ) ) ) as ".$colName;
				
				$fromClause=' from cliniccall where ';
				
				$dateFld='cliniccall.date';
				$grpBy='';
				
				echo 
				" <a href=\"javascript:getReport('".$title."','".$sql."','".$fromClause.
				"','".$dateFld."','".$grpBy."')\">".$title;
			?>			</td>
            <td width="10%" >&nbsp;</td>
          </tr>
          <tr>
            <td width="10%" >&nbsp;</td>
            <td align="left" >
			<?php 
				echo $tab.$tab;

				$title='Average patient waiting time for a doctor';
				
				$sql="SELECT SEC_TO_TIME( AVG( TIME_TO_SEC( TIMEDIFF(
				treatment.`timeIN`,cliniccall.`timeLogged`) ) ) ) as ".$colName;
				
				$fromClause=' from cliniccall,treatment where cliniccall.entryid=treatment.cliniccallid and ';
				
				$dateFld='cliniccall.date';
				$grpBy='';
				
				echo 
				" <a href=\"javascript:getReport('".$title."','".$sql."','".$fromClause.
				"','".$dateFld."','".$grpBy."')\">".$title;
			?>			</td>
            <td width="10%" >&nbsp;</td>
          </tr>
          <tr>
            <td width="10%" >&nbsp;</td>
            <td align="left" >
			<?php 
				echo $tab.$tab;

				$title='Average patient waiting time for a pharmacist';
				
				$sql="SELECT SEC_TO_TIME( AVG( TIME_TO_SEC( TIMEDIFF(dispensaryvisit.`timeIN` ,".
				" CASE lower( cliniccall.purpose )".
				" WHEN \'to see doctor\'".
				" THEN treatment.`timeLogged`".
				" ELSE cliniccall.`timeLogged`".
				" END". 
				" ) ) ) ) as ".$colName;
				
				$fromClause=' FROM cliniccall'.
				' INNER JOIN dispensaryvisit ON cliniccall.entryid = dispensaryvisit.cliniccallid'.
				' LEFT JOIN treatment ON treatment.cliniccallid = dispensaryvisit.cliniccallid WHERE ';
				
				$dateFld='cliniccall.date';
				$grpBy='';
				
				echo 
				" <a href=\"javascript:getReport('".$title."','".$sql."','".$fromClause.
				"','".$dateFld."','".$grpBy."')\">".$title;
			?>			</td>
            <td width="10%" >&nbsp;</td>
          </tr>
          <tr>
            <td >&nbsp;</td>
            <td align="left" ><?php echo $tab?>
			  <span class="style6">Others</span></td>
            <td >&nbsp;</td>
          </tr>
          <tr>
            <td width="10%" >&nbsp;</td>
            <td align="left" >
			<?php 
				echo $tab.$tab;

				$title='Referrals that have been made';
				
				/*just in case you are wondering why the set of statements below was not compressed to one statement,
				it's b'cos breaking it up this way does not give an error when it is passed as an argument to an object event
				e.g onChange event*/
				$sql="Select hospitals.hospital as Hospital,count(*) as `Frequency`";
				
				$fromClause=' from cliniccall,referrals,hospitals where referrals.hospId=hospitals.entryid'.
				' and cliniccall.entryid=referrals.cliniccallid and ';
				
				$dateFld='cliniccall.date';
				$grpBy=' GROUP BY hospitals.hospital ORDER BY hospitals.hospital';
				
				echo 
				" <a href=\"javascript:getReport('".$title."','".$sql."','".$fromClause.
				"','".$dateFld."','".$grpBy."')\">".$title;
			?>
			</td>
            <td width="10%" >&nbsp;</td>
          </tr>
          <tr>
            <td >&nbsp;</td>
            <td align="left" >
			<?php 
				echo $tab.$tab;

				$title='Ailment statistics';
				
				/*just in case you are wondering why the set of statements below was not compressed to one statement,
				it's b'cos breaking it up this way does not give an error when it is passed as an argument to an object event
				e.g onChange event*/
				$sql="Select diagnosis as `Ailment`,count(*) as `Frequency`";
				
				$fromClause=' from cliniccall,treatment where cliniccall.entryid=treatment.cliniccallid and ';
				
				$dateFld='cliniccall.date';
				$grpBy=' GROUP BY diagnosis';
				$grpBy.=' ORDER BY diagnosis';
				
				echo 
				" <a href=\"javascript:getReport('".$title."','".$sql."','".$fromClause.
				"','".$dateFld."','".$grpBy."')\">".$title;
			?>
			</td>
            <td >&nbsp;</td>
          </tr>
          <tr>
            <td >&nbsp;</td>
            <td align="left" >&nbsp;</td>
            <td >&nbsp;</td>
          </tr>
          <tr>
            <td >&nbsp;</td>
            <td align="left" ><span class="style3">View Records Of </span></td>
            <td >&nbsp;</td>
          </tr>
          <tr>
            <td >&nbsp;</td>
            <td align="left" ><?php echo $tab?>
			  <span class="style6">Drugs</span></td>
            <td >&nbsp;</td>
          </tr>
          <tr>
            <td width="10%" >&nbsp;</td>
            <td align="left" >
			<?php 
				echo $tab.$tab;

				$title='Drugs that are above re-order level';
				
				$sql="Select drugcode as `Drug Code`,drugname as `Drug Name`,name as `Drug Group`,Dosage,";
				$sql.="qtyinstock as `Qty in Stock`,reorderlevel as `Re-order Level`,";
				$sql.="unitmeasure as `Unit of Measurement`,dispensemode as `Dispense on`";
				
				$fromClause=' from drugs,drugstore,druggroups where drugs.entryid=drugstore.drugid'.
				' and drugstore.druggroup=druggroups.entryid'.
				' and qtyinstock>reorderlevel';
				
				$dateFld='';
				$grpBy=' ORDER BY drugname';
				
				echo 
				" <a href=\"javascript:getReport('".$title."','".$sql."','".$fromClause.
				"','".$dateFld."','".$grpBy."')\">".$title;
			?>			</td>
            <td width="10%" >&nbsp;</td>
          </tr>
          <tr>
            <td >&nbsp;</td>
            <td align="left" >
			<?php 
				echo $tab.$tab;

				$title='Drugs that are within or below re-order level';
				
				$fromClause=str_replace('>','<=',$fromClause);
				
				echo 
				" <a href=\"javascript:getReport('".$title."','".$sql."','".$fromClause.
				"','".$dateFld."','".$grpBy."')\">".$title;
			?>			</td>
            <td >&nbsp;</td>
          </tr>
          <tr>
            <td >&nbsp;</td>
            <td align="left" ><?php echo $tab?>
			  <span class="style6">Others</span></td>
            <td >&nbsp;</td>
          </tr>
          <tr>
            <td width="10%" >&nbsp;</td>
            <td align="left" >
			<?php 
				echo $tab.$tab;

				$title='Hospitals listed for referrals';
				
				$sql="Select Hospital,Specialty,Address,Phone,managingDirector as `Managing Director`,Comment";
				
				$fromClause=' from Hospitals';
				
				$dateFld='';
				$grpBy=' ORDER BY Hospital';
				
				echo 
				" <a href=\"javascript:getReport('".$title."','".$sql."','".$fromClause.
				"','".$dateFld."','".$grpBy."')\">".$title;
			?>			</td>
            <td width="10%" >&nbsp;</td>
          </tr>
          <tr>
            <td width="10%">&nbsp;</td>
            <td>&nbsp;</td>
            <td width="10%">&nbsp;</td>
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
include ('foot.php');
?>
