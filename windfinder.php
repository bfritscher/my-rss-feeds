<style type="text/css">
.weathertable{
	width: auto !important;
}
</style>
<?php
require('core.php');

function test(){
	$page = get_web_page_content($_GET['url']);
	preg_match('/<link rel="stylesheet"(.*?)>/ms', $page, $match);
	echo $match[0];
	preg_match('/tab-content">(.*)<div class="bottom-section/ms', $page, $match);
	echo $match[1];
}
test();
?>