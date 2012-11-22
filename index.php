<?php

require_once("response.php");

$r = new Response();
$r->setFiller("yes");
$r->addPlayAudio("http://mbulance.karenxiao.com/audio/test.wav");

?>
