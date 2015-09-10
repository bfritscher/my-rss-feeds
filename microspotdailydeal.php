<?php
require('core.php');
$html =  get_web_page_content('http://www.microspot.ch/msp/pages/deals.jsf?selectedLanguage=fr');

preg_match_all( '/deals-carousel-item">(.*?)<\/div>/is', $html, $matches);

$base = "http://www.microspot.ch";
$date =  date('D, d M Y H:i:s O', mktime(6, 0, 0));

echo '<?xml version="1.0" encoding="UTF-8" ?>';
?>

<rss version="2.0">
<channel>
        <title>microspot.ch DEALS</title>
        <description></description>
        <link>http://www.microspot.ch/msp/pages/deals.jsf</link>
        <lastBuildDate><?php echo $date;?></lastBuildDate>
        <pubDate><?php echo $date;?></pubDate>

<?php
$i=0;
while( $i < count($matches[0])) {
  preg_match( '/href="(.*?)".*?src="(.*?)"/s', $matches[1][$i], $match);
  $id = str_replace('/', '', $match[2]);
  $title = 'Deal';
  $link = $base . $match[1];
  $description = '<div><a href="' . $base . $match[1] . '"><img src="' . $base . $match[2] . '"/></a></div>';
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






