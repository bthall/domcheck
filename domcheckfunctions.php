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

function getTLD($domain){
   $tld =  explode(".", $domain, 2)[1];
   return $tld;
}

function getWhois($domain){
   $command = exec("which whois");
   $whois = shell_exec("$command $domain");
   return $whois;
}

function getExpiration($domain, $tld, $whois){
   if ($tld == 'co'){
      $regex = '/Domain Expiration Date:\s+(.*)/';
   } elseif ($tld == 'com'){
      $regex = '/Expiration Date:\s+(.*)/';
   } elseif ($tld == 'info'){
      $regex = '/Expiry Date:\s+(.*)/';
   } elseif ($tld == 'me'){
      $regex = '/Expiration Date:(.*)/';
   } elseif ($tld == 'mobi'){
      $regex = '/Expiration Date:(.*)/';
   } elseif ($tld == 'net'){
      $regex = '/Expiration Date:\s(.*)/';
   } elseif ($tld == 'org'){
      $regex = '/Expiry Date:\s+(.*)/';
   } elseif ($tld == 'tv'){
      $regex = '/Expiry Date:\s+(.*)/';
   } elseif ($tld == 'xxx'){
      $regex = '/Expiry Date:\s+(.*)/';
   } else {
      echo "INVALID TLD";
      echo 'Failed to obtain TLD for ' . $domain . PHP_EOL;
      die;
   }
   preg_match($regex, $whois, $results);
   $expiration = $results[1];
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
