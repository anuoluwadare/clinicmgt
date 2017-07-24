<?php
session_start();
include('conn.php');

@$action=$_POST['Submit'];
if ($action=='Go!') {
	$sql="SELECT 
  `drugstore`.`drugname`,
  `drugstore`.`druggroup`,
  `drugstore`.`qtyinstock`,
  `drugstore`.`reorderlevel`,
  `drugstore`.`dispensemode`,
  `drugstore`.`unitmeasurement`
FROM
  `drugstore`
WHERE
  (`drugstore`.`qtyinstock` <= `drugstore`.`reorderlevel`)
 ";
 
 
 
 
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title></title>
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
        <td><form method="post" action="reports5.php" >
          <table width="100%" border="0">
            <tr>
              <td height="41" class="article-title">Reports - &gt; Drugs that are within or below re-order level</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><input type="submit" name="Submit" value="Go!" /></td>
            </tr>
            <tr>
              <td align="center" valign="top"><span class="TableRow">
                <?php 
	
	@$pager = new ADODB_Pager($db,$sql); 
	if ((@$pager) && (@$sql)) {
    	$pager->Render($rows_per_page=5);
	}
		
		  ?>
              </span></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td align="left">&nbsp;</td>
            </tr>
            <tr>
              <td align="center">&nbsp;</td>
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
