<?php


function getTLD($domain){
   $tldposition = strripos($domain, '.');
   $domainlength = strlen($domain);
   $tld = substr($domain, $tldposition, $domainlength);
   return $tld;
}
$whois = exec('which whois');
$domain = $argv[1];
$tld = getTLD($domain);
$expiration = getExpiration($domain, $tld, $whois);
$days = getDays($expiration);
echo 'Days until expiration:' . $days;

function getExpiration($domain, $tld, $whois){
   if ($tld == '.co'){
      $expiration = shell_exec("$whois $domain | grep 'Expiration' | cut -d ' ' -f26-30");
   } elseif ($tld == '.com'){
      $expiration = shell_exec("$whois $domain | grep 'Registration Expiration Date' | cut -d ' ' -f5");
   } elseif ($tld == '.info'){
      $expiration = shell_exec("$whois $domain | grep 'Expiry' | cut -d ' ' -f4");
   } elseif ($tld == '.me'){
      $expiration = shell_exec("$whois $domain | grep 'Expiration' | cut -d ' ' -f3 | cut -d ':' -f2");
   } elseif ($tld == '.mobi'){
      $expiration = shell_exec("$whois $domain | grep 'Expiration' | cut -d ' ' -f2 | cut -d ':' -f2");
   } elseif ($tld == '.net'){
      $expiration = shell_exec("$whois $domain | grep 'Registration Expiration Date' | cut -d ' ' -f5");
   } elseif ($tld == '.org'){
     $expiration = shell_exec("$whois $domain | grep 'Expiry' | cut -d ' ' -f4");
   } elseif ($tld == '.tv'){
      $expiration = shell_exec("$whois $domain | grep 'Expiry' | cut -d ' ' -f7");
   } elseif ($tld == '.xxx'){
      $expiration = shell_exec("$whois $domain | grep 'Expiry' | cut -d ' ' -f4");
   } else {
      echo "INVALID TLD";
   }
   return $expiration;
}

function getDays($expiration){
   $now = strtotime('today UTC');
   $time = strtotime($expiration);
   $days = abs($time - $now)/60/60/24;
   $daysrounded = floor($days);
   return $daysrounded;
}
?>
