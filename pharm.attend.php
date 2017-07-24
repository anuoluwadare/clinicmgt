<?php
//filter out drugs that meet given criteria
if(@$_POST['search'] && $searchValue=@$_POST['txtDrugParam']){
	$searchFldCode=$_POST['cboCriteria'];
	$filter=searchDrugStore($searchFldCode,$searchValue);
	
	$osql="select `drugstore`.*,drugs.drugname,druggroups.name
	from drugs inner join `drugstore` on drugs.entryid=`drugstore`.drugid inner join druggroups
	on `drugstore`.druggroup=druggroups.entryid".$filter." order by drugname";
}

//add the dispensary of doctor's prescription of listed drugs to dispensary list
elseif(@$_POST['savedrug'] && $selectedDrugs=@$_POST['chkSelect']){
	if(!@$_SESSION['listedDrugs']) $_SESSION['listedDrugs']=array();

	foreach($selectedDrugs as $drugId){
		//get dispense mode
		$dispenseOn=explode(';',$_POST['dispense'][$drugId],2);//explode runs faster than split
		
		//note for arrays, a+b is not equal to b+a
		$_SESSION['listedDrugs']=array($_POST['listedDrugName'][$drugId]=>
		array('drugId'=>$drugId,
		'qty'=>$_POST['qty'][$drugId],'unit'=>$_POST['listedDrugUnit'][$drugId],
		'dosage'=>$_POST['dosage'][$drugId],'dispenseOn'=>$dispenseOn[0],'status'=>$_POST['DStatus'][$drugId]))+
		$_SESSION['listedDrugs'];
	}

}

//add the dispensary of doctor's prescription of unlisted drugs to dispensary list
elseif (@$_POST['btnOtherDrug']) {
	$drugname=$_POST['txtDrugName'];
	$qty=$_POST['txtQuantity'];
	$unit=$_POST['txtUnit'];
	$dosage=$_POST['txtDosage'];
	
	if(!@$_SESSION['unlistedDrugs']) $_SESSION['unlistedDrugs']=array();
	
	$_SESSION['unlistedDrugs']=
	array($drugname=>array('qty'=>$qty,'unit'=>$unit,'dosage'=>$dosage))+$_SESSION['unlistedDrugs'];
}
		
//remove items from dispensary list		
elseif(@$_POST['removefromList'] && $selectedDrugs=@$_POST['chkSelect2']){
	foreach($selectedDrugs as $idx){
		$drugname=$_POST['listNames'][$idx];
		
		if(array_key_exists($drugname,$_SESSION['listedDrugs'])){
			unset($_SESSION['listedDrugs'][$drugname]);
			continue;
		}	
		if(array_key_exists($drugname,$_SESSION['unlistedDrugs'])){
			unset($_SESSION['unlistedDrugs'][$drugname]);
			continue;
		}	

	}//end foreach
}

