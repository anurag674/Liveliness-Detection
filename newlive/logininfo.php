<?php
//error_reporting(0); 
function loggedin()
{
if(count($_COOKIE) >0):
 {
   if(!isset($_COOKIE['user']))
    {
      return false;
    } 
    else 
    {
      return true;
    }
 }
else:
 {
   return false;
 }
endif;
}
/*function loggedin()
{
if(isset($_SESSION['username'])&&!empty($_SESSION['username'])) // This is the session variable which is stored during login you can replace with the one you used
 return true;
else  
return false;
}*/
?>