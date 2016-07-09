<?php
$com="psql -c '\copy new_s from Files/new_s.csv CSV'";
exec($com,$newarr);
echo '<pre>'; print_r($newarr); echo '</pre>';
require('../vendor/autoload.php');  // this will simply read AWS_ACCESS_KEY_ID and AWS_SECRET_ACCESS_KEY from env vars
$s3 = Aws\S3\S3Client::factory(
array('region' => 'us-west-2',
		'version' =>'2006-03-01')
);
$bucket = 'csvfilesuploads';


?>
<html>
    <head><meta charset="UTF-8"></head>
    <body>
        <h1>S3 upload</h1>
<?php
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['userfile']) && $_FILES['userfile']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['userfile']['tmp_name'])) {
    // FIXME: add more validation, e.g. using ext/fileinfo
    
    try {
        // FIXME: do not use 'name' for upload (that's the original filename from the user's computer)
        $upload = $s3->upload($bucket, 'new_s.csv', fopen($_FILES['userfile']['tmp_name'], 'rb'), 'public-read');
?>
        <p>Upload <a href="<?=htmlspecialchars($upload->get('ObjectURL'))?>">successful</a> :)</p>
<?php } catch(Exception $e) { ?>
        <p>Upload error :(</p>
<?php } } ?>
        <h2>Upload a file</h2>
        <form enctype="multipart/form-data" action="<?=$_SERVER['PHP_SELF']?>" method="POST">
            <input name="userfile" type="file"><input type="submit" value="Upload">
        </form>
        
        <?php
        // Connecting, selecting database
				$dbconn = pg_connect("host=recomdb2.cnbi0ip1wv3h.us-west-2.rds.amazonaws.com dbname=recomdb2 user=badwolf password=recomdb2") or die('Could not connect: ' . pg_last_error());        
				$p=htmlspecialchars($upload->get('ObjectURL'));
				$data= array("StudentID"=>"0","Name"=>"0","Ethics"=>"0","Composure"=>"0","Sociability"=>"0","Cooperation"=>"0","Motivation"=>"0","Composure2"=>"0","Flexibility"=>"0","Practicality"=>"0","Curiosity"=>"0","Creativity"=>"0","Coaching"=>"0","Persuasiveness"=>"0","Analytical"=>"0");
				if (($handle = fopen($p, "r")) !== FALSE) {
    				pg_execute($dbconn,"begin");
    				while (($t = fgetcsv($handle, 1000)) !== FALSE) {
        			
         			$data= array("studentid"=>$t[0],"name"=>$t[1],"ethics"=>$t[2],"composure"=>$t[3],"sociability"=>$t[4],"cooperation"=>$t[5],"motivation"=>$t[6],"composure2"=>$t[7],"flexibility"=>$t[8],"practicality"=>$t[9],"curiosity"=>$t[10],"creativity"=>$t[11],"coaching"=>$t[12],"persuasiveness"=>$t[13],"analytical"=>$t[14]);
           			$res=pg_execute($dbconn,'insert new_s');	
 					
 				//		pg_copy_from($dbconn,'new_s',$t, $delimiter = null, $null_as = null);
        			 }$toss=pg_execute($dbconn,"commit");
   				 
   				 if ($res) {
      					echo "POST data is successfully logged\n";
  						} else {
     						echo "User must have sent wrong inputs\n";
 						}
    fclose($handle);
}
?>
    </body>
</html>