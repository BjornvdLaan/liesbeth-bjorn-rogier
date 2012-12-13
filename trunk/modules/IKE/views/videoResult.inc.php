<script src="http://www.google.com/jsapi" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="/content/css/hide.css">
<script type="text/javascript">
    google.load("swfobject", "2.1");
</script>    
<script type="text/javascript">
    /*
     * Change out the video that is playing
     */
      
    // Update a particular HTML element with a new value
    function updateHTML(elmId, value) {
        document.getElementById(elmId).innerHTML = value;
    }
      
    // Loads the selected video into the player.
    function loadVideo() {
        var selectBox = document.getElementById("videoSelection");
        var videoID = selectBox.options[selectBox.selectedIndex].value
        
        if(ytplayer) {
            ytplayer.loadVideoById(videoID);
        }
    }
      
    // This function is called when an error is thrown by the player
    function onPlayerError(errorCode) {
        alert("An error occured of type:" + errorCode);
    }
      
    // This function is automatically called by the player once it loads
    function onYouTubePlayerReady(playerId) {
        ytplayer = document.getElementById("ytPlayer");
        ytplayer.addEventListener("onError", "onPlayerError");
    }
      
    // The "main method" of this sample. Called when someone clicks "Run".
    function loadPlayer() {
        // The video to load
        var videoID = "<?= $oModuleData->data->link ?>"
        // Lets Flash from another domain call JavaScript
        var params = { allowScriptAccess: "always" };
        // The element id of the Flash embed
        var atts = { id: "ytPlayer" };
        // All of the magic handled by SWFObject (http://code.google.com/p/swfobject/)
        swfobject.embedSWF("http://www.youtube.com/v/" + videoID + 
            "?version=3&enablejsapi=1&playerapiid=player1", 
        "videoDiv", "480", "295", "9", null, null, params, atts);
    }
    function _run() {
        loadPlayer();
    }
    
    $(document).ready(function(){
        $("#abstract").click(function(){
            //var i = $(this).find("i");
            //var cl = $(img).attr("class");
            
            //if(cl.endsWith("plus-sign"))
           //     cl = cl.replace('plus', 'minus');
           // else
           //     cl = cl.replace('minus', 'plus');
           // $(i).attr("class", cl);
            
            $("#abstractreadmore").toggle();
        })
    })
    
    google.setOnLoadCallback(_run);
</script>

<div class="container-fluid">
    <div class="row-fluid">
        <div class="hero-unit" style="min-height: 250px">
            <div class="span6">
                <div id="videoDiv">Loading video. Please wait...</div>
            </div>

            <div class="span5" >
                <div class="row-fluid">
                    <div class="span4">
                        <div class="row-fluid"><h4>Video artist:</h4></div>
                        <div class="row-fluid"><h4>Video Title:</h4></div>
                    </div>
                    <div class="span6">
                        <div class="row-fluid"><h4><?= $oModuleData->data->video->artist ?> <?= $oModuleData->data->hotttnesss ?></h4></div>
                        <div class="row-fluid"><h4><?= ucwords($oModuleData->data->video->title) ?></h4></div>
                    </div>
                </div>
                <div class="row-fluid">
                    <?php include('videoInput.inc.php'); ?>
                </div>

            </div>
            <div>&nbsp;</div>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span6">
            <h2 id="abstract"><a class="btn"><i class="icon-text-height"></i></a> About the artist</h2>

            <p><?php
                $abstract = Echonest::$wikipedia->text;
                $first = strpos($abstract, CHAR_NL);
                $intro = nl2br(substr($abstract, 0, $first));
                $readmore = nl2br(substr($abstract, $first));
                echo $intro; ?>
                <span id="abstractreadmore" class="hide">
                 <?= $readmore ?>
                </span>
            </p>    
        </div>
        <table>


            <tr>
                <th style="width:150px;text-align:left;">Spotify</th>
                <td>Spotify track-ID: <?= $oModuleData->data->spotify->track->getTrack() ?><br>
                    Spotify artist-ID: <?= $oModuleData->data->spotify->artist->href ?><br>
                    Spotify populariteit: <?= $oModuleData->data->spotify->track->getPopularity() ?></td>
            </tr>
            <tr>
                <th style="width:150px;text-align:left;">Buy this track</th>
                <td>
                    <?php if (!empty(Echonest::$itunes->url)) { ?><a href="<?= Echonest::$itunes->url ?>"><img src="/content/img/itunes.png"></a> <?php } ?>
                    <?php if (!empty(Echonest::$amazon->url)) { ?><a href="<?= Echonest::$amazon->url ?>"><img src="/content/img/amazon.gif"></a><br><?php } ?>
                </td>
            </tr>
            <tr style="width:150px;text-align:left;vertical-align:top;">
                <th>Related</th>
                <td><?php
foreach ($oModuleData->data->youtube->related as $entry) {
    echo $entry->getVideoTitle() . '<br>';
}
?></td>
            </tr>
            <tr style="width:150px;text-align:left;vertical-align:top;">
                <th>CHristmas</th>
                <td><?php
foreach ($oModuleData->data->xmas as $entry) {
    echo $entry . '<br>';
}
?></td>
            </tr>
            <tr style="width:150px;text-align:left;vertical-align:top;">
                <th>Discography</th>
                <td><?php
                    foreach ($oModuleData->data->allsongs as $entry) {
                       echo $entry . '<br>';
                    }
                    ?></td>
            </tr>
        </table>
    </div>
</div>
