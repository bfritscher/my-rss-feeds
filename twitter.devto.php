<?php
require('core.php');

$rss =  get_web_page_content('https://rsshub.app/twitter/user/ThePracticalDev');
preg_match_all( '/<a href="(https:\/\/dev\.to\/.*?)">.*?<\/a>/is', $rss, $matches);
for($i=0; $i < count($matches[0]); $i++){
	$html =  get_web_page_content($matches[1][$i]);
	preg_match( '/(<div class="body" data.*?>.*?)<div class="comments-container-container"/is', $html, $match);
	$rss = str_replace($matches[0][$i], $match[1], $rss);
}
print $rss;

