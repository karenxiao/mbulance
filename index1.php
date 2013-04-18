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
    $cd->addPlayAudio("http://www.karenxiao.com/mbulance/mbulance/audio/cold/e2.wav");
    $r->addCollectDtmf($cd);
    $r->send();
  } 

else 
  {
    $r->addPlayText("Goodbye!");
    $r->addHangup();
    $r->send();
  }
?>