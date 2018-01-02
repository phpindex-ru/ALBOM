<?php
include 'upload.php';
if(isset($_FILES['files'])){
    $errors= array();
	foreach($_FILES['files']['tmp_name'] as $key => $tmp_name ){
		$file_name = $key.$_FILES['files']['name'][$key];
		$file_size =$_FILES['files']['size'][$key];
		$file_tmp =$_FILES['files']['tmp_name'][$key];
		$file_type=$_FILES['files']['type'][$key];	
		$user_id = 1;
        if($file_size > 2097152){
			$errors[]='File size must be less than 2 MB';
        } else  {	
        $upload = new Upload($file_name, $file_size, $file_tmp, $file_type, $user_id);
        $upload->uploadFiles();
		}
}
}
?>

<!doctype html>
<html lang="en">
  <head>
  </head>
    <title>Top navbar example for Bootstrap</title>
  <body>
<form action="" method="POST" enctype="multipart/form-data">
	<input type="file" name="files[]" multiple/>
	<input type="submit"/>
</form>
</body>
</html>