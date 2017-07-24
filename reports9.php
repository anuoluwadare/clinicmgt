<?php
session_start();
include('conn.php');

@$action=$_POST['Submit'];
if ($action=='Go!') {
	$sql="SELECT 
 ROUND(AVG( TIME_FORMAT(subtime(`doctordiagnosis`.`time`,`patientvitals`.`TimeLogged`),'%i')),0) as diff
FROM
  `doctordiagnosis`
  INNER JOIN `patientvitals` ON (`doctordiagnosis`.`PatientID` = `patientvitals`.`PatientID`) AND (`doctordiagnosis`.`callid` = `patientvitals`.`CallID`)
 ";
 
 
 
 
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Reports</title>
<link href="styles.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="100%" border="0">
  <tr>
    <td align="center" valign="top"><table width="600" border="0">
      <tr>
        <td><table width="100%" border="0">
          <tr>
            <td><?php include('banner.header.php') ?></td>
          </tr>
          <tr>
            <td align="right"><a href="logout.php"><span class="bold-blue">&nbsp;welcome <?php echo $_SESSION['username']; ?></span>|&nbsp;logout</a></td>
          </tr>
          <tr>
            <td align="right"><?php include('menu.header.php');  ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><form method="post" action="reports9.php" >
          <table width="100%" border="0">
            <tr>
              <td height="34" class="article-title">Reports -&gt;Average time patient waits for a doctor </td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td align="left"><input type="submit" name="Submit" value="Go!" /></td>
            </tr>
            <tr>
              <td align="center" class="TableRow"><?php 
	
		$rst2=$db->execute($sql);
			
			echo "Average time in minutes: " . $rst2->fields('diff');
	
		
		  ?></td>
            </tr>
          </table>
        </form></td>
      </tr>
      <tr>
        <td></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
