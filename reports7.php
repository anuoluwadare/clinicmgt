<?php
session_start();
include('conn.php');

$sql2='SELECT 
  `drugstore`.`drugcode`,
  `drugstore`.`drugname`
FROM
  `drugstore`';

@$action=$_POST['Submit'];
if ($action=='Go!') {
$drugcode=$_POST['cboDrug'];
$patientID=$_POST['txtPatientID'];
	$sql="SELECT 
 count(`patientprescription`.`drugcode`) as num
FROM
  `drugstore`
  INNER JOIN `patientprescription` ON (`drugstore`.`drugcode` = `patientprescription`.`drugcode`)
  INNER JOIN `patientbiodata` ON (`patientprescription`.`patientid` = `patientbiodata`.`PatientID`)
WHERE
  (`patientprescription`.`patientid`  ='" . $patientID  . "' ) AND 
  (`drugstore`.`drugcode` = '" . $drugcode . "')
 order by `patientprescription`.`patientid`
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
        <td><form method="post" action="reports7.php" >
          <table width="100%" border="0">
            <tr>
              <td height="36" class="article-title">Reports -&gt;No of times a particular patient requested for a particular drug</td>
            </tr>
            <tr>
              <td><table width="100%" border="0">
                <tr>
                  <td width="13%" class="bigger-content">PatientID</td>
                  <td width="34%" class="bigger-content"><input name="txtPatientID" type="text" id="txtPatientID" /></td>
                  <td width="7%" class="bigger-content">Drug</td>
                  <td width="42%" class="bigger-content"><select name="cboDrug" id="cboDrug">
				  <?php $rst=$db->execute($sql2);
				  		while ($rst->EOF==false):
						echo "<option value=" . $rst->fields('drugcode') . ">" . $rst->fields('drugname') . "</option>";
						$rst->movenext();
						endwhile;
						?>
                  </select>
                  </td>
                  <td width="4%" class="bigger-content">&nbsp;</td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td align="left"><input type="submit" name="Submit" value="Go!" /></td>
            </tr>
            <tr>
              <td align="center" class="TableRow"><?php 
			$rst2=@$db->execute($sql);
			echo "Number of Times: " . @$rst2->fields('num');
	
		  ?>
		  
		  </td>
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
