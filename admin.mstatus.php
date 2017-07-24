<?php
include('head.php');
include_once('functions.php');


//add or edit marital status
if($action=$_POST['Submit']){
	$mstatus=$_POST['txtMStatus'];
	
	if($action=='Save')
		//insert marital status information
		$sql="insert into `mstatus`(mstatus) values('" . $mstatus ."')"; 
			
	else{
		//update marital status information
		$old_id=$_REQUEST['id'];
		
		$sql="Update `mstatus` set mstatus='" . $mstatus ."' where entryid=".$old_id;
	}
	
	if(!@$db->execute($sql)) $errmsg='Was unable to save the information';
}

//delete marital status
elseif($_GET['action']=='delete'){
	$old_id=$_REQUEST['id'];
	
	$sql="DELETE From mstatus where entryid=".$old_id;
	if(!@$db->execute($sql)) $errmsg='Was unable to delete the information';
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Administrative Console - Marital Status</title>

<link href="clinic_inside.css" rel="stylesheet" type="text/css" />
</head>


<script language="JavaScript" src="General.js" type="text/javascript">
</script>

<script language="javascript">
function editRecord(id,mStatus){
	formObj=document.mainform
	formObj.Submit.value='Update';
	formObj.txtMStatus.value=mStatus

	formObj.action='?id='+id
}

function deleteRecord(id,mStatus){
	if(!confirm('Are you sure you want to delete "'+mStatus+'"')) return
	self.location='?action=delete&id='+id
}
</script>


<form method="post" name="mainform">
<table width="800px" border="0" cellpadding="0" cellspacing="0" align="center">
          <tr>
            <td width="22%" height="20" class="ItemTitle"><a href="admin.setup.php">Setup</a> -> Marital Status List</td>
            <td width="45%">&nbsp;</td>
            <td width="33%">&nbsp;</td>
          </tr>
          <tr>
            <td height="31" class="style4">Marital Status </td>
            <td><input name="txtMStatus" type="text" class="textfield" id="txtMStatus" /></td>
            <td><input name="Submit" type="submit" class="btnlogin" value="Save" /></td>
          </tr>
          <tr>
            <td class="errormsg"><?php echo $errmsg;    ?></td>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="3">
			<?php 
			$colEdit=makeHtmlElementCol($colName='Edit',
			"<a href=\"javascript:editRecord(''##'',''##'')\">".$colName."</a>",
			array('entryid','mstatus'));
			
			$colDelete=makeHtmlElementCol($colName='Delete',
			"<a href=\"javascript:deleteRecord(''##'',''##'')\">".$colName."</a>",
			array('entryid','mstatus'));

			$sql = "select ".$colEdit.",".$colDelete.", mstatus as 'Marital Status' from mstatus order by mstatus"; 
			
    		$pager = new ADODB_Pager($db,$sql); 
			if ($pager) {
				$rs=$db->execute($sql);
				echo $rs->RecordCount().' record(s) returned';
				
				$pager->Render($rows_per_page=5); 
			}
             ?></td>
          </tr>
        </table>
        </form>
<?php
include('foot.php');
?>
