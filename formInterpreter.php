<?php 
require_once("DBQueries.php");
	//******************************************FUNCTIONS FOR BUTTONS AND FORMS**************************************
if(isset($_REQUEST['formname'])) {
//*************************USER MANAGEMENT BUTTONS
/************************************
* Author: Haider Ali
* This code is updated to handle registration
**************************************/
	if($_REQUEST['formname']=="Register"){ 			
		$state 	= mysql_real_escape_string($_POST['state']);
		$city 		= mysql_real_escape_string($_POST['city']);
		$email 	= mysql_real_escape_string($_POST['email']);
		$username 	= mysql_real_escape_string($_POST['username']);
		$password 	= $_POST['password']!=''?md5(mysql_real_escape_string($_POST['password'])):false;//md5	
		
		// Check if an account with the provided username exists or not
		$res = mysql_query("SELECT username from tt_users where username='$username'");
		$countExisting = mysql_num_rows($res);
		
		if($countExisting == 0){
			// Creating the user account
			$res2 = mysql_query("INSERT INTO tt_users (`name`, `username`,`email`, `password`, `city`, `state`) VALUES('$username','$username','$email','$password','$city','$state')");			
			if($res2 && mysql_affected_rows()==1){
			$userId = mysql_insert_id();	
			// Creating the default user group[
			$res3 = mysql_query("INSERT INTO tt_groups (`name`, `default`) VALUES('$username Default Group',1)");
			$groupId = mysql_insert_id();
			$res4 = mysql_query("INSERT INTO tt_mebership_map (`user`, `group`, `authority`) VALUES($userId,$groupId,1)");
			echo "{\"status\":\"yes\", \"page\":\"\", \"message\":\"Your account created successfully. Please login with the username and password you entered while creating the accoutn.\"}";			
			}
			else
			echo "{\"status\":\"no\", \"page\":\"\", \"message\":\"There was some error while creating your account. Please try again.\"}";
		} else {
			echo "{\"status\":\"no\", \"page\":\"\", \"message\":\"We already have an account with the provided username. Please choose a different username.\"}";			
		}
	}	
	
/************************************
* Author: Haider Ali
* This code is updated to handle registration
**************************************/
	if($_REQUEST['formname']=="Profile"){ 			
		$state 	= mysql_real_escape_string($_POST['state']);
		$city 		= mysql_real_escape_string($_POST['city']);
		$email 	= mysql_real_escape_string($_POST['email']);
		$passwordTxt 	= $_POST['password']!=''?"`password`='".md5(mysql_real_escape_string($_POST['password']))."'":'';//md5	
		

			// Creating the user account
			$res2 = mysql_query("UPDATE tt_users SET `email`='$email', ".$passwordTxt." `city`='$city', `state`='$state' WHERE id='".$_SESSION['userid']."'");			
			if($res2){
			echo "{\"status\":\"yes\", \"page\":\"\", \"message\":\"Your profile has been updated successfully.\"}";			
			}
			else
			echo "{\"status\":\"no\", \"page\":\"\", \"message\":\"There was some error while updating your profile. Please try again.\"}";
		
	}	
	
/************************************
* Author: Haider Ali
* This code handles login 
**************************************/	
	if($_REQUEST['formname']=="mainsignin"){
			$username = mysql_real_escape_string($_REQUEST['username']);
			$password_sha1 = md5(mysql_real_escape_string($_REQUEST['passwordsign'])); //sha1()
			$result = mysql_fetch_array(mysql_query("SELECT id,password,name,email FROM tt_users WHERE username = '$username'")); //should be unique studio name
		  // clear out any existing session that may exist
			if (!isset($_SESSION)) 		  
			session_start();
			session_destroy();
			session_start();
		
		  if (($result['password'] == $password_sha1) and (!($_REQUEST['passwordsign']==""))) {
	  
			$_SESSION['userid'] = $result['id'];
			$_SESSION['name'] = $result['name'];
			echo "{\"status\":\"correct\", \"page\":\"MainPage.php\"}";  
		  } else {			
			$_SESSION['userid'] = false;
			$_SESSION['name'] = null;
			echo "{\"status\":\"no\", \"page\":\"index.php\"}";
		  }		  
	}	
	

 	
}
	
?>
