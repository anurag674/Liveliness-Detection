<?php

$command = escapeshellcmd('/usr/bin/python3.5 /var/www/html/newlive/face_classification/src/test.py 505050505050 6995.webm neutral happy angry');
$response = shell_exec($command);  
print_r($response);
$response = json_decode($response,true);
echo '<br>';
echo $totalcnt = count($response);



?>
