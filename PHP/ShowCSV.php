//Show

<?php
$row = 1;
echo getcwd();
if (($handle = fopen("../tmp/new_s.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $num = count($data);
       // echo "<p> $num fields in line $row: <br /></p>\n";
        $row++;
        for ($c=0; $c < $num; $c++) {
            echo $data[$c] . " ";
            
        }echo "<p>\n</p>";
    }
    fclose($handle);
}
?>