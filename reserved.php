<?php
session_start();
if (isset($_GET['email'])) {
	$_SESSION['email']=$_GET['email'];
}
include_once 'createDB.php';
$db=new database();
?>
<!DOCTYPE html>
<html>
<head>
	<title>reserved</title>
	<style type="text/css">
	a{
			color: white;
			text-decoration: none;
			padding-right: 50px
		}
	.head{
			height: 30px;
			width: 100%;
			background: black;
			font-size: 20px;
			text-align: right;
		}
		h1{
			text-align: center;
		}
		body{
			text-align: center;
			padding: 0px;
			margin: 0px;
			background: url('plane.jpg');
		}
		table{
			margin-left: 250px;
		}
		
	</style>
</head>
<body>
	<div class="head">
	<a href="index.php">log out</a>
</div>
	<h1><?php echo $_SESSION['email'];?></h1>
	<?php
	$email=$_SESSION['email'];
	$rows=$db->getRows("select * from reserved where email='$email'");
	if (count($rows)!=0) {
		?>
		<form method="get">
		<table border="2">
			<caption>You are booking</caption>
			<tr>
			<th>num_plane</th>
			<th>station_start</th>
			<th>start_date</th>
			<th>station_stop</th>
			<th>name plane</th>
			<th>name company</th>
			<th>remove reserved</th>
		</tr>
		<?php
		foreach ($rows as $row) {
			$id=$row['id_plane'];
			$rowR=$db->getRows("select * from palnes where id='$id'");
			?>
			<tr>
			<td><?php echo $rowR[0]['id'];?></td>
			<td><?php echo $rowR[0]['start'];?></td>
			<td><?php echo $rowR[0]['start_date'];?></td>
			<td><?php echo $rowR[0]['end'];?></td>
			<td><?php echo $rowR[0]['name'];?></td>
			<td><?php echo $rowR[0]['company'];?></td>
			<td><input type="submit" name="remreserved" value=<?php echo $rowR[0]['id'];?> >remreserved</input></td>
		</tr>
		<?php

		}
	}
	?>
</table>
</form>
<?php
if (isset($_GET['remreserved'])) {
	$id=$_GET['remreserved'];
	$email=$_SESSION['email'];
	$db->getRows("delete from reserved where id_plane='$id' and email='$email'");
	header("location:reserved.php?email=$email");
}
?>
<br>
<br>
	<form method="post">
		Enter start <input type="text" name="start">
		<br>
		<br>
		Enter End <input type="text" name="end">
		<br>
		<br>
		<input type="submit" name="submit" value="search">
	</form>
	<br>
	<br>
	<?php
if (isset($_POST['submit'])) {
	$start=$_POST['start'];
	$end=$_POST['end'];
	$rows=$db->getRows("select * from palnes where start='$start' and 
		end='$end';",array());
		?>
		<form method="get">
	<table border="2">
			<tr>
			<th>num_plane</th>
			<th>station_start</th>
			<th>start_date</th>
			<th>station_stop</th>
			<th>name plane</th>
			<th>name company</th>
			<th>reserve</th>
		</tr>
		<?php
		foreach ($rows as $row) {
		?>
		<tr>
			<td><?php echo $row['id'];?></td>
			<td><?php echo $row['start'];?></td>
			<td><?php echo $row['start_date'];?></td>
			<td><?php echo $row['end'];?></td>
			<td><?php echo $row['name'];?></td>
			<td><?php echo $row['company'];?></td>
			<td><input type="submit" name="reserve" value=<?php echo $row['id'];?>>reserve</td>
		</tr>
		<?php
	}}
		?>
	</table>
	</form>
</body>
</html>
<?php
if (isset($_GET['reserve'])) {
	$id=$_GET['reserve'];
	$email=$_SESSION['email'];
	if (isReserved($email,$id)) {
		$db->Execute("insert into reserved values('$id','$email');");
	header("location:reserved.php?email=$email");
	}else
		echo "<script>
		alert('is reserved');
		</script>";
	
}
 function isReserved($email,$id)
{
	global $db;
$c=$db->getRows("select * from reserved where id_plane='$id' and email='$email';",array());
if (count($c)==0) {
		return True;
	}
	return False;	
}
?>