<?php
    require_once('Shortener.php');
    $data = $Shortener->showDatafromDB();
	foreach ($data as $data){
    	echo "<tr><th scope='row'><a href=".$data['long_url']." target='_blank' onclick='totalHit(".$data['id'].")'>".$data['short_code']."</th><td>".$data['hits']."</a></td></tr>";
	}
?>
