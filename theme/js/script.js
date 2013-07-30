$(document).ready(function(){		
	// Jquery Code to Load Appropraite Page content on click of links	
	$(document).delegate('a.innerLink',"click",function(e){ e.preventDefault(); 
		$('.container').hide();
		var idToShow = $(this).attr('href').replace('#', '');
		$('#'+idToShow).show();
		$('.msg2').html('');
	});
	
});
