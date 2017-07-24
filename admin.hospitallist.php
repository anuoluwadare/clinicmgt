<?php

include('head.php');


//add or edit hospital
if($action=$_POST['Submit']){
	$hospital=$_POST['txtHospital'];
	$specialty=$_POST['txtSpecialty'];
	$address=$_POST['txtAddress'];
	$phone=$_POST['txtPhone'];
	$MD=$_POST['txtMD'];
	$comment=$_POST['txtComment'];
	
	if($action=='Save')
		//insert hospital information
		$sql="insert into `hospitals`(hospital,specialty,Address,phone,managingDirector,comment) 
		values('" . $hospital ."','" . $specialty . "','" . $address . 
		"','" .$phone . "','" . $MD . "','" . $comment . "')";
			
	else{
		//update hospital information
		$old_hospId=$_REQUEST['hospId'];
		
		$sql="Update `hospitals` set hospital='" . $hospital ."',
		specialty='" . $specialty . "',Address='" . $address ."',
		phone='" .$phone . "',managingDirector='" . $MD . "',
		comment='" . $comment . "' where entryid=".$old_hospId;
	}

	if(!@$db->execute($sql)) $errmsg='Was unable to save the information';
}

//delete hospital
elseif($_GET['action']=='delete'){
	$old_hospId=$_REQUEST['hospId'];
	
	$sql="DELETE From hospitals where entryid=".$old_hospId;
	if(!@$db->execute($sql)) $errmsg='Was unable to delete the information';
}

?>

<script language="JavaScript" src="General.js" type="text/javascript">
</script>

<script language="javascript">
function editRecord(hospId,hospName,specialty,addr,phone,MD,comment){
	formObj=document.mainform
	formObj.Submit.value='Update';
	formObj.txtHospital.value=hospName
	formObj.txtSpecialty.value=specialty
	formObj.txtAddress.value=addr
	formObj.txtPhone.value=phone
	formObj.txtMD.value=MD
	formObj.txtComment.value=comment

	formObj.action='?hospId='+hospId
}

function deleteRecord(hospId,hospName){
	if(!confirm('Are you sure you want to delete "'+hospName+'"')) return
	self.location='?action=delete&hospId='+hospId
}
</script>


<body>
<form method="post" name="mainform" id="mainform" >
<table width="800px" border="0" align="center">
            <tr>
              <td height="29" colspan="4" align="left" class="ItemTitle"><a href="admin.setup.php">Setup</a> -> Hospital List</td>
              </tr>
            <tr>
              <td width="20%" align="left" class="style4">Hospital name </td>
              <td width="28%" align="left"><input name="txtHospital" type="text" class="textfield" id="txtHospital" /></td>
              <td width="15%" align="left">Specialty</td>
              <td width="37%"><input name="txtSpecialty" type="text" class="textfield" id="txtSpecialty" /></td>
            </tr>
            <tr>
              <td align="left" class="style4">Hospital address</td>
              <td align="left"><textarea name="txtAddress" id="txtAddress"></textarea></td>
              <td align="left">Phone</td>
              <td><input name="txtPhone" type="text" class="textfield" id="txtPhone" /></td>
            </tr>
            <tr>
              <td align="left" class="style4">Managing Director's Name </td>
              <td align="left"><input name="txtMD" type="text" class="textfield" id="txtMD" /></td>
              <td align="left">Comment</td>
              <td><textarea name="txtComment" class="textfield" id="txtComment"></textarea></td>
            </tr>
            <tr>
              <td align="left" class="style4">&nbsp;</td>
              <td align="left">&nbsp;</td>
              <td align="left">&nbsp;</td>
              <td align="left" valign="bottom"><input name="Submit" type="submit" class="btnlogin" value="Save" /></td>
            </tr>
            <tr>
              <td colspan="5" class="errormsg"><?php echo $errmsg;    ?></td>
              </tr>
            <tr>
              <td colspan="5" align="center">
			<?php 
			$colEdit=makeHtmlElementCol($colName='Edit',
			"<a href=\"javascript:editRecord(''##'',''##'',''##'',''##'',''##'',''##'',''##'')\">".$colName."</a>",
			array('entryid','hospital','specialty','address','phone','managingDirector','comment'));

			$colDelete=makeHtmlElementCol($colName='Delete',
			"<a href=\"javascript:deleteRecord(''##'',''##'')\">".$colName."</a>",
			array('entryid','hospital'));
			
			$sql = "select ".$colEdit.",".$colDelete.",hospital, specialty, address from hospitals";
			 
			$pager = new ADODB_Pager($db,$sql); 
			if ($pager){
				$rs=$db->execute($sql);
				echo $rs->RecordCount().' record(s) returned';
    			
				$pager->Render($rows_per_page=5); 
			}
			
            ?>
			 &nbsp;</td>
             </tr>
          </table>          
</form>
<?php
include('foot.php');
?>