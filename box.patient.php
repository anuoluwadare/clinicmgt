<?php
include('conn.inc.php');
include_once('functions.php');
session_start();
//was anything submitted?
$submit=$_POST['Go'];
$pid=$_POST['txtPatientID'];
if (($submit=='Go') || ($pid)) {
	$job=$_SESSION['jobdesc'];
	$_SESSION['curpid']=$pid;
 
}
?>
<form id="form1" name="form1" method="post" action="<?php $_SERVER['PHP_SELF'];  ?>">
  <table width="100%" border="0" cellspacing="0" cellpadding="0" >
    <tr align="right">
      <td><span class="style4"> Attend To Patient </span>
          <input name="txtPatientID" type="text" class="textfield" id="txtPatientID" />
          <input name="Go" type="submit" class="btnadd" id="Go" value="Go" /></td>
    </tr>
  </table>
</form>
