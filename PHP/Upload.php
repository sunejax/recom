
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
// Check if image file is a actual image or fake image
/*if(isset($_POST["submit"])) {
   echo "Uploading";
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
/*if ($_FILES["fileToUpload"]["size"] > 50000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($fileType != "csv" ) {
    echo "Sorry, only CSV files are allowed.";
    $uploadOk = 0;
}*/
// Check if $uploadOk is set to 0 by an error
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
$com="psql -c '\copy existing_s from ../../tmp/existing_s.csv CSV'";
exec($com,$newarr);
echo '<pre>'; print_r($newarr); echo '</pre>';
}


?>




