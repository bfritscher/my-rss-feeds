<?php
date_default_timezone_set('Europe/Zurich');
require('core.php');

$html =  get_web_page_content('https://www.digitec.ch/fr/LiveShopping');
preg_match( '/.*?daily-offer.*?>(.*?)<\/article/is', $html, $matches);

$link = "https://www.digitec.ch";
$title = date('d-m-Y');
$description = $matches[1];

preg_match('/ data-src="(.*?)"/', $description, $imgs);
$description = preg_replace( '/href="(.*?)"/', 'href="' . $link . '${1}"', $description);


preg_match('/class="overlay.*?href="(.*?)"/s', $description, $links);
$link = $links[1];
preg_match( '/<div.*?class="daily-offer-new-date__day.*?(\d+)<\//is', $description, $date_match);
preg_match('/(<div class="product-content">.*)<div class="product-buttons">/is', $description, $match);
$description = '<img src="'. $imgs[1] .'" />' . $match[1];


$date =  date('D, d M Y H:i:s O', mktime(6, 0, 0));
$id =  $title;

echo '<?xml version="1.0" encoding="UTF-8" ?>';
?>

<rss version="2.0">
<channel>
        <title>DIGITEC.CH DEALS</title>
        <description></description>
        <link>http://digitec.ch</link>
        <lastBuildDate><?php echo $date;?></lastBuildDate>
        <pubDate><?php echo $date;?></pubDate>
<?php if ($date_match[1] == date('d')): ?>
        <item>
                <title><?php echo $title;?></title>
                <description><![CDATA[
<?php echo $description; ?>
  ]]>
</description>
                <link><?php echo $link;?></link>
                <guid><?php echo $id;?></guid>
                <pubDate><?php echo $date;?></pubDate>
        </item>
<?php endif;?>
</channel>
</rss>
