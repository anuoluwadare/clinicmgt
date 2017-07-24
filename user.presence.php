<?php
$patientID=$_SESSION['curpid'];
$psql="SELECT 
  CONCAT_WS(' ',`patients`.`firstname`, `patients`.`othername`, `patients`.`surname`) AS  'Fullname'
FROM
  `patients`
WHERE
  (`patients`.`patientid` ='". $patientID ."')";
  $r=@$db->execute($psql);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="48%" align="left"><span class="bold-blue"> Current Patient:&nbsp;<?php echo $_SESSION['curpid'] . ' ' . @$r->fields('Fullname'); ?></span></td>
    <td width="52%" align="right"><span class="bold-blue">&nbsp;welcome <?php echo $_SESSION['username']; ?></span>|<a href="logout.php">&nbsp;logout</a></td>
  </tr>
 
</table>

