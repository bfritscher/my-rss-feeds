<?php
   /**
     * Get a web file (HTML, XHTML, XML, image, etc.) from a URL.  Return an
     * array containing the HTTP server response header fields and content.
     */
    function get_web_page( $url )
    {
        $user_agent='Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0';

        $options = array(

            CURLOPT_CUSTOMREQUEST  =>"GET",        //set request type post or get
            CURLOPT_POST           =>false,        //set to GET
            CURLOPT_USERAGENT      => $user_agent, //set user agent
            CURLOPT_COOKIEFILE     =>"cookie.txt", //set cookie file
            CURLOPT_COOKIEJAR      =>"cookie.txt", //set cookie jar
            CURLOPT_RETURNTRANSFER => true,     // return web page
            CURLOPT_HEADER         => false,    // don't return headers
            //CURLOPT_FOLLOWLOCATION => true,     // follow redirects
            CURLOPT_ENCODING       => "",       // handle all encodings
            CURLOPT_AUTOREFERER    => true,     // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
            CURLOPT_TIMEOUT        => 120,      // timeout on response
            CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
        );

        $ch      = curl_init( $url );
        curl_setopt_array( $ch, $options );
        $content = curl_exec( $ch );
        $err     = curl_errno( $ch );
        $errmsg  = curl_error( $ch );
        $header  = curl_getinfo( $ch );
        curl_close( $ch );

        $header['errno']   = $err;
        $header['errmsg']  = $errmsg;
        $header['content'] = $content;
        return $header;
    }


$result =  get_web_page('http://www.microspot.ch/msp/pages/deals.jsf?selectedLanguage=fr');
$html = $result['content'];
preg_match( '/(<div class="deals-happyhour.*?<\/div>)/is', $html, $matches);

$link = "http://www.microspot.ch";
$title = date('d-m-Y');
$description = $matches[1];
$description = preg_replace( '/href="(.*?)"/', 'href="' . $link . '${1}"', $description);
$description = preg_replace( '/src="(.*?)"/', 'src="' . $link . '${1}"', $description);
preg_match('/href="(.*?)"/s', $description, $links);
$link = $links[1];
preg_match('/^.*\/(.*)-\d+/', $link, $titles);
$id = $titles[1];
$title = $title . ' '. str_replace('-', ' ', $id);
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
        <item>
                <title><?php echo $title;?></title>
                <description><?php echo htmlentities($description); ?></description>
                <link><?php echo $link;?></link>
                <guid><?php echo $id;?></guid>
                <pubDate><?php echo $date;?></pubDate>
        </item>
</channel>
</rss>






