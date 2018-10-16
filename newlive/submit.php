<?php

   header('Access-Control-Allow-Origin: *'); 
   header('Content-type: application/json');


  function test_input($data)
  {
       $data = stripslashes($data);
       $data = htmlentities($data);
       $data = htmlspecialchars($data);
       return $data;
  };

    $name = test_input($_POST['name']);
    $phone = test_input($_POST['phone']);
    $aadhar = test_input($_POST['aadhar']);
    $path = $_POST['path'];
    
    if(isset($name) && !empty($name) && isset($phone) && !empty($phone) && isset($aadhar) && !empty($aadhar))
     {

                try
                  {
                    require 'connect.php';

                    $currslt = $conn->prepare("select * from guests where phone = :phone");
                    $currslt->bindParam(':phone', $phone, PDO::PARAM_STR);
                    $currslt->execute();
                    $dayresult=$currslt->fetchColumn();
                  }
                  catch(PDOException $q)
                  {
                    echo "Error:" . $q->getMessage();
                  }
        
                   $conn = null;              
                   
                  if($dayresult >= 1)
                   {
                       echo json_encode("error");
                   }
                  else
                   {                         
                       
                      if (!is_dir("/var/www/html/newlive/server/php/files/".$aadhar)) 
                           {

		             mkdir("/var/www/html/newlive/".$aadhar, 0777, true);
		             chmod("/var/www/html/newlive/".$aadhar,0777);
                             chmod("/var/www/html/newlive/server/php/files/".$path,0777);
                             $command = escapeshellcmd('mv /var/www/html/newlive/server/php/files/'.$path.' /var/www/html/newlive/'.$aadhar);
                             shell_exec($command);
                       
			   }

                        set_time_limit(0);
                        $command = escapeshellcmd('/usr/bin/python3.5 /var/www/html/newlive/vidyatest.py '.$aadhar);
                        $response = shell_exec($command);
                        $response = json_decode($response,true);
                        $totalcnt = $response['code'];
                      if($totalcnt == 'Success')
                       {
                         try
                          {
                             require 'connect.php';
        
                             $currslt = $conn->prepare("INSERT INTO `guests`(`name`, `phone`, `aadhar`,`path`) VALUES (:name,:phone,:aadhar,:path)");
                             $currslt->bindParam(':name', $name, PDO::PARAM_STR);
                             $currslt->bindParam(':phone', $phone, PDO::PARAM_STR);
                             $currslt->bindParam(':aadhar', $aadhar, PDO::PARAM_STR);
                             $currslt->bindParam(':path', $path, PDO::PARAM_STR);
                             $currslt->execute();
                             setcookie('user',$aadhar, time() + (86400 * 30), "/");
                             //die(header("location:step-3.php?id=$phone"));
                             echo json_encode(1);
                          }
                          catch(PDOException $q)
                          {
                             echo json_encode("error");
                          }
                          $conn = null;
      
                       }
                      else
                       {
                         echo json_encode(3);
                       }
                   }
     }
    else
     {
       echo json_encode("blank");
     }

?>
