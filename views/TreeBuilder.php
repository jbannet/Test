<?php 


/* Function To Create Tree */

function TreeBuilder($user)
{ 

	$html = "";	 
	$resDate = getEventsDate($user); 
 
	if($resDate)
	{
		// set today and yesterday dates 
		$today = date('Y-m-d');
		$Yesterday = date('Y-m-d', strtotime('-1 day', strtotime(date('Y-m-d'))));
		// set counter for left or right
		// if  counter mod 2 = 0 then left 
		// if  counter mod 2 = 1 then right 				
		$counter  = 0;				
		foreach($resDate as $records)
			{
			$dateFormated = date("m/d", strtotime($records['date'])); 
			$dateActual =$records['date']; 
			$groupname= '';//$records['groupname'] ; 
					 
			$html  .='<div class="act_head">';
			if($dateActual==$today){  
			$html  .='Today'; 
			} else if(
			$dateActual==$Yesterday){ 
			$html  .='Yesterday';
			} else { 
			$html  .=$dateFormated; 
			}	
			$html  .='</div>';
			// query to get all events of this date which getting from main query
			$resEvent = getEventsOnDateByUser($dateActual,$user);			
			$html  .='<div class="act_right event">
						<ul>
						<li class="leftli" style="dispaly:none;"><img  src="theme/small-img.jpg" width="32" height="28" alt="smal" /> </li>
						<li class="rightli"><h1>Goals and activities<button name="add" value="event" class="add" title="Add Event" id="'.$resEvent[0]['group_id'].'"></button></h1></li>';
			

													
				// execute the loop till there is any records
				if($resEvent)
				foreach($resEvent as $Events) {
				//$dateFormated = date("M dS", strtotime($Events['date'])); 
				$date  =  $Events['date']; 
				$owner =  $Events['owner']; 
				$pic   =  $Events['pic'];
				$name  =  $Events['name'];
				$time  =  date("h:i A", strtotime($Events['time']));
								
				$html  .='<li class="leftli" id="lileft'.$counter.'"><img  src="theme/small-img.jpg" width="32" height="28" alt="smal" /></li>
						 <li class="rightli" id="liright'.$counter.'"><span><img  src="theme/star.png" width="27" height="24" alt="heart" /></span><p > '.$name;
				if($Events['owner']==$user || $resEvent[0]['authority']==1)
				$html  .='<button name="add" value="event" class="delete" title="Delete It" id="'.$resEvent[0]['group_id'].','.$Events['id'].'"></button>';
				$html .= '<span>'.$Events['groupname'].'</span></p></li>';
				
				  } 
				  // end of inner while loop  
	  
		 $html  .='</div>';
		 $html  .='<div style="clear:both;"> </div>';  
		 $counter++;
		 }  // end of while loop 
	} else { 
  	$html  .='<div style="color:#FF0000"> There is no event. </div>';
 	} 
  echo  $html;   
  }