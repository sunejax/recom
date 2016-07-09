<?php
//$pgconn = pg_connect("host= recomdb2.cnbi0ip1wv3h.us-west-2.rds.amazonaws.com port=5432 dbname=recomdb2 user=badwolf password=recomdb2");
//$dquery='delete from prog';
//pg_query($dquery);
$time_start = microtime(true);
$hc=fopen('server/php/files/recommendations.csv', 'w');
$twoDarray = array();
$flag=array();
$c=array();
$lim;
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
//
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
////////////////////////////////////////////////Generating Point Cloud
for($i=2;$i<16;$i++)
    	for($j=0;$j<$tr;$j++) 
   	 	$x[$i-2][$j]=$etd[$j][$i];
   	 	

  //$point=array(3,4,8,3,0,10,3,8,5,2,8,2,4);
 array_multisort($x[0],$x[1],$x[2],$x[3],$x[4],$x[5],$x[6],$x[7],$x[8],$x[9],$x[10],$x[11],$x[12],$x[13]);
for($j=0;$j<$tr;$j++)     
    {for($i=0;$i<14;$i++)
   	 $pc[$j][$i]= $x[$i][$j] ; //sorted point array 
    }
    
    
      function ranger($l,$h,$point,$depth,$p) {global $lim;
		if($depth==6) {$lim=array($l,$h); //Depth decides m :the number of prospective candidates 
		return;}  	
    	$k=($h+$l)/2;
    	ceil($k);
    	if($point[$depth]<$p[$k][$depth]) {$h=$k;}
    	if($point[$depth]>=$p[$k][$depth]) {$l=$k;}
    	ranger($l,$h,$point,$depth+1,$p);
    	}
    


$flag=range(0, $to-1);//change hard number
for($s=0;$s<$tc;$s++) {//change hard number
unset($g);
$p=array_slice($std[$s], 2, $length = 13);	
////////////////////////////////
    
    $depth=0;
    $l=0;$h=$tr;

 
   ranger($l,$h,$p,$depth,$pc);
  

//var_dump($lim);
////////////////////////////////
for($i=0;$i<$to;$i++) {$score[$i]=0;}

for($i=$lim[0];$i<$lim[1];$i++) {$diss=0;
	for($j=0;$j<13;$j++) {
		$temp=$pc[$i][$j]-$p[$j];
		$diss=$diss+$temp*$temp;
	}
	$g[]=str_getcsv($pc[$i][13]," ");
	$dis[$i-$lim[0]]=sqrt($diss);
	}
	//echo sizeof($dis)." ";
	array_multisort($dis, $g); 
	for($i=0;$i<150;$i++) //K for knn
	{ 
		for($j=0;$j<6;$j++) {
			if(isset($g[$i][$j])) 
				{	
					if(!$dis[$i])
					{$dis[$i]=0.1;exit;} // Biasing factor for equal results
		 			$score[$g[$i][$j]]+= 1/$dis[$i];
				}
	}
}
$h=$flag; //temporary flag

array_multisort($score,SORT_DESC,$h);

/*if($s%100==0) {
$prog=$s/100 . "\n";
if($prog%5==0)
{$query='insert into prog values('.$s.','.$prog.')';
pg_query($query);}
}*/
array_multisort($score,SORT_DESC,$h);
$clubs=$std[$s][0].",".$std[$s][1].",".$std[$s][2].",".$std[$s][3].",".$std[$s][4].",".$std[$s][5].",".$std[$s][6].",".$std[$s][7].",".$std[$s][8].",".$std[$s][9].",".$std[$s][10].",".$std[$s][11].",".$std[$s][12].",".$std[$s][13].",".$std[$s][14].",".$h[0] . " ".$h[1] . " ".$h[2] . " ".$h[3] . " ".$h[4] . "\n";

fwrite($hc, $clubs);

}

$time_end = microtime(true);
$time = $time_end - $time_start;

echo "Time Taken For $s Students equals $time seconds\n";
?>

