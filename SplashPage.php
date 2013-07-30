<?php 
require_once("DBQueries.php");
unset($_SESSION['userid']);
?>
<!DOCTYPE HTML>
<html>
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Team Tracker</title>
    <link media="all" type="text/css" href="theme/style.css" rel="stylesheet">    
    <script type="text/javascript" src="theme/js/jquery.min.js"></script>
    <script type="text/javascript" src="theme/js/jquery.validate.js"></script>
    <script src="http://malsup.github.com/jquery.form.js"></script> 
    <script src="theme/js/modernizr.js"></script>
    <script src="theme/js/placeholder.js"></script>
    <script type="text/javascript">	
	$(document).ready(function(){
							   
		/* browser caches the result and doesn't update divs post an a change to server	 */							   
		$.ajaxSetup ({cache: false}); 
		
		/*  Jquery Code to Handle the Login Form Submission Through Ajax */
		$('button[name=mainsignin]').click(function(evt){
			var btnClicked = $(this);
			btnClicked.css('opacity','0.2');													
			$('div.msg1').html("");			
			$('div.msg2').html("");	
			var formData = $('form[name=mainsignin]').serialize();			
			$.post('formInterpreter.php',formData,function(result){ 
														   var evalresult=eval(result); 
														   if(evalresult.status=="correct"){window.location=evalresult.page;}
														   else{$('div.msg1').html("<p class='box text-error'>INCORRECT USERNAME OR PASSWORD</p>");} 
														   btnClicked.css('opacity','1'); 
														   },'json');			
			evt.preventDefault();
		});
			
		/*  Jquery Code to Handle the REgistration Form Submission Through Ajax */			
		$('button[name=registerAcct]').click(function(evt){ 
			var btnClicked = $(this);
			btnClicked.css('opacity','0.2');
			$('div.msg1').html("");			
			$('div.msg2').html("");		
			/* Jquery Form Validation before submitting through Jquery*/
		    $('#Register').validate({	
									 highlight: function(element, errorClass) {
										btnClicked.css('opacity','1');
									  },									
								     submitHandler: function(form)
										{ 			   				
											var formData = $('form[name=Register]').serialize();  
											$.post('formInterpreter.php',formData,function(result){  
													var evalresult=eval(result);																			
													if(evalresult.status=="yes"){  
													$('div.msg2').html("<p class='box text-success'>"+ evalresult.message +"</p>");																				
													} else{
													$('div.msg2').html("<p class='box text-error'>" + evalresult.message + "</p>");
													}							
													btnClicked.css('opacity','1');
											},'json');														
											evt.preventDefault();										
										}
									});					
		});			 				
		
	});
	</script>	
	</head>
<body class="splashPage">
<div class="container">
 <div class="LoginArea">
  <div class="login">
  <p class="title">Login-In</p>
	<div class="msg1"></div>  
   <form name="mainsignin" id="mainsignin" method="post">  
    <input name="username" type="text" id="username" placeholder="User Name">
    
    <input name="passwordsign" type="password" id="passwordsign" placeholder="Password">
    <button class="btn" name="mainsignin">Log in</button>
    <input type="hidden" name="formname" value="mainsignin">
   </form>   
  </div>
  <div class="register">
 <p class="title">Sign-Up</p>
	<div class="msg2"></div> 
   <form name="Register" id="Register" method="post">  
   <input name="email" type="text" id="email" placeholder="E-mail" class="required email">
    <input name="username" type="text" id="username" placeholder="User Name" class="required">
    <input name="password" type="password" id="password" placeholder="Password" class="required">
    <input name="confirm_password" type="password" id="confirm_password" placeholder="Repeat password"  equalto="#password">  
   <input name="city" type="text" id="city" placeholder="City" class="required">      
   <select name="state" id="state" class="required">
   	<option value="">Select State</option>
    <?php printDropdown(getStateArray()); ?>
   </select>
    <button class="btn" name="registerAcct">Sign up</button>
    <input type="hidden" name="formname" value="Register">
   </form>      
  </div>
 </div>
</div>
</body>
</html>