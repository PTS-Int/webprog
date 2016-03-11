<?php
	function dbDemo_connect(){
		$db = mysqli_connect("ap-cdbr-azure-southeast-a.cloudapp.net","b2a07a27ec207d","0050c998","webprog");
		if(mysqli_connect_errno($db)){
	  		$db = null;
		}
		return $db;
	}

	function dbDemo_main_menu(){
		$content .= '<div id="dbDemo-main-menu">'."\n";
		$content .= '  <a href="dbDemo.php" class="link">StudentDB Home</a>'."\n";
		$content .= '  <a href="dbDemo.php?page=add" class="link">Add a Student</a>'."\n";
		$content .= '</div>'."\n";
		return $content;
	}

	function dbDemo_gen_message(){
		if(isset($_SESSION['message'])&&count($_SESSION['message'])>0){
			$content .= '<div id="dbDemo-message"><ul>';
			for($i=0;$i<count($_SESSION['message']);$i++){
				$content .= '  <li class="'.$_SESSION['message'][$i]['type'].'">'.$_SESSION['message'][$i]['content'].'</li>'."\n";
			}
			$content .= '</ul></div>'."\n";
			$_SESSION['message'] = array();
		}
		return $content;
	}

	function dbDemo_add_message($msg,$type='normal'){
		$_SESSION['message'][] = array('content'=>$msg,'type'=>$type);
	}

	function dbDemo_gen_content($page){
		$content .= '<h1>'.dbDemo_gen_page_title($page).'</h1>'."\n";
		$content .= dbDemo_gen_message();
		$content .= dbDemo_main_menu();
		$content .= '<div id="dbDemo-main">'."\n";
		switch($page){
			case 'home':
			 	$content .= dbDemo_gen_content_home();
			 	break;
			case 'add':
			 	$content .= dbDemo_gen_content_add();
			 	break;
			default:
				$content .= 'Unknown page.'."\n";
		}
		$content .= '</div>'."\n";
		return $content;
	}
	
	function dbDemo_gen_page_title($page){
		$title = array(
					'home'=>'StudentDB Home',
					'add'=>'Add a Student Record',
					'edit'=>'Edit a Student Record',
					'delete'=>'Delete a Student Record'
				);
		return $title[$page];
	}

	function  dbDemo_gen_content_home(){
		$r = dbDemo_get_items();
		$content .= '<table class="dbDemo-table">'."\n";
		$content .= '  <thead><th>ID</th><th></th><th>Name</th><th>Actions</th></thead>'."\n";
		$content .= '  <tbody>'."\n";
		while($row = mysqli_fetch_array($r)){
			if(isset($row['fb_id'])&&$row['fb_id']!=''){
				$portrait = '<img src="https://graph.facebook.com/'.$row['fb_id'].'/picture" style="width:40px;height:40px;"/>'."\n";
			}else{
				$portrait = ''."\n";
			}


			$content .= '    <tr>'."\n";
			$content .= '      <td>'.$row['id'].'</td>'."\n";
			$content .= '      <td>'.$portrait.'</td>'."\n";
			$content .= '      <td>'.$row['firstname'].' '.$row['lastname'].'</td>'."\n";
			$content .= '      <td><a href="dbDemo.php?page=edit&id='.$row['id'].'">Edit</a> | <a href="dbDemo.php?page=delete&id='.$row['id'].'">Delete</a> </td>'."\n";
			$content .= '    </tr>'."\n";
		}
		$content .= '  </tbody>'."\n";
		$content .= '</table>'."\n";
		return $content;
	}

	function  dbDemo_gen_content_add(){
		if(isset($_POST['password'])&&$_POST['password']=='webprog'){
			if(dbDemo_insert_an_item_from_post()){
				dbDemo_add_message('A new student record has been added.');
			}else{
				dbDemo_add_message('Oops! Something went wrong.','error');
			}
			return '<script>window.location="dbDemo.php";</script>';
		}elseif(isset($_POST['password'])&&$_POST['password']!='webprog'){
			dbDemo_add_message('Wrong password.','error');
			return '<script>window.location="dbDemo.php?page=add";</script>';
		}
		$content .= '<form class="dbDemo-student-form" id="dbDemo-add-student-form" action="dbDemo.php?page=add" method="post">'."\n";
		$content .= '  <div class="dbDemo-form-element">'."\n";
		$content .= '    <span class="dbDemo-label">Student ID:</span><input class="non-blank" type="text" name="student_id"/>'."\n";
		$content .= '  </div>'."\n";
		$content .= '  <div class="dbDemo-form-element">'."\n";
		$content .= '    <span class="dbDemo-label">Firstname:</span><input class="non-blank" type="text" name="firstname"/>'."\n";
		$content .= '  </div>'."\n";
		$content .= '  <div class="dbDemo-form-element">'."\n";
		$content .= '    <span class="dbDemo-label">Lastname:</span><input class="non-blank" type="text" name="lastname"/>'."\n";
		$content .= '  </div>'."\n";
		$content .= '  <div class="dbDemo-form-element">'."\n";
		$content .= '    <span class="dbDemo-label">Gender:</span>'."\n";
		$content .= '    <select name="gender">'."\n";
		$content .= '      <option value="0" selected="selected">ไม่ระบุ</option>'."\n";
		$content .= '      <option value="1">ชาย</option>'."\n";
		$content .= '      <option value="2">หญิง</option>'."\n";
		$content .= '    </select>'."\n";
		$content .= '  </div>'."\n";
		$content .= '  <div class="dbDemo-form-element">'."\n";
		$content .= '    <span class="dbDemo-label">FB id:</span><input type="text" name="fb_id"/>'."\n";
		$content .= '  </div>'."\n";
		$content .= '  <div class="dbDemo-form-element">'."\n";
		$content .= '    <span class="dbDemo-label">Password:</span><input class="non-blank" type="password" name="password"/>'."\n";
		$content .= '  </div>'."\n";
		$content .= '  <div class="dbDemo-form-element">'."\n";
		$content .= '    <span class="dbDemo-label"></span><span class="dbDemo-submit-button">Add</span>'."\n";
		$content .= '  </div>'."\n";
		$content .= '</form>'."\n";
		return $content;
	}

	function dbDemo_get_items($limit_from=null,$limit_num=null){
		global $db;
		if(isset($limit_from)&&isset($limit_num)){
			$limit_clause = ' LIMIT '.$limit_from.' , '.$limit_num;
		}
		$q = 'SELECT * FROM student '.$limit_clause;
		$r = mysqli_query($db,$q);
		return $r;
	}

	function dbDemo_insert_an_item_from_post(){
		global $db;
		$q = 'INSERT INTO student (id,firstname,lastname,gender,fb_id) 
				VALUES ("'.$_POST['student_id'].'", 
						"'.$_POST['firstname'].'",
						"'.$_POST['lastname'].'",
						"'.$_POST['gender'].'",
						"'.$_POST['fb_id'].'")';
		return mysqli_query($db,$q);
	}
?>