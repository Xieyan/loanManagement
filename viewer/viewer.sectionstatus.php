<?php 
	require_once '../classes/membership.php';
	$mysql = new Mysql();

	$id = $_GET['id'];
	$formname = $_GET['formname'];

	$selectsql = "select status from viewers where id = '$id'";
	$query = mysql_query($selectsql);
	$row = mysql_fetch_assoc($query);

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

        <title>ViewerSectionModify</title>
    </head>
	<body>
		<div class="container">
	    <div class="row main">
		<div class="container">
			<div class=' row col-md-6 col-md-offset-2 custyle'>
				<h1>Viewer Section Status Change </h1>
				<br/>
			</div>
		    <div class="row col-md-7 col-md-offset-2 custyle">
				<form class="form-horizontal" method = "post" action = "viewer.sectionstatus.handle.php" >
					<input type="hidden" name="id" value="<?php echo $id ?>" />
					
					<div class="form-group">
						<label for="exampleInputEmail1"><?php echo $formname?> Status:</label>
						<input type="text" class="form-control" name = "status" id="exampleInputEmail1" value = "<?php echo $row['status']?>">
					</div>

					<button type="submit" class="btn btn-success pull-right">Submit</button>
					<a href="viewer.index.php" class='btn btn-danger'> Back To Viewer Page </a> 

				</form>
			</div>
		</div>
		</div>
		</div>
	</body>
</html>

	