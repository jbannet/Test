<?php 

function buildBoxes($detailsArray){
	if($detailsArray)
	foreach($detailsArray as $records)
	{
		echo '<div class="group_box">
		<table>
		<tr><td class="leftInfo"><h3>'.ucfirst($records['name']).'</h3><h3>'.getAuthorityText($records['authority']).'</h3><h3>'.stripslashes($records['description']).'</h3></td><td class="rightInfo"><img src="theme/small-img.jpg" /></td></tr>
		<tr><td></td></tr>
		</table>
		<div class="row">
		<p>X Pending Goals and activities</p>
		</div>
		</div>';	
	}
}
function getAuthorityText($id){
	switch($id){
	case 1:
	return 'Admin';
	break;
	case 2:
	return 'Member';
	break;
	default:
	return 'N/A';
	break;		
	}
	
}

	  