<?php
session_start();
include('conn.php');
//include date control class
include("datepulldown.class.php");
//create 2 date control objects
$date1 = new date_pulldown("fromdate");
$date2 = new date_pulldown("todate");

//if posted
@$action=$_POST['Submit'];
if ($action=='Go!') {
	$fromdate=$_POST['fromdate'] ;
	$todate=$_POST['todate'];
	$a=$fromdate['year'] . '-' . $fromdate['mon'] . '-' .$fromdate['mday'];
	$b=$todate['year'] .'-' . $todate['mon'] . '-' .$todate['mday'] ;
	$ailment=$_POST['txtAilment'];
	$sql="select concat(surname , ' ', firstname,  ' ' , othername) as fullname ,doctordiagnosis.Diagnosis from patientbiodata inner join doctordiagnosis on(patientbiodata.patientid=doctordiagnosis.patientid) WHERE doctordiagnosis.Diagnosis LIKE '%" .$ailment . "%' AND doctordiagnosis.date BETWEEN '" . $a . "' AND '" . $b ."'";
	
	


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
        <td><form method="post" action="reports2.php" >
		  <table width="100%" border="0">
            <tr>
              <td height="41" class="article-title">Reports -&gt;Patients that have had a specific ailment in a given period</td>
            </tr>
            <tr>
              <td><table width="100%" border="0">
                <tr>
                  <td width="10%" class="bigger-content">From</td>
                  <td width="39%" class="bigger-content"><?php     
			  echo $date1->output();
			  
			  ?></td>
                  <td width="10%" class="bigger-content">To</td>
                  <td width="41%" class="bigger-content"><?php     
			  echo $date2->output();
			  
			  ?></td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td align="left"><table width="100%" border="0">
                <tr>
                  <td width="8%" class="bigger-content">Ailment</td>
                  <td width="39%" class="bigger-content"><input name="txtAilment" type="text" id="txtAilment" /></td>
                  <td width="10%" class="bigger-content">&nbsp;</td>
                  <td width="41%" class="bigger-content">&nbsp;</td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td align="left"><input type="submit" name="Submit" value="Go!" /></td>
            </tr>
            <tr>
              <td align="center" valign="top"><?php 
	//render using adodb pager class
	@$pager = new ADODB_Pager($db,$sql); 
	if (($pager) && ($sql)) {
    	$pager->Render($rows_per_page=5);
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
