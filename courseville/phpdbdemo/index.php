<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PHP DB+Ajax Demo</title>
    <!-- Bootstrap -->
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="style.css" rel="stylesheet"></link>
</head>
<body>
<div id="main-panel">
	<div class="container">
		<div class="row">
			<div class="col-sm-4">
				<div class="panel panel-default">
					<div class="panel-body">
						<button class="btn btn-primary" data-cmd="create">Create Table</button>
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-body">
						<button class="btn btn-primary" data-cmd="drop">Drop Table</button>
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-body">
						<input type="text" placeholder="First Name" id="input-firstname"/><br/>
						<input type="text" placeholder="Last Name" id="input-lastname"/><br/>
						<button class="btn btn-primary" data-cmd="add">Add a Record</button>
					</div>
				</div>
			</div>
			<div class="col-sm-8">
				<div id="result">
					<?php
						include('db_util.php');
    					if(!dbUtil_connect()){
							print '<div class="alert alert-danger">Cannot connect to the Database</div>';
						}else{
							$q = array();
							print dbUtil_formatResult($q); 
						}
					?>
				</div>
				<div class="loader"></div>
			</div>
		</div>
	</div>
</div>
<div id="query-history">
		<div class="item">Query History</div>
</div>
<div id="msg-history">
		<div class="item">Message History</div>
</div>


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="../bootstrap/js/bootstrap.min.js"></script>
<script src="script.js"></script>
</body>
</html>