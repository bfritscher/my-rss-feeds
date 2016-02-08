<?php
function GetFromHost($host, $path) {
  $fp = fsockopen($host, 80);
  fputs($fp, "GET $path HTTP/1.1\r\n");
  fputs($fp, "Host: $host\r\n");
  fputs($fp, "Connection: close\r\n\r\n");
  while(!feof($fp))
      $res .= fgets($fp, 128);
  fclose($fp);
  return $res;
}
$months = array(1=>"January",2=>"February",3=>"March",4=>"April",5=>"May",6=>"June",7=>"July",8=>"August",9=>"September",10=>"October",11=>"November",12=>"December");
 
$response = GetFromHost("dilbert.com","/");
preg_match_all('/img-comic-link".*?(?<y>\d+)-(?<m>\d+)-(?<d>\d+).*?src="(?<img>.*?)"/s', $response, $strips);
 
echo '<?xml version="1.0" encoding="utf-8"?>
<rss version="2.0"><channel><title>Dilbert Daily Strip</title><link>http://dilbert.com</link>
<description>The Unofficial Dilbert Daily Comic Strip RSS Feed</description><language>en-us</language>';
foreach ($strips[img] as $key => $img)
echo '<item><title>Comic for '.$months[($strips[m][$key]+0)].' '.$strips[d][$key].', '.$strips[y][$key].'</title><link>http://dilbert.com/strips/comic/'.$strips[y][$key].'-'.$strips[m][$key].'-'.$strips[d][$key].'</link><description>&lt;img src="'. str_replace('strip.gif','strip.zoom.gif', str_replace('.sunday', '', $img)).'" /&gt;</description><guid>Dilbert-Daily-Strip-'.$strips[y][$key].'-'.$strips[m][$key].'-'.$strips[d][$key].'</guid></item>';
echo '</channel></rss>';
?>