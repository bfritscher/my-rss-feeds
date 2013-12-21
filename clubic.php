<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
function main(){
	$feed = file_get_contents('http://www.clubic.com/articles.rss');
	//extract header and footer
	preg_match_all('/(.*?)<item>.*<\/item>(.*)$/ms', $feed, $match);
	//extract items
	preg_match_all('/<item>.*?<\/item>/ms', $feed, $matches);
	echo $match[1][0]; //header
	foreach( $matches[0] as $item ){
		//extract link url
		preg_match('/<link>(.*)<\/link>/ms', $item, $link);
		//could extract category from link
		$description = get_content_from_link($link[1]);
		if($description != "<div "){
			//replace description
			echo preg_replace('/<description>.*?<\/description>/ms', "<description><![CDATA[ " . $description . " ]]></description>", $item);
		}else{
			echo $item;
		}
	}
	echo $match[2][0]; //footer
}

function get_content_from_link($link){
	return strpos($link, 'pro.clubic') ? get_content_from_article($link) : get_content_from_clubic($link);
}

function get_content_from_clubic($link){
	$content = "";
	//TODO: caching
	$html = file_get_contents($link);
	preg_match('/\<div class="editorial"(.*?)\<!--/ms', $html, $article);
	$content .= $article[1];
	return "<div " . utf8_encode($content);
}

function get_content_from_article($link){
	$content = "";
	//TODO: caching
	$html = file_get_contents($link);
	preg_match('/<article>(.*?)<\/article>/ms', $html, $article);
	$content .= $article[1];
	return "<div>" . $content ."</div>";
}
main();
?>