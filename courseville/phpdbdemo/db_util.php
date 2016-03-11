<?php
$db = null;
function dbUtil_connect(){
	global $db;
	$db = mysqli_connect("ap-cdbr-azure-southeast-a.cloudapp.net","b2a07a27ec207d","0050c998","webprog");
	if(mysqli_connect_errno($db)){
  		$db = null;
	}
	return isset($db);
}
function dbUtil_table_exists(&$qh){
	global $db;
	if(!isset($db)) return false;
	$q = 'SHOW TABLES LIKE "person"';
	$qh[] = $q;
	$r = mysqli_query($db,$q);
	return mysqli_num_rows($r) > 0;
}
function dbUtil_create_table(&$qh){
	global $db;
	if(!isset($db)) return false;
	$q = 'CREATE TABLE  IF NOT EXISTS person (
				id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
				firstname VARCHAR(100) NOT NULL,
				lastname VARCHAR(100) NOT NULL
	)';
	$qh[] = $q;
	return mysqli_query($db,$q);
}
function dbUtil_drop_table(&$qh){
	global $db;
	if(!isset($db)) return false;
	$q = 'DROP TABLE person';
	$qh[] = $q;
	return mysqli_query($db,$q);
}
function dbUtil_get_items(&$qh){
	global $db;
	if(!isset($db)) return false;
	$q = 'SELECT * FROM person';
	$qh[] = $q;
	return mysqli_query($db,$q);
}

function dbUtil_insert_an_item_from_post(&$qh){
	global $db;
	if(!isset($db)) return false;
	$q = 'INSERT INTO person (firstname,lastname) 
			VALUES ("'.$_POST['firstname'].'",
					"'.$_POST['lastname'].'")';
	$qh[] = $q;
	return mysqli_query($db,$q);
}

function dbUtil_formatResult(&$qh){
		if(dbUtil_table_exists()){
			$ct = '<table class="table table-striped">'."\n";
			$ct .= '  <thead><th>id</th><th>First Name</th><th>Last Name</th><thead>'."\n";
			$ct .= '  <tbody>'."\n";
			$r = dbUtil_get_items($qh);
			
			while($row = mysqli_fetch_array($r)){
				$ct .= '    <tr>'."\n";
				$ct .= '      <td>'.$row['id'].'</td>'."\n";
				$ct .= '      <td>'.$row['firstname'].'</td>'."\n";
				$ct .= '      <td>'.$row['lastname'].'</td>'."\n";
				$ct .= '    </tr>'."\n";
			}
			$ct .= '  </tbody>'."\n";
			$ct .= '</table>'."\n";
		}else{
			$ct = '<div class="alert alert-danger">Table does not exist</div>'."\n";
		}
		return $ct;
	}
?>