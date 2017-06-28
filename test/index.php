<!DOCTYPE html>
<html>
<head>
    <title>测试excel表导入</title>
    <meta charset="utf-8">
</head>
<body>
	<form method="post" action="index.php" enctype="multipart/form-data">
		<input type="file" name="file" value="文件选择"/>
		<input type="submit" value="导入"/>
	</form>
</body>
</html>
<?php
	if(!empty($_FILES['file']['tmp_name'])){
		include './PHA.php';
		$aa = $_FILES['file']['tmp_name'];
		
		$dir = "upload/aa/";
		if(!file_exists($dir)){
			mkdir($dir, 0777, true);
		}
		
		
		move_uploaded_file($_FILES['file']['tmp_name'], $dir . $_FILES['file']['name']);
		$path = "./" . $dir . $_FILES['file']['name'];
		$pha = new PHAHash();
		$bb = $pha->Obtain($path);
		
		print_r("<pre>");
		print_r($path);
		print_r($bb);
	}
	
	/* if($_FILES[''][]){
		
	} */
?>