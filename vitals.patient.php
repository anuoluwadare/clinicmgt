<link href="clinic_inside.css" rel="stylesheet" type="text/css" />


<form name="vitals" method="post" action="nurse.attend.php">
  <table width="76%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td class="bigger-content"><input name="LoginTime" type="hidden" id="LoginTime" value="<?php echo date('H:i:s');?>" /></td>
      <td class="bigger-content">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td width="19%" class="bigger-content">Time In </td>
      <td width="19%" class="bigger-content">&nbsp;</td>
      <td width="25%"><input name="TimeIn" type="text" class="textfield" id="TimeIn"></td>
      <td width="25%">&nbsp;</td>
      <td width="28%">&nbsp;</td>
      <td width="28%">&nbsp;</td>
      <td width="28%">&nbsp;</td>
    </tr>
    <tr>
      <!--<td class="bigger-content">Patient Vitals </td>-->
      <td class="bigger-content">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="bigger-content">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="bigger-content">Temperature</td>
      <td class="bigger-content">&nbsp;</td>
      <td class="bigger-content">Blood Pressure</td>
      <td class="bigger-content">&nbsp;</td>
      <td class="bigger-content">Pulse Rate </td>
      <td class="bigger-content">&nbsp;</td>
      <td class="bigger-content">&nbsp;</td>
    </tr>
    <tr>
      <td class="bigger-content"><input name="Temperature" type="text" class="textfield" id="Temperature" /></td>
      <td class="bigger-content">&nbsp;</td>
      <td class="bigger-content"><input name="BloodPressure" type="text" class="textfield" id="BloodPressure" /></td>
      <td class="bigger-content">&nbsp;</td>
      <td class="bigger-content"><input name="PulseRate" type="text" class="textfield" id="PulseRate" /></td>
      <td class="bigger-content"><input name="Submit" type="submit" class="btnlogin" value="Save" /></td>
      <td class="bigger-content">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><input type="hidden" name="action" id="action"/></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>

