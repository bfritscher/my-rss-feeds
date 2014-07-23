<?php
$html =  file_get_contents('http://www.steg-electronics.ch/fr/Default.aspx');
preg_match( '/<div.*?url\((.*?)\).*?href="(.*?)"/i', $html, $matches);

$title = date('d-m-Y');
$link = $matches[2];
$description = '<div><a href="' . $matches[2] . '"><img src="' . $matches[1] . '"/></a></div>';

$date =  date('D, d M Y H:i:s O', mktime(6, 0, 0));
$id =  $title;

echo '<?xml version="1.0" encoding="UTF-8" ?>';
?>

<rss version="2.0">
<channel>
        <title>StegPC DEALS</title>
        <description></description>
        <link>http://www.steg-electronics.ch/fr/Default.aspx</link>
        <lastBuildDate><?php echo $date;?></lastBuildDate>
        <pubDate><?php echo $date;?></pubDate>
        <item>
                <title><?php echo $title;?></title>
                <description><?php echo htmlentities($description); ?></description>
                <link><?php echo $link;?></link>
                <guid><?php echo $id;?></guid>
                <pubDate><?php echo $date;?></pubDate>
        </item>
</channel>
</rss>






