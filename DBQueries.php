<?php

#error_reporting("all^notice");
session_start();
/**
 * 
 *  Environment. development or production
 *
 */
#define("Environment","development");
define("Environment","production");

define ("SITE_PATH" , Environment=='development'?"http://localhost/team/":"http://www.teamtrackeronline.com/team/");
define ("SITE_JS" , SITE_PATH.'js/');
define ("SITE_IMAGES" , SITE_PATH.'images/');
define ("EVENT_IMAGES" , SITE_IMAGES.'Event/');
define ("USER_IMAGES" , SITE_IMAGES.'User/'); 
define("AdminEmail","singh.pooran@gmail.com");
define("AdminName","Team Admin");
/**
 * 
 *  Events Setting 
    set variable to both, left, right
 *
 */
define("EVENTLOOK","both");
/**
 * 
 *  Hostname. Usually is localhost
 *
 */
	$host = (Environment=='development'?"localhost":"localhost");
/**
 * 
 *  Username to access database server
 *
 */	
	$user = (Environment=='development'?"root":"teamtra4_haider");
/**
 * 
 *  Password to access database server
 *
 */		
	$password = (Environment=='development'?"vertrigo":"!88sdndSshh@j");
/**
 * 
 *  database name
 *
 */		
	$database = (Environment=='development'?"team_tracker":"teamtra4_tracker");	
/**
 * 
 *  Connecting to the database server using the above credentials
 *
 */		
	$con = mysql_connect($host, $user, $password) or die("Website unavailable. Please try again later");	
/**
 * 
 *  selecting the required database
 *
 */			
	$db = mysql_select_db($database, $con) or die("Failed to select database");

/*********************************FUNCTIONS FOR GETTING SIMPLE INFORMATION FROM DATABASE***********************************/
	/* 
	* Function to fetch name of the user
	* Params : int (user unique id)
	* Returns: string (Name of the user or msg stating No user)
	*/	
	function GetUserName($user){
	$str = "select name from tt_users where id = '".mysql_real_escape_string($user)."' ";	
	$res = mysql_query($str);
	
	if(mysql_num_rows($res)>0)
	   {
	   $record = mysql_fetch_array($res);		   
	   return $record['name'];
	   }
	   else
	   return false;
	} 

	/* 
	* Function to fetch avatar(profile pic) of the user
	* Params : int (user unique id)
	* Returns: string (avatar file name  or defaukt pic file name)
	*/	
	function GetUserAvatar($user){
	$str = "select avatar from tt_users where id = '".mysql_real_escape_string($user)."' ";		
	$res = mysql_query($str);
	
	if(mysql_num_rows($res)>0)
	   {
	   $record = mysql_fetch_array($res);		   
	   return $record['avatar'];
	   }
	   else
	   return false;
	} 
	
	
	
	/* 
	* Function to get events Based On Date
	* Params : string 
	* Returns: array containg events, if no event found it return false;
	*/	
	function getEventsOnDate($dateActual)
	{
	$datalist = array();	
	$str = "Select * from tt_events  where date = '".mysql_real_escape_string($dateActual)."' order by TIME DESC";		
	$res = mysql_query($str);
	
	if(mysql_num_rows($res)>0)
	   {
	  	 while($row = mysql_fetch_assoc($res))
		 {
			 $datalist[] = $row;
		 }
		 return $datalist;
	   }
	   else
	   return false;
	} 		

