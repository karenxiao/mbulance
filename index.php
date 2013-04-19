<?php

require_once("response.php");
require_once("trees.php");
require_once("Logging.php");
require_once("lib.php");

session_start();

$rating_log = new Logging();
$rating_log->lfile("logs/rating_logs");

$timeout_log = new Logging();
$timeout_log->lfile("logs/timeout_logs");

$r = new Response();

if ($_REQUEST['event']=="NewCall") 
  {	
    $cd = new CollectDtmf();
    $cd->setMaxDigits("1");
    $cd->setTimeOut("4000");
    $cd->addPlayText("Welcome to em bulance mobile healthcare diagnostic service. Press one to begin.");

    $_SESSION['code'] = "";
	$_SESSION['cid'] = $_REQUEST['cid'];
	
    $r->addCollectDtmf($cd);
    $r->send();
  } 

else if ($_REQUEST['event']=="GotDTMF")
{
	$response = $_REQUEST['data'];
	
	if ($response == '')
	{
		$r->addPlayText("Sorry. The system has timed out. Goodbye!");
		$r->addHangup();
		if(array_key_exists('code' , $_SESSION))
			$timeout_log->lwrite($_SESSION['cid']."\tStage of system timeout : ".$_SESSION['code']);
		$r->send();
		$timeout_log->lclose();
		$rating_log->lclose();
	}
     
	else if(array_key_exists('rating' , $_SESSION) && $_SESSION['rating'])
	{
		if($response>='0' && $response<='5')
		{
			
			$_SESSION['rating']=false;
			$rating_log->lwrite($_SESSION['cid']."\tRating for tree ".$_SESSION['code']." : ".$response);
			$r->addPlayText("Your response has been recorded. Thank you for using em bulance. Goodbye!");
			$r->addHangup();
			$r->send();
			$rating_log->lclose();
			$timeout_log->lclose();
		}
		else
		{
			$string = "Sorry. That is not a valid response. Please rate between zero to five";
			$cd = new CollectDtmf();
			$cd->setMaxDigits("1");
			$cd->setTimeOut("4000");
			$cd->addPlayText($string);
			
			$r->addCollectDtmf($cd);
			$r->send();
		}
	}
	else
	{
	
		$_SESSION['rating'] = false;
		if ($response == '1' || $response == '0')
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
		else if ($response == '2')
		{
			CountLog::increment($_SESSION['code']);
			$_SESSION['rating'] = true;
			$string = "Thank you for using em bulance. Please rate our service from zero to five, zero being the lowest and five the highest.";
			$cd = new CollectDtmf();
			$cd->setMaxDigits("1");
			$cd->setTimeOut("4000");
			$cd->addPlayText($string);
			$r->addCollectDtmf($cd);
			$r->send();
			
		}
		else
		{
			$r->addPlayText("Sorry. That is not a valid response. Please press one for yes, zero for no.");
			$r->send();
		}
	}
}
else if ($_REQUEST['event']=="Hangup")
{
		if(array_key_exists('code' , $_SESSION))
		$timeout_log->lwrite($_SESSION['cid']."\tStage of user hangup : ".$_SESSION['code']);
		$rating_log->lclose();
		$timeout_log->lclose();
		exit();
}
=======
<?php

require_once("response.php");
require_once("trees.php");

session_start();

$stats[];

$r = new Response();

if ($_REQUEST['event']=="NewCall") 
  {
    $cd = new CollectDtmf();
    $cd->setMaxDigits("1");
    $cd->setTimeOut("4000");
    $cd->addPlayText("Welcome to em bulance mobile healthcare diagnostic service. Press one to begin.");

    $_SESSION['code'] = "";
    $_SESSION['state'] = 1;

    $r->addCollectDtmf($cd);
    $r->send();
  } 

else if ($_REQUEST['event']=="GotDTMF")
  {
     $response = $_REQUEST['data'];
     
     if ($_SESSION['state'] == 0)
       {
	 $stats['rating'] = $response;
	 $r->addPlayText("Thanks again for using em bulance. Goodbye");
	 $r->addHangup();
	 $r->send();
       }
     
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
	 $_SESSION['state'] = 0;

	 $cd = new CollectDtmf();
         $cd->setMaxDigits("1");
         $cd->setTimeOut("4000");
	 $cd->addPlayText("Thank you for using em bulance. Before you hang up, please rate your experience today on a scale of one to five.");
	
	 $r->addCollectDtmf($cd);
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