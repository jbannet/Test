<?php 

$user_info_array = getUserDetails($_SESSION['userid']);
if(!$user_info_array)
die("User Not Found");
?>
<div class="register">
 <div class="act_head">Profile</div>
	<div class="msg2"></div> 
   <form name="Profile" id="Profile" method="post">  
   <input name="email" type="text" id="email" placeholder="E-mail" value="<?php echo $user_info_array['email']; ?>" class="required email">  
    <input name="password" type="password" id="password" placeholder="Password">
    <small>Enter Password only when you change</small>
    <input name="confirm_password" type="password" id="confirm_password" placeholder="Repeat password"  equalto="#password">  
   <input name="city" type="text" id="city" value="<?php echo $user_info_array['city']; ?>" placeholder="City" class="required">      
   <select name="state" id="state" class="required">
   	<option value="">Select State</option>
    <?php printDropdown(getStateArray(),$user_info_array['state']); ?>
   </select>
    <button class="btn" name="updtaeAcct">Update Profile</button>
    <input type="hidden" name="formname" value="Profile">
   </form>      
  </div>
          


        
             
             

              

