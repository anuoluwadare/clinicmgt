<?php
function PrintMessage($msg)
{
	echo "<br><table border=0><tr><td>" . $msg . "</td></tr></table>";
	
}

function LoadPageforUser($job,$pid)
{
switch ($job) :
	case 'doctor':
		header('Location: doctor.attend.php?pid=' . $pid );
		break;
	case 'nurse':
		header('Location: nurse.attend.php?pid=' . $pid );
		break;
	case 'pharm':
		header('Location: pharm.attend.php?pid=' . $pid );
		break;
	default:
		//access denied
		header("Location: error.php?msg=" . "An error occurred!");

endswitch;

}

function checkuserroles($user)
{
$sql="SELECT 
  `useralias`.`username`,
  `useralias`.`actas`
FROM
  `useralias`
WHERE
  (actas = 'admin' AND username='" . $user .")";
  $rst=$db->execute($sql);
  if (@$rst->fields('actas')=='admin') {
		$checkuserroles='admin';
	}
	else
{
$checkuserroles=@$rst->fields('actas');
}

}

function makeHtmlElementCol($colName,$element,$fldNames){
	/*replace instances of ## in $element with corresponding
	values in $fldNames*/
	
	$elementParts=split('##',$element);
	
	//for field names that are javascript function args, replace ' with \'
	$isjavaParams=stripos($element,'javascript');
	
	for($i=0; $i<count($elementParts); $i++){
		if($i==0) 
			$col="concat('".$elementParts[0];
		else{
			$fld_idx=$i-1;
			
			$col.="',".
			($isjavaParams===false? $fldNames[$fld_idx]: "Replace(".$fldNames[$fld_idx].",'''','\\\''')").
			",'".$elementParts[$i];
		}
	}
	
	$col.="') as `".$colName."`";
	
	return $col;
}

function displayListFromArray($list_src,$selectedItem){
	foreach($list_src as $key=>$value) {
		$selected=$selectedItem==$key? ' selected': '';
		echo '<option value="'.$key.'"'.$selected.'>'.$value.'</option>';
	}
}

function searchDrugStore($searchFldCode,$searchValue){
	//filter out drugs that meet given criteria
	
	//0: drugs like
	$filter=" Where drugname like '%".$searchValue."%'";

	switch ($searchFldCode) {
		case 1://drugs like or alternative drugs to
		case 2://alternative drugs to
			$qryPart=" druggroup in (select distinct druggroup from drugs inner join 
			drugstore on drugs.entryid=drugstore.drugid".$filter.")";
			
			$filter=($searchFldCode==1? $filter." or": 
			str_replace('like','not like',$filter)." and").$qryPart;
			
			break;
		case 3://drug group like
			$filter=" where name like '%".$searchValue."%'";
			
			break;
	}//end switch
	
	return $filter;
}

?>