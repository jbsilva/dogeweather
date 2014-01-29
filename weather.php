<?php

function get_client_ip() {
     $ipaddress = '180.76.6.19';
     if (getenv('HTTP_CLIENT_IP'))
         $ipaddress = getenv('HTTP_CLIENT_IP');
     else if(getenv('HTTP_X_FORWARDED_FOR'))
         $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
     else if(getenv('HTTP_X_FORWARDED'))
         $ipaddress = getenv('HTTP_X_FORWARDED');
     else if(getenv('HTTP_FORWARDED_FOR'))
         $ipaddress = getenv('HTTP_FORWARDED_FOR');
     else if(getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
     else if(getenv('REMOTE_ADDR'))
         $ipaddress = getenv('REMOTE_ADDR');
     return $ipaddress; 
}

$city = $_GET['city'];

if ($city) {
    $url = "http://api.openweathermap.org/data/2.5/weather?q={$city}&cnt=1";
}
else {
    $ip = get_client_ip(); // the IP address to query
    $query = @unserialize(file_get_contents('http://ip-api.com/php/'.$ip));
    if($query && $query['status'] == 'success') {
      //get Coords
      $lat = $query['lat'];
      $lon = $query['lon'];
      $url = "http://api.openweathermap.org/data/2.5/weather?lat={$lat}&lon={$lon}";
    }
    else {
        $url = "http://api.openweathermap.org/data/2.5/weather?q=Paris";
    }
}

$djson = file_get_contents($url);
echo $djson;
?>
