<?php

$ip = "127.0.0.1"; // suspicious IP address (note that 127.0.0.1 address will not work)
$httpbl_api_key = "YOUR_HTTBL_API_KEY"; // valid http:BL API key

require_once("chttpbl.class.php");
$chttpbl = new cachedHttpBl($httpbl_api_key);

$chttpbl->enableCache(); // enables queries caching (not requied, but very usefull)

if ($chttpbl->check($ip)) {
  echo "Type: ".$chttpbl->type."<br />";
  echo "Typemeaning: ".$chttpbl->typemeaning_description." (typemeaning code: ".$chttpbl->typemeaning.")<br />";
  echo "Threat: ".$chttpbl->threat_description." (threat code: ".$chttpbl->threat.")<br />";
  echo "Activity: ".$chttpbl->activity_description." (activity code: ".$chttpbl->activity.")";
} else
  echo "Something went wrong: ".$chttpbl->error_description." (error code: ".$chttpbl->error.")";
