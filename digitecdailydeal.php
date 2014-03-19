<?php
$html =  file_get_contents('http://digitec.ch/Tagesaktionen.aspx');
preg_match( '/<div.*?dday big.*?(<div class="image".*?)<div id="a/is', $html, $matches);
$link = "http://digitec.ch";
$title = date('d-m-Y');
preg_match( '/<div.*?class="date.*?(\d+)<\//is', $html, $date_match);
$description = $matches[1];
//$description = str_replace('ProdukteDetails2', 'http://digitec.ch/ProdukteDetails2', $matches[1]);
$description = str_replace('class="info"', 'style="position: absolute;left: 265px;top: 0;padding: 60px 30px 60px 0;height: 198px;font-family: Arial, sans-serif;color:  #00559D;letter-spacing: 0.049em;font-weight: normal;font-size: 11px;line-height: 12px;"', $description);
$description = str_replace('class="name"', 'style="color: black;font-size: 16px;line-height: 20px;"', $description);
$description = str_replace('class="brand"', 'style="color: black;font-size: 16px;line-height: 20px;font-weight: bold;"', $description);
$description = str_replace('class="price"', 'style="color: #E20031;font-weight: bold;font-size: 16px;line-height: 13px;"', $description);
$description = str_replace('class="price-attribute"', 'style="color: #E20031;"', $description);
$description = str_replace('class="stock"', 'style=""', $description);
preg_match( '/image:url\((.*?)\)/', $description, $pic);
$description = preg_replace('/src=".*?"/', 'src="'.$pic[1].'"', $description);
//remove qty because feedly reparses
$description = preg_replace('/<strong.*?strong>/', '', $description);

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
