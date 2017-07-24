<?php
session_start();
include('conn.inc.php');
$user=$_SESSION['username'];
$sql=" SELECT username,  rolename FROM  `actingroles`
WHERE  (username = '" . $user . "') ";
  //if user belongs to multiple roles then
  //the menus will be concatenated
  //first get the roles for a specific user
  
$rst=$db->execute($sql);
while ($rst->EOF==false) :
	$role=$rst->fields('rolename');
		switch ($role):
			case 'admin' :
			//create menu for admin
				$menuadmin='admin.header.php';
				break;
			case 'nurse' :
				$menunurse='nurse.header.php';
				break;
			case 'doctor' :
				$menudoc='doc.header.php';
				break;
			case 'pharm' :
				$menupharm='pharm.header.php';
				break;
		endswitch;
	$rst->movenext();
endwhile;


?>

<link href="clinic_inside.css" rel="stylesheet" type="text/css" />
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="navbar">

  <tr>
    <td  align="left"><?php if ($menunurse) {include($menunurse); }?></td>
    <td  align="left"><?php if ($menudoc) { include($menudoc); } ?></td>
    <td  align="left"><?php if ($menupharm) { include($menupharm);} ?></td>
	<td  align="left"><?php if ($menuadmin) {include($menuadmin);} ?> </td>
	<td ><?php include('help.header.php'); ?> </td>
	<td ><?php include('box.patient.php'); ?> </td>
  </tr>
</table>
