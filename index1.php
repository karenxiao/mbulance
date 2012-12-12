<?php

require_once("response.php");
require_once("trees.php");

session_start();

$r = new Response();

if ($_REQUEST['event']=="NewCall") 
  {
    $r->addPlayAudio("http://www.hcs.harvard.edu/~care/mbulance/audio/test.wav");
    $r->send();
  } 

else 
  {
    $r->addPlayText("Goodbye!");
    $r->addHangup();
    $r->send();
  }
?>