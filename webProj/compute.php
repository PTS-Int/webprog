<?php
// $servername = "localhost";
// $username = "root";
// $password = "1234";
// $dbname = "traffic";

// // Create connection
// $conn = new mysqli($servername, $username, $password, $dbname);

// // Check connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// } 
	$length = array();
	$speed = array();
	// for ($i=0; $i < 60; $i++) { 
	// 	$speed[$i] = array();
	// 	for ($j=0; $j < 2 ; $j++) { 
	// 		$speed[$i][$j] = array();
	// 		for ($k=0; $k < 7; $k++) { 
	// 			$speed[$i][$j][$k] = array();
	// 		}
	// 	}
	// }

		$handle = fopen("Length.csv", "r");
		if ($handle) {
		    while (($line = fgets($handle)) !== false) {
		        $line = explode(",", $line);
		        $length[$line[0]] = $line[1];
		    }

		    fclose($handle);
		} else {
		    // error opening the file.
		} 

		$handle = fopen("Speed.csv", "r");
		if ($handle) {
		    while (($line = fgets($handle)) !== false) {
		        $line = explode(",", $line);
		        $speed[$line[0]][$line[1]][$line[2]][$line[3]] = $line[4];
		    }

		    fclose($handle);
		} else {
		    // error opening the file.
		} 

		$semester = $_POST["semester"];
		$day = $_POST["day"];
		$time = $_POST["time"];
		$time = explode(":", $time);
		$timeHr = floor($time[0]);
		$timeMin = $time[1];
		$timeLeft = 60 - $timeMin;

		$path1 = array(0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23);
		$path2 = array(0,1,2,3,4,5,6,7,8,9,10,11,25,26,27,28,29,30,31,32,33,34,35,36,37,23,24);
		$path3 = array(0,1,2,3,4,5,6,38,39,40,41,42,43,44,45,46,47,47,48,49,50,51,52,53,54,55,56,57,58,59,20,21,22,23,24);

		$time1 = computeTime($path1,$semester,$day,$timeHr,$timeLeft);
		$time2 = computeTime($path2,$semester,$day,$timeHr,$timeLeft);
		$time3 = computeTime($path3,$semester,$day,$timeHr,$timeLeft);

		echo $time1.",".$time2.",".$time3;

		function computeTime($path,$semester,$day,$time,$timeLeft){
			$timeCost = 0;

			for ($i = 0; $i < count($path); $i++) {
				$re = array();
				$re = useTime($path,$i,$semester,$day,$time,$timeLeft,0,0);
				$timeLeft = $re[0];
				$timeCost += $re[1];
				$time = $re[2];
				}
			$outputTime = ceil($timeCost);
			return $outputTime;
		}

		function useTime($pathChosen, $i, $semester, $day, $time, $timeleft, $code, $distance){
			// global $conn;
			$re = array();
			global $length;
			global $speed;
			// $sql = "SELECT Length FROM roadlength WHERE RoadGroup=".$pathChosen[$i];
			// $result = $conn->query($sql);
			// $row = $result->fetch_assoc();
			// $length = $row["Length"];
			// $sql = "SELECT `".$time."` FROM roadgroup".$pathChosen[$i]." WHERE Semester='".$semester."' AND Day='".$day."'";
			// $result = $conn->query($sql);
			// $row = $result->fetch_assoc();
			// $speed = $row[$time];
			$curSpeed = $speed[$pathChosen[$i]][$semester][$day][$time]*1000/60;
			if($code ==0){
				$timeNeed = $length[$pathChosen[$i]]/$curSpeed;
				if($timeNeed <= $timeleft) {
					$re[0] = $timeleft - $timeNeed;
					$re[1] = $timeNeed;
					$re[2] = $time;

					if($curSpeed > 4000/6) echo "green,";
					elseif($curSpeed > 4000/9) echo "yellow,";
					elseif($curSpeed > 4000/18) echo "orange,";
					else echo "red,";
				}
				else {
					$distanceLeft = $length[$pathChosen[$i]] - $timeleft * $curSpeed;
					$time++;
					if($time==24) {
						$time=0;
						$day++;
						if($day==7) $day=0;
					}
					$re = useTime($pathChosen,$i,$semester,$day,$time,60,1,$distanceLeft);
					$re[1] += $timeleft;
				}
			}
			else {
				$timeNeed = $distance / $curSpeed;
				if($timeNeed <= $timeleft) {
					$re[0] = $timeleft - $timeNeed;
					$re[1] = $timeNeed;
					$re[2] = $time;

					if($curSpeed > 4000/6) echo "green,";
					elseif($curSpeed > 4000/9) echo "yellow,";
					elseif($curSpeed > 4000/18) echo "orange,";
					else echo "red,";
				}
				else {
					$distanceLeft = $distance - $timeleft * $curSpeed;
					$timeleft = 60;
					$time++;
					if($time==24) {
						$time=0;
						$day++;
						if($day==7) $day=0;
					}
					$re = useTime($pathChosen,$i,$semester,$day,$time,$timeleft,1,$distanceLeft);
					$re[1] += $timeleft;
				}
			}
			return $re;
		}

?>