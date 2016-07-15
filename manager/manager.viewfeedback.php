<?php
	require_once '../classes/membership.php';
	$mysql = new Mysql();

	$id = $_GET['id'];
	$company = $_GET['company'];
	$department = $_GET['department'];

	#select all my staff.
	$sql = "select id, username from users where company = '$company' and department = '$department' and role = 'viewer'";
	$query = mysql_query($sql);
	if ($query && mysql_num_rows($query)){
		while($row = mysql_fetch_assoc($query) ){
			$mystaff[] = $row;
		}
	}

	#find all feedbacks from viewers.
	$sql = "select * from viewers where sectionid = '$id'";
	$query = mysql_query($sql);
	if ($query && mysql_num_rows($query)){
		while($row = mysql_fetch_assoc($query) ){
			$feedback[] = $row;
		}
	}

	#find avaiable staff.
	$avaiablestaff = array();
	if ($mystaff){
	foreach ($mystaff as $i){
		$f = True;
		if ($feedback){
			foreach($feedback as $j){
			if ($i['username'] == $j['name']){
				$f = False;
			}
		}}
		if ($f == True) $avaiablestaff[] = $i['username'];
	}}

?>

<!DOCTYPE html>
<html lang="en">
	<head> 
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">

        <!-- Website CSS style -->
        <link rel="stylesheet" type="text/css" href="../css/login.css">

        <!-- Website Font style -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
        
        <!-- Google Fonts -->
        <link href='https://fonts.googleapis.com/css?family=Passion+One' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Oxygen' rel='stylesheet' type='text/css'>

        <title>Feedback</title>
    </head>
    <body>
		<div class="container">
	    <div class="row main">
		<div class="container">
			<div class=' row col-md-6 col-md-offset-2 custyle'>
				<h1> Manager Task Dashboard </h1>
			</div>
		    <div class="row col-md-7 col-md-offset-2 custyle">
		    	<!-- display feedbacks -->
		    	<h3>1.Overview the feedbacks:</h3>
		    	<form class="form-horizontal" method="post" action="#">
			    <table class="table table-striped custab" >
				    <thead>
				        <tr>
				        	<th>SectionID</th>
				        	<th>Viewer name</th>
				            <th>Comments</th>
				            <th>Status</th>
				        </tr>
				    </thead>
						<?php 
							if (empty($feedback)){
								echo "Currently, feedback list is empty.";
							}
							else {
								foreach ($feedback as $value) {
									# code...
						?>
			            <tr>
			                <td><?php echo $id?></td>
			                <td><?php echo $value['name']?></td>
			                <td><?php echo $value['comments']?></td>
			                <td><?php echo $value['status']?></td>
			            </tr>
			            
						<?php 
								}
							}
						?>

			    </table>
			    </form>
				<hr>
				<h3>2. Assign task:</h3>
				<form class="form-horizontal" method="post" action="#">
			    <table class="table table-striped custab" >
				    <thead>
				        <tr>
				        	<th>Avaiable viewer name:</th>
				        </tr>
				    </thead>
						<?php 
							if (empty($avaiablestaff)){
								echo "Currently, no staff is avaiable.";
							}
							else {
								foreach ($avaiablestaff as $value) {
									# code...
						?>
			            <tr>
			                <td><?php echo $value?></td>
			            </tr>
			            
						<?php 
								}
							}
						?>

			    </table>
			    </form>
				<form class="form-horizontal" method="post" action="manager.task.handle.php">
					<input type = "hidden" name = "sectionid" value = "<?php echo $id ?>" /> 
					<input type="hidden" name="company" value="<?php echo $company ?>" />
					<input type="hidden" name="department" value="<?php echo $department ?>" />
					<select class="form-control" name="option">
						<?php
							foreach($avaiablestaff as $value){
								echo "<option>$value</option>";
							}
						?>
					</select></br>
					<div class="form-group">
						    <div class="col-sm-offset-2 col-sm-8">
						      <button type="submit" class="btn btn-success pull-right">Assign task to this viewer.</button>
						    </div>
						</div>
				</form>
				<hr>

				<!-- return button -->
				<a href="manager.index.php" class='btn btn-danger'> Back To Viewer Page </a> 
			</br></br>
			</div>
		</div>
		</div>
		</div>
	</body>
</html>