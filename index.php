<?php

session_start();

require_once("response.php");
require_once("trees.php");

$r = new Response();

// code to look up the specific string in the tree
$_SESSION['code'] = "";

if($_REQUEST['event']=="NewCall") 
  {
    $cd = new CollectDtmf();
    $cd->setTimeOut("4000");
    $cd->addPlayText("Welcome to Em Bulance mobile diagnostic system. To begin, press 1. To respond yes to a question, press 1. To respond no to a question press 2.");
    $r->addCollectDtmf($cd);
    $r->send();
  } 

while($_REQUEST['event']=="GotDTMF")
   {

     $response = $_REQUEST['data'];

     if ($response == 1)
       {
	 $cd = new CollectDtmf();
	 $cd->setTimeOut("4000");
	 $code = $_SESSION['code'] . '1';
	 $cd->addPlayText($code);
	 $r->addCollectDtmf($cd);
	 $r->send();
       }
     else if ($response == 2)
       {
	 $cd = new CollectDtmf();
	 $cd->setTimeOut("4000");
	 $code = $_SESSION['code'] . '0';
	 $cd->addPlayText($code);
	 $r->addCollectDtmf($cd);
	 $r->send(); 
       }

   } 

$r->addHangup();
$r->send();

?>
