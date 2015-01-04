<?php
$html =  file_get_contents('http://www.steg-electronics.ch/fr/Default.aspx');
preg_match_all( "/<div.*?url\((.*?)\).*Weekly-Deals','Klick','(.*?)'.*?href=\"(.*?)\"/i", $html, $matches);

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
  $id = $matches[2][$i];
  $title = str_replace('-', ' ', $id);
  $link = $matches[3][$i];
  $description = '<div><a href="' . $matches[3][$i] . '"><img src="' . $matches[1][$i] . '"/></a></div>';
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






