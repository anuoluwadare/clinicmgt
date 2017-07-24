<?php
	//determine wheither drug dispensary is on prescrition(add/edit) or request
	include('head.php');
	
	echo
	'<script language="JavaScript" src="General.js" type="text/javascript">
	</script>';
	
	function dispSearch4DrugsTable(){
?>
		<table width="100%" border="0" class="doc_attend">
          <tr>
            <td class="article-title"><strong>Get from store</strong></td>
            <td><select name="cboCriteria" class="textfield" id="cboCriteria">
              <?php
				  	$list_src=
					array('Drugs Like','Drugs Like Or Alternate Drug To','Alternate Drug To','Drug Groups like');
					
				  	displayListFromArray($list_src,@$searchFldCode);
				  ?>
            </select>			</td>
            <td><input name="txtDrugParam" type="text" class="textfield" id="txtDrugParam"
			value="<?php echo @$searchValue?>" />
                <input name="search" type="submit" class="btnadd" id="search" value="Search" /></td>
          </tr>
        </table>
<?php
	}//end function
	
	function dispSearchResult($dispensePrescription=true){
		global $db,$osql;
?>
		<table width="100%" border="0" cellspacing="1" cellpadding="1">
          <tr bgcolor="#0099CC" class="style1">
            <td><input type="checkbox" onclick="toggleCheck('chkSelect[]',this)">Drug</td>
            <td>Qty in stock</td>
            <td>Qty Dispensed</td>
            <td>Unit</td>
            <td>Dosage</td>
            <td>Dispense On</td>
            <td>Dispensary Status</td>
          </tr>
		  <?php
			if ($msrt=$db->execute($osql)){
				while (!$msrt->EOF):
					$drugId=$msrt->fields('drugid');
					
					echo '<tr align=left>
					<td>
					<input type="checkbox" value="'.$drugId.'" name="chkSelect[]">'. $msrt->fields('drugname') . 
					'<input type="hidden" name="listedDrugName['.$drugId.']" value="'.$msrt->fields('drugname').'">
					</td>';
					echo '<td>' . $msrt->fields('qtyinstock') . '</td>';
					echo '<td><input type="text" name="qty['.$drugId.']" size="4" class="textfield"></td>';
					echo '<td>' . $msrt->fields('unitmeasure') . 
					'<input type="hidden" name="listedDrugUnit['.$drugId.']" value="'.$msrt->fields('unitmeasure').'">
					</td>';
					echo '<td><input type="text" name="dosage['.$drugId.']" size="4" class="textfield"
					value="'.$msrt->fields('dosage').'"></td></td>';
					
					echo '<td><select name="dispense['.$drugId.']" style="width:120px" 
					onclick="displayLOV(this.value,this.form.elements[\'DStatus['.$drugId.']\'],\'\')">';
					
					if($dispensePrescription){
						echo
						'<option value=
						"Prescription;Dispensed;Not Available;TBB:Partially Dispensed - TBB;WNB:Partially Dispensed - WNB"
						>Prescription</option>';
						
						$list_src=array('Dispensed'=>'Dispensed','Not Available'=>'Not Available',
						'TBB'=>'Partially Dispensed - TBB','WNB'=>'Partially Dispensed - WNB');
					}
					else{
						$list_src=array('Dispensed'=>'Dispensed','WNB'=>'Partially Dispensed - WNB');
					}
					
					if(strtolower($msrt->fields('dispensemode'))=='request')  
						echo '<option value="Request;Dispensed;WNB:Partially Dispensed - WNB">Request</option>';
					
					echo '</select></td>';
					
					echo '<td>
					<select name="DStatus['.$drugId.']" style="width:200px">';
						displayListFromArray($list_src,'');
					echo
					'</select>   
					 </td></tr>';
					
					$msrt->movenext();
				endwhile;
		 }
		 
		 if($dispensePrescription){
	   ?>
		    <tr >
            <td height="30"></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td align="right"><input type=submit name= "savedrug" value= "Add to list >>" class="btnadd"/></td>
          </tr>
        
<?php
		}//end if
		
		echo '</table>';	
	}// end function
	
	
	$patientID=$_SESSION['curpid'];
	
	$sql="SELECT cliniccall.entryid, dispensaryvisit.cliniccallid
	FROM cliniccall
	INNER JOIN `doctorprescription` ON cliniccall.entryid = `doctorprescription`.cliniccallid
	LEFT JOIN dispensaryvisit ON `doctorprescription`.cliniccallid = dispensaryvisit.cliniccallid
	WHERE cliniccall.patientId='" . $patientID ."'
	ORDER BY cliniccall.entryid DESC LIMIT 0 , 1";

	$rs=$db->execute($sql);
	
	$dispenseOnRequest=$rs->EOF==true;//if eof then dispense on request
	if(!$dispenseOnRequest){
		$cliniccallid=$rs->fields('entryid');
		
		if($isNewPrescDisp=!$rs->fields('cliniccallid')){
			//new prescription dispensary - no dispensary made yet for this prescription
			include('pharm.attend.php');
		}
		else{
			//dispensary for this precription exists - check for partial dispensary
			$sql="SELECT * FROM drugdispensary,drugdispensary_listed where drugdispensary.entryid=
			drugdispensary_listed.dispensaryid and	
			instr(lower(dispensarystate),'tbb') and drugdispensary.cliniccallid='".$cliniccallid."'";
			
			$rs=$db->execute($sql);
			$dispenseOnRequest=$rs->EOF==true;//if eof then dispense on request
		}
	}
	
	if($dispenseOnRequest){
		//handle request
		include('dispensary.attend.php');
	}
	elseif(!@$isNewPrescDisp){
		//edit prescription
		include('editprescription.php');
	}
	
	include('foot.php');
?>