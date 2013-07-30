<?php 
require_once("DBQueries.php");/*
*  Code To check if user exists, if not it redirect the user to main.php
*/
	if(!isset($_SESSION['userid'])){
	header("location: index.php");	
	}
require_once("views/TreeBuilder.php");	
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Events</title>
<!-- Loading External Css Files         -->
<link media="all" type="text/css" href="theme/style.css" rel="stylesheet">
<!-- Loading External Javascript Files  -->
<script type="text/javascript" src="theme/js/jquery.min.js"></script>
<script type="text/javascript" src="theme/js/script.js"></script>
<script type="text/javascript" src="theme/js/jquery.validate.js"></script>
<script src="http://malsup.github.com/jquery.form.js"></script>
<script src="theme/js/modernizr.js"></script>
<script src="theme/js/placeholder.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
		/*  Jquery Code to Handle the Profile Update Form Submission Through Ajax */			
		$(document).delegate('button[name=updtaeAcct]',"click",function(evt){
			var btnClicked = $(this);
			btnClicked.css('opacity','0.2');		
			$('div.msg2').html("");		
			/* Jquery Form Validation before submitting through Jquery*/
		    $('#Profile').validate({	
									 highlight: function(element, errorClass) {
										btnClicked.css('opacity','1');
									  },									
								     submitHandler: function(form)
										{ 			   				
											var formData = $('form[name=Profile]').serialize();  
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
			/* Jquery To detele the event Jquery*/
		$('.DelteIt').click(function(){
		var id = this.id;
		});		
		$('button[name=add]').click(function(){
		  formname = $(this).val();
		  /*$("#form_content").show().('#page_content').hide();*/
		 
		 $("#page_content").animate({width: 'toggle'}, {direction:'right'}, 500);
		 $("#form_content").html("<div class='slideOutform'><div class='arrow'></div><div class='contentForm'>" + formname + " form will be shown here</div></div>").animate({width: 'toggle'}, {direction:'right'}, 500);
		});	
		
		$('.arrow').click(function(){ 	
			 $("#form_content").html("<div class='slideOutform'><div class='arrow'></div><div class='contentForm'>" + formname + " form will be shown here</div></div>").animate({width: 'toggle'}, {direction:'right'}, 500);	
			 $("#page_content").animate({width: 'toggle'}, {direction:'right'}, 500);
		});
    });
    </script>
</head>
<body style="height:1500px;">
<?php include("views/TopPanel.php"); ?>

<!-- Home Page -->
<div class="container inner" id="HomePage">
  <?php include("views/LeftPanel.php"); ?>
  <div class="rowright" id="form_event" style="display:none; height:150px;">
  </div>
  <div class="rowright" id="form_group" style="display:none; height:150px;">
  </div>  
  <div class="rowright" id="page_content">
  
  <?php TreeBuilder($_SESSION['userid']); ?>
    <!-- Main Body Starts Here -->
    <!-- <div class="contents" id="page_content"> </div> -->
    <!-- Main Body Ends Here -->
  </div>
</div>

<!-- Profile Page -->
<div class="container inner" id="ProfilePage" style="display:none;">
  <div class="rowright" id="page_content">
  
  <?php include("views/profile.php"); ?>
    <!-- Main Body Starts Here -->
    <!-- <div class="contents" id="page_content"> </div> -->
    <!-- Main Body Ends Here -->
  </div>
</div>

</body>
</html>