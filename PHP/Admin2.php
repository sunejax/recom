<!DOCTYPE html>
<?php
$target_dir = "../../tmp/";
if(isset($_POST['new_s'])){
$file_name="new_s.csv";
}else if(isset($_POST['existing_s'])){
$file_name="existing_s.csv";
}
$target_file = $target_dir . $file_name;
$uploadOk = 1;
$fileType = pathinfo($target_file,PATHINFO_EXTENSION);
echo $target_file;
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error in uploading ".basename( $_FILES["fileToUpload"]["name"]);
    }
}
if(isset($_POST['new_s'])){
$com="psql -c '\copy new_s (studentid, name, ethics, composure, sociability, cooperation, motivation, composure2, flexibility, practicality, curiosity, creativity, coaching, persuasiveness, analytical) from ../../tmp/new_s.csv CSV'";
exec($com,$newarr);
echo '<pre>'; print_r($newarr); echo '</pre>';
}else if(isset($_POST['existing_s'])){
$com="psql -c '\copy existing_s (studentid, name, ethics, composure, sociability, cooperation, motivation, composure2, flexibility, practicality, curiosity, creativity, coaching, persuasiveness, analytical, clubs) from ../../tmp/existing_s.csv CSV'";
exec($com,$newarr);
echo '<pre>'; print_r($newarr); echo '</pre>';
}


?>
<html>
<title>Admin</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="Style/w3.css">
<link rel="stylesheet" href="Style/style.css">

<form action="<?=$_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload CSV" name="new_s">
</form>

<form action="<?=$_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload CSV" name="existing_s">
</form>

</body>
</html>
