<?php

//$blob = $_POST['thefile'];
//$filename = $_POST['filename'];

$post_data = file_get_contents('php://input');
$name = $_GET['name'];
$chlng = $_GET['chlng'];




//error_log('the post data is: '.$post_data);
//error_log('the filename is: '.$filename);
$filename = $name.'_'.$chlng.'_'.mt_rand(1000,10000);
$filePath = '/var/www/html/newlive/'.$filename.'.webm';
file_put_contents($filePath, $post_data);

if($chlng == 1)
 {
   $command = escapeshellcmd('/usr/bin/python3.5 /var/www/html/newlive/face_classification/src/videofileemotion.py '.$name.' '.$filename.'.webm neutral happy');
   $response = shell_exec($command);
   print_r($response);
 }
else
 {
   $command = escapeshellcmd('/usr/bin/python3.5 /var/www/html/newlive/face_classification/src/videofileemotion.py '.$name.' '.$filename.'.webm neutral angry');
   $response = shell_exec($command);
   print_r($response);
 }
/*$response = json_decode($response,true);
echo '<br>';
echo $totalcnt = count($response);*/




?>
