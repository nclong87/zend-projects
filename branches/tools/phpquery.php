<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include './functions.php';
include './libs/Core/Curl.php';
include './libs/phpQuery/phpQuery.php';

$curl = new Core_Curl(array(
    'method' => 'GET',
    'header' => array(
        'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
        'Accept-Encoding: gzip, deflate',
        'Accept-Language: en-US,en;q=0.5',
        'Connection: keep-alive',
        'User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64; rv:19.0) Gecko/20100101 Firefox/19.0'
    )
));
//$content = $curl->getContent('https://m.facebook.com/HanetElectronicsVN/posts/1495693790646443');
$content = $curl->getContent('https://m.facebook.com/Cristiano');
//echo $content;die;
$pq = phpQuery::newDocument($content);
foreach ($pq[".tlBelowUnit"] as $element) {
    foreach (pq($element)->find('a') as $key => $value) {
        $href = $value->getAttribute("href");
        if(strpos($href, '/sharer.php') !== false) {
            $array = parse_url($href);
            $query = $array['query'];
            parse_str($query,$array);
            $sid = $array['sid'];
            echo $sid.PHP_EOL;
        }
        //echo $key.PHP_EOL;
    }
}
die;

echo 'l='.$pq->find('#m_story_permalink_view ._5rgn')->get(0)->textContent;
die;

while ($text = $pq->find("span.tlActorText")->next()) {
    echo $text->getString();
}
die;
foreach ($pq->find("span.tlActorText") as $text) {
    echo $text->get($index);
}
//$content = $pq->find("span.tlActorText")->get(0)->textContent;
//print_r($content);
