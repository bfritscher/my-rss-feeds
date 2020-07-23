<?php
#error_reporting(E_ALL);
#ini_set('display_errors', 1);
require('core.php');
$page = get_web_page_content('https://www.galaxus.ch/de/Magazine');
preg_match_all('/<article class="teaser-new.*?H2>(.*?)<\/H2.*?href="(.*?)".*?<\/article>/s', $page, $matches, PREG_SET_ORDER);
$date =  date('D, d M Y H:i:s O', mktime(6, 0, 0));
echo '<?xml version="1.0" encoding="UTF-8"?>';
?>

<rss version="2.0">
<channel>
        <title>Glaxus Magazine</title>
        <description></description>
        <link>https://www.galaxus.ch/de/Magazine</link>
        <lastBuildDate><?php echo $date;?></lastBuildDate>
        <pubDate><?php echo $date;?></pubDate>
<?php
foreach ($matches as $match){
?>
        <item>
                <title><?php echo trim($match[1]); ?></title>
                <link>https://www.galaxus.ch<?php echo $match[2]; ?></link>
                <guid>https://www.galaxus.ch<?php echo $match[2]; ?></guid>
                <pubDate><?php echo $date;?></pubDate>
        </item>
<?php } ?>
</channel>
</rss>