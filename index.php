<?php
session_start();
include('conn.inc.php');
$username=$_POST['txtUsername'];
$password=$_POST['txtPassword'];

$msg='';

$sql="select * from users where username='" . $username ."' and password='" . $password ."'";
$db->SetFetchMode(ADODB_FETCH_ASSOC);
$rs =$db->execute($sql); 
if (!$rs->EOF) {
	$_SESSION['username']=$username;
	$_SESSION['userid']=$rs->fields('staffid');
	$_SESSION['jobdesc']= $rs->fields('jobdesc');
	header('Location: home.php');
} else {
	if( $username!=''){
	$msg='Invalid Username/Password';
}
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>ClinicOps Login</title>
<link href="css/clinic_inside.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form method="post">
  <table width="100%" border="0">
    <tr>
      <td align="center"><IMG SRC="images/clinicops_home%2b_01.gif" WIDTH=800 HEIGHT=99 ALT="" /></td>
    </tr>
    <tr>
      <td align="center"><IMG SRC="images/clinicops_home%2b_02.jpg" WIDTH=800 HEIGHT=122 ALT="" /></td>
    </tr>
    <tr>
      <td align="center"><table width="353" height="186" border="0" cellpadding="2" cellspacing="3" bordercolor="#111111" id="AutoNumber2" >
        <tr>
          <td height="19" colspan="5" valign="top"></td>
        </tr>
        <tr>
          <td height="19" colspan="5" valign="top"></td>
        </tr>
        <tr valign="top">
          <td width="107" height="22"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Username</font></td>
          <td height="22" colspan="4"><input name="txtUsername" type="text" class="textfield" size="35" /></td>
        </tr>
        <tr valign="top">
          <td width="107" height="22"><font size="2" face="Verdana" class="mainbody">Password</font></td>
          <td height="22" colspan="4"><input name="txtPassword" type="password" class="textfield" size="35" /></td>
        </tr>
        <tr>
          <td width="107" height="24">&nbsp;</td>
          <td width="11" height="24">&nbsp;</td>
          <td width="133" height="24"><input name="B1" type="submit" class="btnadd"  value="Login" /></td>
          <td width="61" height="24">&nbsp;</td>
          <td width="3" height="24">&nbsp;</td>
        </tr>
        <tr>
          <td width="107" height="28">&nbsp;</td>
          <td height="28" colspan="4" id="password"><a href="users.php?mode=edit"> Change My Password</a></td>
        </tr>
        <tr>
          <td height="28" colspan="5"><p align="center"><b><font face="Verdana" size="2" color="#FF0000"> <?php echo $msg ;?></font></b></p></td>
        </tr>
      </table></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  </form>

</body>
</html>
