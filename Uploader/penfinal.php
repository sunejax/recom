<?php
$time_start = microtime(true);
$hc=fopen('server/php/files/recommendations.csv', 'w');
$twoDarray = array();
$flag=array();
$c=array();
if (($handle = fopen("server/php/files/orgs.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $o[] = $data;// existing students two-d array
    
       
    }
    fclose($handle);
}

if (($handle = fopen("server/php/files/existing_s.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $etd[] = $data;// existing students two-d array
        $c[]=str_getcsv($data[15]," ");
       
    }
    fclose($handle);
}else {echo '<script language="javascript">';
echo 'alert("Please Upload existing_s")';
echo '</script>';}
if (($handle = fopen("server/php/files/new_s.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $std[] = $data;// new students two-d array
    }
    fclose($handle);
}else {echo '<script language="javascript">';
echo 'alert("Please Upload new_s")';
echo '</script>';}
 $tr=sizeof($etd);
	$tc=sizeof($std);
		$to=sizeof($o);
$flag=range(0, $to-1);
for($s=0;$s<$tc;$s++) {
$p=array_slice($std[$s], 2, $length = 13);	
for($i=0;$i<$to;$i++) {$score[$i]=0;
}
for($i=0;$i<$tr;$i++) {$diss=0;
	for($j=2;$j<15;$j++) {$temp=$etd[$i][$j]-$p[$j-2];
		$diss=$diss+$temp*$temp;
	}
	$dis[$i]=sqrt($diss);
	
	}
	
$g=$c;//temporary flag
	array_multisort($dis, $g); //here is a mistake
	for($i=0;$i<150;$i++){ //this is k of knn
	for($j=0;$j<6;$j++) {
		if(isset($g[$i][$j])) 
		{	if(!$dis[$i])
			$dis[$i]=0.1; // Biasing factor for equal results
		 	$score[$g[$i][$j]]+= 1/$dis[$i];
		}
	}
}
$h=$flag; //temporary flag
if($s%100==0) {
echo $s/100 . "\n";}
array_multisort($score,SORT_DESC,$h);
$clubs=$std[$s][0].",".$std[$s][1].",".$std[$s][2].",".$std[$s][3].",".$std[$s][4].",".$std[$s][5].",".$std[$s][6].",".$std[$s][7].",".$std[$s][8].",".$std[$s][9].",".$std[$s][10].",".$std[$s][11].",".$std[$s][12].",".$std[$s][13].",".$std[$s][14].",".$h[0] . " ".$h[1] . " ".$h[2] . " ".$h[3] . " ".$h[4] . "\n";

fwrite($hc, $clubs);

}

$time_end = microtime(true);
$time = $time_end - $time_start;

echo "Time Taken For $s Students equals $time seconds\n";
?>