//save dispensary list to db
elseif(@$_POST['saveDispensary'] && $selectedDrugs=@$_POST['chkSelect2']){
	$comment=$_POST['txtComment'];
	//get the staffid of the person doing the posting
	$pharm=$_SESSION['userid'];
	$currTime=date('H:i:s');
	
	//save dispensary header
	$sql="insert into `dispensaryvisit` 
	(userid, comment, cliniccallid,timein,timelogged)
	values
	( '" . $pharm . "','" . $comment ."','" . $cliniccallid ."','" . 
	$_SESSION['logintime'] ."','" . $currTime . "')";

	$db->execute($sql);
	
	//save listed drug dispensary
	$sql_start="insert into drugdispensary(drugId, qty, dosage, cliniccallid) values(";
	
	foreach($_SESSION['listedDrugs'] as $drugname=>$drugDetails){
		$sql_end=$drugDetails['drugId'].",'".$drugDetails['qty']."','".$drugDetails['dosage'].
		"','".$cliniccallid."')";
		$db->execute($sql_start.$sql_end);
		
		$dispensaryid=$db->Insert_ID();
		$sql="insert into drugdispensary_listed(dispensaryid,dispensemode,dispensarystate)
		values(".$dispensaryid.",'".$drugDetails['dispenseOn']."','".$drugDetails['status']."')";
		$db->execute($sql);
		
		//make the nessesary updates for the drugstore to reflect drugs dispensed
		$sql="UPDATE drugstore SET qtyinstock= qtyinstock - ".$drugDetails['qty']." WHERE drugid=".$drugId;
		$db->execute($sql);
	}
	
	foreach($_SESSION['unlistedDrugs'] as $drugname=>$drugDetails){
		//find if this drug exists in the db
		$sql="Select * from drugs where drugname='".$drugname."'";
		$rst=$db->execute($sql);
		if(!$rst->EOF){ 
			if($rst->fields('isListed')) continue;
			$drugId=$rst->fields('entryid');
		}
		else{
			$db->execute("Insert into drugs(drugname) values('".$drugname."')");
			$drugId=$db->Insert_ID();
		}
		
		$sql_end=$drugId.",'".$drugDetails['qty']."','".$drugDetails['dosage']."','".$cliniccallid."')";
		$db->execute($sql_start.$sql_end);
		
		$dispensaryid=$db->Insert_ID();
		$sql="insert into drugdispensary_unlisted(dispensaryid,unitmeasure)
		values(".$dispensaryid.",'".$drugDetails['unit']."')";
		$db->execute($sql);
	}	
	
	session_unregister('logintime');
	session_unregister('listedDrugs');
	session_unregister('unlistedDrugs');
	
	$msg='List saved!';
}

?>


<style type="text/css">
<!--
.style1 {
	color: #FFFFFF;
	font-weight: bold;
}
.style2 {color: #FFFFFF}
-->
</style>


<form method="post">
<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
<tr>
 <td height="19" colspan="3" align="left"><a href="home.php">Home</a> - Drug Dispensary</td>
    </tr>
      <tr>
        <td height="18" colspan="3">&nbsp;</td>
      </tr>
      <tr>
        <td height="18" colspan="3">
      <?php 
		$sql="SELECT `users`.`jobdesc`,`users`.`fullname`,prescription
		FROM `users`,`treatment`,`doctorprescription` WHERE 
		`treatment`.cliniccallid=`doctorprescription`.cliniccallid and
		`users`.`staffid` = `treatment`.`doctor` and
		`treatment`.`cliniccallid` = '" . $cliniccallid . "'";
	 
		$rst=$db->execute($sql);
		if (!$rst->EOF){
      		echo
			'Prescription by '.(($jobdesc=$rst->fields('jobdesc'))=='Other'? '': $jobdesc.' ').$rst->fields('fullname').
			'<br />
			<textarea style="height:100px; width:350px">'.$rst->fields('prescription').'</textarea>';
		}
	  ?>
	  </td>
    </tr>
      <tr>
        <td height="18" colspan="3">&nbsp;</td>
      </tr>

      <tr>
        <td colspan="3"><?php echo dispSearch4DrugsTable()?></td>
      </tr>
      <tr>
        <td colspan="3"><p style="color:#FF0000; font-weight:bold"><?php echo $msg?></p></td>
      </tr>
      <tr>
        <td colspan="3"><?php dispSearchResult()?></td>
      </tr>
      <tr>
        <td colspan="3"><table width="100%" cellpadding="0" cellspacing="0">
          <tr>
            <td height="26"><strong>Other Drugs </strong></td>
          </tr>
          <tr><td><table width="100%" border="0">
        <tr>
          <td class="tut-spacer"><span class="style4">Drug Name
              <input name="txtDrugName" type="text" class="textfield" id="txtDrugName" />
          </span></td>
          <td class="tut-spacer"><span class="style4">Quantity
              <input name="txtQuantity" type="text" class="textfield" id="txtQuantity" />
          </span></td>
          <td class="tut-spacer"><span class="style4">Unit
              <input name="txtUnit" type="text" class="textfield" id="txtUnit" />
          </span></td>
          <td class="tut-spacer"><p class="style4">Dosage
            <input name="txtDosage" type="text" class="textfield" id="txtDosage" />
          </p>            </td>
        </tr>
      </table></td></tr>
	  <tr>
	    <td><table width="100%" border="0">
          <tr>
            <td align="left">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td align="right"><input name="btnOtherDrug" type="submit" class="btnadd" id="btnOtherDrug" 
			value="Add to list >>" /></td>
          </tr>
          <tr>
            <td colspan="4" align="left">
			<?php 

			function add2List($drugname,$drugDetails,$dispenseOn,$status,$idx){	
				echo
				'<tr class=TableRow>
				<td>
				<input type="checkbox" name="chkSelect2[]" value="'.$idx.'" checked>
				<input type="hidden" name="listNames['.$idx.']" value="'.$drugname.'">' . $drugname . 
				'</td>
				<td>' . $drugDetails['qty'] . '</td>
				<td>' . $drugDetails['unit'] . '</td>
				<td>' . $drugDetails['dosage']. '</td>
				<td>' . $dispenseOn . '</td>
				<td>' . $status. '</td>
				</tr>';
			}
			
			if(@$_SESSION['listedDrugs'] || @$_SESSION['unlistedDrugs']){
				//atleast a drug has been selected for dispensary
				echo  
				"<strong>Dispensary List</strong>
				<br /><br />
				<table width=100% border=0>
				<tr class=TableHeader style=color:#0099CC>
				<td><input type=checkbox onclick=toggleCheck('chkSelect2[]',this) checked>
				<strong>Drug Name</strong></td>
				<td><strong>Quantity</strong> </td>
				<td><strong>Unit</strong></td>
				<td><strong>Dosage</strong></td>
				<td><strong>Dispense On</strong></td>
				<td><strong>Dispensary Status</strong></td>
				</tr>";
				
				if(!@$_SESSION['listedDrugs']) @$_SESSION['listedDrugs']=array();
				if(!@$_SESSION['unlistedDrugs']) @$_SESSION['unlistedDrugs']=array();
				
				ksort($_SESSION['listedDrugs']); ksort($_SESSION['unlistedDrugs']);
				$idx=0;
				
				foreach($_SESSION['listedDrugs'] as $drugname=>$drugDetails){
					add2List($drugname,$drugDetails,$drugDetails['dispenseOn'],$drugDetails['status'],$idx++);
				}
				
				foreach($_SESSION['unlistedDrugs'] as $drugname=>$drugDetails){
					add2List($drugname,$drugDetails,'Prescription','Not Available',$idx++);
				}
				
				echo '</table>';
			}
			?>
			</td>
            </tr>
          
        </table></td>
	    </tr></table></td>
      </tr>
      <tr>
        <td width="74" height="55">Comments</td>
        <td width="180" valign="bottom"><textarea name="txtComment" class="txtarea" id="txtComment"  ></textarea></td>
        <td width="546" valign="bottom"><input name="saveDispensary" type="submit" class="btnadd" id="saveDispensary" 
		value="Save list" />
          <input name="removefromList" type="submit" class="btnadd" id="removefromList" 
		value="Remove from list" /></td>
      </tr>
  </table>
  </form>
<?php 
	if(!@$_SESSION['logintime']) $_SESSION['logintime']=date('H:i:s');
?>

