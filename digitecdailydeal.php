<?php
require('core.php');

$html =  get_web_page('https://www.digitec.ch/fr/LiveShopping');
preg_match( '/<article class="product dday.*?>(.*?)<\/article/is', $html['content'], $matches);

$link = "https://www.digitec.ch";
$title = date('d-m-Y');
$description = $matches[1];

preg_match('/ src="(.*?)"/', $description, $imgs);
$description = preg_replace( '/href="(.*?)"/', 'href="' . $link . '${1}"', $description);
$description = '<img src="'.$link. $imgs[1] .'" />' . $description;
$description = preg_replace('/<div class="stock">.*?<\/div>/s', '', $description);
$description = preg_replace('/<noscript>.*?<\/noscript>/s', '', $description);

preg_match('/class="product-overlay".*?href="(.*?)"/s', $description, $links);
$link = $links[1];
$description = preg_replace('/class="product-overlay"(.*?)></s', 'class="overlay"${1}>Page produit<', $description);
preg_match( '/<div.*?class="date.*?(\d+)<\//is', $description, $date_match);

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
                <description><?php echo htmlentities($description); ?></description>
                <link><?php echo $link;?></link>
                <guid><?php echo $id;?></guid>
                <pubDate><?php echo $date;?></pubDate>
        </item>
<?php endif;?>
</channel>
</rss>
