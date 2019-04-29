<?php
include_once('simple_html_dom.php');

$url  	 	= 'https://vnexpress.net/thoi-su/8-oto-tong-lien-hoan-tren-cao-toc-trung-luong-3916236.html';
$arrMain 	= array(array('URL', 'Title', 'Author', 'Date'));
$html 	 	= file_get_html($url);
$title		= $html->find('.title_news_detail',0);
$time	 	= $html->find('.time',0);
$author  	= $html->find('p strong', 0);
$arrMain[] 	= array($url, $title->plaintext, $author->plaintext, $time->plaintext);

foreach ($html->find('h4 a[title]') as $value) {
	$title = isset($value->title) ? $value->title : '';
	$link  = isset($value->href) ? $value->href : '';
	if (!empty($value->title) && !empty($link)){
		$data = getLinkData($title, $link);
		$arrMain[] = $data;
	}
	
}

arrayToCsv($arrMain);

function getLinkData($title,$link) {
	$html 	 	= file_get_html($link);
	$time	 	= $html->find('.time',0);
	$author  	= $html->find('p strong', 0);
	return array($link, $title, $author->plaintext, $time->plaintext);
}

function arrayToCsv ($arr) {
	$fp = fopen('file.csv', 'w');
	foreach ($arr as $value) {
		fputcsv($fp, $value);
	}
	fclose($fp);
}