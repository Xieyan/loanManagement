<?php
	require_once '../classes/membership.php';
	$membership = new Membership();
	$membership->confirm_Member();

	//load the userlist
	$mysql = new Mysql();
	$sql = "select * from users where role = 'manager' or role = 'viewer'";
	$query = mysql_query($sql);
	if ($query && mysql_num_rows($query)){
		while($row = mysql_fetch_assoc($query) ){
			$userlist[] = $row;
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

        <title>Admin</title>
    </head>
	<body>
	
		<div class="container">
	    <div class="row main">
		<div class="container">
			<div class=' row col-md-6 col-md-offset-2 custyle'>
				<h1> Welcome to the Admin page! </h1>
				<br/>
			</div>
		    <div class="row col-md-7 col-md-offset-2 custyle">
		    	<h3>1. Add a new member</h3>
		    	<!-- add a new member -->
				<form class="form-horizontal" method="post" action="admin.add.handle.php">
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
						<label for="inputPassword3" class="col-sm-2 control-label">Title</label>
						<label class="radio-inline">
							<input type="radio" name="optionTitle" id="inlineRadio1" value="manager" > Manager
						</label>
						<label class="radio-inline">
						  	<input type="radio" name="optionTitle" id="inlineRadio2" value="viewer" checked> Viewer
						</label>
					</div>
					<div class="form-group">
					    <div class="col-sm-offset-2 col-sm-8">
					      <button type="submit" class="btn btn-success pull-right">Add a new member!</button>
					    </div>
					</div>
				</form>

		    	<!-- display members list-->
		    	<h3>2. Member list</h3>
		    	<form class="form-horizontal" method="post" action="#">
			    <table class="table table-striped custab" >
				    <thead>
				        <tr>
				            <th>ID</th>
				            <th>Username</th>
				            <th>Title</th>
				            <th>Company</th>
				            <th>Department</th>
				            <th class="text-center">Action</th>
				        </tr>
				    </thead>
						<?php 
							if (empty($userlist)){
								echo "Userlist is empty.";
							}
							else {
								foreach ($userlist as $value) {
									# code...
						?>
			            <tr>
			                <td><?php echo $value['id']?></td>
			                <td><?php echo $value['username']?></td>
			                <td><?php echo $value['role']?></td>
			                <td><?php echo $value['company']?></td>
			                <td><?php echo $value['department']?></td>
			                <td class="text-center">
			                	<!-- edit and delete members -->
			                	<a href="admin.edit.php?id=<?php echo $value['id']?>" class='btn btn-info btn-xs'><span class="glyphicon glyphicon-edit"></span> Edit</a> 
			                	<a href="admin.del.handle.php?id=<?php echo $value['id']?>" class="btn btn-danger btn-xs"> <span class="glyphicon glyphicon-remove"></span> Del</a>
			     
			                </td>
			            </tr>
			            
						<?php 
								}
							}
						?>

			    </table>
			    </form>
			    <a href="../login.php?status=loggedout" class='btn btn-primary btn-lg btn-block pull-center'> Log Out </a>
		    </div>
		</div>
		</div>
		</div>
	</body>
</html>


