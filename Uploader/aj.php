<?php

if (isset($_POST['inaction'])) 
					{ $pd=$_POST['inaction'];
						$com='kill -9 '. $pd;						
							exec($com);
							echo "Stopped $pd";
  				}

if (isset($_POST['action'])) 
	{
		if ($_POST['action']==='true')
		
		{
               
  					$pi=exec('php penfinal-fast.php > /dev/null 2>&1 & echo $!');
  					echo $pi;
		}	
else 
  {
  		
  				$pi=exec('php penfinal.php > /dev/null 2>&1 & echo $!');
  					echo $pi;
	
		
  }
   

}
?>