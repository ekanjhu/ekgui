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
        $arrvar = array("results"=>$rows);
        echo json_encode($arrvar);
}


?>
