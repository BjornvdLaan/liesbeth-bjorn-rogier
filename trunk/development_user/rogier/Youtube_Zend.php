<?php

require_once 'Zend/Loader.php'; // the Zend dir must be in your include_path
Zend_Loader::loadClass('Zend_Gdata_YouTube');
$yt = new Zend_Gdata_YouTube();

header('Content-type: text/plain');

function printVideoEntry($videoEntry) {
    // the videoEntry object contains many helper functions
    // that access the underlying mediaGroup object
    echo 'Video: ' . $videoEntry->getVideoTitle() . "\n";
    echo 'Video ID: ' . $videoEntry->getVideoId() . "\n";
    echo 'Updated: ' . $videoEntry->getUpdated() . "\n";
    echo 'Description: ' . $videoEntry->getVideoDescription() . "\n";
    echo 'Category: ' . $videoEntry->getVideoCategory() . "\n";
    echo 'Tags: ' . implode(", ", $videoEntry->getVideoTags()) . "\n";
    echo 'Watch page: ' . $videoEntry->getVideoWatchPageUrl() . "\n";
    echo 'Flash Player Url: ' . $videoEntry->getFlashPlayerUrl() . "\n";
    echo 'Duration: ' . $videoEntry->getVideoDuration() . "\n";
    echo 'View count: ' . $videoEntry->getVideoViewCount() . "\n";
    echo 'Rating: ' . $videoEntry->getVideoRatingInfo() . "\n";
    echo 'Geo Location: ' . $videoEntry->getVideoGeoLocation() . "\n";
    echo 'Recorded on: ' . $videoEntry->getVideoRecorded() . "\n";

    // see the paragraph above this function for more information on the 
    // 'mediaGroup' object. in the following code, we use the mediaGroup
    // object directly to retrieve its 'Mobile RSTP link' child
    foreach ($videoEntry->mediaGroup->content as $content) {
        if ($content->type === "video/3gpp") {
            echo 'Mobile RTSP link: ' . $content->url . "\n";
        }
    }

    echo "Thumbnails:\n";
    $videoThumbnails = $videoEntry->getVideoThumbnails();

    foreach ($videoThumbnails as $videoThumbnail) {
        echo $videoThumbnail['time'] . ' - ' . $videoThumbnail['url'];
        echo ' height=' . $videoThumbnail['height'];
        echo ' width=' . $videoThumbnail['width'] . "\n";
    }
    var_dump($videoEntry);
}

$x = $yt->getVideoEntry('xVpe2DyHJr0');
printVideoEntry($x);
die();

$query = $yt->newVideoQuery();
$query->videoQuery = 'cat';
$query->startIndex = 10;
$query->maxResults = 20;
$query->orderBy = 'viewCount';

echo $query->queryUrl . "\n";
$videoFeed = $yt->getVideoFeed($query);

foreach ($videoFeed as $videoEntry) {
    echo "---------VIDEO----------\n";
    echo "Title: " . $videoEntry->mediaGroup->title->text . "\n";
    echo "\nDescription:\n";
    echo $videoEntry->mediaGroup->description->text;
    echo "\n\n\n";
}
?>