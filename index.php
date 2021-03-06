<!DOCTYPE html>
<html>
<head>
<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script> 
<script type="test/javascript" src="/js/jquery.timers.js"></script>

<script> 
	var makeHTML = function (data_arr){
		//console.log(i.entry,i.time);
		//Make table
		var html= "";
		html += "<tr><th>Entry</th><th>Date</th><th>Time</th><th>State</th></tr>";
		data_arr.results.forEach(function(data_arr2){
			//console.log(data_arr2.entry,data_arr2.time);
			html += "<tr><td>" + data_arr2.entry + "</td><td>" +  data_arr2.date + "</td><td>" + data_arr2.time + "</td><td>" + data_arr2.state + "</td></tr>";
		});
		return html;
	}
	

	var buildTable = function(roomName,roomTable){
		$.ajax({
			url:"script_test.php",
			type:"GET",
			data: {'room':roomName},
			success: function(data){
				//data.results.forEach(makeHTML);
				$('#' + roomTable).html(makeHTML(data));
				//console.log($('#' + roomTable));
			}
		});
	}


	var makeHTMLvideo = function (data_arr){
                //Make table
                console.log(data_arr);
		var html2= "";
                html2 += "<tr><th>Entry</th><th>Date</th><th>Time</th><th>Viewed Status</th><th>Video Link</th></tr>";
                data_arr.results.forEach(function(data_arr2){
			html2 += "<tr><td>" + data_arr2.entry + "</td><td>" +  data_arr2.date + "</td><td>" + data_arr2.time + "</td><td>" + data_arr2.viewedStatus + "</td><td><a id=\"" + data_arr2.link + "\"" + " href=\"#\">" + data_arr2.link + "</a></td></tr>";
		});
		//html2 = "<a id=\"click2\" href=\"#\"> click inside makeHtmlvideo </a>";
		//console.log(html2);
                return html2;
        }

	var buildTable_video = function(videoFile,vidTable){
                $.ajax({
                        url:"script_test.php",
                        type:"GET",
                        data: {'video_table':videoFile},
                        success: function(data){
                                $('#' + vidTable).html(makeHTMLvideo(data));
                        }
                });
        }

	//Refreshes recorded video table every 30-seconds
	setInterval(function(){
		$.ajax({ 
			url: "server",
			success: function(){
				buildTable_video('inputvideo','recorded_video_table');
				buildTable('room1','room1_table');
	                	buildTable('room2','room2_table');
				console.log('loop worked');
			}
		});
	},30000);

	
	$(document).ready(function(){
		buildTable('room1','room1_table');
		buildTable('room2','room2_table');
		buildTable_video('inputvideo','recorded_video_table');
		
		$("#btnon1").click(function(){
			event.preventDefault();
			var button_id = $(this).attr("id");
			$.ajax({
				url: "script_test.php",
				type: "POST",
				data:{id:button_id},
				dataType: "json",
				success: function(data1){
					//$("#ajaxrequest").html(data1);
					//var rLength = ajaxresult.results.length;
					//var phparray = ajaxresult.results
					console.log(data1);
					buildTable('room1','room1_table');
					
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
                                success: function(data1){
                                        //$("#ajaxrequest").html(ajaxresult);
                                        console.log(data1);
                                	buildTable('room1','room1_table');
				}
                        });
                });

		 $("#timer1").submit(function(){
                        event.preventDefault();
			$("#timer1_state").html("Timer1 Set");
                        var button_id2 = $(this).attr("id");
			var formData ={	
				'ontime' : $('input[name=onTime1]').val(),
				'offtime': $('input[name=offTime1]').val()
			};
                        $.ajax({
                                url: "script_test.php",
                                type: "POST",
                                data:{id:button_id2,formData1:formData},
                                success: function(data1){
                                        console.log(data1);
                                }
                        });
                });

		    $("#timer2").submit(function(){
                        event.preventDefault();
                        $("#timer2_state").html("Timer2 Set");
			var button_id2 = $(this).attr("id");
                        var formData ={ 
                                'ontime' : $('input[name=onTime2]').val(),
                                'offtime': $('input[name=offTime2]').val()
                        };
                        console.log(button_id2,formData);
                        $.ajax({
                                url: "script_test.php",
                                type: "POST",
                                data:{id:button_id2,formData1:formData},
                                success: function(data1){
                                        //$("#ajaxrequest").html(ajaxresult);
                                        console.log(data1);
                                }
                        });
                });




		 $("#cancel_timer").click(function(){
                        event.preventDefault();
                        var button_id3 = $(this).attr("id");
                        //$('input').val('');
                        $.ajax({
                                url: "script_test.php",
                                type: "POST",
                                data:{id:button_id3},
                                success: function(){
                                        $("#timer1_state").html("Timer1 Off");
                                        console.log('timer reset');
                                }
                        });
                });

		  $("#cancel_timer2").click(function(){
                        event.preventDefault();
                        var button_id3 = $(this).attr("id");
                        //$('input').val('');
                        $.ajax({
                                url: "script_test.php",
                                type: "POST",
                                data:{id:button_id3},
                                success: function(){
                                        $("#timer2_state").html("Timer2 Off");
                                        console.log('timer reset');
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
                                        //$("#ajaxrequest").html(ajaxresult);
                                        //console.log('It worked3');
					buildTable('room2','room2_table');
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
                                        //$("#ajaxrequest").html(ajaxresult);
                                        //console.log('It worked4');
					buildTable('room2','room2_table');
                                }
                        });
                });

		$("#start_livevideo").click(function(){
                        event.preventDefault();
			var button_id5 = $(this).attr("id");
			var player = document.getElementById("vlc");
			//player.playlist.play();
                        $.ajax({
                                url: "script_test.php",
                                type: "POST",
                                data:{id:button_id5},
                                success: function(ajaxresult){
                                        //$("#ajaxrequest").html(ajaxresult);
                                        console.log('It worked5');
					player.playlist.play();
                                }
                        });
	
                });

		 $("#start_livevideo_record").click(function(){
                        event.preventDefault();
                        var button_id5 = $(this).attr("id");
                        var player = document.getElementById("vlc");
                        //player.playlist.play();
                        $.ajax({
                                url: "script_test.php",
                                type: "POST",
                                data:{id:button_id5},
                                success: function(ajaxresult){
                                        //$("#ajaxrequest").html(ajaxresult);
                                        console.log(ajaxresult);
                                        //player.playlist.play();
                                }
                        });
        
                });


		$("#stop_livevideo").click(function(){
                        event.preventDefault();
                        var button_id6 = $(this).attr("id");
			var player = document.getElementById("vlc");
                	player.playlist.stop();
                        player.playlist.items.clear();

			$.ajax({
                                //url: "script_test.php",
                                type: "POST",
                                data:{id:button_id6},
                                success: function(ajaxresult){
                                        //$("#ajaxrequest").html(ajaxresult);
                                        console.log('It worked6');
                                }
                        });

		});

		$("#kill_raspivid").click(function(){
                        event.preventDefault();
                        var button_id7 = $(this).attr("id");
                        $.ajax({
                                url: "script_test.php",
                                type: "POST",
                                data:{id:button_id7},
                                success: function(ajaxresult){
                                        //$("#ajaxrequest").html(ajaxresult);
                                        console.log('It worked7');
                                }
                        });

                });


		$("#slider").on('change',function(){
                        event.preventDefault();	
			var slider_id = $(this).attr("id");
			var degrees = $('#slider').val();
			$("#slidervalueid").val($('#slider').val());
			$.ajax({
                                url: "script_test.php",
                                type: "POST",
                                data:{id:slider_id,angle:degrees},
                                success: function(ajaxresult){
                                        //$("#ajaxrequest").html(ajaxresult);
                                        //console.log("sliderid=",slider_id,"slider stop value=",degrees);
				}
                        });
		});

		$("#activate_motiondetector").click(function(){
                        event.preventDefault();
                        var button_id8 = $(this).attr("id");
			$("#activate_state").html("Motion Detector Activated");
                        $.ajax({
                                url: "script_test.php",
                                type: "POST",
                                data:{id:button_id8},
                                success: function(ajaxresult){
                                        $("#activate_state").html(ajaxresult);
                                        //console.log('It worked8');
					buildTable_video('inputvideo','recorded_video_table');
                                	//$("#motion_detector_status").html("<p>Motion Detector On</p>")
				}
                        });

                });

		$("#deactivate_motiondetector").click(function(){
                        event.preventDefault();
                        var button_id8 = $(this).attr("id");
                        $.ajax({
                                url: "script_test.php",
                                type: "POST",
                                data:{id:button_id8},
                                success: function(ajaxresult){
                                        $("#activate_state").html("Motion Detector Deactivated");
                                        //console.log('It worked8');
                                        //buildTable_video('inputvideo','recorded_video_table');
                                }
                        });

                });

		
		$("table").click(function(){
                        
			event.preventDefault();
			//var test1 = $(this).find('tr').find('td').find('a').attr("id");
			var test1 = event.target.id;
                       	//var videoID = 'videoclip';
			//var sourceID= 'mp4video';
			//var newmp4 = "videos/"+test1;
			//$('#'+videoID).get(0).pause();
			//$('#'+sourceID).attr('src',newmp4);
			//$('#'+videoID).get(0).load();
			//$('#'+videoID).get(0).play();
			$.ajax({
                                url: "script_test.php",
                                type: "POST",
                                data:{change_status:true,filename:test1},
                                success: function(newtable){
					var videoID = 'videoclip';
                        		var sourceID= 'mp4video';
                        		var newmp4 = "videos/"+newtable.newfile;
					console.log(newtable,newmp4);
                        		$('#'+videoID).get(0).pause();
                        		$('#'+sourceID).attr('src',newmp4);
                        		$('#'+videoID).get(0).load();
					buildTable_video('inputvideo','recorded_video_table');
                                	
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
<br></br>
<table id="room1_table" border="1" cellspacing="2" cellpadding="2"></table>
<br></br>

<form id="timer1">
Time On: <input type="time" name="onTime1"/>
Time Off: <input type="time" name="offTime1"/>
<button type="submit" id="set_timer"> Program Timer </button>
</form>
<!--button type="submit" id="set_timer"> Program Timer </button-->
<button id="cancel_timer">Cancel Timer</button>
<div id="timer1_state"></div>

<p id="LightControl2">-------- Room 2--------</p>
<button id="btnon2"> Turn Light On </button>
<br></br>
<button id="btnoff2"> Turn Light Off </button>
<br></br>
<table id="room2_table" border="1" cellspacing="2" cellpadding="2"></table>
<br></br>

<form id="timer2">
Time On: <input type="time" name="onTime2"/>
Time Off: <input type="time" name="offTime2"/>
<button type="submit" id="set_timer2"> Program Timer </button>
</form>
<!--button id="set_timer2"> Program Timer </button-->
<button id="cancel_timer2">Cancel Timer</button>
<div id="timer2_state"></div>



<p id="record_video_table_label">--------Recorded Video-------------</p>
<table id="recorded_video_table" border="1" cellspacing="2" cellpadding="2"></table>
<br></br>
<video id="videoclip"  width = "400" height="300" controls="controls" autoplay="false">
<!--<source src="videos/testclip2.mp4" type="video/mp4">-->
<source id = "mp4video" src="#" type="video/mp4" />
</video>



<br></br>
<p id="Live Video Control"> --------Surveillance Camera--------</p>
<button id="start_livevideo" align="left">  Start Live Video </button>
<!--button id="start_livevideo_record"> Start Live Video and Record</button-->
<br></br>
<button id="stop_livevideo" align="left">  Stop Live Video </button>
<br></br>

<button id="kill_raspivid" align="left"> Kill Live Feed </button>
<!--button id="kill_raspivid_record">Kill Live Feed and Recording</button-->
<br></br>
<embed type="application/x-vlc-plugin" pluginspage="http://www.videolan.org" version="VideoLAN.VLCPlugin.2" width="600"
 height="400" id="vlc" loop="no" autoplay="no" target="http://169.254.64.100:8160/"</embed>

<br></br>
<label for=slider> Camera Pan Control</label>
<input type="range" id="slider" min="0" max="180" value="0" step="10">
<input type="text" name="slidervalue" id="slidervalueid" class="text" value="0">
<br></br>
<p id="Motion Detector"> -------------Motion Detector----------------</p>
<button id="activate_motiondetector" align="left"> Activate Motion Detector </button>
<br> 
<div id="motion_detector_status"></div>
</br>
<button id="deactivate_motiondetector" align="left"> Deactivate Motion Detector </button>
<br></br>
<div id="activate_state"></div>
<?php
$servername = "localhost";
$username = "root";
$password = "Ek5rpid6";
$dbname = "light_status";

//Create connection
//$conn = new mysqli($servername,$username,$password, $dbname);
//$dbhandle = mysql_connect($servername,$username,$password) or die ("Unable to connect to mysql <br>");

//Check connection
//echo "Connected Successfully <br>";
//console.log($phparray)
//$selected = mysql_select_db($dbname,$dbhandle) or die ("Unable to select database<br>");
//$query="SELECT * FROM test2";
//$result=mysql_query($query);
//$num=mysql_numrows($result);
//mysql_close();
?>
<br></br>

</body>
</html>

