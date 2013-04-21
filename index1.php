<?php

require_once("response.php");
require_once("trees.php");

$r = new Response();

if ($_REQUEST['event']=="NewCall") 
  {
    $cd = new CollectDtmf();
    $cd->setMaxDigits("1");
    $cd->setTimeOut("4000");
    $cd->addPlayText("Welcome to em bulance mobile healthcare diagnostic service. Press one to begin.");

    $_SESSION['code'] = "";

    $r->addCollectDtmf($cd);
    $r->send();
  } 

else if ($_REQUEST['event']=="GotDTMF")
  {
     $response = $_REQUEST['data'];
     
     if ($response == 1 || $response == 0)
       {
   $code = $_SESSION['code'] . $response;
   $string = $cold[$code];

   $cd = new CollectDtmf();
   $cd->setMaxDigits("1");
   $cd->setTimeOut("4000");
   $cd->addPlayText($string);

   $r->addCollectDtmf($cd);
   $r->send();
       }
     else
       {
   $r->addPlayText("Sorry. That is not a valid response. Please press one for yes, two for no.");
   $r->send();
       }
   } 
else 
  {
     $r->addPlayText("Goodbye!");
     $r->addHangup();
     $r->send();
  }
?>