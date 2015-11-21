<?php
	include 'ph-queries.php';
	$ph_query = new PHQUERIES( $conn );
   $file="split_aa";

   $fopen = fopen($file, r);

   $fread = fread($fopen,filesize($file));

   fclose($fopen);

   $remove = "\n";

   $split = explode($remove, $fread);

   $array[] = null;
   $tab = "|";
   $i = 1;
   foreach ($split as $string)
   {
	   $row = explode($tab, $string);
	   array_push($array,$row);
	 	$ph_query->add_videos( $array[$i][0], $array[$i][1], $array[$i][2], $array[$i][3], $array[$i][4], $array[$i][5], $array[$i][7], $array[$i][8] );
	 	$i++;

   }

?>