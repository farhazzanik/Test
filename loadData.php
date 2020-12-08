<?php
    require_once('Shortener.php');
    $data = $Shortener->showDatafromDB();
	foreach ($data as $data){
    	echo "<tr><th scope='row'>".$data['short_code']."</th><td>".$data['hits']."</td></tr>";
	}
?>
