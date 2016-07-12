<?php 
	require_once '../classes/membership.php';
	$mysql = new Mysql();

	$id = $_GET['id'];
	$selectsql = "select id, username, role, company , department from users where id = '$id'";
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

        <title>Modify</title>
    </head>
	<body>
		<div class="container">
	    <div class="row main">
		<div class="container">
			<div class=' row col-md-6 col-md-offset-2 custyle'>
				<h1> Welcome to the Modify page! </h1>
				<br/>
			</div>
		    <div class="row col-md-7 col-md-offset-2 custyle">
				<form class="form-horizontal" method = "post" action = "admin.edit.handle.php" >
					<input type="hidden" name="id" value="<?php echo $id ?>" />
					<div class="form-group">
						<label for="exampleInputEmail1">Username:</label>
						<input type="text" class="form-control" name = "username" id="exampleInputEmail1" value = "<?php echo $row['username']?>">
					</div>

					<div class="form-group">
						<label for="exampleInputPassword1">Title:</label>
						<input type="text" class="form-control" name = "title" id="inputRole" value = "<?php echo $row['role']?>">
					</div>
					
					<div class="form-group">
						<label for="exampleInputPassword1">Company:</label>
						<input type="text" class="form-control" name = "company" id="inputCompany" value = "<?php echo $row['company']?>">
					</div>

					<div class="form-group">
						<label for="exampleInputPassword1">Department:</label>
						<input type="text" class="form-control" name = "department" id="inputDepartment" value = "<?php echo $row['department']?>">
					</div>
					
					<button type="submit" class="btn btn-success pull-right">Submit</button>
					<a href="admin.index.php" class='btn btn-danger'> Back To Admin Page </a> 

				</form>
			</div>
		</div>
		</div>
		</div>
	</body>
</html>

	<?php 
	/*$updatesql = "update article set title='$title',author='$author',description='$description',content='$content',dateline=$dateline where id=$id";
	if(mysql_query($updatesql)){
		echo "<script>alert('修改文章成功');window.location.href='article.manage.php';</script>";
	}else{
		echo "<script>alert('修改文章失败');window.location.href='article.manage.php';</script>";
	}*/
?>