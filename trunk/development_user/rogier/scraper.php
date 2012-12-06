<?php

include ( '../../modules/constants.php');
include ( '../../app_client/_config.php');
include ( '../../modules/config.php');
include ( '../../modules/sources.php');
include ( '../../modules/IKE/class.php');
$toScrape = array(
    'http://www.youtube.com/watch?v=AcpicphRd_Q',
    'http://www.youtube.com/watch?v=zAP3hqAayDk',
    'http://www.youtube.com/watch?v=fWNaR-rxAic',
    'http://www.youtube.com/watch?v=q04_ClDxRsk',
    'http://www.youtube.com/watch?v=gJLIiF15wjQ',
    'http://www.youtube.com/watch?v=kffacxfA7G4'
);
$visited = array();

$j = 0;
header('Content-type: text/plain');
for ($i = 0; isset($toScrape[$i]) && $j < 1000; $i++) {
    echo CHAR_NL.CHAR_NL.'new mainlink';
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
            if ( in_array($match,$visited) ) {
                continue;
            }
            echo CHAR_NL . $match . ' #' .$j;
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