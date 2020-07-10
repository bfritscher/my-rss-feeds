<?php
require('core.php');

$html =  get_web_page_content('https://www.galaxus.ch/fr/LiveShopping');

preg_match( '/<article.*?class="liveshoppingbig.*?>([\w\W]*?)<\/article>/is', $html, $matches);

$link = "https://www.galaxus.ch";
$title = date('d-m-Y');
$description = $matches[1];

preg_match('/<a href="(\/fr\/[a-z\d]+\/product\/)ratings\/(.*?)#/s', $description, $links);
$link = $link . $links[1] . $links[2];

$description = preg_replace( '/href="(.*?)"/', 'href="' . $link . '${1}"', $description);
preg_match('/img src="(http.*?)"/', $description, $imgs);


preg_match('/<div.*?class="daily-offer-new-date__day.*?(\d+)<\//is', $description, $date_match);
preg_match('/(\d+\.–.*?)<\/div><\/div>/is', $description, $match);

$description = '<img src="'. $imgs[1] .'" /><div><span><strong>' . $match[1];


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
</channel>
</rss>






