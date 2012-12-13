<?php

include ( '../../modules/constants.php');
include ( '../../app_client/_config.php');
include ( '../../modules/config.php');
include ( '../../modules/sources.php');
include ( '../../modules/IKE/class.php');
$toScrape = array(
    /* 'http://www.youtube.com/watch?v=TIy3n2b7V9k',
      'http://www.youtube.com/watch?v=_aARooQAfy8',
      'http://www.youtube.com/watch?v=7kVNl-9cS9c',
      'http://www.youtube.com/watch?v=5OoihTVlcUY',
      'http://www.youtube.com/watch?v=4T9-54o4DzE',
      'http://www.youtube.com/watch?v=NB58B2Gn3CU',
      'http://www.youtube.com/watch?v=hGc28ZMQEh8',
      'http://www.youtube.com/watch?v=JxZcFArCeKs',
      'http://www.youtube.com/watch?v=ISETbQws10Q',
      'http://www.youtube.com/watch?v=4fndeDfaWCg',
      'http://www.youtube.com/watch?v=ulOb9gIGGd0',
      'http://www.youtube.com/watch?v=qFYaImiDnEE',
      'http://www.youtube.com/watch?v=ZyhrYis509A',
      'http://www.youtube.com/watch?v=1G4isv_Fylg',
      'http://www.youtube.com/watch?v=PVzljDmoPVs',
      'http://www.youtube.com/watch?v=BJ-CmHZrKHU',
      'http://www.youtube.com/watch?v=KlyXNRrsk4A',
      'http://www.youtube.com/watch?v=bW6PowAIAxg',
      'http://www.youtube.com/watch?v=oABEGc8Dus0' */
    'http://www.youtube.com/watch?v=2Z4m4lnjxkY',
    'http://www.youtube.com/watch?v=uE-1RPDqJAY',
    'http://www.youtube.com/watch?v=dQw4w9WgXcQ',
    'http://www.youtube.com/watch?v=GKeXHCOEZ1k',
    'http://www.youtube.com/watch?v=kNPcxp2sMQQ',
    'http://www.youtube.com/watch?v=hMtZfW2z9dw',
    'http://www.youtube.com/watch?v=dVPCYr3XDPg',
    'http://www.youtube.com/watch?v=XHEFbX81XWQ',
    'http://www.youtube.com/watch?v=0w6c9zHFfCg',
    'http://www.youtube.com/watch?v=6FgDXAUYqHg'
);
$visited = array();

$j = 0;
header('Content-type: text/plain');
for ($i = 0; isset($toScrape[$i]) && $j < 10000; $i++) {
    echo CHAR_NL . CHAR_NL . 'new mainlink';
    $data = file_get_contents($toScrape[$i]);
    $parser = new simple_html_dom();
    $parser->load($data);
    $aDingen = $parser->find('a');

    foreach ($aDingen as $link) {
        $link = $link->__get('outertext');
        $match = array();
        preg_match('/"\/watch\?v=([a-zA-Z0-9\-_]*)"/', $link, $match);
        if (isset($match[0])) {
            $match = sprintf('http://www.youtube.com%s', substr($match[0], 1, -1));
            if (in_array($match, $visited)) {
                continue;
            }
            echo CHAR_NL . $match . ' #' . $j;
            $args = array('link' => $match);
            doPost('http://ike.rogierslag.nl/video', $args, 80);
            usleep(200);
            $toScrape[] = $match;
            $visited[] = $match;
            $j++;
        }
    }
}

function doPost($url, $args, $port, $cookie = '') {
    $args = http_build_query($args);
    $url = parse_url($url);

    # Host info destilleren
    $host = $url['host'];
    $path = $url['path'];

    # Socket
    $fp = fsockopen($host, $port, $errno, $errstr, 10);

    if ($fp) {
        // send the request headers:
        fputs($fp, "POST " . $path . " HTTP/1.1\r\n");
        fputs($fp, "Host: " . $host . "\r\n");

        fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
        fputs($fp, "Content-length: " . strlen($args) . "\r\n");
        fputs($fp, "Cookie: " . $cookie . "\r\n");
        fputs($fp, "Connection: close\r\n\r\n");
        fputs($fp, $args);

        $result = '';
        while (!feof($fp))
            $result .= fgets($fp, 128);
    } else {
        return array(
            'status' => 'err',
            'error' => $errstr . " (" . $errno . ")"
        );
    }

    fclose($fp);

    # Header en content scheiden
    $result = explode("\r\n\r\n", $result, 2);

    $header = isset($result[0]) ? $result[0] : '';
    $content = isset($result[1]) ? $result[1] : '';

    // return as structured array:
    return array(
        'status' => 'ok',
        'header' => $header,
        'content' => $content
    );
}