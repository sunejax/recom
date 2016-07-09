<!DOCTYPE html>


<html>

<title>rcom</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="Style/w3.css">
<link rel="stylesheet" href="Style/style.css">
<body>
<div class="w3-padding-top w3-padding-24">
<a class="w3-btn w3-green w3-text-shadow w3-round w3-border w3-display-container w3-padding-top w3-display-topright" href="Uploader/ui.php">Admin</a>
</div>
<!--<form method="get", action=
<input type="text" name="search" placeholder="Search.." class="w3-display-container w3-card-8 w3-display-middle w3-padding-32">
<input type="submit" name="sbtn" style="display:none">
</form>-->
<form  method="post" action="home.php?go"  id="searchform"> 
    <input type="text" name="name" placeholder="Search.." class="w3-display-container w3-card-8 w3-display-middle w3-padding-32">
	<input  type="submit" name="submit" value="Search" style="display:none"> 
</form> 
<?

  if(isset($_POST['submit'])){
  if(isset($_GET['go'])){
  if(preg_match("/^[  a-zA-Z]+/", $_POST['name'])){
  $name=$_POST['name'];
 $name= strtoupper($name);
  //connect  to the database
$dbconn = pg_connect("host= recomdb2.cnbi0ip1wv3h.us-west-2.rds.amazonaws.com port=5432 dbname=recomdb2 user=badwolf password=recomdb2");
  //-query  the database table
  $sql="SELECT distinct studentid, name, clubs FROM new_s WHERE name LIKE '%" . $name .  "%' order by studentid";
  //-run  the query against the mysql query function
  $result=pg_query($sql);
  //-create  while loop and loop through result set
  echo "<table class='w3-table w3-striped w3-bordered w3-card-4'><thead><tr class='w3-blue'><th>Student ID</th><th>Name</th><th>Clubs</th></tr>";
  ?>
<style type="text/css">#searchform{
display:none;
}</style>
<?php
  while($row=pg_fetch_row($result)){
          $Name =$row[1];
          $StudentID=$row[0];
          $Clubs=$row[2];

  //-display the result of the array
 // echo "<table class="w3-table w3-striped w3-bordered w3-card-4"><thead><tr class="w3-blue"><th>Student ID</th><th>Name</th></tr>";
 echo "<tr>
  <td>".$StudentID."</td>
  <td>".$Name."</td>
  <td>".$Clubs."</td>
	</tr>";

  }
  }
  else{
  echo  "<p>Please enter a search query</p>";
  }
  }
  }
?>

</body>
</html>