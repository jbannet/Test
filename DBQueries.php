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

	/* 
	* Function to fetch name of the user
	* Params : int (user unique id)
	* Returns: string (Name of the user or msg stating No user)
	*/	
	function GetUserName($user)
	{
	$str = "select name from tt_users where id = '".mysql_real_escape_string($user)."' ";	
	$res = mysql_query($str);
	
	if(mysql_num_rows($res)>0)
	   {
	   $record = mysql_fetch_array($res);		   
	   return $record['name'];
	   }
	   else
	   return "No User";
	} 

	/* 
	* Function to fetch avatar(profile pic) of the user
	* Params : int (user unique id)
	* Returns: string (avatar file name  or defaukt pic file name)
	*/	
	function GetUserAvatar($user)
	{
	$str = "select avatar from tt_users where id = '".mysql_real_escape_string($user)."' ";		
	$res = mysql_query($str);
	
	if(mysql_num_rows($res)>0)
	   {
	   $record = mysql_fetch_array($res);		   
	   return $record['avatar'];
	   }
	   else
	   return "Noimage.gif";
	} 
	
	/* 
	* Function to get events list
	* Params : 
	* Returns: array containg events, if no event found it return false;
	*/	
	function getEvents()
	{
	$datalist = array();	
	$str = "Select * from tt_events group by date DESC";		
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


/*  
	* Function to get events Based On Date and User
	* Params : string 
	* Returns: array containg events, if no event found it return false;
	*/	
	function getEventsOnDateByUser($dateActual,$user)
	{
	$datalist = array();	
	$str = "SELECT tt_events.*,tt_groups.name as groupname,tt_groups.id as group_id,tt_mebership_map.authority 
    FROM tt_events 
    INNER JOIN tt_event_group_map ON tt_event_group_map.event=tt_events.id 
    INNER JOIN tt_groups ON tt_event_group_map.group=tt_groups.id 
    INNER JOIN tt_mebership_map ON tt_mebership_map.group=tt_groups.id 
    WHERE tt_mebership_map.user = '".mysql_real_escape_string($user)."' AND tt_events.date = '".mysql_real_escape_string($dateActual)."'  
    GROUP BY tt_events.id ORDER BY tt_events.time DESC";  
	
			
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
	* Function to get Particular User's events list
	* Params : 
	* Returns: array containg events, if no event found it return false;
	*/	
	function getEventsDate($user)
	{
	$datalist = array();	
					
	$str = "Select tt_events.date from tt_events
		   inner join tt_event_group_map on tt_event_group_map.event=tt_events.id
		   inner join tt_groups on tt_event_group_map.group=tt_groups.id
		   inner join tt_mebership_map on tt_mebership_map.group=tt_groups.id
		   where tt_mebership_map.user='".$user."'
		   GROUP BY tt_events.date DESC";
		 
		   	
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
	
	function printDropdown($list,$selected=''){	
			if($list)
			foreach ($list as $item){
				echo "<option value='".$item['id']."'".($selected==$item['id']?' selected':'').">".$item['value']."</option>";
			}
	}
/*  
	* Function to get Groups Based On  User
	* Params : string 
	* Returns: array containg events, if no event found it return false;
	*/	
	function getGroupByUser($user)
	{
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
	function getUsersByGroup($group)
	{
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
function getLastUpdateByGroup($group)
	{
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