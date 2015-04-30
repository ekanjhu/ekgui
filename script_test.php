<?php
header('Content-Type::application/json');
$servername = "localhost";
$username = "root";
$password = "Ek5rpid6";
$dbname = "light_status";

//Create connection
$dbhandle = mysql_connect($servername,$username,$password) or die ("Unable to connect to mysql <br>");

//Select Database
function select_database($database_name,$database_handle) {
	$selected = mysql_select_db($database_name,$database_handle) or die ("Unable to select database<br>");	
}

//Select last light state for roomX
function select_LastLightState($mysql_colname,$mysql_tbl,$mysql_newstate){
	$query_select    = "SELECT $mysql_colname FROM $mysql_tbl where entry=(SELECT MAX(entry) FROM $mysql_tbl)";
	$result_select   = mysql_query($query_select);
        $result_select   = mysql_fetch_array($result_select);
        $last_state = $result_select[$mysql_colname];
        if ($mysql_newstate != $last_state) {
                $query_insert    = "INSERT INTO $mysql_tbl (date,time,state) VALUES (curdate(),curtime(),'$mysql_newstate')";
                $result = mysql_query($query_insert);
        }else{
		
        }
        mysql_close();
	return $last_state;
}

$post_button =$_REQUEST["id"];
$post_value  =$_REQUEST["angle"];
$get_roomTable=$_REQUEST["room"];
$get_videoFile=$_REQUEST["video_table"];
$get_viewVideo=$_POST["change_status"];
$video_filename=$_POST["filename"];
$timer_data=$_POST["formData1"];

if($post_button == "btnon1"){
	shell_exec('sudo python /home/pi/lighton.py');
	select_database($dbname,$dbhandle);
	$colname = "state";
	$tableName= "table_for_room1";
	$new_state = "on";
	$last_state = select_LastLightState($colname,$tableName,$new_state);
	echo json_encode($last_state);

}elseif($post_button =="btnoff1"){
	shell_exec('sudo python /home/pi/lightoff.py');
	select_database($dbname,$dbhandle);
        $colname = "state";
        $tableName= "table_for_room1";
        $new_state = "off";
	$last_state = select_LastLightState($colname,$tableName,$new_state);
	echo json_encode($last_state);
}elseif($post_button=="timer1"){
	$ontimeval=$timer_data{'ontime'};
	$offtimeval=$timer_data{'offtime'};
	shell_exec('sudo python /home/pi/time_lights.py '.$ontimeval.' '.$offtimeval);
	echo json_encode($offtimeval);
}elseif($post_button=="timer2"){
	$ontimeval=$timer_data{'ontime'};
        $offtimeval=$timer_data{'offtime'};
        shell_exec('sudo python /home/pi/time_lights2.py '.$ontimeval.' '.$offtimeval);
        echo json_encode($offtimeval);
}elseif($post_button=="cancel_timer"){
	shell_exec('sudo pkill -f time_lights.py');
}elseif($post_button=="cancel_timer2"){
	shell_exec('sudo pkill -f time_lights2.py');
}elseif($post_button == "btnon2"){
	shell_exec('sudo python /home/pi/lighton2.py');
	select_database($dbname,$dbhandle);
        $colname = "state";
        $tableName= "table_for_room2";
	$new_state = "on";
        $last_state = select_LastLightState($colname,$tableName,$new_state);
	echo json_encode($last_state);
}elseif($post_button == "btnoff2"){
	shell_exec('sudo python /home/pi/lightoff2.py');
	select_database($dbname,$dbhandle);
        $colname = "state";
        $tableName= "table_for_room2";
        $new_state= "off";
	$last_state = select_LastLightState($colname,$tableName,$new_state);
        mysql_close();
	echo json_encode($last_state);
}elseif($post_button == "start_livevideo"){
	echo "Starting Live Video"."<br>";
	$result=shell_exec('/var/www/camloop.sh');
	echo "<pre> $result </pre>";
}elseif($post_button=="start_livevideo_record"){
	$result=shell_exec('/var/www/camloop_record.sh');
	echo json_encode("<pre>$result</pre>");
	//$result=escapeshellarg($result);
	//$result2=shell_exec("/var/www/test1.sh $result");
	//echo json_encode("$result");
}elseif($post_button == "kill_raspivid"){
	echo "Stopping Raspivid"."<br>";
	$result2=shell_exec('/var/www/camloop_stop.sh');
}elseif($post_button == "slider"){
	echo "slider changed"."<br>";
	echo "user selected angle=".$post_value."<br>";
	shell_exec('sudo python /home/pi/servo_slidercontrol.py '.$post_value);
}elseif($post_button == "activate_motiondetector"){
	echo "turn on motion detector"."<br>";
	shell_exec('sudo python /home/pi/pir_capture_video_scan.py');
}elseif($post_button == "deactivate_motiondetector"){
	shell_exec('sudo pkill -f "pir_capture_video_scan.py"');
}elseif($get_roomTable == "room1"){
	//$selected = mysql_select_db($dbname,$dbhandle) or die ("Unable to select database<br>");
	select_database($dbname,$dbhandle);
	$query="SELECT * FROM table_for_room1 ORDER BY date DESC,time DESC LIMIT 5";
	$result=mysql_query($query);
	$rows = array();
	 while($r = mysql_fetch_array($result)) {
                $rows[] = $r;
        }
	mysql_close();
        $arrvar =  array("results"=>$rows);
        echo json_encode($arrvar);
}elseif($get_roomTable == "room2"){
        //$selected = mysql_select_db($dbname,$dbhandle) or die ("Unable to select database<br>");
	select_database($dbname,$dbhandle);
        $query="SELECT * FROM table_for_room2 ORDER BY date DESC,time DESC LIMIT 5";
        $result=mysql_query($query);
        $rows = array();
         while($r = mysql_fetch_array($result)) {
                $rows[] = $r;
        }
	mysql_close();
        $arrvar =  array("results"=>$rows);
	echo json_encode($arrvar);
}elseif($get_videoFile == "inputvideo"){
	select_database($dbname,$dbhandle);
	$query="SELECT * FROM recorded_video";
	$result= mysql_query($query);
	$rows = array();
	while ($r = mysql_fetch_array($result)){
		$rows[]=$r;
	}
	mysql_close();
	$arrvar = array("results"=>$rows);
	echo json_encode($arrvar);
}elseif($get_viewVideo == "true"){
	select_database($dbname,$dbhandle);
        $query  = "UPDATE recorded_video SET viewedStatus='viewed' WHERE link='$video_filename'";
        $result = mysql_query($query);
        $query2 = "SELECT * FROM recorded_video";
	$result2 = mysql_query($query2);
	$rows = array();
        while ($r = mysql_fetch_array($result2)){
                $rows[]=$r;
        }
        mysql_close();
	
	//Check if this is h264 file, if it is, then convert before updating
        $filetype=stristr($video_filename,"h264");
        if($filetype =="h264"){
                $newfile_name=str_replace("h264","mp4",$filetype);
                shell_exec('sudo MP4Box -add $video_filename $newfile_name');   	
	}else{
		$newfile_name=$video_filename;
	}

        $arrvar = array("results"=>$rows,"newfile"=>$newfile_name);
        echo json_encode($arrvar);
}


?>
