<?php
//filter out drugs that meet given criteria
if(@$_POST['search'] && $searchValue=@$_POST['txtDrugParam']){
	$searchFldCode=$_POST['cboCriteria'];
	$filter=searchDrugStore($searchFldCode,$searchValue);
	
	$osql="select `drugstore`.*,drugs.drugname,druggroups.name
	from drugs inner join `drugstore` on drugs.entryid=`drugstore`.drugid inner join druggroups
	on `drugstore`.druggroup=druggroups.entryid".$filter.
	" and `drugstore`.dispensemode='request' order by drugname";
}

//save the dispensary of requested drugs
elseif(@$_POST['saveDispensary'] && $selectedDrugs=@$_POST['chkSelect']){
	$comment=$_POST['txtComment'];
	//get the staffid of the person doing the posting
	$pharm=$_SESSION['userid'];
	$currTime=date('H:i:s');
	
	//save clinic call
	$date=date('Y-m-d');
	$vticket=getdate();
	
	$sql="insert into `cliniccall` 
	(timein, patientid, 
	date, time, userid,visitticket,TimeLogged,purpose)
	values
		( '" . $_SESSION['logintime'] . "','" . $patientID . "','" . $date . "','" . 
		$_SESSION['logintime'] . "','" . $pharm . "','" . $vticket[0] . "','" . 
		$currTime . "','To collect drugs')";
	$db->execute($sql);
	
	$cliniccallid=$db->Insert_ID();
	
	//save dispensary header
	$sql="insert into `dispensaryvisit` 
	(userid, comment, cliniccallid,timein,timelogged)
	values
	( '" . $pharm . "','" . $comment ."'," . $cliniccallid .",'" . 
	$_SESSION['logintime'] ."','" . $currTime . "')";
	$db->execute($sql);
	
	foreach($selectedDrugs as $drugId){
		//get dispense mode
		$dispenseOn=explode(';',$_POST['dispense'][$drugId],2);//explode runs faster than split
		
		$sql="insert into drugdispensary(drugId, qty, dosage, cliniccallid) values(".
		$drugId.",'".$_POST['qty'][$drugId]."','".$_POST['dosage'][$drugId]."',".
		$cliniccallid .")";
		$db->execute($sql);
		
		$dispensaryid=$db->Insert_ID();
		$sql="insert into drugdispensary_listed(dispensaryid,dispensemode,dispensarystate)
		values(".$dispensaryid.",'".$dispenseOn[0]."','".$_POST['DStatus'][$drugId]."')";
		$db->execute($sql);
		
		//make the nessesary updates for the drugstore to reflect drugs dispensed
		$sql="UPDATE drugstore SET qtyinstock= qtyinstock - ".$_POST['qty'][$drugId]." WHERE drugid=".$drugId;
		$db->execute($sql);
	}
	
	$msg='List saved!';
}

/*//$db->debug=true;
$osql="select * from drugstore where dispensemode='Request' order by drugname limit 0,10";
//get submitted values fro search
		$action=$_POST['Submit'];
		$criteria=$_POST['txtDrugParam'];
		$clause=$_POST['cboCriteria'];
if (($action=='search')) {
		//run a search for selected drugs

switch ($clause):
		//drugs like
		case 1:
			$osql = "select * from drugstore where drugname like '%" . $criteria . "%' AND dispensemode='Request'" ;
			break;
		//drugs like or alternative to	 
		case 2:
			$osql="SELECT druggroup from drugstore where drugname like '%" . $criteria . "%'";
			$rs=$db->execute($osql);
			if ($rs->EOF==false) {
  				$osql="SELECT * from drugstore where drugname LIKE '%" . $criteria                 ."%' OR druggroup   = '" . $rs->fields('druggroup') . "' AND dispensemode='Request'";
			}
			break;
			//alternative drug to
		case 3:
			$osql="SELECT druggroup from drugstore where drugname LIKE '%" . $criteria . "%'";
			$rs=$db->execute($osql);
			if ($rs->EOF==false) {
				$osql="SELECT * from drugstore where druggroup='" . $rs->fields('druggroup') . "' AND dispensemode='Request'" ;
				}
			break;
			//drug groups like
		case 4:
			$osql = "select * from drugstore where druggroup like '%" . $criteria . "%' AND dispensemode='Request'" ;
			break;
		default:
		$osql="select * from drugstore limit 10";
		break;
		endswitch;
		
		
}

//post and save the selected drugs
$posted=$_POST['savedrug'];
if( ($posted=="Save")){
//save the prescription and 
//update the quantities for the prescribed drugs

//the maximum no of drugs posted
$index=$_POST['drugindex'];
$comment=$_POST['txtComment'];
$pharm=$_SESSION['username'];
$logintime=$_POST['LoginTime'];
$timein=date('H:i:s');

	//save dispensary header
	$sql="insert into `dispensaryvisit` 
	(userid, comment, cliniccallid,timein,timelogged)
	values
	( '" . $pharm . "','" . $comment ."','" . $cliniccallid ."','" . $timein ."','" . $logintime . "')";
	$drst1=$db->execute($sql);
	for ($i = 1; $i <= $index; $i++):
	//get the drug code
	$drugcode=$_POST['drugcode' . $i];

if ($drugcode) {

	//get the prescribed quantity
	$qtyp=$_POST['qty' . $i]; 
	//get the dosage
	$dose=$_POST['dosage' . $i];
	//get the name of the person doing the posting
	$pharm=$_SESSION['username'];
	//dispense type
	$dispensemode="Request";
	//Status
	$status=$_POST['DStatus' . $i];
	
	//save the call first
	$timein=date('H:i:s');
	$date=date('Y-m-d');
	$time=date('H:i:s');
	$nurse=$_SESSION['username'];
	$logintime=$_POST['LoginTime'];
	$patientID=$_SESSION['curpid'];
	$vticket=getdate();
	$sql="insert into `cliniccall` 
	(timein, patientid, 
	date, time, userid,visitticket,TimeLogged)
	values
		( '" . $timein . "','" . $patientID . "','" . $date . "','" . $time . "','" . $nurse . "','" . $vticket[0] . "','" . $logintime . "')";
	
	//get the most recent call date 
	$sql="select max(entryid) as entryid from cliniccall where patientID='" .$patientID . "'" ;
	$crst=$db->execute($sql);
	$cliniccallid=$crst->fields('entryid');	
	
	
	$sql="insert into drugdispensary 
	(drugcode, qtydispensed, dosage, dispensemode, 
	dispensarystate,cliniccallid)
	values
	('" . $drugcode  . "','" . $qtyp  . "','" . $dose  . "','" . $dispensemode . "','" . 
	$status  . "','" . $cliniccallid . "')";
	$drst2=$db->execute($sql);
	
	//make the nessesary updates for the drugstore to reflect drugs dispensed
	$sql="UPDATE drugstore SET qtyinstock= qtyinstock - " . $qtyp . " WHERE drugcode='" . 	$drugcode . "'";
	$drst3=$db->execute($sql);
}
endfor;
}
*/


?>
<style type="text/css">
<!--
.style1 {
	color: #FFFFFF;
	font-weight: bold;
}
-->
</style>


<form name="pharmform" method="post"><table width="800" border="0" align="center">
      <tr>
        <td></td>
      </tr>
      
      <tr>
        <td align="left"><strong><a href="home.php">Home </a>- Dispensary</strong></td>
      </tr>
      <tr>
        <td align="left"><strong>Drug Request For: </strong><?php $tsql="SELECT 
  CONCAT_WS(' ',`patients`.`firstname`, `patients`.`othername`, `patients`.`surname`) AS  'Fullname'
FROM
  `patients`
WHERE
  (`patients`.`patientid` ='". $patientID ."')";
  $trs=$db->execute($tsql);
  if ($trs->fields){ echo " " . $trs->fields('Fullname'); } else {echo " No Patient Selected!"; }
  
    ?></td>
      </tr>
      <tr>
        <td height="2"></td>
      </tr>
      <tr>
        <td><p style="color:#FF0000; font-weight:bold"><?php echo $msg?></p></td>
      </tr>
      <tr>
        <td><?php echo dispSearch4DrugsTable()?></td>
      </tr>
      
      <tr>
        <td><?php dispSearchResult(false)?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
	  
        <td align="left">Comments
          <textarea name="txtComment" class="txtarea" id="txtComment"  ></textarea>
          <input type=submit name= "saveDispensary" value= "Save list" class="btnadd"/></td>
      </tr>
    </table>
    </form>
<?php 
	if(!@$_SESSION['logintime']) $_SESSION['logintime']=date('H:i:s');
?>
