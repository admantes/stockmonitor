<?php

 
				$url = "http://phisix-api4.appspot.com/stocks/MEG.json";
				                
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_URL,$url);
				$result=curl_exec($ch);
				curl_close($ch);

				
				echo $result;
				/*
				$parent = json_decode($result, true);
				$series = $parent['series'];
				$courses = $parent['courses'];
				$modules = $parent['modules'];
*/

				
				
?>
