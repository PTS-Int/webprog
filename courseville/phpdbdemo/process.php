<?php
	include('db_util.php');
	$rp = array();
	$queries = array();
	$msg = array();
    if(!dbUtil_connect()){
		$success = false;
		$msg[] = 'Cannot connect to the Database';
	}elseif(isset($_POST['cmd'])){
		//$msg[] = 'db:'.print_r($db,true);
		$success = true;
		$cmd = $_POST['cmd'];
	
		if($cmd=='create'){
			if(!dbUtil_create_table($queries)){
				$success = false;
				$msg[] = 'Cannot create table';
			}else{
				$msg[] = 'Table created';
			}
		}elseif($cmd=='drop'){
			if(!dbUtil_drop_table($queries)){
				$success = false;
				$msg[] = 'Cannot drop table';
			}else{
				$msg[] = 'Table dropped';
			}		
		}elseif($cmd=='add'){
			if(!dbUtil_insert_an_item_from_post($queries)){
				$success = false;
				$msg[] = 'Cannot insert data';
			}else{
				$msg[] = 'Data inserted';
			}
		}
		
	}
	$status = $success?'success':'error';
	$result = dbUtil_formatResult($queries);
	$rp = array('status'=>$status,'msg'=>$msg,'result'=>$result,'q'=>$queries);
    print json_encode($rp);
	
	
?>