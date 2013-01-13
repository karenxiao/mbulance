<?php

require_once("response.php");
require_once("trees.php");

session_start();

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
	 $_SESSION['code'] .= $response;
	 $string = $cold[$_SESSION['code']];

	 $cd = new CollectDtmf();
	 $cd->setMaxDigits("1");
	 $cd->setTimeOut("4000");
	 $cd->addPlayText($string);

	 $r->addCollectDtmf($cd);
	 $r->send();
       }

     else if ($response == 2)
       {
	 $r->addPlayText("Thank you for using em bulance. Goodbye!");
	 $r->addHangup();
	 $r->send();
       }

     else
       {
	 $r->addPlayText("Sorry. That is not a valid response. Please press one for yes, zero for no.");
	 $r->send();
       }
   } 
else 
  {
     $r->addPlayText("Sorry. The system has timed out. Goodbye!");
     $r->addHangup();
     $r->send();
  }
?>