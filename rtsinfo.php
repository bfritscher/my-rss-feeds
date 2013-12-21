<?php

function main(){
	$feed = file_get_contents('http://www.rts.ch/info/toute-info/?format=rss/news');
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
		//replace description
		echo preg_replace('/<!\[CDATA\[.*?\]\]>/ms', "<![CDATA[ " . $description . " ]]>", $item);
		
	}
	echo $match[2][0]; //footer
}

function get_content_from_link($link){
	$content = "";
	//TODO: caching
	$html = file_get_contents($link);
	preg_match('/media small">.*?(<img.*?\/>)/ms', $html, $img);
	$content .=  "<p>" . $img[1] ."</p>";
	preg_match('/intro">(.*?)<\/div/ms', $html, $intro);
	$content .= "<b>" . $intro[1] . "</b>";
	preg_match('/tsr-gallery">(.*?)<\/div/ms', $html, $article);
	$content .= $article[1];
	$content = preg_replace('/src="\//m', 'src="http://www.rts.ch/', $content);
	$content = preg_replace('/href="\//m', 'href="http://www.rts.ch/', $content);
	return $content;
}
main();
?>