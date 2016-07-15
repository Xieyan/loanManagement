<?php
	require_once '../classes/membership.php';
	$membership = new Membership();
	$membership->confirm_Member();

	$mysql = new Mysql();
	$username = $_SESSION['username'];
	$id = $_SESSION['id'];
	
	# find the company and the department of certain manager.
	$sql = "select company, department from users where id = '$id'";
	$query = mysql_query($sql);
	if ($query && mysql_num_rows($query)){
			$info = mysql_fetch_assoc($query);
	}

	$company = $info['company'];
	$department = $info['department'];

	# find my staff from users depends on the company and department.
	$sql = "select id, username, role from users where company = '$company' and department = '$department' and role = 'viewer'";
	$query = mysql_query($sql);
	if ($query && mysql_num_rows($query)){
		while($row = mysql_fetch_assoc($query) ){
			$mystaff[] = $row;
		}
	}

	# find my forms from form database.
	$sql = "select * from forms where company = '$company' and department = '$department'";
	$query = mysql_query($sql);
	if ($query && mysql_num_rows($query)){
		while($row = mysql_fetch_assoc($query) ){
			$myforms[] = $row;
		}
	}



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

        <title>Manager</title>
    </head>
	<body>
	
		<div class="container">
	    <div class="row main">
		<div class="container">
			<div class=' row col-md-6 col-md-offset-2 custyle'>
				<h1> Manager Dashboard </h1>
				<h2> Name : <? echo $username ?> </h2>
				<h3> Department : <?php echo $department; echo "</br>"?> Company: <?php echo $company ?></h3>
			</div>
		    <div class="row col-md-7 col-md-offset-2 custyle">
		    	<!-- display members list-->
		    	<h3>1. My staff:</h3>
		    	<form class="form-horizontal" method="post" action="#">
			    <table class="table table-striped custab" >
				    <thead>
				        <tr>
				        	<th>ID</th>
				            <th>Username</th>
				            <th>Role</th>
				        </tr>
				    </thead>
						<?php 
							if (empty($mystaff)){
								echo "Userlist is empty.";
							}
							else {
								foreach ($mystaff as $value) {
									# code...
						?>
			            <tr>
			                <td><?php echo $value['id']?></td>
			                <td><?php echo $value['username']?></td>
			                <td><?php echo $value['role']?></td>
			            </tr>
			            
						<?php 
								}
							}
						?>

			    </table>
			    </form>
				<hr>
				<!-- add a new member -->
				<h3>2. Add a new user:</h3>
				<form class="form-horizontal" method="post" action="manager.add.handle.php">
					<input type="hidden" name="company" value="<?php echo $company ?>" />
					<input type="hidden" name="department" value="<?php echo $department ?>" />
				  	<div class="form-group">
				    <label for="inputEmail3" class="col-sm-2 control-label">Username</label>
					    <div class="col-sm-8">
					      <input type="email" class="form-control" name = "username" id="inputEmail3" placeholder="Email">
					    </div>
					</div>
					<div class="form-group">
					    <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
						    <div class="col-sm-8">
						      <input type="password" class="form-control" name = "password" id="inputPassword3" placeholder="Password">
						    </div>
					</div>
					<!-- Title list menu -->
					<div class="form-group"> 
						<label for="inputPassword3" class="col-sm-2 control-label">Role</label>
						<label class="radio-inline">
						  	<input type="radio" name="optionTitle" id="inlineRadio2" value="viewer" checked> Viewer
						</label>
					</div>
					<div class="form-group">
					    <div class="col-sm-offset-2 col-sm-8">
					      <button type="submit" class="btn btn-success pull-right">Add a new user</button>
					    </div>
					</div>
				</form>
				<hr>
				
				<!--  Form Contents -->
				<h3>3. My forms:</h3>
				<div id="content">
					<?php
						if(empty($myforms)){	
							echo "Currently, Your form list is empty.";
						}else{
							foreach($myforms as $value){
					?>
						<div class="post">
							<h1 class="title"><?php echo $value['formname']?><span style="color:#808080;font-size:20px;">  Author: <?php echo $value['author']?></span></h1>
							<div class="entry">
								<?php echo $value['header']?>
							</div>
							<!-- display section lists -->
							<?php
								$formid = $value['id'];
								$sql = "select * from sections where formid = '$formid'";
								$query = mysql_query($sql);
								$mysections = array();
								if ($query && mysql_num_rows($query)){
									while($row = mysql_fetch_assoc($query) ){
										$mysections[] = $row;
									}
								}
							?>
							<form class="form-horizontal" method="post" action="#">
							    <table class="table table-striped custab" >
								    <thead>
								        <tr>
								            <th>ID</th>
								            <th>Formid</th>
								            <th>Header</th>
								            <th>Status</th>
								            <th class="text-center">Action</th>
								        </tr>
								    </thead>
										<?php 
											if (empty($mysections)){
												echo "Currently, the section list is empty.";
											}
											else {
												foreach ($mysections as $sectionvalue) {
													# code...
										?>
							            <tr>
							                <td><?php echo $sectionvalue['id']?></td>
							                <td><?php echo $sectionvalue['formid']?></td>
							                <td><?php echo $sectionvalue['header']?></td>
							                <td><?php echo $sectionvalue['status']?></td>
							 
							                <td class="text-center">
							                	<!-- edit and delete members -->
							                
							                	<a href="manager.viewfeedback.php?id=<?php echo $sectionvalue['id']?>&&company=<?php echo $company?>&&department=<?php echo $department?>" class='btn btn-info btn-xs'><span class="glyphicon glyphicon-edit"></span> Task Dashboard</a> </br></br>
							                
							                	<a href="manager.sectionstatus.php?id=<?php echo $sectionvalue['id']?>&&formname=<?php echo $value['formname'] ?>&&sectionno=<?php echo $sectionvalue['sectionNo']?>" class="btn btn-warning btn-xs"> <span class="glyphicon glyphicon-remove"></span> Modify Status</a>
							     
							                </td>
							            </tr>
							            
										<?php 
												}
											}
										?>

							    </table>
							</form>
							<!-- sections detail link -->
							<div class="meta">
								<p class="links"><a href="article.show.php?id=<?php echo $value['id']?>" class="more">Sections Detail</a>&nbsp;&nbsp;&raquo;&nbsp;&nbsp;</p>
							</div>
							
							<div class = "form-group">
								<h3>Form Status: <?php echo $value['status']?></h3> 
							    	<a href="manager.formstatus.php?id=<?php echo $formid?>&&formname=<?php echo $value['formname']?>" class="btn btn-success">I want to change the form status</a>
							</div>

						</div>
					<?php
							}
						}
					?>
				</div>
				<hr>
			    <!-- LogOut Button. -->
			    <a href="../login.php?status=loggedout" class='btn btn-primary btn-lg btn-block pull-center'> Log Out </a>
			</br></br>
		    </div>
		</div>
		</div>
		</div>
	</body>
</html>


