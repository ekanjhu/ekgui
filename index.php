<!DOCTYPE html>
<html>
<head>
<script src="http://code.jquery.com/jquery-1.11.2.min.js"></script>
<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script> 
<script> $(document).ready(function(){
		$("#btnon1").click(function(){
			event.preventDefault();
			var button_id = $(this).attr("id");
			//alert("Text: "+ $("#test").text());	
			$.ajax({
				url: "script_test.php",
				type: "POST",
				data:{id:button_id},
				success: function(ajaxresult){
					$("#ajaxrequest").html(ajaxresult);
					console.log('It worked1');
				}
			});
		});
	
		 $("#btnoff1").click(function(){
                        event.preventDefault();
                        var button_id2 = $(this).attr("id");
                        $.ajax({
                                url: "script_test.php",
                                type: "POST",
                                data:{id:button_id2},
                                success: function(ajaxresult){
                                        $("#ajaxrequest").html(ajaxresult);
                                        console.log('It worked2');
                                }
                        });
                });

		 $("#btnon2").click(function(){
                        event.preventDefault();
                        var button_id3 = $(this).attr("id");
                        //alert("Text: "+ $("#test").text());   
                        $.ajax({
                                url: "script_test.php",
                                type: "POST",
                                data:{id:button_id3},
                                success: function(ajaxresult){
                                        $("#ajaxrequest").html(ajaxresult);
                                        console.log('It worked3');
                                }
                        });
                });

                 $("#btnoff2").click(function(){
                        event.preventDefault();
                        var button_id4 = $(this).attr("id");
                        $.ajax({
                                url: "script_test.php",
                                type: "POST",
                                data:{id:button_id4},
                                success: function(ajaxresult){
                                        $("#ajaxrequest").html(ajaxresult);
                                        console.log('It worked4');
                                }
                        });
                });

		
		$("#start_livevideo").click(function(){
                        event.preventDefault();
                        var button_id5 = $(this).attr("id");
                        $.ajax({
                                url: "script_test.php",
                                type: "POST",
                                data:{id:button_id5},
                                success: function(ajaxresult){
                                        $("#ajaxrequest").html(ajaxresult);
                                        console.log('It worked5');
                                }
                        });
                });




	});
</script>
</head>
<body>
<div id="ajaxrequest"></div>
<p id="LightControl1">-------- Room 1--------</p>
<button id="btnon1"> Turn Light On </button>
<br></br>
<button id="btnoff1"> Turn Light Off </button>

<p id="LightControl2">-------- Room 2--------</p>
<button id="btnon2"> Turn Light On </button>
<br></br>
<button id="btnoff2"> Turn Light Off </button>

<p id="Live Video Control"> --------Surveillance Camera--------</p>
<button id="start_livevideo" align="left">  Start Live Video </button>
<br></br>
<button id="stop_livevideo" align="center"> Stop Live Video </button>
<br></br>
<embed type="application/x-vlc-plugin" pluginspage="http://www.videolan.org" ve$


</body>
</html>

