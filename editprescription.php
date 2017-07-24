<?php
//$db->debug=true;

//post and save the selected drugs
if (@$_POST['savedrug'] && $selectedDrugs=@$_POST['chkSelect']){

	foreach($selectedDrugs as $drugId){
		//get the newly added quantity
		$qtyadded=$_POST['qtyadd'][$drugId]; 
		$status=$_POST['DStatus'][$drugId];
		
		//now build query to update the prescriptioon
		$sql="UPDATE drugdispensary SET qty=qty + ".$qtyadded. 
		" WHERE cliniccallid='" . $cliniccallid . "' AND drugid=".$drugId;
		$db->execute($sql);

		$sql="UPDATE drugdispensary_listed inner join drugdispensary on 
		drugdispensary_listed.dispensaryid=drugdispensary.entryid
		SET drugdispensary_listed.dispensarystate='".$status."' 
		WHERE cliniccallid='" . $cliniccallid . "' AND drugid=".$drugId;
		$db->execute($sql);

		//now update the stock in the drugstore
		$sql="UPDATE drugstore SET qtyinstock= qtyinstock - " . $qtyadded . " WHERE drugid=".$drugId;
		$db->execute($sql);

	}// end foreach
	
	$msg='Dispensary updated!';
}

?>

<form method="post">
          <p style="color:#FF0000; font-weight:bold" align="center"><?php echo $msg?></p>
          <table width="800" border="0" cellspacing="1" cellpadding="1" align="center">
                <tr bgcolor="#0099CC" style="color:#FFFFFF">
                  <td width="7%"><input type="checkbox" onclick="toggleCheck('chkSelect[]',this)">
				  <strong>Drug</strong></td>
                  <td width="12%"><strong>Qty in stock</strong></td>
                  <td width="13%"><strong>Qty Dispensed</strong></td>
                  <td width="17%"><strong>Qty to Add</strong></td>
                  <td width="5%"><strong>Unit</strong></td>
                  <td width="9%"><strong>Dosage</strong></td>
                  <td width="15%"><strong>Dispense on</strong></td>
                  <td width="22%"><strong>Dispensary Status</strong></td>
                </tr>
            <?php
			$osql="SELECT `drugdispensary`.`dosage` , `drugdispensary_listed`.`dispensemode` , 
			`drugdispensary_listed`.`dispensarystate` , `drugdispensary`.`qty` , 
			`drugs`.`drugname` , `drugstore`.`qtyinstock`, `dispensaryvisit`.`cliniccallid` , 
			`drugstore`.`unitmeasure` , `drugstore`.`drugid` 
			FROM drugs
			INNER JOIN drugstore ON drugs.entryid = drugstore.drugid
			INNER JOIN drugdispensary ON `drugdispensary`.`drugid` = `drugstore`.`drugid` 
			INNER JOIN `dispensaryvisit` ON `dispensaryvisit`.`cliniccallid` = drugdispensary.`cliniccallid` 
			INNER JOIN drugdispensary_listed ON drugdispensary.entryid = drugdispensary_listed.dispensaryid
			WHERE `drugdispensary_listed`.`dispensarystate` = 'TBB'
			AND `dispensaryvisit`.`cliniccallid` = '".$cliniccallid."'";
			
			if ($msrt=$db->execute($osql)){
				while (!$msrt->EOF):
					$drugId=$msrt->fields('drugid');
					
					echo "<tr><td><input type=checkbox value=". $drugId ." name=chkSelect[]>" . 
					$msrt->fields('drugname')."</td>";
					echo "<td>" . $msrt->fields('qtyinstock') . "</td>";
					echo "<td>" . $msrt->fields('qty') . "</td>";
					echo "<td><input type=text name=qtyadd[" . $drugId . "] value=0 class=textfield></td>";
					
					echo "<td>" . $msrt->fields('unitmeasure') . "</td>";
					echo "<td>" . $msrt->fields('dosage') ."</td></td>";
					echo "<td>" . $msrt->fields('dispensemode') ." </td>";
					
					echo '<td>
					<select name="DStatus['.$drugId.']" style="width:200px">';
						$list_src=array('Dispensed'=>'Dispensed','Not Available'=>'Not Available',
						'TBB'=>'Partially Dispensed - TBB','WNB'=>'Partially Dispensed - WNB');
						
						displayListFromArray($list_src,$msrt->fields('dispensarystate'));
					echo
					'</select>   
					 </td></tr>';
					
					$msrt->movenext();
					
				endwhile;
		 	}
		
		   ?>
                <tr align="right" >
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
				  <td></td>
                  <td>&nbsp;</td>
                </tr>
                <tr >
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td align="right"><input type=submit name= "savedrug" value= "Save" class="btnadd"/></td>
                </tr>
              </table>
          
          </form>

