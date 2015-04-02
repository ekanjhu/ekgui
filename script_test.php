<?php
$post_button =$_REQUEST["id"];
if($post_button == "btnon1")
{
	echo "Room1: Turned light on"."<br>";
	echo $post_button."<br>";
	shell_exec('sudo python /home/pi/lighton.py');

}elseif($post_button =="btnoff1"){

	echo "Room1: Turned light off"."<br>";
	echo $post_button2."<br>";
	shell_exec('sudo python /home/pi/lightoff.py');

}elseif($post_button == "btnon2"){

	echo "Room2:Turned light on"."<br>";
	shell_exec('sudo python /home/pi/lighton2.py');

}elseif($post_button == "btnoff2"){
	
	echo "Room2:Turned light off"."<br>";
	shell_exec('sudo python /home/pi/lightoff2.py');

}elseif($post_button == "start_livevideo"){
	echo "Starting Live Video"."<br>";
	shell_exec('sudo raspivid -o - -t 0 -hf -w 800 -h 400 -fps 24| cvlc -vvv stream:///dev/stdin --sout \'#standard{access=http,mux=ts,dst=:8160}\':demux=h264')

}
?>
