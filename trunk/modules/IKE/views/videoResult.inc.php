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

<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <span class="span6">
                <form class="navbar-form pull-left" action="/video" method="GET">
                    <input class="span4" type="text" name="link" value="<?= $oModuleData->data->URL ?>" id="link" style="width:350px;">
                    <button class="btn" name="Go Go Gadget!" type="submit">play</button>
                </form>
            </span>
            <span class="span4">
                <a class="brand pull-right">
                    You are currently logged in as: <?= $oModuleData->data->user->getUsername() ?>
                </a>
            </span>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row-fluid">
        <div class="hero-unit" style="min-height: 250px; margin-top:20px">
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
                        <div class="row-fluid"><h4><?= $oModuleData->data->video->artist ?> <?= $oModuleData->data->hotttnesssIcon ?> </h4></div>
                        <div class="row-fluid"><h4><?= ucwords($oModuleData->data->video->title) ?></h4></div>
                    </div>
                </div>


            </div>
            <div>&nbsp;</div>
        </div>
    </div>
    <div class="row-fluid">
        <div class="hero-unit" style="padding-top:20px; padding-bottom:0">

            <ul class="thumbnails">
                <?php
                for ($i = 0; $i < 5 && isset($oModuleData->rogierisgaaf[$i]); $i++) {
                    $HITJE = $oModuleData->rogierisgaaf[$i];
                    ?>
                    <li class="span2" style="background-color:white">
                        <a href ="http://<?= IKE_APP_URI ?>/video?link=http://www.youtube.com/watch?v=<?= $HITJE['youtube_id'] ?>" class="thumbnail">
                            <img data-src="holder.js/160x120" alt="160x120" style="width: 160px; height: 120px;" src="http://img.youtube.com/vi/<?= $HITJE['youtube_id'] ?>/0.jpg">
                            <div class="caption">
                                <p><?= $HITJE['artist'] ?> - <?= $HITJE['name'] ?></p>

                            </div>
                        </a></li>
                <?php } ?>
            </ul>

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
                echo $intro;
                ?>
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
            <?php if (!empty($oModuleData->data->xmas)) { ?>
                <tr style="width:150px;text-align:left;vertical-align:top;">
                    <th>CHristmas</th>
                    <td><?php
            foreach ($oModuleData->data->xmas as $entry) {
                echo $entry . '<br>';
            }
                ?></td><?php } ?>
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
<?php
var_dump($oModuleData->rogierisgaaf) ?>
<script type="text/javascript">
    $('#link').click( function() { if($(this).val() == '<?= $oModuleData->data->URL ?>') { $(this).val(''); }});
    $('#link').blur( function() { if($(this).val() == '') { $(this).val('<?= $oModuleData->data->URL ?>'); }});
 
</script>
