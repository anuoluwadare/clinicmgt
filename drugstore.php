<?php

include_once('head.php');

if ($_SESSION['username']=='') header('Location: default.php');

$action=$_GET['action'];
$part=$_GET['part'];

//filter out drugs that meet given criteria
if($action=='search' && $searchValue=@$_POST['txtDrugParam']){
	$filter=searchDrugStore($_POST['cboCriteria'],$searchValue);
}

//perform db operations on drug
elseif($part=='drug'){
	$drugId=@$_REQUEST['drugid'];
	
	$whereClause=" Where drugid=".$drugId;
	
	if($action=='delete'){
		//delete drug
		
		//you cannot delete a drug that has dispensary record(s)
		$rs=$db->execute("Select * from drugdispensary".$whereClause);
		if($rs->EOF){
			//has no dispensary record
			$db->execute("DELETE From drugs where entryid=".$drugId);
			$db->execute("DELETE From drugstore".$whereClause);
		}
		//else $db->execute("Update drugs set isListed=0 where entryid=".$drugId);
	}//end delete drug
	
	//add or edit drug
	else{
		//get posted value
		$drugcode=$_POST['txtDrugCode'];
		$drugname=$_POST['txtDrugName'];
		$drugdesc=$_POST['txtDrugDesc'];
		$druggroup=$_POST['cboDrugGroup'];
		$dosage=$_POST['txtDosage'];
		$reorderlevel=$_POST['txtRrdLevel'];
		$unitOfMeasurement=$_POST['txtUnitMsm'];
		$dispense=$_POST['optDispense'];
	
		if($action=='save'){
			//add drug
			
			$stockqty=$_POST['txtStockQty'];
			
			//check if drug with this name already exists in the drugs table
			$sql="Select * from drugs where drugname='".$drugname."'";
			$rs=$db->execute($sql);
			if(!$rs->EOF){
				$drugId=$rs->fields('entryid');
				$db->execute("Update drugs set isListed=1 where drugname='".$drugname."'");
			}
			else{
				$db->execute("Insert into drugs(drugname,isListed) values('".$drugname."',1)");
				$drugId=$db->Insert_ID();
			}
			
			$sql="INSERT INTO drugstore(drugid, drugcode, druggroup, description, dosage, 
			qtyinstock, reorderlevel, unitmeasure, dispensemode)
			values
			('" . $drugId ."','". $drugcode ."','".  $druggroup ."','".  $drugdesc ."','".  $dosage ."','".  
			$stockqty  ."','".  $reorderlevel ."','".  $unitOfMeasurement  . "','". $dispense ."')";
		}//end add
		
		else{
			//edit drug
			
			$db->execute("Update drugs set drugname='".$drugname."' where entryid=".$drugId);
			
			$addStock=$_POST['txtAddStock'];
			
			$sql="UPDATE drugstore SET druggroup='" . $druggroup ."',description='".$drugdesc. 
			"',dosage='".$dosage."', qtyinstock=qtyinstock+" . $addStock .", reorderlevel='" . $reorderlevel . 
			"', unitmeasure='" . $unitOfMeasurement . "', dispensemode='" . $dispense ."'".$whereClause;
		} //end edit
		
	}//end add or edit
	
	if (!@$db->execute($sql)) $msg='unable to update drug store';	
}

//perform db operations on drug group
elseif($part=='druggroup'){
	$whereClause=" Where entryid='" .@$_REQUEST['grpId']. "'";
	
	if($action=='delete')
		//delete drug group
		$sql="DELETE From druggroups".$whereClause;
	
	//add or edit drug group
	else{
		//get posted value
		$groupname=$_POST["txtDrugGroup"];

		if($action=='save')
			//add drug group
			$sql="insert into druggroups (name) values('" . $groupname ."')";
		else
			//edit drug group
			$sql="UPDATE druggroups SET name='".$groupname."'".$whereClause; 
	}//end add or edit

	if (!@$db->execute($sql)) $msg='unable to update drug group';	
}
				

