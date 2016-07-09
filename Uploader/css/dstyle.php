<?php
header("Content-type: text/css");
$pgconn = pg_connect("host= recomdb2.cnbi0ip1wv3h.us-west-2.rds.amazonaws.com port=5432 dbname=recomdb2 user=badwolf password=recomdb2");
$str='block';
$pro='2%';

		{/*echo '#progress{
			display:print '.$str.' !important;
			}';*/
		while ($pro!=100)
						{$pro=pg_query('select cur from prog where sno=(select max(sno) from prog)-1');
						$pro=$pro.'%';
						}
		}
									
?>

#progress{
			display:<?php print $str?> !important;
			}

#myBar{
			width:<?php print $pro?>  !important;
		}