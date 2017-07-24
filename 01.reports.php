<?php
session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>All Reports</title>
<link href="reports/styles.css" rel="stylesheet" type="text/css" />
<link href="styles.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="100%" border="0">
  <tr>
    <td align="center" valign="top"><table width="600" border="0" cellpadding="0" cellspacing="0" bordercolor="#006666">
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
        <td><table width="100%" border="0">
          <tr>
            <td width="10%"></td>
            <td width="80%"></td>
            <td width="10%"></td>
          </tr>
          <tr>
            <td width="10%" class="title-section">&nbsp;</td>
            <td align="left" class="title-section"><a href="reports.php">Patients that have visited the clinic in a given period</a></td>
            <td width="10%" class="title-section">&nbsp;</td>
          </tr>
          <tr>
            <td width="10%" class="title-section">&nbsp;</td>
            <td align="left" class="title-section"><a href="reports2.php">Patients that have had a specific ailment in a given period</a></td>
            <td width="10%" class="title-section">&nbsp;</td>
          </tr>
          <tr>
            <td width="10%" class="title-section">&nbsp;</td>
            <td align="left" class="title-section"><a href="reports3.php">Times that  a particular patient visited the clinic in a given period</a></td>
            <td width="10%" class="title-section">&nbsp;</td>
          </tr>
          <tr>
            <td width="10%" class="title-section">&nbsp;</td>
            <td align="left" class="title-section"><a href="reports4.php">Drugs that are in stock</a></td>
            <td width="10%" class="title-section">&nbsp;</td>
          </tr>
          <tr>
            <td width="10%" class="title-section">&nbsp;</td>
            <td align="left" class="title-section"><a href="reports5.php">Drugs that are within or below re-order level</a></td>
            <td width="10%" class="title-section">&nbsp;</td>
          </tr>
          <tr>
            <td width="10%" class="title-section">&nbsp;</td>
            <td align="left" class="title-section"><a href="reports6.php">Drugs in low / high demand</a></td>
            <td width="10%" class="title-section">&nbsp;</td>
          </tr>
          <tr>
            <td width="10%" class="title-section">&nbsp;</td>
            <td align="left" class="title-section"><a href="reports7.php">No of times  a particular patient requested for a particular drug</a></td>
            <td width="10%" class="title-section">&nbsp;</td>
          </tr>
          <tr>
            <td width="10%" class="title-section">&nbsp;</td>
            <td align="left" class="title-section"><a href="reports8.php">Average patient waiting time for a  nurse</a></td>
            <td width="10%" class="title-section">&nbsp;</td>
          </tr>
          <tr>
            <td width="10%" class="title-section">&nbsp;</td>
            <td align="left" class="title-section"><a href="reports9.php">Average patient waiting time for a doctor</a></td>
            <td width="10%" class="title-section">&nbsp;</td>
          </tr>
          <tr>
            <td width="10%" class="title-section">&nbsp;</td>
            <td align="left" class="title-section"><a href="reports10.php">Average patient waiting time for a pharmacist</a></td>
            <td width="10%" class="title-section">&nbsp;</td>
          </tr>
          <tr>
            <td width="10%" class="title-section">&nbsp;</td>
            <td align="left" class="title-section"><a href="reports11.php">Referrals that have been made in a given period</a></td>
            <td width="10%" class="title-section">&nbsp;</td>
          </tr>
          <tr>
            <td width="10%">&nbsp;</td>
            <td>&nbsp;</td>
            <td width="10%">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
