function showInt ()
{
			$.ajax({
		  url: "get_intrests.php",
		  
		})
		  .done(function( data ) {
		    
		      inter = data;
		      inter = inter.split(",");
		     

		      for (var i = inter.length - 1; i >= 0; i--) {
		      	

		      	$('#interestlist').append(inter[i]);


		      };
		    
		  });
}


$(document).ready(function(){

			$(function(){
		  $("#comptable").hide();
		});

	$('.datepicker').datepicker("option", "dateFormat","YYYY-MM-DD");

	interestlist = [];
	var interestliststr,place,date;

	$( "#interestbutton" ).click(function() {
	  	$('#myModal').modal('show');
	});









	$("#interesttext").keypress(function(e) {
	    if(e.which == 13) {
	    	if($("#interesttext").val() != ""){
			    	interestlist.push($("#interesttext").val());
			    	console.log(interestlist);
			    	interestliststr = (interestliststr + $("#interesttext").val() + ",");
			    	interestliststr  = interestliststr.substring(0,interestliststr.length - 1);
			    	var x = $("#interesttext").val().toString();
			    	interestitem = '<div id = "interestbox" class="interestbox" >' + x + '<button type="button" class="btn btn-default btn-lg">x</button></div>';

					$(".bootbox-body").append(interestitem); 
					$(this).val("");


					$(".interestbox").click(function(e) {
					    $(this).remove();
					});

			}


	        }
	});

		function postPHP() {

			console.log(interestlist);
			$.ajax({
				type: "POST",
				url: "add_interests.php?v="+ interestlist,
				data: interestlist,
				cache: false,
				success: function(html) {
					console.log(html);
				
			}
			});
			
			return false;
		}



		$( "#appendbutton" ).click(function() {
				  	postPHP();
				});

		 $( "#datepicker" ).datepicker({
      changeMonth: true,
      changeYear: true 
    });



	$("#gobutton").click(function(e) {

		
				 	$("#comptable").show();
				
	    			if($("#placetxt").val() != "") {

	    			place = $("#address").html();

	    			console.log(place);
 
					$("#placetxt").val("");

					date = $("#datepicker").val();
					
		  						$.ajax({
				type: "POST",
				url: "add_event.php?destination="+ place + '&date='+ date,
				cache: false,
				success: function(html) {
					if(html=="success")
					{
						$("#asdasd").fadeOut();
						$.ajax({
							type: "POST",
							url: "fstest.php",
							cache: false,
							success: function(html) {
								$("#asdasd").html(html);
								$("#asdasd").fadeIn();
							
							}
						});
					}
				}
			});
			
				//return false;

		

	        }
	});

});


