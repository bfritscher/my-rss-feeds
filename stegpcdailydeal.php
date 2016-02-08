<?php
require('core.php');
$html =  get_web_page_content('http://www.steg-electronics.ch/fr/Default.aspx');
preg_match( '/weeklydeal">(.*)<div class="box">/s', $html, $matches);
preg_match_all( '/href="(.*?)".*?src="(.*?)"/s', $matches[1], $matches);

$base = "http://www.steg-electronics.ch";
$date =  date('D, d M Y H:i:s O', mktime(6, 0, 0));
echo '<?xml version="1.0" encoding="UTF-8" ?>';
?>

<rss version="2.0">
<channel>
        <title>StegPC DEALS</title>
        <description></description>
        <link>http://www.steg-electronics.ch/fr/Default.aspx</link>
        <lastBuildDate><?php echo $date;?></lastBuildDate>
        <pubDate><?php echo $date;?></pubDate>
<?php 
$i=0;
while( $i < count($matches[0])) {
  $id = str_replace('/', '', $matches[2][$i]);
  $title = 'Weeklydeal';
  $link = $base . $matches[1][$i];
  $description = '<div><a href="' . $base . $matches[1][$i] . '"><img src="' . $base . $matches[2][$i] . '"/></a></div>';
  $date =  date('D, d M Y H:i:s O', mktime(6, 0, 0));
  $i++;
?>
        <item>
                <title><?php echo $title;?></title>
                <description><?php echo htmlentities($description); ?></description>
                <link><?php echo $link;?></link>
                <guid><?php echo $id;?></guid>
                <pubDate><?php echo $date;?></pubDate>
        </item>
<?php } ?>        
</channel>
</rss>






