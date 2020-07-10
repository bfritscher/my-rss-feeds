<?php
require('core.php');
$json = get_web_page_content('https://hummingbird.rts.ch/api/info/v4/feed/inbrief?limit=50&offset=0');
$res = json_decode($json);
$date =  date('D, d M Y H:i:s O', mktime(6, 0, 0));
echo '<?xml version="1.0" encoding="UTF-8"?>';
?>

<rss version="2.0">
<channel>
        <title>Toute l'info - RTS Un / RTS Deux</title>
        <description>RTSinfo.ch - le portail d'info de rts.ch - Pour un usage privé exclusivement.</description>
        <link>https://www.rts.ch/info/toute-info/</link>
        <lastBuildDate><?php echo $date;?></lastBuildDate>
        <pubDate><?php echo $date;?></pubDate>
        <image>
            <url>https://www.rts.ch/img/general/header/rts.ch-logo.gif</url>
            <title>Toute l'info - RTS Un / RTS Deux</title>
            <link>https://www.rts.ch/info/toute-info/</link>
        </image>
<?php
foreach ($res->elements as $item){
    $url = "https://hummingbird.rts.ch/api/info/v4/articles/{$item->id}?native=android-4250";
    $json = get_web_page_content($url);
    $a = json_decode($json);
    $date =  date('D, d M Y H:i:s O', $a->dateTime/1000);
    preg_match( '/(<article.*?>.*<\/article>)/is', $a->html, $matches);
    $replace = "<img src=\"{$a->mainImage->imageUrl}?w=580\" />";
    if ($a->mainMedia and $a->mainMedia->type == "video") {
        $replace = '<iframe referrerpolicy="no-referrer-when-downgrade" allowfullscreen="" allow="geolocation *; encrypted-media" height="360" width="100%" frameborder="0" src="//player.rts.ch/p/rts/inline?urn=' . $a->mainMedia->mediaUrn . '&amp;hidesegments=true" srg-player-id="b38f120b-2f04-4882-9ba0-9e0313c72fcf"></iframe>';
    }
    
    
    $description = preg_replace( '/<div class="article-media-caption.*?<\/header>/',  $replace, $matches[1]);
    $description = preg_replace( '/<div class="article-lead">(.*?)<\/div>/is', '<div><b>${1}</b></div>', $description);
?>
        <item>
                <title><?php echo $a->title;?></title>
                <description><![CDATA[
<?php echo $description; ?>
  ]]> 
</description>
                <link><?php echo $a->url;?></link>
                <guid isPermaLink="false"><?php echo $a->id;?></guid>
                <pubDate><?php echo $date;?></pubDate>
        </item>
<?php } ?>
</channel>
</rss>