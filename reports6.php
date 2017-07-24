<?php
session_start();
include('conn.php');

//@$action=$_POST['Submit'];
//if ($action=='Go!') {
	$sql1="SELECT count( `drugstore`.`drugname`) as num,`drugstore`.`drugname`
FROM  `drugstore`  INNER JOIN `patientprescription` ON (`drugstore`.`drugcode` = `patientprescription`.`drugcode`) group by    `drugstore`.`drugcode` order by num asc ";
 
 $sql2="SELECT count( `drugstore`.`drugname`) as num,`drugstore`.`drugname`
FROM  `drugstore`  INNER JOIN `patientprescription` ON (`drugstore`.`drugcode` = `patientprescription`.`drugcode`)
 group by    `drugstore`.`drugcode` order by num desc ";
 
 
//}
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
        <td><form method="post" action="reports6.php" >
          <table width="100%" border="0">
            <tr>
              <td height="36" class="article-title">Reports -&gt;Drugs in low / high demand</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td align="left"><input type="submit" name="Submit" value="Go!" /></td>
            </tr>
            <tr>
              <td align="center" class="TableHeader">Low Demand </td>
            </tr>
            <tr>
              <td align="center" class="style4"><?php 
	
	@$pager = new ADODB_Pager($db,$sql1); 
	if ((@$pager) && (@$sql1)) {
    	$pager->Render($rows_per_page=3);
	}
		
		  ?></td>
            </tr>
            <tr>
              <td align="center" class="TableHeader">High Demand </td>
            </tr>
            <tr>
              <td align="center" class="style4"><?php 
	
	@$pager = new ADODB_Pager($db,$sql2); 
	if ((@$pager) && (@$sql2)) {
    	$pager->Render($rows_per_page=3);
	}
		

		
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
