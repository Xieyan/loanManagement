<?php
	require_once '../classes/membership.php';
	$membership = new Membership();
	$membership->confirm_Member();

	$mysql = new Mysql();
	$id = $_SESSION['id'];
	$username = $_SESSION['username'];

	#find my company and department info from users based on $id.
	$sql = "select company, department from users where id = '$id'";
	$query = mysql_query($sql);
	if ($query && mysql_num_rows($query)){
			$info = mysql_fetch_assoc($query);
	}

	$company = $info['company'];
	$department = $info['department'];

	#find my task from viewers based on $id.
	$sql = "select * from viewers where viewerid = '$id'";
	$query = mysql_query($sql);
	if ($query && mysql_num_rows($query)){
		while($row = mysql_fetch_assoc($query) ){
			$mytask[] = $row;
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
				<h1> Viewer Dashboard </h1>
				<h2> Name : <? echo $username ?> </h2>
				<h3> Department : <?php echo $department; echo "</br>"?> Company: <?php echo $company ?></h3>
			</div>
		    <div class="row col-md-7 col-md-offset-2 custyle">
		    	<!-- display members list-->
		    	<h3>1. Task Overview:</h3>
		    	<form class="form-horizontal" method="post" action="#">
			    <table class="table table-striped custab" >
				    <thead>
				        <tr>
				        	<th>ID</th>
				            <th>Username</th>
				            <th>SectionID</th>
				            <th>Comments</th>
				            <th>Status</th>
				        </tr>
				    </thead>
						<?php 
							if (empty($mytask)){
								echo "Userlist is empty.";
							}
							else {
								foreach ($mytask as $value) {
									# code...
						?>
			            <tr>
			                <td><?php echo $value['id']?></td>
			                <td><?php echo $value['name']?></td>
			                <td><?php echo $value['sectionid']?></td>
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

				<!-- My sections -->
				<h3>2. Sections:</h3>
				<div id="content">
					<?php
						if(empty($mytask)){	
							echo "Currently, Your task list is empty.";
						}else{
							foreach($mytask as $value){
								$sectionid = $value['sectionid'];
								#get data from sections based on section id.
								$sql = "select * from sections where id = '$sectionid'";
								$query = mysql_query($sql);
								if ($query && mysql_num_rows($query)){
										$sectioninfo = mysql_fetch_assoc($query);
								}
								$formid = $sectioninfo['formid'];

								#get form name from forms as title.
								$sql = "select formname from forms where id = '$formid'";
								$query = mysql_query($sql);
								if ($query && mysql_num_rows($query)){
										$forminfo = mysql_fetch_assoc($query);
								}
								$formname = $forminfo['formname'];

					?>
						<div class="post">
							<h1 class="title"><?php echo $formname?><span style="color:#808080;font-size:20px;">  Section No. <?php echo $sectioninfo['sectionNo']?></span></h1>
							<div class="entry">
								<?php echo $sectioninfo['content']?>
							</div>

							<form class="form-horizontal" method="post" action="viewer.comments.handle.php">
								<input type="hidden" name="sectionid" value="<?php echo $sectionid ?>" />
								<input type="hidden" name="viewerid" value="<?php echo $id ?>" />
								<h3>Comments:</h3>
						        <div class="input-group">
						            <textarea name="comments" class="form-control custom-control" rows="6" cols="60" style="resize:none"><?php echo htmlspecialchars($value['comments']); ?></textarea> 
						            <span class="input-group-addon">                                            
						                <button type="submit" name="post_comment" class="btn btn-primary">
						                    Post
						                </button>
						            </span>
						        </div>
						    </form>
							
							<div class = "form-group">
								<h3>Section Status: <?php echo $value['status']?></h3> 
							    <a href="viewer.sectionstatus.php?id=<?php echo $value['id']?>&&formname=<?php echo $formname?>" class="btn btn-success">I want to change the section status</a>
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


