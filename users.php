<?php //start

include('head.php');


if($action=$_POST['Submit']){
	function saveRoles($username,$db){
		//save  roles
		if($roles=$_POST['chkRoles']){
			foreach($roles as $role){
				$sql="insert into actingroles(username, rolename) values('" . $username . "','" . $role ."')";
				$db->execute($sql);
			}
		}
	}

	//get all the posted values
	$staffId=$_POST['txtStaffId'];
	$fullname=$_POST['txtFullname'];
	$officialRole=$_POST['cboRole'];
	$username=$_POST['txtUsername'];
	$password=$_POST['txtPwd'];
	$defaultpwd=$_POST['chkDefaultPwd'];
	if ($defaultpwd==true) $password='password';
	
	
	//we are adding a new user		
	if ($action=='Save') {
		//add new user
		if ($defaultpwd==true) $password='password';
	
		//first check that username has not been used
		$sql="SELECT username from users where username='" . $username . "'";
		$rs=$db->execute($sql);
		if ($rs->fields==true) $found=true;
		else{
			$sql="insert into users
			(staffId,fullName,jobdesc,username,password)
			values
			('" . $staffId . "','" . $fullname . "','" . $officialRole . "','" . $username . "','" . $password . "')";
			$rs=$db->execute($sql);
					
			//save  roles
			saveRoles($username,$db);
			
		}
	}
	
	
	//we are editing
	//if ($_POST['Submit']=='Update') 
	else{
		
		$user=$_GET['uid'];
		
		$sql="UPDATE users SET username='".$username."',password='" . $password . 
		"',jobdesc='".$officialRole."', fullname='" . $fullname . "' where username='" .
		$user. "'";
		$fs=$db->execute($sql);
		//remove the old roles and add these new ones just posted
		$sql="DELETE From actingroles where username='" . $user ."'";
		$fs=$db->execute($sql);
		//now insert
		saveRoles($username,$db);								
	}//end edit
	
}//end add or edit

//we are deleting
elseif ($_GET['action']=='delete'){
	$user=$_GET['uid'];
	$sql="DELETE FROM  users WHERE username= '" . $user . "'";
	$rst=@$db->execute($sql);
	$sql="DELETE FROM  actingroles WHERE username= '" . $user . "'";
	$rst=@$db->execute($sql);
}

?>



<script language="javascript">
function setDefaultPwd(thisObj){
	if(thisObj.checked){
		thisObj.form.txtPwd.value='password'
		thisObj.form.txtConfPwd.value='password'
	}
}

function editRecord(uid,fullName,officialRole,username,pwd,arrRoles){
	formObj=document.users
	
	formObj.txtStaffId.readOnly=true
	formObj.txtStaffId.value=uid
	formObj.txtFullname.value=fullName
	formObj.cboRole.value=officialRole
	formObj.txtUsername.value=username
	formObj.txtPwd.value=pwd
	formObj.txtConfPwd.value=pwd
	formObj.chkDefaultPwd.checked=false
	
	//get user roles
	chkRoles=formObj.elements('chkRoles[]');
	for(i=0; i<arrRoles.length; i++){
		chkRoles[i].checked=arrRoles[i]
	}
	
	formObj.Submit.value='Update'
	formObj.action='?action=edit&uid='+username
}

function deleteRecord(username){
	if(!confirm('Are you sure you want to delete user "'+username+'"')) return 
	self.location='?action=delete&uid='+username
}

function validateEntries(formObj){
	retVal=ValidateEntry(formObj.txtStaffId,'Enter Staff Id')
	retVal=retVal && ValidateEntry(formObj.txtFullname,'Enter Full Name')
	retVal=retVal && ValidateEntry(formObj.cboRole,'Enter Official Role')
	retVal=retVal && ValidateEntry(formObj.txtUsername,'Enter Username')
	
	if(formObj.txtPwd.value!=formObj.txtConfPwd.value){
		alert('Password must be the same as Confirm Password')
		formObj.txtPwd.focus()
		return false
	}
	
	return retVal
}
</script>



