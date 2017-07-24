<?php
include('conn.php');
session_start();
if ($_SESSION['username']!='') {
	header('Location: home.php');
}
$username=$_POST['txtUsername'];
$password=$_POST['txtPassword'];

$msg='';

$sql="select * from users where username='" . $username ."' and password='" . $password ."'";
$db->SetFetchMode(ADODB_FETCH_ASSOC);
$rs =$db->execute($sql); 
if ($rs->EOF==false) {
	$_SESSION['username']=$username;
	$_SESSION['role']= $rs->fields('role');
	$uri='home.php';
	header('Location:' . $uri );
} else {
	if( $username!=''){
	$msg='Invalid Username/Password';
	}
	}
	
?><title>Login</title>


<form method="post">
  <table width="100%" border="0">
    <tr>
      <td align="center"><img src="images/Login_03.gif" width="672" height="148" /></td>
    </tr>
    <tr>
      <td align="center"><img src="images/Login_05.gif" width="672" height="105" /></td>
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
          <td width="112" height="22"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Username</font></td>
          <td height="22" colspan="4"><input name="txtUsername" type="text" class="textfield" size="35" /></td>
        </tr>
        <tr valign="top">
          <td width="112" height="22"><font size="2" face="Verdana" class="mainbody">Password</font></td>
          <td height="22" colspan="4"><input name="txtPassword" type="password" class="textfield" size="35" /></td>
        </tr>
        <tr>
          <td width="112" height="24">&nbsp;</td>
          <td width="6" height="24">&nbsp;</td>
          <td width="133" height="24"><input name="B1" type="submit" class="buttonface"  value="Login" /></td>
          <td width="61" height="24">&nbsp;</td>
          <td width="3" height="24">&nbsp;</td>
        </tr>
        <tr>
          <td width="112" height="28">&nbsp;</td>
          <td height="28" colspan="4"><b class="mainbody"><a href="users.php?mode=edit"> Change My Password</a></b></td>
        </tr>
        <tr>
          <td height="28" colspan="5"><p align="center"><b><font face="Verdana" size="2" color="#FF0000"> <?php echo $msg ;?></font></b></p></td>
        </tr>
      </table></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  </form>

<p>&nbsp;</p>