/*********************************FUNCTIONS FOR ADDING INFORMATION TO THE DATABASE***********************************/
	/*
	* Add an event to the database
	* GroupList is all groups (OR USERS SINCE A USER IS ALSO A GROUP) that the Event applies to
	*/
	function addEvent($name, $pic, $date, $time, $owner, $type, $groupList){
		//make the ID for the event
		$id = NULL;
		//1) add the event to the event table with an ID
		$queryEvent = mysql_query("INSERT INTO `tt_events` (`id`, `name`, `pic`, `date`, `time`, `owner`, `type`) 
								   VALUES ($id, '$name', '$pic', '$date', '$time', '$owner', '$type')");
		$eventID 	= mysql_insert_id();
		//2) add the event/group pairing to the Event-Group table
		foreach($groupList as $group){
			//add event/group pairing
			mysql_query("INSERT INTO `tt_event_group_map` (`event`, `group`) VALUES ('$eventID', '$group')");
		}
		
		//3) add the appropriate authorities to the Authorities table
	}
	
	
	/*
	* Add user to the database
	* It Checks if the user already exists, if it exists it return an array containing status as failed and the message, it it gets successfully inserted it return an array 		 	* containing status as success and ID of the user
	*/
	function addUser($name, $username, $pic, $password, $email, $city, $state){
		// Encrypting Password with MD5
		$password = md5($password);
		$returned = array();
		//make an ID for the user
		$id = NULL;
		//0 Check if user already exists
		$resUserExists = mysql_query("SELECT id from tt_users WHERE username='$username'");
		if(mysql_num_rows($resUserExists) > 0){
		  	$returned['status'] = 'failed';
			$returned['message'] = 'We already have an account with the provided username. Please try a different username';
			return $returned;
		}
		//1 create a new user for user table
		$resInsertUser = mysql_query("INSERT INTO  `tt_users` (`id` ,`name` ,`username` ,`avatar` ,`password` ,`city` ,`email` ,`state`)
									  VALUES ($id ,  '$name',  '$username',  '$pic',  '$password',  '$city',  '$email',  '$state')");
		$userID = mysql_insert_id();
		//2 create the associated group since every user is a group too
		$groupId = addGroup("$name Default Group", "", 1);
		
		//3 Creating the association map between user and group
		addUserToGroup($userID, $groupId, 1);

			$returned['status'] = 'success';
			$returned['id'] = $userID;
			return $returned;
	}
	
	/*
	* Add Group
	* It adds a group to the group table, if its successfull it return group id, else returns false
	* Table : tt_groups
	*/
	function addGroup($name, $description, $default = 0){
		//make an ID for the group
		$id = NULL;		
		//Add to group table
		$query = mysql_query("INSERT INTO `tt_groups` (`id`, `name`, `description`, `default`) VALUES ($id, '$name', '$description', '$default')");
		
		$groupID = mysql_insert_id();
		
		return $groupID;
		
	}	

	/*
	* Add user to a group
	* $authority it can be 1 or 2 ( For Admin 1, for Memeber 2), authority is not mandatory, if not passed it will treat the authoirty as member
	* Table : tt_mebership_map
	*/
	function addUserToGroup($user, $group, $authority = 2){
		//Add to User-group mapping table
		$query = mysql_query("INSERT INTO `tt_mebership_map` (`user`, `group`) VALUES ('$user', '$group')");
		
		// Calling the addUserTogroup function to assign authority
		addUserToGroup($user, $group, $authority);
		
	}
	
	/*
	* Add Authority for user to group
	* user ID, Group ID, authority ID
	* Table : tt_mebership_map
	*/
	function addUserToGroup($user, $group, $authority = 1){
		//Update Authority
		$query = mysql_query("UPDATE `tt_mebership_map` SET `authority` = '$authority' WHERE `user` = '$user' AND `group` = '$group'");
		
	}	
	
/*********************************FUNCTIONS FOR DELETING INFORMATION TO THE DATABASE***********************************/	
//most of these functions will require a "don't show" boolean column. Every table that is an add above is a remove here. Make sure it maps 1 for 1.

/*********************************FUNCTIONS FOR GETTING AN ASSOCIATED LIST EVENTS FROM THE DATABASE***********************************/

	/* 
	* Function to get Particular User's events that are not yet completed
	* This returns all events that are not yet marked as completed. Completed events are called by getEventsHistory()
	* SORT BY DATE
	* Params : the User ID number
	* Returns: array containg events, if no event found it return false;
	*/	
	function getEventsForUser($user){
		$datalist = array();	
		
		// SELECT * WHERE Events_User_mapping = $user and Completed = NULL SORTED by date, most recent first
		
		$str = "SELECT tt_events.* 
				FROM tt_event_user_map
				INNER JOIN tt_events ON tt_events.id = tt_event_user_map.event
				WHERE tt_event_user_map.user = $user
				AND tt_event_user_map.completed IS NULL 
				ORDER BY tt_events.date DESC";
		 
		   	
		$res = mysql_query($str);
	
		if(mysql_num_rows($res)>0){
	  	 while($row = mysql_fetch_assoc($res)){
			 $datalist[] = $row;
		 }
		 return $datalist;
	   }
	   else
	   return false;
	}

	
	/* 
	* Function to get Particular User's completed events. It returns X events. 
	* This is all events associated with the user that are marked as completed for the user
	* Events are ordered by completion date and returned $count at a time
	* Params : the User ID number, $ number of events to return, $starting number for events to return
	* Returns: array containg events, if no event found it return false;
	*/	
	function getEventsHistory($user, $count, $startIndex){
		//The event-user mapping needs a "completed" field. It should be a date. When completed is marked the present date is accessed and added to completed. Otherwise it is NULL.	
		$datalist = array();	
					
		$str = "SELECT tt_events.* 
				FROM tt_event_user_map
				INNER JOIN tt_events ON tt_events.id = tt_event_user_map.event
				WHERE tt_event_user_map.user = $user
				AND tt_event_user_map.completed IS NOT NULL 
				ORDER BY tt_events.date DESC
				LIMIT $startIndex,$count";
		 
		   	
		$res = mysql_query($str);
	
		if(mysql_num_rows($res)>0){
	  	 while($row = mysql_fetch_assoc($res)){
			 $datalist[] = $row;
		 }
		 return $datalist;
	   }
	   else
	   return false;
	}
	
	/* 
	* Function to get State List For User Sign Up Page.
	* Params : country ID, By default we have the United States as country 
	* Returns: array containg state list, if no state found it returns false;
	*/	
	function getStateArray($country_id=1){
		$res = mysql_query("SELECT id,name as value FROM tt_state  where country = ".$country_id);		
		if(mysql_num_rows($res)>0)
		   {
			 while($row = mysql_fetch_assoc($res))
			 {
				 $datalist[] = $row;
			 }
			 return $datalist;
		   }
		   else
		   return false;
	}

	  
	/*  
	* Function to get Groups Based On  User
	* Params : string 
	* Returns: array containg events, if no event found it return false;
	*/	
	function getGroupByUser($user){
		$datalist = array();	
		$str = "SELECT tt_groups.*,tt_mebership_map.authority  
		FROM tt_groups    
		INNER JOIN tt_mebership_map ON tt_mebership_map.group=tt_groups.id 
		WHERE tt_mebership_map.user = '".mysql_real_escape_string($user)."'   
		ORDER BY tt_groups.name ASC";  
		
				
		$res = mysql_query($str);
		
		if(mysql_num_rows($res)>0)
		   {
			 while($row = mysql_fetch_assoc($res))
			 {
				 $datalist[] = $row;
			 }
			 return $datalist;
		   }
		   else
		   return false;
	} 		

/*  
	* Function to get All users  Based On Group
	* Params : string 
	* Returns: array containg events, if no Users found it return false;
	*/	
	function getUsersByGroup($group){
		$datalist = array();	
		$str = "SELECT tt_users.name,tt_users.avatar,tt_users.id   
		FROM tt_users    
		INNER JOIN tt_mebership_map ON tt_mebership_map.user=tt_users.id 
		WHERE tt_mebership_map.group = '".mysql_real_escape_string($group)."'   
		ORDER BY tt_users.name ASC";  
		
				
		$res = mysql_query($str);
		
		if(mysql_num_rows($res)>0)
		   {
			 while($row = mysql_fetch_assoc($res))
			 {
				 $datalist[] = $row;
			 }
			 return $datalist;
		   }
		   else
		   return false;
	} 		

	/*  
	* Function to get Last updated Date and time of the group
	* Params : string 
	* Returns:  dateTime, if no Users found it return false;
	*/	
	function getLastUpdateByGroup($group){
		$datalist = array();	
		$str = "SELECT tt_events.date, tt_events.time 
				FROM tt_events 
				INNER JOIN tt_event_group_map ON tt_event_group_map.event=tt_events.id 
				INNER JOIN tt_groups ON tt_event_group_map.group=tt_groups.id 
				INNER JOIN tt_mebership_map ON tt_mebership_map.group=tt_groups.id 
				WHERE tt_groups.id = '".mysql_real_escape_string($group)."'      
				GROUP BY tt_events.id ORDER BY tt_events.time DESC";  
		
				
		$res = mysql_query($str);
		
		if(mysql_num_rows($res)>0)
		   {
			 $row = mysql_fetch_assoc($res);
			 $datalist['date'] = $row['date'];
			 $datalist['time'] = $row['time'];
			 return $datalist;
			
		   }
		   else
		   return false;
	} 			
	
	function getUserDetails($id)
	{
	  $query = mysql_query("SELECT * FROM tt_users WHERE id=$id");
	  if(mysql_num_rows($query)  == 1){
		 $data = mysql_fetch_assoc($query);
		 return $data;
	  } else {
		return false;  
	  }
	}
		
?>