//prepare pager class to show drug groups
$colEdit=makeHtmlElementCol($colName='Edit',
"<a href=\"javascript:editDrugGroup(''##'',''##'')\">".$colName."</a>",
array('entryid','name'));

$colDelete=makeHtmlElementCol($colName='Delete',
"<a href=\"javascript:deleteDrugGroup(''##'',''##'')\">".$colName."</a>",
array('entryid','name'));

$sql= "select ".$colEdit.",".$colDelete.",name as 'Drug Group' from `druggroups` order by name";
$pager = new ADODB_Pager($db,$sql); 

//prepare pager class to show drugs
$colEdit=makeHtmlElementCol($colName='Edit',
"<a href=\"javascript:editDrug(''##'',''##'',''##'',''##'',''##'',''##'',''##'',''##'',''##'',''##'')\">"
.$colName."</a>",
array('drugid','drugcode','drugname','description','druggroup','dosage','qtyinstock',
'reorderlevel','unitmeasure','dispensemode'));

$colDelete=makeHtmlElementCol($colName='Delete',
"<a href=\"javascript:deleteDrug(''##'',''##'')\">".$colName."</a>",
array('drugid','drugname'));

$sql="select ".$colEdit.",".$colDelete.",drugname as 'Drug Name', name as 'Drug Group',dispensemode as 'Dispense On'
from drugstore  inner join druggroups
on `drugstore`.druggroup=druggroups.entryid".@$filter." order by drugname";
$pager2 = new ADODB_Pager($db,$sql); 

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Drug Store</title>
<link href="clinic_inside.css" rel="stylesheet" type="text/css" />
</head>

<script language="JavaScript" src="General.js" type="text/javascript">
</script>

<script language="javascript">
function editDrugGroup(groupId,groupName){
	formObj=document.druggroup
	formObj.Submit.value='Update';
	formObj.txtDrugGroup.value=groupName
	
	formObj.action='?action=edit&part=druggroup&grpId='+groupId
}

function editDrug(drugid,drugCode,name,desc,group,dosage,stockQty,reorderLevel,msrmtUnit,dispenseType){
	formObj=document.drugs
	formObj.Submit.value='Update';
	formObj.txtDrugCode.value=drugCode
	formObj.txtDrugDesc.value=desc
	formObj.txtDrugName.value=name
	formObj.cboDrugGroup.value=group
	formObj.txtDosage.value=dosage
	
	formObj.txtStockQty.value=stockQty
	formObj.txtStockQty.readOnly=true
	
	formObj.txtAddStock.disabled=false
	
	formObj.txtRrdLevel.value=reorderLevel
	formObj.txtUnitMsm.value=msrmtUnit
	formObj.optDispense[0].checked=dispenseType=='prescription'
	formObj.optDispense[1].checked=!formObj.optDispense[0].checked
	
	formObj.action='?action=edit&part=drug&drugid='+drugid
}

function deleteDrugGroup(groupId,groupName){
	if(!confirm('Are you sure you want to delete "'+groupName+'"')) return
	self.location='?action=delete&part=druggroup&grpId='+groupId
}

function deleteDrug(drugid,drugName){
	if(!confirm('Are you sure you want to delete "'+drugName+'"')) return
	self.location='?action=delete&part=drug&drugid='+drugid
}
</script>

