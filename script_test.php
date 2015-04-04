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
	$result=shell_exec('/var/www/camloop.sh');
	echo "<pre> $result </pre>";

}elseif($post_button == "stop_livevideo"){
	echo "Stopping Live Video"."<br>";
	$result2=shell_exec('/var/www/camloop_stop.sh');
}
?>