<form name="users" method="post" onsubmit="return validateEntries(this)">
<table width="800px" border="0" align="center">
          <tr>
            <td width="23%" height="23" align="left" class="ItemTitle"><a href="admin.setup.php">Setup</a> -> Users</td>
            <td width="22%">&nbsp;</td>
            <td width="17%">&nbsp;</td>
            <td width="38%">&nbsp;</td>
          </tr>
          <tr>
            <td height="26" align="left" class="style4">Staff Id </td>
            <td align="left" class="style4"><input name="txtStaffId" type="text" class="textfield" id="txtStaffId" /></td>
            <td><span class="style4">Full Name</span></td>
            <td><span class="style4">
              <input name="txtFullname" type="text" id="txtFullname" style="color:#000; border: 1px solid #ccc; width:300px" />
            </span></td>
          </tr>
          <tr>
            <td height="31" align="left" class="style4">Official Role </td>
            <td align="left" class="style4"><select name="cboRole" id="cboRole">
              <option value="">Select a role</option>
              <option value="Doctor">Doctor</option>
              <option value="Nurse">Nurse</option>
              <option value="Pharmacist">Pharmacist</option>
              <option value="Other">Other</option>
            </select></td>
            <td><span class="style4">User name</span></td>
            <td><span class="style4">
              <input name="txtUsername" type="text" class="textfield" id="txtUsername" />
            <span class="errormsg">
            <?php   if ($found) {echo "   username already exists"; } ?>
            </span></span></td>
          </tr>
          <tr>
            <td height="24" align="left" class="style4">&nbsp;</td>
            <td align="left" class="style4"><input name="chkDefaultPwd" onclick="setDefaultPwd(this)" type="checkbox" id="chkDefaultPwd" value="true" checked />
Use Default password </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td height="25" align="left" class="style4">Password</td>
            <td align="left" class="style4"><input name="txtPwd" type="password" class="textfield" id="txtPwd" value="password" /></td>
            <td><span class="style4">Confirm Password</span></td>
            <td><span class="style4">
              <input name="txtConfPwd" type="password" class="textfield" id="txtConfPwd" value="password" />
            </span></td>
          </tr>
           <tr>
             <td height="28" align="left" class="style4">Can act as</td>
             <td align="left" class="style4"><?php
				//get all available roles
				$sysRoles=array('admin'=>'Admin','nurse'=>'Nurse','doctor'=>'Doctor','pharm'=>'Pharmacist');
				foreach($sysRoles as $key=>$value)
					echo '<input name="chkRoles[]" type="checkbox" class="date_field" id="chkRoles[]" value="'.
					$key.'" />'.$value.'&nbsp;';
				?></td>
             <td>&nbsp;</td>
             <td>&nbsp;</td>
           </tr>

          <tr>
            <td height="41" class="style4">&nbsp;</td>
            <td align="right" class="style4"><input name="Submit" type="submit" class="btnlogin" value="Save" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td colspan="4" align="center" valign="top" class="style4"><?php 
			   $sql= 'select * from users';
				$rst=$db->execute($sql);
				echo $rst->RecordCount()." record(s) returned
				<table width=100% border=0 >
                  <tr class=tbldata>
                    <td>Edit</td>
                    <td>Delete</td>
					<td>Staff ID</td>
					<td>Full Name</td>
					<td>Official Role</td>
                    <td>User Name</td>
                    <td>Can Act As</td>
                  </tr>";

					while (!$rst->EOF):
						//get all available roles
						$sysRoles=array('admin'=>0,'doctor'=>0,'nurse'=>0,'pharm'=>0);
						
						$sql2="SELECT rolename FROM
 						 actingroles WHERE  (username = '" . $rst->fields('username') . "')";
						 $rst2=$db->execute($sql2);

						 while ($rst2->EOF==false):
						 		//get roles assigned to each user
						 		$sysRoles[$rst2->fields('rolename')]=1;
								$rst2->movenext();
						endwhile;
						
						/*in the list of roles available, filter out roles assigned to each user
						and separate them by comma*/
						$myroles=join(', ',array_keys($sysRoles,1));
						
						//this values will be used to determine the checked status of the chkRoles[] check box
						$sysRoleValues=join(',',array_values($sysRoles));
						
						 echo '<tr class=TableRow><td>'; 
						 
						 //i'm putting the editRecord function in the onclick event. this will prevent its parameters
						 //from showing in status bar.
						 echo "<a href=\"javascript:\" onClick=\"
						 editRecord('".$rst->fields('staffid')."','".$rst->fields('fullname')."',
						 '".$rst->fields('jobdesc')."','".$rst->fields('username')."',
						 '".$rst->fields('password')."',[".$sysRoleValues."])\"
						 >edit</a></td>";
						 
						 echo "<td><a href=\"javascript:
						 deleteRecord('".$rst->fields('username')."')\">delete</a></td>"; 
						 
						 echo '<td>' . $rst->fields('staffid') . '</td>';
						 echo '<td>' . $rst->fields('fullname') . '</td>';
						 echo '<td>' . $rst->fields('jobdesc') . '</td>';
						 echo '<td>' . $rst->fields('username') . '</td>';
						 echo '<td>' . $myroles . '</td>';
						 echo '</tr>';
						 $rst->movenext();
	    			 endwhile;
				  echo "</table>";
				  
			 
			 ?></td>
            </tr>
        </table>
</form>
<?php
include('foot.php');
?>