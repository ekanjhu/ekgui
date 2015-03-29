<!DOCTYPE html>
<html>
<head>
<script src="http://code.jquery.com/jquery-1.11.2.min.js"></script>
<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script> 
<script> $(document).ready(function(){
		$("#btnon1").click(function(){
			event.preventDefault();
			//alert("Text: "+ $("#test").text());	
			$.ajax({
				type: "POST",
				url: "/var/www/lighton.py",
				success: function(data, textStatus,jqXHR){
					console.log('It worked');
				}
			})
		});
	});
</script>
</head>
<body>
<p id="LightControl1">-------- Room 1--------</p>
<button id="btnon1"> Turn Light On</button>
<br></br>
<button id="btnoff1"> Turn Light Off</button>
<br></br>
<p> Table of Light States</p>

<p id="LightControl2">--------  Room 2-------- </p>
<button id="btnon2"> Turn Light On</button>
<br></br>
<button id="btnoff2"> Turn Light Off</button>
<br></br>
<p> Table of Light States</p>

<p id="LiveVideo"> --------Surveillance Camera---------</p>
<button id ="StreamStart">Start Live Video Stream </button>
<br></br>
<button id ="StreamStop">Stop Live Video Stream </button>
<br></br>
<!--<img src="http://169.254.64.100:8080/?action=stream" width=200 height=200>-->
<!--<br><a href="http://169.254.64.100/?action=stream">View</a>-->
<embed type="application/x-vlc-plugin" pluginspage="http://www.videolan.org" ve$
<br></br>
<p> Table of Event-Triggered Recordings </p>




</body>
</html>