<table border="0" align="center" width="800px">
<tr>
<td>
<form name="drugs" method="post" action="?action=save&part=drug">
		
		
		<table id="tbldrugstore">
          <tr>
            <td colspan="4"><table width="100%" border="0" class="doc_attend">
              <tr>
                <td height="28" class="ItemTitle"><a href="admin.setup.php">Setup</a> -> Drug Store</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td class="article-title">Get from store </td>
                <td>
				<select name="cboCriteria" class="textfield" id="cboCriteria">
                  <?php
				  	$list_src=
					array('Drugs Like','Drugs Like Or Alternate Drug To','Alternate Drug To','Drug Groups like');
					
				  	displayListFromArray($list_src,@$searchFldCode);
				  ?>
                </select>
				</td>
                <td><input name="txtDrugParam" type="text" class="textfield" id="txtDrugParam" 
				value="<?php echo @$searchValue?>" />
                <input name="search" type="submit" class="btnadd" value="search" 
				onClick="this.form.action='?action=search'"/></td>
              </tr>
            </table>   </td>
          </tr>
          <tr>
            <td width="18%"> </td>
            <td width="22%">&nbsp;</td>
            <td width="17%">&nbsp;</td>
            <td width="20%">&nbsp;</td>
          </tr>
          <tr class="caption">
            <td >Drug Store</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
          </tr>
          <tr>
            <td >Drug Code </td>
            <td><input name="txtDrugCode" type="text" class="textfield" id="txtDrugCode" /></td>
            <td class="style4">Drug Name </td>
            <td><input name="txtDrugName" type="text" class="textfield" id="txtDrugName" /></td>
          </tr>
          <tr>
            <td class="style4">Drug Description</td>
            <td><textarea name="txtDrugDesc" id="txtDrugDesc"></textarea></td>
            <td class="style4">Drug Group</td>
            <td><select name="cboDrugGroup" id="cboDrugGroup">
              <?php $sql="select * from druggroups order by name";
				$rs=$db->execute($sql);
				while ($rs->EOF==false):
					echo 
					'<option value="'.$rs->fields('entryid').'">'.$rs->fields('name').'</option>';
					$rs->MoveNext(); 
				 endwhile; 
			 ?>
            </select></td>
          </tr>
          <tr>
            <td class="style4">Dosage</td>
            <td><input name="txtDosage" type="text" class="textfield" id="txtDosage" /></td>
            <td class="style4">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td class="style4">Qty in stock</td>
			
            <td><input name="txtStockQty" type="text" class="textfield" id="txtStockQty" /></td>
			 
            <td class="style4">Add to stock </td>
            <td><input name="txtAddStock" type="text" disabled class="textfield" id="txtAddStock" value="0" /></td>
          </tr>
          <tr>
            <td class="style4">Re-order level</td>
            <td><input name="txtRrdLevel" type="text" class="textfield" id="txtRrdLevel" /></td>
            <td class="style4">Unit of measurement</td>
            <td><input name="txtUnitMsm" type="text" class="textfield" id="txtUnitMsm" /></td>
          </tr>
          <tr>
            <td height="37" class="style4">Dispense</td>
            <td class="style4"><input name="optDispense" type="radio" value="prescription" checked="checked" />
              On Doc's Prescription </td>
            <td class="style4"><input name="optDispense" type="radio" value="request" />
              On Request </td>
            <td><input type="submit" name="Submit" value="Add>>" class="btnadd" /></td>
          </tr>
          <tr>
            <td class="errormsg"><?php echo $msg ?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
		 
            <td colspan="4">
			<?php 
			if($pager2){
				$rs=$db->execute($pager2->sql);
				//echo $rs->RecordCount().' record(s) returned';
				
				$pager2->Render($rows_per_page=5);
			}
			?>			</td>
            </tr>
        </table>
        </form></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><form name="druggroup" method=post action="?action=save&part=druggroup"><table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="29%" class="article-title">&nbsp;</td>
            <td width="38%">&nbsp;</td>
            <td width="11%">&nbsp;</td>
            <td width="22%">&nbsp;</td>
          </tr>
          <tr class="caption" >
            <td  ><span >Drug Groups </span></td>
            <td ><input name="txtDrugGroup" type="text" id="txtDrugGroup" class="textfield" /></td>
            <td><input type="submit" name="Submit" value="Add>>" class="btnadd" /></td>
            <td >&nbsp;</td>
          </tr>
          
		  <tr><td>&nbsp;</td></tr>
		  <tr>
            
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
		  </tr>
		  <tr><td>&nbsp;</td></tr>
          <tr id="drug_grp">
            <td colspan="4"  >
			<?php 
			if ($pager){
				$rs=$db->execute($pager->sql);
				echo $rs->RecordCount().' record(s) returned';

				$pager->Render($rows_per_page=5);
			} 
			?>
			</td>
            </tr>
        </table>
        </form>
		</td>
		</tr>
		</table>
<?php
include('foot.php');
?>
