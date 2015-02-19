<?php
##################################################################################
# The MIT License (MIT)                                                          #
#                                                                                # 
# Copyright (c) 2015 Brandon Hall                                                #
#                                                                                #
# Permission is hereby granted, free of charge, to any person obtaining a copy   #
# of this software and associated documentation files (the "Software"), to deal  #
# in the Software without restriction, including without limitation the rights   #
# to use, copy, modify, merge, publish, distribute, sublicense, and/or sell      #
# copies of the Software, and to permit persons to whom the Software is          #
# furnished to do so, subject to the following conditions:                       #
#                                                                                #
# The above copyright notice and this permission notice shall be included in all #
# copies or substantial portions of the Software.                                #
#                                                                                #
# THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR     #
# IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,       #
# FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE    #
# AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER         #
# LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,  #
# OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE  #
# SOFTWARE.                                                                      #
##################################################################################

##################################################################################
# VERSION: Version 1.0                                                           #
#                                                                                #
#The latest version of domcheck can be found at:                                 #
#https://github.com/bthall/domcheck                                              #
##################################################################################
$whois = exec('which whois');
$domain = $argv[1];
$tld = getTLD($domain);
$expiration = getExpiration($domain, $tld, $whois);
$days = getDays($expiration);
echo 'Days until expiration:' . $days . PHP_EOL;

function getTLD($domain){
   $tldposition = strripos($domain, '.');
   $domainlength = strlen($domain);
   $tld = substr($domain, $tldposition, $domainlength);
   return $tld;
}

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
