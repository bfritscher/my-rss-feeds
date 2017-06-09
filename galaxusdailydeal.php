<?php
require('core.php');

$html =  get_web_page_content('https://www.galaxus.ch/fr/LiveShopping');
preg_match( '/<article class=".*?daily-offer.*?>(.*?)<\/article/is', $html, $matches);

$link = "https://www.galaxus.ch";
$title = date('d-m-Y');
$description = $matches[1];
$description = preg_replace('/<ul class="product-recommender.*<\/ul>/s', '', $description);
preg_match('/ data-src="(.*?)"/', $description, $imgs);
$description = preg_replace('/^.*?<\/noscript>/s', '', $description);
$description = preg_replace( '/href="(.*?)"/', 'href="' . $link . '${1}"', $description);
$description = '<img src="'. $imgs[1] .'" />' . $description;
$description = preg_replace('/<div class="daily-offer__stock.*?<\/div>/s', '<div>', $description);

preg_match('/class="overlay".*?href="(.*?)"/s', $description, $links);
$link = $links[1];
$description = preg_replace('/class="overlay"(.*?)></s', 'class="overlay"${1}>Page produit<', $description);
preg_match( '/<div.*?class="daily-offer__date.*?(\d+)<\//is', $description, $date_match);


$date =  date('D, d M Y H:i:s O', mktime(6, 0, 0));
$id =  $title;

?>

<rss version="2.0">
<channel>
        <title>Galaxus DEALS</title>
        <description></description>
        <link>http://galaxus.ch</link>
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






